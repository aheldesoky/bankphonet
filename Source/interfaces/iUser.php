<?php

interface Iuser {
    //Error Codes

    const ERR_EMAIL_EXIST = -1;
    const ERR_WRONG_EMAIL = -2;
    const ERR_MOBILE_EXIST = -3;
    const ERR_PASSWORD_MATCH = -4;
    const ERR_PASSWORD_LESS = -5;
    const ERR_EMPTY_FIELD = -6;
    const ERR_LOGIN_FAILED = -7;
    const ERR_VERIFY = -8;
    const ERR_USER_BLOCKED = -9;
    const ERR_USER_NOT_FOUND = -10;
    const ERR_MOBILE_INVALID = -11;
    const ERR_WRONG_PASSWORD = -12;
    const ERR_EMAIL_SEND_FAIL = -13;
    const ERR_WRONG_SECURITY_CODE = -14;
    const ERR_WRONG_IP = -15;
    const ERR_MAX_REACTIVATE = -16;
    /**
     * This function is to register new user
     * @param array $data
     * @param bolean $send_mail
     * return true on success & error code on fail
     *  
     * */
    public function register($data, $send_mail = true);

    /**
     * verify user mobile number
     * @param integer $id
     * @param string $verify_code
     * return true on success & error code on fail 
     */
    public function verify_mobile($id, $verify_code);

    /**
     * Login
     *
     * @param string email
     * @param string password
     * @return userobject
     * @throws ERROR_CODE
     *
     */
    public function authenticate($email, $password, $remember_me);

    /**
     * retrive user password
     * TODo :SEND BY MOBILE 
     */
    public function retreive_password($email);

    /**
     * Change password 
     */
    public function change_password($id, $data);

    /**
     * Update account 
     */
    public function update_account($id, array $data);

    /**
     * Block account 
     */
    public function block_account($id, array $data);

    /**
     * Validate email 
     */
    public function validate_email($email, $for_login = false, $id = false);

    /**
     * Get user by id 
     */
    public function get_user_by_id($id);

    /**
     * Logout 
     */
    public function logout();

    /**
     * Generate the private key for this account
     */
    public function generate_private_key($account_id);

    /**
     * Generate the public key for this account
     */
    public function generate_public_key($account_id);

    /**
     * Get account ID from private key
     */
    public function private_to_id($key);

    /**
     * Get account ID from public key
     */
    public function public_to_id($key);

    /**
     * Get all acounts to admin 
     */
    public function getAccounts($email = fasle, $count = false, $page_no = false, $order = false, $dir = false);

    /**
     * Get Accounts Count 
     */
    public function getAccountsCount($email);

    /**
     * Forget Password 
     */
    public function forgetPassword($email);

    /**
     * reset password 
     */
    public function resetPassword($base_64_email);

    /**
     * Change user password 
     */
    public function changePassword($user_id, $old_password, $new_password, $repassword);
}

?>
