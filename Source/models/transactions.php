<?php

include __DIR__ . "/../interfaces/iTransaction.php";

class transactions implements Itransactions {

    private $db = false;

    public function __construct(Cdb $db) {
        $this->db = $db;
    }

    /**
     * Get all transactions 
     * @param int $myid
     * @param int $count
     * @param int $page_no
     * @return array of transactions 
     */
    public function transactions_get($myid, $count = false, $page_no = false, $order = false, $dir = false) {

        $join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,
                        B.firstname as to_firstname,B.lastname as to_lastname,
                        (CASE  transactions.from_id WHEN $myid THEN transactions.type 
                         ELSE CASE WHEN transactions.type='in' THEN 'out' ELSE
                         CASE WHEN transactions.type='out' THEN 'in' ELSE 
                         transactions.type
                        END END END) as type";

        $join_sql = "INNER JOIN accounts A ON A.id = transactions.from_id
                     INNER JOIN accounts B ON B.id = transactions.to_id";


        if ($myid)
            $sql = " from_id = '$myid' OR to_id = '$myid'";

        /* TO DO orderby */
        if ($order)
            $order_by = $order;

        if ($dir == 'up')
            $order_by .= ' DESC';

        if ($dir == 'down')
            $order_by .= ' ASC';

        return $this->db->select('transactions', $sql, false, false, $order_by, limit($count, $page_no, true), $join_fields, $join_sql);
    }

    /**
     * return transaction count 
     * @param int $myid
     * @return int number of transactions 
     */
    public function transactions_get_count($myid = false) {
        $sql = "SELECT COUNT(*) FROM transactions";
        if ($myid)
            $sql .= " WHERE from_id = '$myid' OR to_id = '$myid'";

        return $this->db->query_value($sql);
    }

    /**
     * Admin Get transactions 
     */
    public function adminGetTransactions($from = false, $to = false, $transaction_id = false, $count = false, $page_no = false, $order = false, $dir = false) {

        $join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,A.email as from_email,
                        B.firstname as to_firstname,B.lastname as to_lastname,B.email as to_email";

        $join_sql = "INNER JOIN accounts A ON A.id = transactions.from_id
                     INNER JOIN accounts B ON B.id = transactions.to_id";

        //FROM
        if ($from)
            $sql = " (A.email = '$from' OR A.mobile='$from') ";

        //TO
        if ($sql && $to)
            $sql .= ' AND ';

        if ($to)
            $sql .= " (B.email = '$to' OR B.mobile='$to') ";

        //Transaction id
        if ($sql && $transaction_id)
            $sql .= ' AND ';

        if ($transaction_id)
            $sql .= " (transactions.id='$transaction_id') ";

        if ($order)
            $order_by = $order;

        if ($dir == 'up')
            $order_by .= ' DESC';

        if ($dir == 'down')
            $order_by .= ' ASC';

        return $this->db->select('transactions', $sql, false, false, $order_by, limit($count, $page_no, true), $join_fields, $join_sql);
    }

    /**
     * Get admin transaction count 
     */
    public function adminGetTransactionsCount($from = false, $to = false, $transaction_id = false) {

        $sql = "SELECT COUNT(*) FROM transactions
                INNER JOIN accounts A ON A.id = transactions.from_id
                INNER JOIN accounts B ON B.id = transactions.to_id";
        //FROM
        if ($from)
            $csql = "  (A.email = '$from' OR A.mobile='$from') ";

        //TO
        if ($csql && $to)
            $csql .= ' AND ';

        if ($to)
            $csql .= " (B.email = '$to' OR B.mobile='$to') ";

        //Transaction id
        if ($csql && $transaction_id)
            $csql .= ' AND ';

        if ($transaction_id)
            $csql .= " (transactions.id='$transaction_id') ";

        if ($csql)
            $csql = " WHERE " . $csql;

        $sql.= $csql;
        return $this->db->query_value($sql);
    }

    /**
     *
     * get one Transaction using it's id and my id
     * @param int $id
     * @param int $myid
     * @return array transaction data 
     */
    public function transaction_get_one($id, $my_id = false, $type = false) {
        $join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,
                        B.firstname as to_firstname,B.lastname as to_lastname";

        $join_sql = "INNER JOIN accounts A ON A.id = transactions.from_id
                     INNER JOIN accounts B ON B.id = transactions.to_id";

        $sql = "transactions.id = $id";
        if ($my_id && $type == 'in')
            $sql .= " AND transactions.to_id = '{$my_id}' AND transactions.type ='out' ";

        return $this->db->select_record('transactions', $sql, false, false, false, false, $join_fields, $join_sql);
    }

    /**
     * Transfare balance from account to account
     * @param int $from_id
     * @param int $to_id
     * @param decimal $amount
     * return error code on fail and true on success 
     */
    public function transfer($from_id, $email, $amount,$admin =false) {
        /* Validate that from id have this amount
         * should validate if amount to transfer is zero or minus
         * */
        if ($amount <= 0)
            return self::ERR_WRONG_AMOUNT;

        //check reciver
        $reciver = $this->db->select_record('accounts', "(email = '$email' || mobile ='$email') AND mobile_verified = 1 AND blocked = 0");
        if (!$reciver)
            return self::ERR_USER_NOT_EXIST;
        //Don't transfer to my self
        if ($reciver['id'] == $from_id)
            return self::ERR_TRANSFER_TOME;

        //Check balance
        if(!$admin){
        //This is only if iam not admin
        $balance = $this->db->select_record('accounts', "id = '$from_id'");
        if ($balance['balance'] < $amount)
            return self::ERR_NOT_ENOUGH_BALANCE;



        // Do transaction 
        $transaction[] = "UPDATE accounts SET balance = balance - $amount WHERE id = $from_id";
        }
        
        $transaction[] = "UPDATE accounts SET balance = balance + $amount WHERE id = {$reciver['id']}";
        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,datetime1,type) VALUES ($from_id,{$reciver['id']},$amount,NOW(),'out')";

        $transaction_do = $this->db->transaction($transaction);

        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;
        
        
        
        $sender_record = $this->db->select_record ('accounts',"id = $from_id");
        if($reciver['admin_type'] == 0) {
            //SEND EMAIL TO RECIVER
            $subject = "BankPhonet transaction details";
            $msg_body  = "There are a new transaction to your account and this is details \n";
            $msg_body .= "Date : ".date('Y-m-d H:i:s')."\n";
            $msg_body .= "Transaction ID : ".$transaction_do."\n";
            $msg_body .= "FROM : ".$sender_record['firstname'].' '.$sender_record['lastname']."\n";
            $msg_body .= "Mobile : ".$sender_record['mobile']."\n";
            $msg_body .= "Amount : ".$amount."\n";
            $msg_body .= "Your Balance : ".($reciver['balance']+$amount)."\n";
            $msg_body .= "For more details visit bankphonet.com website please";
            @mail($reciver['email'], $subject, $msg_body, EMAIL_HEADERS);
        }
        //SEND EMAIL TO SENDER
       
        $subject = "BankPhonet transaction details";
        $msg2_body  = "There are a new transaction from your account and this is details \n";
        $msg2_body .= "Date : ".date('Y-m-d H:i:s')."\n";
        $msg2_body .= "Transaction ID : ".$transaction_do."\n";
        $msg2_body .= "To : ".$reciver['firstname'].' '.$reciver['lastname']."\n";
        $msg2_body .= "Mobile : ".$reciver['mobile']."\n";
        $msg2_body .= "Amount : ".$amount."\n";
        $msg2_body .= "Your Balance : ".($sender_record['balance']+$amount)."\n";
        $msg2_body .= "For more details visit bankphonet.com website please";
        @mail($sender_record['email'], $subject, $msg2_body, EMAIL_HEADERS);
        //END EMAIL SEND
        
        //If success return transaction id
        return $transaction_do;
    }

    /**
     * Refund
     * @param int $id
     * @param int $myid 
     * return error code on error and 1 on success
     */
    public function refund($id, $myid) {
        $refund_record = $this->db->select_record('transactions', "id =$id");
        //Record is no't there 
        if (!$refund_record)
            return self::ERR_REFUND_NOTEXIST;

        //Check balance
        $balance = $this->db->select_record('accounts', "id = '$myid'");
        
        if($balance['admin_type'] != 1){
        if ($balance['balance'] < $refund_record['amount'])
            return self::ERR_NOT_ENOUGH_BALANCE;
        }
        
        //check reciver
        $reciver = $this->db->select_record('accounts', "id = '{$refund_record['from_id']}' AND mobile_verified = 1 AND blocked = 0");
        if (!$reciver)
            return self::ERR_USER_NOT_EXIST;

        // Do transaction SAMPLE
        if($balance['admin_type'] != 1)
            $transaction[] = "UPDATE accounts SET balance = balance - {$refund_record['amount']} WHERE id = '{$refund_record['to_id']}'";
       
        $transaction[] = "UPDATE accounts SET balance = balance + {$refund_record['amount']} WHERE id = '{$refund_record['from_id']}'";
        $transaction[] = "UPDATE  transactions set type='refunded' WHERE id= $id";
        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,datetime1,type) VALUES ({$refund_record['to_id']},{$refund_record['from_id']},{$refund_record['amount']},NOW(),'out')";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;
        //If success
        return 1;
    }

    /**
     * Get banks list 
     */
    public function getBanks($country) {
        global $local;
        $custom_select = "title_$local as title,id";
        return $this->db->select('banks', "country_code = '$country'", false, $custom_select, 'title_' . $local . ' ASC');
    }

    /**
     * Request withdraw
     * @param int $my_id
     * @param array $data 
     */
    public function requestWithdraw($my_id, $data, $balance) {
        //Check Min amount
        if($data['country_code'] == 'EG')
            $min_withdraw = MIN_WITHDRAW_EG;
        else
            $min_withdraw = MIN_WITHDRAW_OUT;
        
        
        //Don't do this check unless if there are country code
        if($data['country_code']){
        if ($data['amount'] < $min_withdraw)
            return self::ERR_MIN_WITHDRAW;
        }
        
        
        //Check if withdraw bigger than balance
        if ($data['amount'] > $balance)
            return self::ERR_NOT_ENOUGH_BALANCE;

        $data['datetime1'] = date('Y-m-d H-i-s');
        $data['account_id'] = $my_id;

        //Get admin record
        $to_id = $this->db->select_record ('accounts',"admin_type = 1");
        if(!$to_id)
            return self::ERR_TRANSFER_FAILED;
        
        $transaction[] = "UPDATE accounts SET balance = balance - {$data['amount']} WHERE id = '$my_id'";
        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,datetime1,type,notes) VALUES ({$my_id},{$to_id['id']},{$data['amount']},NOW(),'out','Withdrawl request')";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;
        
        $data['transaction_id'] = $transaction_do;
        //SEND EMAIL TO ADMIN
        $user_record = $this->db->select_record ('accounts',"id = $my_id");
        $subject = "New Withdrawl request";
        $msg_body = "Date : ".$data['datetime1']."\n";
        $msg_body .= "Request no : ".$transaction_do."\n";
        $msg_body .= "FROM : ".$user_record['firstname'].' '.$user_record['lastname']."\n";
        $msg_body .= "Email : ".$user_record['email']."\n";
        $msg_body .= "Mobile : ".$user_record['mobile']."\n";
        $msg_body .= "Amount : ".$data['amount']."\n";
        $msg_body .= "For more details visit the website please";
       
        @mail(ADMIN_EMAIL, $subject, $msg_body, EMAIL_HEADERS);
        //END EMAIL SEND
        
        //INSERT REQUEST
        return $this->db->insert('withdrawl_requests', $data);
    }

    /**
     * Get withdraw requests
     *  
     */
    public function getWithdrawRequests($email,$count,$page_no,$order,$dir) {
        global $local;
        $join_fields = "accounts.firstname,accounts.lastname,accounts.email,accounts.mobile,accounts.balance,
                        banks.title_$local as bank_title";
        $join_sql = "INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id
                     LEFT JOIN banks ON withdrawl_requests.bank_id = banks.id";
        
        //Filter by email
        if($email)
            $sql = "accounts.email = '$email' OR accounts.mobile ='$email'";
        
        //Order by
        if($order)
            $order_by = $order;
        if($dir == 'up')
            $order_by .=' DESC';
            
        if($dir == 'down')
            $order_by .=' ASC';
            
        
        return $this->db->select("withdrawl_requests", $sql, false, false, $order_by, limit($count,$page_no,true), $join_fields, $join_sql);
        
    }
    
    //GET ONE WITHDRAW REQUEST
    public function getWithdrawReqest($id){
        global $local;
        $join_fields = "accounts.title,accounts.firstname,accounts.lastname,accounts.email,accounts.mobile as acc_mobile,accounts.balance,
                        banks.title_$local as bank_title,A.title_$local as profile_country,B.title_$local as request_country";
        $join_sql = "INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id
                     LEFT JOIN banks ON withdrawl_requests.bank_id = banks.id
                     LEFT JOIN countries A on A.code = accounts.country_code
                     LEFT JOIN countries B on B.code = withdrawl_requests.country_code";
        
        return $this->db->select_record ('withdrawl_requests',"withdrawl_requests.id = $id",false,false,false,false,$join_fields,$join_sql);
    }
    
    
    public function getWithdrawRequestsCount($email){
        $sql = "SELECT COUNT(*) FROM withdrawl_requests
                INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id ";
        //Filter by email
        if($email)
            $sql .= " WHERE accounts.email = '$email' OR accounts.mobile ='$email'";
        
        return $this->db->query_value($sql);
    }
    
    
    /**
     * Add bank to the list
     * @global type $local
     * @param type $title
     * @param type $country
     * @return type 
     */
    public function addBank ($title,$country){
        global $local;
        return $this->db->insert ('banks',array ("title_ar" => $title,"title_en"=>$title,"country_code" => $country));
    }

}

?>
