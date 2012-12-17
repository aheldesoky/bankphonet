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
     * Get all transactions
     * @param int $myid
     * @param int $count
     * @param int $page_no
     * @return array of transactions
     */
    public function transactions_score_get($myid, $count = false, $page_no = false, $order = false, $dir = false) {
    
    	$join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,
    	B.firstname as to_firstname,B.lastname as to_lastname,
    	(CASE  transactions_score.from_id WHEN $myid THEN transactions_score.type
    	ELSE CASE WHEN transactions_score.type='in' THEN 'out' ELSE
    	CASE WHEN transactions_score.type='out' THEN 'in' ELSE
    	transactions_score.type
    	END END END) as type";
    
    	$join_sql = "INNER JOIN accounts A ON A.id = transactions_score.from_id
    	INNER JOIN accounts B ON B.id = transactions_score.to_id";
    
    
        if ($myid)
            $sql = " from_id = '$myid' OR to_id = '$myid'";
    
        /* TO DO orderby */
        if ($order)
    	$order_by = $order;
    
    	if ($dir == 'up')
    			$order_by .= ' DESC';
    
    			if ($dir == 'down')
    	$order_by .= ' ASC';
    
    	return $this->db->select('transactions_score', $sql, false, false, $order_by, limit($count, $page_no, true), $join_fields, $join_sql);
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

    public function deleteTransaction($id) {
        $id = intval($id);
        return $this->db->delete('transactions', "id = '$id'");
    }


    /**
     * return transaction score count
     * @param int $myid
     * @return int number of transactions
     */
    public function transactions_score_get_count($myid = false) {
    	$sql = "SELECT COUNT(*) FROM transactions_score";
    	if ($myid)
    		$sql .= " WHERE from_id = '$myid' OR to_id = '$myid'";
    
    	return $this->db->query_value($sql);
    }
    
    
    /**
     * Admin Get transactions 
     */
    public function adminGetTransactions($from = false, $to = false, $transaction_id = false, $count = false, $page_no = false, $order = false, $dir = false, $frozen = false) {

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



        if ($sql && $frozen == 2)
            $sql .=' AND ';

        if ($frozen == 2)
            $sql .= "  transactions.total_shipping != 0";


        if ($order)
            $order_by = $order;

        if ($dir == 'up')
            $order_by .= ' DESC';

        if ($dir == 'down')
            $order_by .= ' ASC';

        return $this->db->select('transactions', $sql, false, false, ($order_by) ? $order_by : ' datetime1 DESC ', limit($count, $page_no, true), $join_fields, $join_sql);
    }

    /**
     * Admin Get transactions
     */
    public function adminGetTransactionsScore($from = false, $to = false, $transaction_id = false, $count = false, $page_no = false, $order = false, $dir = false, $frozen = false) {
    
    	$join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,A.email as from_email,
                        B.firstname as to_firstname,B.lastname as to_lastname,B.email as to_email";
    
    	$join_sql = "INNER JOIN accounts A ON A.id = transactions_score.from_id
                     INNER JOIN accounts B ON B.id = transactions_score.to_id";
    
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
    		$sql .= " (transactions_score.id='$transaction_id') ";
    
    
    	/*
    	if ($sql && $frozen == 2)
    		$sql .=' AND ';
    
    	if ($frozen == 2)
    		$sql .= "  transactions_score.total_shipping != 0";
    	*/
    
    	if ($order)
    		$order_by = $order;
    
    	if ($dir == 'up')
    		$order_by .= ' DESC';
    
    	if ($dir == 'down')
    		$order_by .= ' ASC';
    
    	return $this->db->select('transactions_score', $sql, false, false, ($order_by) ? $order_by : ' datetime1 DESC ', limit($count, $page_no, true), $join_fields, $join_sql);
    }
    
    /**
     * Get admin transaction count 
     */
    public function adminGetTransactionsCount($from = false, $to = false, $transaction_id = false, $frozen = false) {

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


        if ($csql && $frozen == 2)
            $csql .=' AND ';

        if ($frozen == 2)
            $csql .= "  transactions.total_shipping != 0";

        if ($csql)
            $csql = " WHERE " . $csql;

        $sql.= $csql;
        return $this->db->query_value($sql);
    }


    /**
     * Get admin transaction count
     */
    public function adminGetTransactionsScoreCount($from = false, $to = false, $transaction_id = false, $frozen = false) {
    
    	$sql = "SELECT COUNT(*) FROM transactions_score
                INNER JOIN accounts A ON A.id = transactions_score.from_id
                INNER JOIN accounts B ON B.id = transactions_score.to_id";
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
    		$csql .= " (transactions_score.id='$transaction_id') ";
    
    /*
    	if ($csql && $frozen == 2)
    		$csql .=' AND ';
    
    	if ($frozen == 2)
    		$csql .= "  transactions.total_shipping != 0";
    */
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
        $id = intval($id);
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
     *
     * get one Transaction using it's id and my id
     * @param int $id
     * @param int $myid
     * @return array transaction data
     */
    public function transaction_score_get_one($id, $my_id = false, $type = false) {
    	$id = intval($id);
    	$join_fields = "A.firstname as from_firstname,A.lastname as from_lastname,
                        B.firstname as to_firstname,B.lastname as to_lastname";
    
    	$join_sql = "INNER JOIN accounts A ON A.id = transactions_score.from_id
                     INNER JOIN accounts B ON B.id = transactions_score.to_id";
    
    	$sql = "transactions_score.id = $id";
    	if ($my_id && $type == 'in')
    		$sql .= " AND transactions_score.to_id = '{$my_id}' AND transactions_score.type ='out' ";
    
    	return $this->db->select_record('transactions_score', $sql, false, false, false, false, $join_fields, $join_sql);
    }
    
    /**
     * Transfare balance from account to account
     * @param int $from_id
     * @param int $to_id
     * @param decimal $amount
     * return error code on fail and true on success 
     */
    public function transfer($from_id, $email, $amount, $admin = false, $shipping = false) {
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
        if (!$admin) {
            //This is only if iam not admin
            $balance = $this->db->select_record('accounts', "id = '$from_id'");
            if ($balance['balance'] < $amount)
                return self::ERR_NOT_ENOUGH_BALANCE;



            // Do transaction 
            $transaction[] = "UPDATE accounts SET balance = balance - $amount WHERE id = $from_id";
        }

        if (!$shipping) {
            $transaction[] = "UPDATE accounts SET balance = balance + $amount WHERE id = '{$reciver['id']}'";
            $shipping = 0; //To Inset Into Db
        }

        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,total_shipping,datetime1,type) VALUES ($from_id,{$reciver['id']},$amount,$shipping,NOW(),'out')";

        $transaction_do = $this->db->transaction($transaction);

        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;



        $sender_record = $this->db->select_record('accounts', "id = '$from_id'");
/*        if ($reciver['admin_type'] == 0) {
            //SEND EMAIL TO RECIVER
            $subject = "BankPhonet transaction details";

            global $ereciver;
            $ereciver['transaction_id'] = $transaction_do;
            $ereciver['firstname'] = $sender_record['firstname'];
            $ereciver['lastname'] = $sender_record['lastname'];
            $ereciver['mobile'] = $sender_record['mobile'];
            $ereciver['amount'] = $amount;
            $ereciver['balance'] = $reciver['balance'];
            $msg_body = render('views/transactions/emails/email_transaction_reciver.php');
            AmazonEmail($reciver['email'], $subject, $msg_body);
        }
        //SEND EMAIL TO SENDER

        $subject = "BankPhonet transaction details";

        global $esender;
        $esender['transaction_id'] = $transaction_do;
        $esender['firstname'] = $reciver['firstname'];
        $esender['lastname'] = $reciver['lastname'];
        $esender['mobile'] = $reciver['mobile'];
        $esender['amount'] = $amount;
        $esender['balance'] = $sender_record['balance'];
        //@mail($sender_record['email'], $subject, $msg2_body, EMAIL_HEADERS);
        $msg2_body = render("views/transactions/emails/email_transaction_sender.php");
        AmazonEmail($sender_record['email'], $subject, $msg2_body);
*/        //END EMAIL SEND
        //If success return transaction id
        return $transaction_do;
    }
    
    /**
     * Transfare points from account to account
     * @param int $from_id
     * @param int $to_id
     * @param decimal $amount
     * return error code on fail and true on success
     */
    public function transfer_points($from_id, $email, $amount, $admin = false) {
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
    	if (!$admin) {
    		//This is only if iam not admin
    		$balance = $this->db->select_record('accounts', "id = '$from_id'");
    		if ($balance['points'] < $amount)
    			return self::ERR_NOT_ENOUGH_BALANCE;
    
    		// Do transaction
    		$transaction[] = "UPDATE accounts SET points = points - $amount WHERE id = $from_id";
    	}
    	$transaction[] = "UPDATE accounts SET points = points + $amount WHERE id = '{$reciver['id']}'";
    	$transaction[] = "INSERT INTO transactions_score (from_id,to_id,amount,datetime1,type) VALUES ($from_id,{$reciver['id']},$amount,NOW(),'out')";
    	
    	$transaction_do = $this->db->transaction($transaction);
    
    	if (!$transaction_do)
    		return self::ERR_TRANSFER_FAILED;
    
    
    
    	$sender_record = $this->db->select_record('accounts', "id = '$from_id'");
/*    	if ($reciver['admin_type'] == 0) {
    		//SEND EMAIL TO RECIVER
    		$subject = "BankPhonet transaction details";
    
    		global $ereciver;
    		$ereciver['transaction_id'] = $transaction_do;
    		$ereciver['firstname'] = $sender_record['firstname'];
    		$ereciver['lastname'] = $sender_record['lastname'];
    		$ereciver['mobile'] = $sender_record['mobile'];
    		$ereciver['amount'] = $amount;
    		$ereciver['points'] = $reciver['points'];
    		$msg_body = render('views/transactions/emails/email_transaction_reciver.php');
    		AmazonEmail($reciver['email'], $subject, $msg_body);
    	}
    	//SEND EMAIL TO SENDER
    
    	$subject = "BankPhonet transaction details";
    
    	global $esender;
    	$esender['transaction_id'] = $transaction_do;
    	$esender['firstname'] = $reciver['firstname'];
    	$esender['lastname'] = $reciver['lastname'];
    	$esender['mobile'] = $reciver['mobile'];
    	$esender['amount'] = $amount;
    	$esender['points'] = $sender_record['points'];
    	//@mail($sender_record['email'], $subject, $msg2_body, EMAIL_HEADERS);
    	$msg2_body = render("views/transactions/emails/email_transaction_sender.php");
    	AmazonEmail($sender_record['email'], $subject, $msg2_body);
*/    	//END EMAIL SEND
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
        $refund_record = $this->db->select_record('transactions', "id ='$id'");
        //Record is no't there 
        if (!$refund_record)
            return self::ERR_REFUND_NOTEXIST;

        //CHECK IF THIS TRANSACTION WAS REFUNDED BEAFORE
        if ($refund_record['type'] == 'refunded')
            return self::ERR_REFUNDED_BEFORE;
        //Check balance
        $balance = $this->db->select_record('accounts', "id = '$myid'");

        if ($balance['admin_type'] != 1) {
            if ($balance['balance'] < $refund_record['amount'])
                return self::ERR_NOT_ENOUGH_BALANCE;
        }

        //check reciver
        $reciver = $this->db->select_record('accounts', "id = '{$refund_record['from_id']}' AND mobile_verified = 1 AND blocked = 0");
        if (!$reciver)
            return self::ERR_USER_NOT_EXIST;

        // Do transaction SAMPLE
        if ($balance['admin_type'] != 1)
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
     * Refund
     * @param int $id
     * @param int $myid
     * return error code on error and 1 on success
     */
    public function refund_score($id, $myid) {
    	$refund_record = $this->db->select_record('transactions_score', "id ='$id'");
    	//Record is no't there
    	if (!$refund_record)
    		return self::ERR_REFUND_NOTEXIST;
    
    		//CHECK IF THIS TRANSACTION WAS REFUNDED BEAFORE
    	if ($refund_record['type'] == 'refunded')
    			return self::ERR_REFUNDED_BEFORE;
    			//Check balance
    			$balance = $this->db->select_record('accounts', "id = '$myid'");
    
    			if ($balance['admin_type'] != 1) {
    			if ($balance['points'] < $refund_record['amount'])
    				return self::ERR_NOT_ENOUGH_BALANCE;
			    }
			    
			    //check reciver
			    $reciver = $this->db->select_record('accounts', "id = '{$refund_record['from_id']}' AND mobile_verified = 1 AND blocked = 0");
			    if (!$reciver)
			    	return self::ERR_USER_NOT_EXIST;
			    
    				// Do transaction SAMPLE
    			if ($balance['admin_type'] != 1)
    				$transaction[] = "UPDATE accounts SET points = points - {$refund_record['amount']} WHERE id = '{$refund_record['to_id']}'";
    
    				$transaction[] = "UPDATE accounts SET points = points + {$refund_record['amount']} WHERE id = '{$refund_record['from_id']}'";
    				$transaction[] = "UPDATE  transactions_score set type='refunded' WHERE id= $id";
    				$transaction[] = "INSERT INTO transactions_score (from_id,to_id,amount,datetime1,type) VALUES ({$refund_record['to_id']},{$refund_record['from_id']},{$refund_record['amount']},NOW(),'out')";
    
    
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
        if ($data['country_code'] == 'EG')
            $min_withdraw = MIN_WITHDRAW_EG;
        else
            $min_withdraw = MIN_WITHDRAW_OUT;


        //Don't do this check unless if there are country code
        if ($data['country_code']) {
            if ($data['amount'] < $min_withdraw)
                return self::ERR_MIN_WITHDRAW;
        }

        //Check if withdraw exceed max limit
        if ($data['amount'] > MAX_WITHDRAW_LIMIT)
            return self::ERR_MAX_WITHDRAW;

        //Check if withdraw bigger than balance
        if ($data['amount'] > $balance)
            return self::ERR_NOT_ENOUGH_BALANCE;

        $data['datetime1'] = date('Y-m-d H-i-s');
        $data['account_id'] = $my_id;

        //Get admin record
        $to_id = $this->db->select_record('accounts', "admin_type = 1");
        if (!$to_id)
            return self::ERR_TRANSFER_FAILED;

        $transaction[] = "UPDATE accounts SET balance = balance - {$data['amount']} WHERE id = '$my_id'";
        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,datetime1,type,notes) VALUES ({$my_id},{$to_id['id']},{$data['amount']},NOW(),'out','Withdrawl request')";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;

        $data['transaction_id'] = $transaction_do;
        //SEND EMAIL TO ADMIN
        $user_record = $this->db->select_record('accounts', "id = $my_id");
        $subject = "New Withdrawl request";


        global $withdraw_email;
        $withdraw_email['date'] = $data['datetime1'];
        $withdraw_email['transaction_id'] = $transaction_do;
        $withdraw_email['firstname'] = $user_record['firstname'];
        $withdraw_email['lastname'] = $user_record['lastname'];
        $withdraw_email['email'] = $user_record['email'];
        $withdraw_email['mobile'] = $user_record['mobile'];
        $withdraw_email['amount'] = $data['amount'];

        $msg_body = render('views/transactions/emails/email_withdraw.php');

        AmazonEmail(ADMIN_EMAIL, $subject, $msg_body);
        //END EMAIL SEND
        //INSERT REQUEST
        return $this->db->insert('withdrawl_requests', $data);
    }

    /**
     * Get withdraw requests
     *  
     */
    public function getWithdrawRequests($email, $count, $page_no, $order, $dir) {
        global $local;
        $join_fields = "accounts.firstname,accounts.lastname,accounts.email,accounts.mobile,accounts.balance,
                        banks.title_$local as bank_title";
        $join_sql = "INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id
                     LEFT JOIN banks ON withdrawl_requests.bank_id = banks.id";

        //Filter by email
        if ($email)
            $sql = "accounts.email = '$email' OR accounts.mobile ='$email'";

        //Order by
        if ($order)
            $order_by = $order;
        if ($dir == 'up')
            $order_by .=' DESC';

        if ($dir == 'down')
            $order_by .=' ASC';


        return $this->db->select("withdrawl_requests", $sql, false, false, ($order_by) ? $order_by : ' datetime1 DESC ', limit($count, $page_no, true), $join_fields, $join_sql);
    }

    //GET ONE WITHDRAW REQUEST
    public function getWithdrawReqest($id) {
        global $local;
        $join_fields = "accounts.title,accounts.firstname,accounts.lastname,accounts.email,accounts.mobile as acc_mobile,accounts.balance,
                        banks.title_$local as bank_title,A.title_$local as profile_country,B.title_$local as request_country";
        $join_sql = "INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id
                     LEFT JOIN banks ON withdrawl_requests.bank_id = banks.id
                     LEFT JOIN countries A on A.code = accounts.country_code
                     LEFT JOIN countries B on B.code = withdrawl_requests.country_code";

        return $this->db->select_record('withdrawl_requests', "withdrawl_requests.id = $id", false, false, false, false, $join_fields, $join_sql);
    }

    public function getWithdrawRequestsCount($email) {
        $sql = "SELECT COUNT(*) FROM withdrawl_requests
                INNER JOIN accounts ON withdrawl_requests.account_id = accounts.id ";
        //Filter by email
        if ($email)
            $sql .= " WHERE accounts.email = '$email' OR accounts.mobile ='$email'";

        return $this->db->query_value($sql);
    }

    public function requestDeposit($data) {
        /** Check If User Have done any request ? * */
        $sql = "SELECT * FROM deposit_requests WHERE account_id = '{$data['account_id']}' AND DATE(deposit_time) = '" . date('Y-m-d') . "'";
        $prev_req = $this->db->query_record($sql);

        if ($prev_req)
            return false;

        $data['deposit_time'] = date('Y-m-d H:i:s');
        return $this->db->insert('deposit_requests', $data);
    }

    /**
     * Get withdraw requests
     *  
     */
    public function getDepositRequests($email, $count, $page_no, $order, $dir) {
        global $local;
        $join_fields = "accounts.firstname,accounts.lastname,accounts.email,accounts.mobile,accounts.balance
                        ";
        $join_sql = "INNER JOIN accounts ON deposit_requests.account_id = accounts.id
                    ";

        //Filter by email
        if ($email)
            $sql = "accounts.email = '$email' OR accounts.mobile ='$email'";

        //Order by
        if ($order)
            $order_by = $order;
        if ($dir == 'up')
            $order_by .=' DESC';

        if ($dir == 'down')
            $order_by .=' ASC';


        return $this->db->select("deposit_requests", $sql, false, false, ($order_by) ? $order_by : ' id DESC ', limit($count, $page_no, true), $join_fields, $join_sql);
    }

    public function getDepositRequestsCount($email) {
        $sql = "SELECT COUNT(*) FROM deposit_requests
                INNER JOIN accounts ON deposit_requests.account_id = accounts.id ";
        //Filter by email
        if ($email)
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
    public function addBank($title, $country) {
        global $local;
        return $this->db->insert('banks', array("title_ar" => $title, "title_en" => $title, "country_code" => $country));
    }

    public function acceptWithdraw($id) {
        return $this->db->update('withdrawl_requests', array('accepted' => 1), "id = '$id'");
    }

    /** Create Cobone
     *
     * @param type $user_id
     * @param type $amount 
     */
    public function createCobone($user_id, $amount) {
        $user = $this->db->select_record('accounts', "id='$user_id'");

        if ($amount == 0)
            return self::ERR_WRONG_AMOUNT;

        /** Check balance * */
        if ($user['admin_type'] != 1) {
            $user = $this->db->select_record("accounts", "id = '$user_id'");
            if ($user['balance'] < $amount)
                return self::ERR_NOT_ENOUGH_BALANCE;
        }

        /** Create Cobone and add it to db * */
        $data['owner_id'] = $user_id;
        $data['amount'] = $amount;
        $data['cobone_time'] = time();
        /** GENERATE RANDOM NUMBER * */
        $str = substr(md5($data['cobone_time']), 5, 5);
        $numbers = join(array_map(function ($n) {
                            return sprintf('%03d', $n);
                        }, unpack('C*', $str)));


        /** CHECK IF THIS RANDOM NUMBER EXIST * */
        $check = $this->db->select_record('cobones', "code = '$numbers'");
        if ($check)
            return self::ERR_RETRY;

        /** Fix fraction problem * */
        $data['amount'] = floor($data['amount']);
        /** TRANSFER COBONE HERE * */
        if ($user['admin_type'] != 1) {
            $transaction[] = "UPDATE accounts SET balance = balance - {$data['amount']} WHERE id = '$user_id'";
        }

        $transaction[] = "INSERT INTO cobones (code,amount,owner_id,cobone_time) VALUES ({$numbers},{$data['amount']},{$user_id},'{$data['cobone_time']}')";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;

        return 1;
    }

    public function deleteCobone($user_id, $id) {
        $cobone = $this->db->select_record('cobones', "owner_id = '$user_id' AND id = '$id'");

        if (!$cobone)
            return self::ERR_NO_COBONE;

        if ($cobone['charger_id'])
            return self::ERR_COBONE_USED;

        /** TRANSFER COBONE HERE * */
        $transaction[] = "UPDATE accounts SET balance = balance + {$cobone['amount']} WHERE id = '$user_id'";
        $transaction[] = "DELETE FROM cobones WHERE id = $id";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;

        return 1;
    }

    public function chargeCobone($code, $user_id) {
        $cobone = $this->db->select_record('cobones', "code = '$code'");
        if (!$cobone)
            return self::ERR_NO_COBONE;

        if ($cobone['charger_id'])
            return self::ERR_COBONE_USED;

        /** Charge Cobone * */
        /** TRANSFER COBONE HERE * */
        $transaction[] = "UPDATE accounts SET balance = balance + {$cobone['amount']} WHERE id = '$user_id'";
        $transaction[] = "UPDATE cobones SET charger_id = $user_id  WHERE id = '{$cobone['id']}'";
        $transaction[] = "INSERT INTO transactions (from_id,to_id,amount,datetime1,type,notes) VALUES ({$cobone['owner_id']},{$user_id},{$cobone['amount']},NOW(),'out','Cobone Charge')";


        $transaction_do = $this->db->transaction($transaction);
        if (!$transaction_do)
            return self::ERR_TRANSFER_FAILED;

        return 1;
    }

    /**
     * Get Cobones
     * @param type $user_id
     * @param type $count
     * @param type $page 
     */
    public function getCobones($user_id = false, $count = false, $page_no = false, $order, $dir, $filter = false) {

        //Order by
        if ($order)
            $order_by = $order;
        if ($dir == 'up')
            $order_by .=' DESC';

        if ($dir == 'down')
            $order_by .=' ASC';

        if ($user_id)
            $sql = "owner_id = '$user_id'";

        $join_fields = "A.mobile as from_mobile,B.mobile as to_mobile";
        $join_sql = "INNER JOIN accounts A ON A.id = cobones.owner_id
                     LEFT JOIN accounts B ON B.id = cobones.charger_id";

        if ($filter) {
            if ($sql)
                $sql.=' AND ';
            $sql.= "cobones.code = '$filter'";
        }
        return $this->db->select('cobones', $sql, false, false, (($order_by) ? $order_by : 'cobone_time DESC'), limit($count, $page_no, true), $join_fields, $join_sql);
    }

    public function getCobonesCount($user_id = false) {
        $sql = "SELECT COUNT(*) FROM cobones ";
        if ($user_id)
            $sql.="WHERE owner_id = $user_id";
        return $this->db->query_value($sql);
    }

    public function addCredit($user_id, $amount) {
        $sql = "UPDATE accounts SET balance = balance + '$amount' WHERE id = '$user_id'";
        return $this->db->execute($sql);
    }

    /** Charge by mobile credit card * */
    public function chargeByMobile($account_id, $data) {
        if (!$data['amount'] || !$data['card_number'] || !$data['service_provider']) {
            return self::ERR_EMPTY_FIELD;
        }

        $data['account_id'] = $account_id;
        $data['datetime1'] = date('Y-m-d H:i:s');
        return $this->db->insert('mobile_charge', $data);
    }

    public function getMobileCharge($filter = false, $count, $page_no) {
        $join_sql = "INNER JOIN accounts  ON accounts.id = mobile_charge.account_id";
        $join_fields = "accounts.email,accounts.firstname,accounts.lastname,accounts.mobile,accounts.balance";


        if ($filter['keyword']) {
            $kw = trim($filter['keyword']);
            $sql = "(accounts.mobile ='$kw' OR accounts.email = '$kw')";
        }

        $csql = "SELECT COUNT(*) FROM mobile_charge $join_sql";
        if ($sql)
            $csql .= " WHERE " . $sql;

        $this->mobile_count = $this->db->query_value($csql);

        return $this->db->select('mobile_charge', $sql, false, false, "datetime1 DESC", limit($count, $page_no, true), $join_fields, $join_sql);
    }

    public function acceptMobile($id, $user_id, $reject = false) {
        $id = intval($id);

        $join_sql = "INNER JOIN accounts  ON accounts.id = mobile_charge.account_id";
        $join_fields = "accounts.email";
        $mobile = $this->db->select_record('mobile_charge', "mobile_charge.id = '{$id}'", false, false, false, false, $join_fields, $join_sql);


        if ($mobile['accepted'] == '0') {
            if (!$reject) {
                $new_amount = $mobile['amount'] - ($mobile['amount'] * 0.05);
                $transfer = $this->transfer($user_id, $mobile['email'], $new_amount);
                if ($transfer < 0)
                    return $transfer;

                $accept = 1;
            }else {
                $accept = 2;
            }
            //Accept
            return $this->db->update('mobile_charge', array('accepted' => $accept), "id = '{$id}'");
        } else {
            return self::ERR_ALREADY_PAIED;
        }
    }

    /** Reports * */
    function getReport() {
        $total_credit = "SELECT SUM(balance) FROM accounts";
        $report['credit'] = $this->db->query_value($total_credit);
        $today = date('Y-m-d');
        $yesterday = strtotime('-1 day', strtotime($today));
        $yesterday = date('Y-m-d', $yesterday);

        $last_month = strtotime('-30 day', strtotime($today));
        $last_month = date('Y-m-d', $last_month);

        $last_year = strtotime('-365 day', strtotime($today));
        $last_year = date('Y-m-d', $last_year);

        //Transactions
        $report['t_today'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE DATE(datetime1) = '$today'");
        $report['t_yesterday'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE DATE(datetime1) = '$yesterday'");
        $report['t_month'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_month')");
        $report['t_year'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_year')");

        //Withdraw
        $report['w_today'] = $this->db->query_value("SELECT SUM(amount) FROM withdrawl_requests WHERE DATE(datetime1) = '$today' AND accepted = 1");
        $report['w_yesterday'] = $this->db->query_value("SELECT SUM(amount) FROM withdrawl_requests WHERE DATE(datetime1) = '$yesterday' AND accepted = 1");
        $report['w_month'] = $this->db->query_value("SELECT SUM(amount) FROM withdrawl_requests WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_month' AND accepted = 1) ");
        $report['w_year'] = $this->db->query_value("SELECT SUM(amount) FROM withdrawl_requests WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_year' AND accepted = 1)");

        //Deposit
        $report['d_today'] = $this->db->query_value("SELECT SUM(amount) FROM deposit_requests WHERE DATE(deposit_time) = '$today'");
        $report['d_yesterday'] = $this->db->query_value("SELECT SUM(amount) FROM deposit_requests WHERE DATE(deposit_time) = '$yesterday'");
        $report['d_month'] = $this->db->query_value("SELECT SUM(amount) FROM deposit_requests WHERE (DATE(deposit_time) <= '$today' AND DATE(deposit_time) >= '$last_month')");
        $report['d_year'] = $this->db->query_value("SELECT SUM(amount) FROM deposit_requests WHERE (DATE(deposit_time) <= '$today' AND DATE(deposit_time) >= '$last_year')");



        $admin = $this->db->select_record('accounts', "admin_type = 1");
        $admin_id = $admin['id'];


        //Transactions
        $report['s_today'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE DATE(datetime1) = '$today' AND to_id = '$admin_id'");
        $report['s_yesterday'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE DATE(datetime1) = '$yesterday' AND to_id = '$admin_id'");
        $report['s_month'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_month' AND to_id = '$admin_id')");
        $report['s_year'] = $this->db->query_value("SELECT SUM(amount) FROM transactions WHERE (DATE(datetime1) <= '$today' AND DATE(datetime1) >= '$last_year' AND to_id = '$admin_id')");

        return $report;
    }
    
    // Verify Deduction
    public function verify_deduction($data){
    	
    }

}

?>
