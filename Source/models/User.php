<?php

/* User Class Contain's all user related methods */
include __DIR__ . "/../interfaces/iUser.php";

class User implements Iuser {

    //Holder For db object
    private $db = false;
    private $store = false;
    //Translations for error codes

    public $id = '';
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $mobile = '';
    public $mobile_verified = '';
    public $verify_code = '';
    public $blocked = '';
    public $join_date = '';
    public $last_access = '';
    public $password = '';
    public $balance = '';
    public $admin = '';
    public $admin_type = '';
    public $invite_friends = '';

    public function __construct(Cdb $db) {
        ////use global object of db locally

        $this->db = $db;
        //Check User Session
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $this->authenticate_by_id($_SESSION['user_id']);
        }

        // check if cookie exist, use it to login
        if ((isset($_COOKIE['user_id'])) and ($_COOKIE['user_id'] != '')) {
            $user_id = $_COOKIE['user_id'];
            return $this->authenticate_by_id($user_id, true);
        }
    }

    /**
     * Register a new account.
     *
     * @param string username should be enlish chars & numbers only
     * @param string email
     * @param string password
     * @return userobject
     * @throws ERROR_CODE
     */
    public function register($data, $send_mail = false,$send_sms = true) {

        //Validate first and last name
        if (empty($data['firstname']) || empty($data['lastname']))
            return self::ERR_EMPTY_FIELD;

        //Validate email
        $v_email = $this->validate_email($data['email']);
        if ($v_email != 1)
            return $v_email;
        //Validate mobile
        $v_mobile = $this->validate_mobile($data['mobile']);
        if ($v_mobile != 1)
            return $v_mobile;

        //Validate password
        if (mb_strlen($data['password']) < 6 || mb_strlen($data['repassword']) < 6) {
            return self::ERR_PASSWORD_LESS;
        }

        if ($data['password'] != $data['repassword'])
            return self::ERR_PASSWORD_MATCH;


        $data['join_date'] = 'NOW()';
        $data['verify_code'] = substr(sha1(date('Y-m-d H:i:s')), 0, 5);
        $data['salt'] = md5(date('Y-m-d H:i:s')); //genrate salt
        $data['password'] = MD5(MD5($data['password']) . MD5($data['salt']));

        unset($data['repassword']);
        $id = $this->db->insert('accounts', $data);
        $this->verify_code = $data['verify_code'];

        // $this->authenticate_by_id($id);
        // send verify email
        if($send_sms)
            $sms = file_get_contents ("http://www.smsbox.com/API/HTTP/default.ashx?Operation=SendMessage&UserName=tqniat&Password=ahmad123&IsUnicode=false&Body=".urlencode('BankPhonet.com verification code: '.$data['verify_code'])."&Sender=Tqniat&Recepients=".$data['mobile']);
       
        if ($send_mail) {
            $template = "views/accounts/email_register_verify.php";
            $body = render($template);
            $subject = 'رسالة تفعيل البريد الالكترونى';
            $s = mail($data['email'], $subject, $body, EMAIL_HEADERS);
        }
        
        $this->authenticate_by_id ($id); //Login directly

        return 1;
    }

    public function verify_mobile($id, $verify_code) {
        if ($verify_code != $this->verify_code)
            return self::ERR_VERIFY;

        return $this->db->update('accounts', array('mobile_verified' => 1), "id = '$id'");
    }

    /**
     * Login
     *
     * @param string email
     * @param string password
     * @return userobject
     * @throws ERROR_CODE
     *
     */
    public function authenticate($email, $password, $remember_me) {
        /* Validate email
          $v_email = $this->validate_email($email, 1);
          if ($v_email != 1)
          return $v_email;
         * */


//Validate password
        if (empty($password)) {
            return self::ERR_WRONG_PASSWORD;
        }

//Validate User 
        $salt = $this->db->select_record('accounts', "(email = '$email' || mobile = '$email')");

        $user = $this->db->select_record('accounts', "(email = '$email' || mobile = '$email') AND password = '" . MD5(MD5($password) . MD5($salt['salt'])) . "'");

        if (!$user)
            return self::ERR_LOGIN_FAILED;

        if ($user['blocked'] == 1)
            return self::ERR_USER_BLOCKED;


//Set Session Of ID
        $_SESSION['user_id'] = $user['id'];
//Update Last Access
        $this->db->update('accounts', array('last_access' => 'NOW()'), "id='" . $user['id'] . "'");
//Set User Data
        $this->set_user_data($user);

        if ($remember_me) {
            setcookie('logged', true, mktime(0, 0, 0, 1, 1, 2030));
            setcookie('user_id', $this->id, mktime(0, 0, 0, 1, 1, 2030));
        }


        return 1;
    }

    /**
     * Authenticate user by his id
     * @param type $id
     * @return boolean 
     */
    private function authenticate_by_id($id) {
        if (empty($id))
            return false;
        $this->db->safeit($id);

//get user data
        $user = $this->db->select_record('accounts', "id='$id'");
        if (!$user)
            return false;

//If Blocked kik him out
        if ($user['blocked'] == 1)
            return false;

//Set User Data
        $this->set_user_data($user);
//Set User Id
        $_SESSION['user_id'] = $user['id'];
//Update Last Access
        $this->db->update('accounts', array('last_access' => 'NOW()'), "id='" . $user['id'] . "'");

        return true;
    }

    /**
     * set object user data
     * @param type array of user data
     */
    private function set_user_data($user) {
        $this->id = $user['id'];
        $this->firstname = $user['firstname'];
        $this->lastname = $user['lastname'];
        $this->email = $user['email'];
        $this->mobile = $user['mobile'];
        $this->mobile_verified = $user['mobile_verified'];
        $this->verify_code = $user['verify_code'];
        $this->blocked = $user['blocked'];
        $this->join_date = $user['join_date'];
        $this->last_access = $user['last_access'];
        $this->password = $user['password'];
        $this->balance = $user['balance'];
        $this->admin = $user['admin'];
        $this->admin_type = $user['admin_type'];
        $this->invite_friends = $user['invite_friends'];
    }

    /**
     * Retreive password
     *
     * @param string email
     * @return password
     * @throws ERROR_CODE
     */
    public function retreive_password($email) {
        return $this->db->select_record('accounts', "email = '{$email}'");
    }

    public function change_password($id, $data) {
        if (empty($data['old']) || empty($data['password']) || empty($data['cpassword']))
            return self::ERR_EMPTY_FIELD;

        //Check if user exist
        $user = $this->get_user_by_id($id);
        if ($user < 0)
            return $user;

        //Check if old password correct !
        if ($data['old'] != $user['password'])
            return self::ERR_WRONG_PASSWORD;

        //Check if passwords dosen't match
        if ($data['password'] != $data['cpassword'])
            return self::ERR_PASSWORD_NOT_MATCH;

        //Do the job here 
        $update = $this->update_account($id, array('password' => $data['password']), true);
        return $update;
    }

    /**
     * Update account information
     *
     * @param integer id
     * @param array data
     * @return accountobject
     * @throws ERROR_CODE
     */
    public function update_account($id, array $data) {
        //Validate Email,mobile
        //Validate first and last name
        if (empty($data['firstname']) || empty($data['lastname']))
            return self::ERR_EMPTY_FIELD;

        //Validate email
        $v_email = $this->validate_email($data['email'], false, $id);
        if ($v_email != 1)
            return $v_email;
        //Validate mobile
        $v_mobile = $this->validate_mobile($data['mobile'],$id);
        if ($v_mobile != 1)
            return $v_mobile;

        /** TODO: update user ads to belong for him if admin updated his username * */
        return $this->db->update('accounts', $data, "id= $id ");
    }

    
    /**
     * Disable invite friends if i already did
     * @param type $id
     * @return type 
     */
    
    public function disableInviteFriends ($id){
    
        return $this->db->update('accounts', array ('invite_friends'=>1), "id= $id ");
    }
    /**
     * 
     */
    public function block_account($id, array $data) {
        return $this->db->update('accounts', $data, "id = '$id'");
    }

    /*
     * Validate mobile number
     */

    private function validate_mobile($mobile, $id = false) {
        if (empty($mobile))
            return self::ERR_EMPTY_FIELD;

        if ($id)
            $sql = "mobile = '$mobile' AND id != $id";
        else
            $sql = "mobile = '$mobile'";
        
        $user = $this->db->select_record('accounts', $sql);
        if ($user)
            return self::ERR_MOBILE_EXIST;

        return 1;
    }

    /**
     * validate email function
     * @param type $email
     * @param type is this function used for login page ?
     * @return type 1 or error code 
     */
    public function validate_email($email, $for_login = false, $id = false) {

        if (empty($email))
            return self::ERR_WRONG_EMAIL;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return self::ERR_WRONG_EMAIL;

        if (!$for_login) {
            $email = trim($email);

            if ($id)
                $sql = "email = '$email' AND id != $id";
            else
                $sql = "email = '$email'";

            $user = $this->db->select_record('accounts', $sql);
            if ($user)
                return self::ERR_EMAIL_EXIST;
        }
        return 1;
    }

    /**
     * function to check if user exist by id
     */
    public function get_user_by_id($id) {
        $user = $this->db->select_record('accounts', "id = '$id'");
        if (!($user))
            return self::ERR_USER_NOT_FOUND;
        return $user;
    }
    
    /**
     * function to check if user exist by email,mobile
     */
    public function get_user_by_email_mobile($email_mobile) {
        $user = $this->db->select_record('accounts', "email = '$email_mobile' OR mobile = '$email_mobile'");
        if (!($user))
            return self::ERR_USER_NOT_FOUND;
        return $user;
    }
    
    public function getSupperAdmin (){
        $user = $this->db->select_record('accounts', "admin_type = 1");
        if (!($user))
            return self::ERR_USER_NOT_FOUND;
        
        return $user;
    }


    /**
     * return user proile
     * @param type $id 
     */
    public function get_user_profile($id) {
        global $local;
        $join_fields = "title_$local as country_title";
        $join_sql = "LEFT JOIN countries ON countries.code = accounts.country_code";
        return $this->db->select_record('accounts', "id = '{$id}'", false, FALSE, false, false, $join_fields, $join_sql);
    }

    /**
     * Get Countries
     * @global type $local
     * @return type 
     */
    public function countries_get() {
        global $local;
        $custom_select = "title_$local as title,code";
        return $this->db->select('countries', false, false, $custom_select, 'code ASC');
    }

    /**
     * Generate the public key for this account
     */
    public function generate_public_key($account_id) {
        $secret_key = "BANK"; //Secret Code 1
        $iv = "1234567812345678"; //Secret Code 2 it must be 16 digits
        return openssl_encrypt($account_id, 'aes128', $secret_key, false, $iv);
    }

    /**
     * Generate the private key for this account
     */
    public function generate_private_key($account_id) {
        $secret_key = "BANKP"; //Secret Code 1
        $iv = "1234567812345679"; //Secret Code 2 it must be 16 digits
        return openssl_encrypt($account_id, 'aes128', $secret_key, false, $iv);
    }

    /**
     * Get account ID from private key
     */
    public function private_to_id($key) {
        $secret_key = "BANKP"; //Secret Code 1
        $iv = "1234567812345679"; //Secret Code 2 it must be 16 digits
        return openssl_decrypt($key, 'aes128', $secret_key, false, $iv);
    }

    /**
     * Get account ID from public key
     */
    public function public_to_id($key) {
        $secret_key = "BANK"; //Secret Code 1
        $iv = "1234567812345678"; //Secret Code 2 it must be 16 digits
        return openssl_decrypt($key, 'aes128', $secret_key, false, $iv);
    }
    
    
    /**
     * Get all acounts to admin 
     */
    public function getAccounts ($email=fasle,$count = false,$page_no=false,$order=false,$dir=false){
        //If user Filter used email
        if($email)
            $sql = "(email = '$email' OR mobile = '$email')";
        
        //Don't Get admin
        if($sql) $sql .= ' AND ';
        
        //Don't get supper admin
        $sql .= ' admin_type != 1';
        
        if($order)
            $order_by = $order;
        //Check Dir
        if($dir=='up')
            $order_by .= " DESC";
        
        if($dir=='down')
            $order_by .= " ASC";
        
        return $this->db->select ('accounts',$sql,false,false,($order_by) ? $order_by : 'join_date DESC',limit($count,$page_no,true));
    }
    
    /**
     * Get Accounts Count 
     */
    public function getAccountsCount ($email){
        $sql = "SELECT COUNT(*) FROM accounts ";
        if($email)
            $sql .= "WHERE email ='$email' OR mobile ='$mobile'";
        
        if($email)
            $sql .= ' AND ';
        else
            $sql .= ' WHERE ';
        
         $sql .= ' admin != 1';
        return $this->db->query_value($sql);
    }

    /**
     * logout user
     */
    public function logout() {
        unset($_SESSION['user_id']);
        setcookie('logged');
        setcookie('user_id');
    }

    public function __destruct() {
        unset($this->db);
    }

}
