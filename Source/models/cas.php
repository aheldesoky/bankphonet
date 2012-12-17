<?php

class cas{
    
    
    function __construct() {
        global $oUser;
        $this->oUser = $oUser;
    }
    
    /**
     * Register new user at bank phonet 
     * @param mixed $data
     * @param boolean $send_email
     * @param boolean $send_sms
     * @param boolean $return_data
     * @return mixed
     */
    public function register ($data,$send_email,$send_sms,$retun_data){
       $reg = $this->oUser->register ($data,$send_email,$send_sms,$retun_data);
       return $reg;
    }
    
    /**
     * remotely authenticate user
     * @param string $email
     * @param string $password
     * @param boolean $return_data
     * @return mixed 
     */
    public function authenticate ($email,$password,$remember,$returndata){
        $auth = $this->oUser->authenticate ($email,$password,$remember,$returndata);
        return $auth;
    }
    
    /**
     * verify user mobile
     * @param integer $id
     * @param string $code
     * @return string 
     */
    public function verify_mobile ($id,$code){
        $verify = $this->oUser->verify_mobile ($id,$code);
        return $verify;
    }
    
    /**
     * reset password
     * @param string $email
     * @return string 
     */
    public function  resetPassword ($email){
        return $this->oUser->resetPassword ($email);
    }
    
    
    /**
     * get public key
     * @param integer id
     * @return string key
     */
    public function getPublicKey ($id){
        return $this->oUser-> generate_public_key($id);
    }
    
    /**
     * retrive private key
     * @param integer $id
     * @return string private key
     */
    public function getPrivateKey ($id){
        return $this->oUser-> generate_private_key($id);
    }
    
}

?>
