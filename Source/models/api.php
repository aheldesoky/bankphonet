<?php
include __DIR__ . "/../interfaces/iAPI.php";

class api implements Iapi{
    
   public function __construct() {
       global $oUser;
       global $db;
       
       $this->user = $oUser ; //User api
       $this->db = $db;
   }
    
    
    
    /**
	 * 
	 *
	 * You can call this method to insure that transaction was happened or not
	 * @param string $private_key
	 * @param integer $transaction_id
	 * @param integer $amount
	 *
	 * @return boolean
	 *
	 */
    public function confirm($private_key, $transaction_id, $amount){
        
        
        $user_id = $this->user->private_to_id ($private_key);
       
        $transaction = $this->db->select_record ('transactions',"id= '{$transaction_id}' AND to_id = '{$user_id}' AND amount = '{$amount}'");
        
        if($transaction)
            return true;
        else
            return false;
    }
    
    }


?>
