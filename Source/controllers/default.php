<?php
//if i logged and didn't verify my mobile
if ((!empty($oUser->id) && $oUser->mobile_verified == 0) && ($page != 'verify' && $action != 'logout')) {
    $notify_msg = l('Please verify your mobile number so you can use your account');
    save_session_messages();
    go_to('?page=verify');
}



if ($page == 'transactions') {
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
    $order = ifempty($_GET['order'], 'datetime1');
    $dir = ifempty($_GET['dir'], 'up');


    $page_no = ifempty($_GET['page-no'], 1);
    $transactions = $oTransactions->transactions_get($oUser->id, LIST_COUNT, $page_no, $order, $dir);


    $count = $oTransactions->transactions_get_count($oUser->id);
    $pages_count = ceil($count / LIST_COUNT);
    
    $inner_page = 'views/transactions/transactions.php';
    include $master_page;
}

// Transfer
if ($page == 'transfer') {
    //Not logged ?
   if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
    //No Enough balance
    if ($oUser->balance <= 0) {
        $error_msg = l('Sorry : you dont have enough balance !');
        save_session_messages();
        go_to('?page=transactions');
    }
    //Check Post
    if ($_POST) {
        $transfer = $oTransactions->transfer($oUser->id, $_POST['mobile'], $_POST['amount']);

        if ($transfer <= 0) {
            $error_msg = l($oError->message($transfer));
        } else {
            $notify_msg = l("Transaction done");
            save_session_messages();
            go_to('?page=transactions');
        }
    }

    $inner_page = 'views/transactions/transfer.php';
    include $master_page;
}


if ($page == 'refund') {
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
        
        
    $id = empty2false($_GET['id']);
    //Check if there are no id
    if (!$id) {
        $error_msg = l('Error : Bad request');
        save_session_messages();
        go_to('?page=transactions');
    }

    //Get transaction
    $transaction = $oTransactions->transaction_get_one($id, $oUser->id, 'in');
    if (!$transaction) {
        $error_msg = l('Sorry there are no transaction for you with this id');
        save_session_messages();
        go_to('?page=transactions');
    }


    if ($_POST) {
        $refund = $oTransactions->refund($id, $oUser->id);
        if ($refund != 1)
            $error_msg = l($oError->message($refund));
        else {
            $notify_msg = l('Operation done successfully');
            save_session_messages();
            go_to('?page=transactions');
        }
    }



    $inner_page = 'views/transactions/refund.php';
    include $master_page;
}



if ($page == 'default') {

	//If !user show the normal home page
	if (!$oUser->id){
		$countries = $oUser->countries_get();
		$inner_page = 'views/main.php';
		include $master_page;

	//Else show the main page without the registration form
	}else{
		
		$inner_page = 'views/main-in.php';
		include $master_page;
	}
    
}




if ($page == 'register') {
    if ($oUser->id)
        go_to();

    if ($_POST) {
        $register_data = $oUser->register($_POST);


        if ($register_data != 1)
            $error_msg = l($oError->message($register_data));
        else {

            $notify_msg = l('Thank you for regestering our service please check your mobile for verfication code ');
            save_session_messages();
            go_to('?page=login');
        }
    }

    $countries = $oUser->countries_get();
    $inner_page = 'views/accounts/register.php';
    include $master_page;
}


/**
 * Login page 
 */
if ($page == 'login') {
    if ($oUser->id)
        go_to();

    if ($_POST) {
        $login = $oUser->authenticate($_POST['email'], $_POST['password'], 1);
        if ($login != 1)
            $error_msg = l($oError->message($login));
        else {
            $ref = empty2false($_GET['ref']);
            
            //Check if logged in and didn't invite any friends
            if((!empty($oUser->id) && $oUser->mobile_verified == 1 && $oUser->invite_friends ==0)){
            $notify_msg = l('Invite your friends to try bankphonet now');
            save_session_messages();
                go_to ('?page=invite-friends');
            }
            
            if ($ref)
                go_to($ref);
            else
                go_to();
        }
    }
    $inner_page = 'views/accounts/login.php';
    include $master_page;
}




if($page == 'editprofile')
{
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
    
    $id = ifempty($_GET['id'], $oUser->id);
    //Check If iam admin
     if($oUser->admin ==1)
        $id = $id;
    else
        $id = $oUser->id;
    
    if($_POST){
        $edit_profile = $oUser->update_account ($id,$_POST);
        if($edit_profile <=0){
            $error_msg = l($oError->message ($edit_profile));
            save_session_messages();
            go_to ('?page=editprofile');
        }else{
            
            if($oUser->id == $id){
                $notify_msg = l('Your profile was updated successfully !');
                save_session_messages();
                go_to ('?con=view&page=myprofile');
            }else{
                $notify_msg = l('This profile was updated successfully !');
                save_session_messages();
                go_to('?con=admin&page=admin-accounts');
            }
        }
    }
    
   
    
    $profile = $oUser->get_user_profile ($id);
     $countries = $oUser->countries_get();
    $inner_page = 'views/accounts/editprofile.php';
    include $master_page;
}


/**
 * Login page 
 */
if ($page == 'verify') {
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
        
    if ($oUser->mobile_verified == 1) {
        $notify_msg = l('You have been verified your mobile');
        save_session_messages();
        go_to();
    }

    if ($_POST) {
        $notify_msg = ''; //Clear notify
        $verify = $oUser->verify_mobile($oUser->id, $_POST['code']);
        if ($verify != 1)
            $error_msg = l($oError->message($verify));
        else {
            $notify_msg = l("Your mobile has been verified");
            save_session_messages();
            go_to();
        }
    }

    $inner_page = 'views/accounts/verify_mobile.php';
    include $master_page;
}


/* order page
 * 
 */

if ($page == 'order') {
    //Get Parameters
    $public_key = ifempty($_GET['pk'], $_SESSION['pk']);
    $amount = ifempty($_GET['am'], $_SESSION['am']);
    $go_back_link = ifempty($_GET['gb'], $_SESSION['gb']);

    //Check Authorization
    if ($public_key && $amount && $go_back_link) {
        //SET SESSIONS FIRST
        $_SESSION['pk'] = $public_key;
        $_SESSION['am'] = $amount;
        $_SESSION['gb'] = $go_back_link;
        //Check if logged in ?
        if (!$oUser->id) {
            $error_msg = l('You must log in to order');
            save_session_messages();
            go_to('?page=login&ref=' . getURL());
        }
    } else {
        $error_msg = l('Bad page request !');
        save_session_messages();
        go_to();
    }


    //ORDER INFO
    $to_id = $oUser->public_to_id($public_key);
    //Bad public key
    if (!$to_id) {
        $error_msg = l('This user key is not exist');
        save_session_messages();
        go_to();
    }

    $to_data = $oUser->get_user_by_id($to_id);

    //Do transfer and go_to go back link
    if ($_POST) {
        //Clear Old data 
        $_SESSION['pk'] = '';
        $_SESSION['am'] = '';
        $_SESSION['gb'] = '';

        $transfer = $oTransactions->transfer($oUser->id, $to_data['email'], $amount);
        if ($transfer <= 0) {
            $error_msg = l($oError->message($transfer));
            save_session_messages();
            go_to();
        } else {
            /* do add to admin 2 %
             * it will no't diduct if transfer to admin (not deduct from admin to admin)
             */
            $new_amount = round((0.02 * $amount),2); 
            $to_user_id = $oUser->get_user_by_email_mobile ($to_data['email']);
            $supper_admin = $oUser->getSupperAdmin ();
            $oTransactions->transfer($to_user_id['id'], $supper_admin['email'], $new_amount);
            //End deduction of 2%
            
            //Go Back here 
            $url_vars = parse_url($go_back_link);
            //Check schema 1st
            if(!$url_vars['scheme'])
                $go_back_link = 'http://'.$go_back_link;
            
            if($url_vars['query'])
                go_to ($go_back_link.'&tid='.$transfer);
            else
                go_to ($go_back_link.'?tid='.$transfer);
        }
    }

    $inner_page = 'views/transactions/order.php';
    include $master_page;
}








if($page == 'myprofile')
{
     if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
     
    $profile = $oUser->get_user_profile ($oUser->id);
    $inner_page = 'views/accounts/myprofile.php';
    include $master_page;
}



if($page == 'request-withdraw')
{
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
        
        
    if($_POST){
        
        if($_POST['bank_title'])
            //Add bank first
            $_POST['bank_id'] = $oTransactions->addBank ($_POST['bank_title'],$_POST['country_code']);
            
        
        
        unset ($_POST['bank_title']);
        
        
        $withdraw_request = $oTransactions->requestWithdraw ($oUser->id,$_POST,$oUser->balance);
        if($withdraw_request < 0)
            $error_msg = l($oError->message ($withdraw_request));
        else{
            $notify_msg = l('Your request is sent,we will process it soon');
            save_session_messages();
            go_to();
        }
    }
    
    
    $countries = $oUser->countries_get ();
    $inner_page = "transactions/request-withdraw.php";
    include $master_page;
}



if($page == 'partner-solutions'){
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
     
    $profile = $oUser->get_user_profile ($oUser->id);
    $inner_page = 'views/accounts/partner-solutions.php';
    include $master_page;
}
/**
 * Logout 
 */
if ($action == 'logout') {
    $oUser->logout();
    go_to();
}



if($page == 'invite-friends'){
    if (!$oUser->id){
        $error_msg = l('You have to login first');
        save_session_messages();
        go_to('?page=login');
        }
    
    
    if($oUser->invite_friends == 1){
        $notify_msg = l('You have already invited your friends');
        save_session_messages();
        go_to ();
    }
    
    
    if($_POST){
        foreach ($_POST['friend'] as $mobile) {
           $sms = file_get_contents ("http://www.smsbox.com/API/HTTP/default.ashx?Operation=SendMessage&UserName=tqniat&Password=ahmad123&IsUnicode=false&Body=".urlencode($oUser->title.' '.$oUser->firstname.' '.$oUser->lastname.' invites you to BankPhonet.com')."&Sender=Tqniat&Recepients=".$mobile);

        }
        
        $oUser->disableInviteFriends ($oUser->id);
        $notify_msg = l('Thank you for inviteing your friends');
        save_session_messages();
        go_to ();
    }
    
    $inner_page = 'views/accounts/invite-friends.php';
    include $master_page;
}


if($page == 'contact-us'){
    if($_POST)
    {
	$body = "لقد قام " . $_POST['contact_name'] . " بارسال الاتى : \n";
	$body .= $_POST['contact_message'];
	$body .= "\n وبياناته كالاتى : \n";
	$body .= "البريد الاليكترونى : " . $_POST['contact_email'] . "\n";
	$body .= "التليفون :" . $_POST['contact_phone'];
	$subject = 'رسالة من الموقع';
	$send = mail(CONTACT_EMAIL, $subject, $body, EMAIL_HEADERS);
	
	$notify_msg = l("Thank you for contacting us !");
        save_session_messages();
        go_to();
    }
    
    
    $inner_page = 'views/contact-us.php';
    include $master_page;


}




if($ajax == 'get_banks'){
   
   $country = $_GET['cn'];
   $banks = $oTransactions->getBanks ($country);
 
   if($banks){
        $banks_html =  generate_select_options($banks, 'title', 'id');
        $banks_html .= "<option value=''>".l('Other')."</option>";
        echo $banks_html;
   }
    
       
}