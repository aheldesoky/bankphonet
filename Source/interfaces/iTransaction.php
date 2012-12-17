<?php

interface Itransactions {
    
    /** Error Codes **/
    const ERR_NOT_ENOUGH_BALANCE = -21;
    const ERR_WRONG_AMOUNT = -22;
    const ERR_USER_NOT_EXIST = -23;
    const ERR_TRANSFER_TOME = -24;
    const ERR_TRANSFER_FAILED = -25;
    const ERR_REFUND_NOTEXIST = -26;
    const ERR_MIN_WITHDRAW = -27;
    const ERR_MAX_WITHDRAW = -28;
    const ERR_REFUNDED_BEFORE = -29;
    const ERR_RETRY = -30;
    const ERR_NO_COBONE = -31;
    const ERR_COBONE_USED = -32;
    const ERR_EMPTY_FIELD = -33;
    const ERR_ALREADY_PAIED = -34;
    /**
     * Get all transactions credit
     * @param int $myid
     * @param int $count
     * @param int $page_no
     * @param string $order_by
     * @return array of transactions 
     */
    public function transactions_get ($myid,$count = false,$page_no =false,$order=false);
    
    /**
     * Get all transactions score
     * @param int $myid
     * @param int $count
     * @param int $page_no
     * @param string $order_by
     * @return array of transactions
     */
    public function transactions_score_get ($myid,$count = false,$page_no =false,$order=false);
    
     /**
     * return transaction credit count 
     * @param int $myid
     * @return int number of transactions 
     */
    public function transactions_get_count ($myid =false);

    /**
     * return transaction score count
     * @param int $myid
     * @return int number of transactions
     */
    public function transactions_score_get_count ($myid =false);
    
            
    /**
     * get one Transaction using it's id and my id
     * @param int $id
     * @param int $myid
     * @return array transaction data 
     */
    public function transaction_get_one ($id,$my_id =false);
    
    /**
     * Transfare balance from account to account
     * @param int $from_id
     * @param int $to_id
     * @param decimal $amount
     * return error code on fail and true on success 
     */
    public function transfer ($from_id,$to_id,$amount);
    
    /**
     * Transfare points from account to account
     * @param int $from_id
     * @param int $to_id
     * @param decimal $amount
     * return error code on fail and true on success
     */
    public function transfer_points ($from_id,$to_id,$amount);
    
     /**
     * Refund
     * @param int $id
     * @param int $myid 
     * return error code on error and 1 on success
     */
    public function refund ($id,$myid);
    

}
?>
