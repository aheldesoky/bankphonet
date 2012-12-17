<?php

if ($oUser->admin != 1) {
    go_to();
}

$_SESSION['local'] = 'en'; //SET LOCAL TO EN

if ($page == "default") {
	$page_title = "ADMIN HOME:";
    $inner_page = 'views/admin/home.php';
    include $master_page;
}


if ($page == 'admin-accounts') {
    if ($_POST) {

        if ($_POST['set'])
            $_SESSION['account_filter'] = $_POST['email'];
        else
            unset($_SESSION['account_filter']);

        go_to('?con=admin&page=admin-accounts');
    }

    $page_no = ifempty($_GET['page-no'], 1);
    $accounts = $oUser->getAccounts($_SESSION['account_filter'], LIST_COUNT, $page_no, $_SESSION['account_order'], $_SESSION['account_dir']);

    $count = $oUser->getAccountsCount($_SESSION['account_filter']);
    $pages_count = ceil($count / LIST_COUNT);
	$page_title = "ACCOUNTS:";
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}


if ($action == 'set-order') {
    $order = $_GET['order'];
    if ($_SESSION['account_dir'] == 'down')
        $_SESSION['account_dir'] = 'up';
    else
        $_SESSION['account_dir'] = 'down';


    $_SESSION['account_order'] = $order;
    go_to('?con=admin&page=admin-accounts');
}




if ($page == 'admin-transactions') {
    if ($_POST) {

        if ($_POST['set']) {
            $_SESSION['transaction_from'] = $_POST['from'];
            $_SESSION['transaction_to'] = $_POST['to'];
            $_SESSION['transaction_id'] = $_POST['tid'];
        } else {
            $_SESSION['transaction_from'] = '';
            $_SESSION['transaction_to'] = '';
            $_SESSION['transaction_id'] = '';
        }
        go_to('?con=admin&page=admin-transactions');
    }

    $page_no = ifempty($_GET['page-no'], 1);

    $transactions = $oTransactions->adminGetTransactions($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id'], LIST_COUNT, $page_no, $_SESSION['transaction_order'], $_SESSION['transaction_dir']);

    $count = $oTransactions->adminGetTransactionsCount($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id']);

    $pages_count = ceil($count / LIST_COUNT);
	$page_title = "TRANSACTIONS:";
    $inner_page = 'views/transactions/admin-transactions.php';
    include $master_page;
}


//Set Transaction order
if ($action == 'set-torder') {

    $order = $_GET['order'];
    if ($_SESSION['transaction_dir'] == 'down')
        $_SESSION['transaction_dir'] = 'up';
    else
        $_SESSION['transaction_dir'] = 'down';


    $_SESSION['transaction_order'] = $order;
    go_to('?con=admin&page=admin-transactions');
}




if ($page == 'admin-refund') {
    $id = empty2false($_GET['id']);
    //Check if there are no id
    if (!$id) {
        $error_msg = l('Error : Bad request');
        save_session_messages();
        go_to('?con=admin&page=admin-transactions');
    }

    //Get transaction
    $transaction = $oTransactions->transaction_get_one($id);
    if (!$transaction) {
        $error_msg = l('Sorry there are no transaction with this id');
        save_session_messages();
        go_to('?con=admin&page=admin-transactions');
    }


    if ($_POST) {
        $refund = $oTransactions->refund($id, $transaction['to_id']);
        if ($refund != 1)
            $error_msg = $oError->message($refund);
        else {
            $notify_msg = l('Operation done successfully');
            save_session_messages();
            go_to('?con=admin&page=admin-transactions');
        }
    }

    $inner_page = 'views/transactions/admin-refund.php';
    include $master_page;
}


if ($page == 'withdraw') {

    if ($_POST) {
        $from_user = $oUser->get_user_by_email_mobile($_POST['mobile']);
        if ($from_user <= 0) {
            $error_msg = $oError->message($from_user);
            save_session_messages();
            go_to('?con=admin&page=withdraw');
        }

        $withdraw = $oTransactions->transfer($from_user['id'], $oUser->email, $_POST['amount']);

        if ($withdraw <= 0) {
            $error_msg = $oError->message($withdraw);
            save_session_messages();
            go_to('?con=admin&page=withdraw');
        } else {
            $notify_msg = l("Withdraw done !");
            save_session_messages();
            go_to('?con=admin&page=admin-transactions');
        }
    }

	$page_title = "WITHDRAW:";
    $inner_page = 'views/transactions/withdraw.php';
    include $master_page;
}


if ($page == 'deposit') {

    if ($_POST) {

        $deposit = $oTransactions->transfer($oUser->id, $_POST['mobile'], $_POST['amount'], (($oUser->admin_type == 1) ? true:false));

        if ($deposit <= 0) {
            $error_msg = $oError->message($deposit);
            save_session_messages();
            go_to('?con=admin&page=deposit');
        } else {
            $notify_msg = l("Deposit done !");
            save_session_messages();
            go_to('?con=admin&page=admin-transactions');
        }
    }
	$page_title = "DEPOSIT:";
    $inner_page = 'views/transactions/deposit.php';
    include $master_page;
}


if ($page == 'admin-transfer') {


    if ($_POST) {
        $from_user = $oUser->get_user_by_email_mobile($_POST['mobilefrom']);
        if ($from_user <= 0) {
            $error_msg = $oError->message($from_user);
            save_session_messages();
            go_to('?con=admin&page=admin-transfer');
        }

        $transfer = $oTransactions->transfer($from_user['id'], $_POST['mobileto'], $_POST['amount']);

        if ($transfer <= 0) {
            $error_msg = $oError->message($transfer);

            save_session_messages();
            go_to('?con=admin&page=admin-transfer');
        } else {

            $notify_msg = l("Transfer done !");
            save_session_messages();
            go_to('?con=admin&page=admin-transactions');
        }
    }

	$page_title = "TRANSFER:";
    $inner_page = 'views/transactions/admin-transfer.php';
    include $master_page;
}


if ($page == 'newaccount') {


    if ($_POST) {
        $register_data = $oUser->register($_POST);


        if ($register_data != 1)
            $error_msg = l($oError->message($register_data));
        else {

            $notify_msg = l('This account was created successfully ') . $oUser->verify_code;
            save_session_messages();
            go_to('?con=admin&page=admin-accounts');
        }
    }
	$page_title = "NEW ACCOUNT:";
    $countries = $oUser->countries_get();
    $inner_page = 'views/accounts/admin-newaccount.php';
    include $master_page;
}



if ($page == 'withdraw-requests') {

    if ($_POST) {

        if ($_POST['set'])
            $_SESSION['withdraw_filter'] = $_POST['email'];
        else
            unset($_SESSION['withdraw_filter']);

        go_to('?con=admin&page=withdraw-requests');
    }

    $page_no = ifempty($_GET['page-no'], 1);
    $withdraw_requests = $oTransactions->getWithdrawRequests($_SESSION['withdraw_filter'], LIST_COUNT, $page_no, $_SESSION['withdraw_order'], $_SESSION['withdraw_dir']);

    $count = $oTransactions->getWithdrawRequestsCount($_SESSION['withdraw_filter']);
    $pages_count = ceil($count / LIST_COUNT);


	$page_title = "WITHDRAWAL REQUEST:";
    $inner_page = 'views/transactions/withdraw-requests.php';
    include $master_page;
}


if ($action == 'set-order-withdraw') {
    $order = $_GET['order'];
    if ($_SESSION['withdraw_dir'] == 'down')
        $_SESSION['withdraw_dir'] = 'up';
    else
        $_SESSION['withdraw_dir'] = 'down';


    $_SESSION['withdraw_order'] = $order;
    go_to('?con=admin&page=withdraw-requests');
}




if ($page == 'cms') {

    $page_no = ifempty($_GET['page-no'], 1);

    $cms = $oCms->getAllPages(LIST_COUNT, $page_no);
    $count = $oCms->getAllPagesCount();

    $pages_count = ceil($count / LIST_COUNT);

	$page_title = "CMS";
    $inner_page = 'views/cms/cms.php';
    include $master_page;
}




if ($page == 'create-page') {

    $page_name = empty2false($_GET['name']);


    if ($_POST) {
        //Upload Files First
        if ($_FILES['image1']['name']) {
            // check image upload
            $ext = file_ext($_FILES['image1']['name']);
            if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                $error_msg = l('Wrong file type, upload only Photos');
            } else {
                // upload and save
                $basename = base64_encode($_FILES['image1']['name'] . 'NOW()');
                $filename1 = upload($_FILES['image1'], "uploads/cms/", $basename . $ext, true);
            }
        }

        //Image 2
        if ($_FILES['image2']['name']) {
            // check image upload
            $ext = file_ext($_FILES['image2']['name']);
            if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                $error_msg = l('Wrong file type, upload only Photos');
            } else {
                // upload and save
                $basename = base64_encode($_FILES['image2']['name'] . 'NOW()');
                $filename2 = upload($_FILES['image2'], "uploads/cms/", $basename . $ext, true);
            }
        }
        
        
        $cms_data = $_POST;
        
        if($filename1)
            $cms_data['image1'] = $filename1;
        
        if($filename2)
            $cms_data['image2'] = $filename2;
        
        //Create And edit page
        if($page_name){
            $oCms->editPage ($page_name,$cms_data);
            $notify_msg = l('CMS page edited successfully !');
        }else{
            $oCms->createPage ($cms_data);
            $notify_msg = l('CMS page added successfully !');
        }
        
        save_session_messages();
        go_to ('?con=admin&page=cms');
    }
    
    
    
    //initialize ck editor
    ckeditor();

    if ($page_name)
        $cms_page = $oCms->getPage($page_name);



    $inner_page = "views/cms/create.php";
    include $master_page;
}


if ($page == 'delete-page'){
    $page_name = empty2false($_GET['name']);

    $oCms->deletePage ($page_name);
    $notify_msg =l('Page was deleted successfully ');
    
    save_session_messages();
    go_to('?con=admin&page=cms');
}


if($page == 'withdrawl-request-details'){
    $id = empty2false($_GET['id']);
    
    if($id)
        $withdraw = $oTransactions->getWithdrawReqest ($id);
    
    $inner_page = 'views/transactions/withdrawl-request-details.php';
    include $master_page;
}
?>
