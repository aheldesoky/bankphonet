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
            $_SESSION['frozen'] = $_POST['frozen'];
        } else {
            $_SESSION['transaction_from'] = '';
            $_SESSION['transaction_to'] = '';
            $_SESSION['transaction_id'] = '';
            $_SESSION['frozen'] = '';
        }
        go_to('?con=admin&page=admin-transactions');
    }

    $page_no = ifempty($_GET['page-no'], 1);

    $transactions = $oTransactions->adminGetTransactions($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id'], LIST_COUNT, $page_no, $_SESSION['transaction_order'], $_SESSION['transaction_dir'], $_SESSION['frozen']);

    $count = $oTransactions->adminGetTransactionsCount($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id'], $_SESSION['frozen']);

    $pages_count = ceil($count / LIST_COUNT);
    $page_title = "TRANSACTIONS:";
    $inner_page = 'views/transactions/admin-transactions.php';
    include $master_page;
}

if ($page == 'admin-transactions-score') {
	if ($_POST) {

		if ($_POST['set']) {
			$_SESSION['transaction_from'] = $_POST['from'];
			$_SESSION['transaction_to'] = $_POST['to'];
			$_SESSION['transaction_id'] = $_POST['tid'];
			$_SESSION['frozen'] = $_POST['frozen'];
		} else {
			$_SESSION['transaction_from'] = '';
			$_SESSION['transaction_to'] = '';
			$_SESSION['transaction_id'] = '';
			$_SESSION['frozen'] = '';
		}
		go_to('?con=admin&page=admin-transactions-score');
	}

	$page_no = ifempty($_GET['page-no'], 1);

	$transactions = $oTransactions->adminGetTransactionsScore($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id'], LIST_COUNT, $page_no, $_SESSION['transaction_order'], $_SESSION['transaction_dir'], $_SESSION['frozen']);

	$count = $oTransactions->adminGetTransactionsScoreCount($_SESSION['transaction_from'], $_SESSION['transaction_to'], $_SESSION['transaction_id'], $_SESSION['frozen']);

	$pages_count = ceil($count / LIST_COUNT);
	$page_title = "TRANSACTIONS:";
	$inner_page = 'views/transactions/admin-transactions-score.php';
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

if ($page == 'admin-refund-score') {
	$id = empty2false($_GET['id']);
	//Check if there are no id
	if (!$id) {
		$error_msg = l('Error : Bad request');
		save_session_messages();
		go_to('?con=admin&page=admin-transactions-score');
	}

	//Get transaction
	$transaction = $oTransactions->transaction_score_get_one($id);
	if (!$transaction) {
		$error_msg = l('Sorry there are no transaction with this id');
		save_session_messages();
		go_to('?con=admin&page=admin-transactions-score');
	}


	if ($_POST) {
		$refund = $oTransactions->refund_score($id, $transaction['to_id']);
		if ($refund != 1)
			$error_msg = $oError->message($refund);
		else {
			$notify_msg = l('Operation done successfully');
			save_session_messages();
			go_to('?con=admin&page=admin-transactions-score');
		}
	}

	$inner_page = 'views/transactions/admin-refund-score.php';
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
    	//var_dump($_POST);exit;
		if($_POST['deposittype'] == 'credit'){
			$deposit = $oTransactions->transfer($oUser->id, $_POST['mobile'], $_POST['amount'], (($oUser->admin_type == 1) ? true : false));
			//echo $deposit;exit;
		} elseif($_POST['deposittype'] == 'points') {
			$deposit = $oTransactions->transfer_points($oUser->id, $_POST['mobile'], $_POST['amount'], (($oUser->admin_type == 1) ? true : false));
		}

        if ($deposit <= 0) {
            $error_msg = $oError->message($deposit);
            save_session_messages();
            go_to('?con=admin&page=deposit');
        } else {
            $notify_msg = l("Deposit done !");
            save_session_messages();
            
            if($_POST['deposittype'] == 'credit')
            	go_to('?con=admin&page=admin-transactions');
            elseif($_POST['deposittype'] == 'points')
            	go_to('?con=admin&page=admin-transactions-score');
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

        if ($oUser->admin_type != 1) {
            if ($from_user['admin_type'] == 1) {
                $error_msg = l('You do not have permession to transfer from this account !');
                save_session_messages();
                go_to('?con=admin&page=admin-transfer');
            }
        }

        if($_POST['transfertype']=='credit')
        	$transfer = $oTransactions->transfer($from_user['id'], $_POST['mobileto'], $_POST['amount']);
        elseif($_POST['transfertype']=='points')
        	$transfer = $oTransactions->transfer_points($from_user['id'], $_POST['mobileto'], $_POST['amount']);

        if ($transfer <= 0) {
            $error_msg = $oError->message($transfer);

            save_session_messages();
            go_to('?con=admin&page=admin-transfer');
        } else {

            $notify_msg = l("Transfer done !");
            save_session_messages();
            if($_POST['transfertype']=='credit')
            	go_to('?con=admin&page=admin-transactions');
            elseif($_POST['transfertype']=='points')
            	go_to('?con=admin&page=admin-transactions-score');
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



if ($page == 'deposit-requests') {

    if ($_POST) {

        if ($_POST['set'])
            $_SESSION['deposit_filter'] = $_POST['email'];
        else
            unset($_SESSION['deposit_filter']);

        go_to('?con=admin&page=deposit-requests');
    }

    $page_no = ifempty($_GET['page-no'], 1);
    $deposit_requests = $oTransactions->getdepositRequests($_SESSION['deposit_filter'], LIST_COUNT, $page_no, $_SESSION['deposit_order'], $_SESSION['deposit_dir']);

    $count = $oTransactions->getdepositRequestsCount($_SESSION['deposit_filter']);
    $pages_count = ceil($count / LIST_COUNT);


    $page_title = "DEPOSIT REQUEST:";
    $inner_page = 'views/transactions/deposit-requests.php';
    include $master_page;
}


if ($action == 'set-order-deposit') {
    $order = $_GET['order'];
    if ($_SESSION['deposit_dir'] == 'down')
        $_SESSION['deposit_dir'] = 'up';
    else
        $_SESSION['deposit_dir'] = 'down';


    $_SESSION['deposit_order'] = $order;
    go_to('?con=admin&page=deposit-requests');
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

        if ($filename1)
            $cms_data['image1'] = $filename1;

        if ($filename2)
            $cms_data['image2'] = $filename2;

        //Create And edit page
        if ($page_name) {
            $oCms->editPage($page_name, $cms_data);
            $notify_msg = l('CMS page edited successfully !');
        } else {
            $oCms->createPage($cms_data);
            $notify_msg = l('CMS page added successfully !');
        }

        save_session_messages();
        go_to('?con=admin&page=cms');
    }



    //initialize ck editor
    ckeditor();

    if ($page_name)
        $cms_page = $oCms->getPage($page_name);



    $inner_page = "views/cms/create.php";
    include $master_page;
}


if ($page == 'delete-page') {
    $page_name = empty2false($_GET['name']);

    $oCms->deletePage($page_name);
    $notify_msg = l('Page was deleted successfully ');

    save_session_messages();
    go_to('?con=admin&page=cms');
}


if ($page == 'withdrawl-request-details') {
    $id = empty2false($_GET['id']);

    if ($id)
        $withdraw = $oTransactions->getWithdrawReqest($id);


    $inner_page = 'views/transactions/withdrawl-request-details.php';
    include $master_page;
}


if ($page == 'cobones') {

    $page_no = ifempty($_GET['page-no'], 1);
    $order = ifempty($_GET['order'], 'cobone_time');
    $dir = ifempty($_GET['dir'], 'up');


    if ($_POST) {

        if ($_POST['set']) {
            $_SESSION['code'] = $_POST['code'];
        } else {
            $_SESSION['code'] = '';
        }
        go_to('?con=admin&page=cobones');
    }


    $cobones = $oTransactions->getCobones(false, LIST_COUNT, $page_no, $order, $dir, $_SESSION['code']);
    $count = $oTransactions->getCobonesCount();
    $pages_count = ceil($count / LIST_COUNT);

    $inner_page = 'views/transactions/admin-cobones.php';
    include $master_page;
}

if ($action == "delcopone") {
    $id = empty2false($_GET['id']);
    $user_id = empty2false($_GET['user']);
    $del = $oTransactions->deleteCobone($user_id, $id);
    if ($del < 0) {
        $error_msg = $oError->message($del);
    } else {
        $notify_msg = l("This cobone was deleted successfully !");
    }

    save_session_messages();
    go_to('?con=admin&page=cobones');
}




if ($action == 'cancel') {


    $id = empty2false($_GET['id']);


    if ($id) {


        $transaction = $oTransactions->transaction_get_one($id);
        $new_amount = $transaction['amount'];
        $to_user_id = $oUser->get_user_by_id($transaction['from_id']);
        $supper_admin = $oUser->getSupperAdmin();
        $tr = $oTransactions->transfer($supper_admin['id'], $to_user_id['email'], $new_amount, true);


        if ($tr > 0) {
            $del = $db->delete('transactions', "id = '$id'");
            $notify_msg = l('Transaction canceled successfully !');
        } else {
            $error_msg = $oError->message($tr);
        }
    } else {
        $error_msg = l("There are no transaction selected !");
    }

    save_session_messages();

    go_to('?con=admin&page=admin-transactions');
    return;
}


if ($action == 'defreez') {
    $id = empty2false($_GET['id']);
    if ($id) {
        $id = intval($id);
        $transaction = $oTransactions->transaction_get_one($id);
        $to_id = $transaction['to_id'];
        $oTransactions->addCredit($to_id, $transaction['amount']);

        $amount = $transaction['amount'] - $transaction['total_shipping'];
        $new_amount = round((0.02 * $amount), 2) + $transaction ['total_shipping'];
        $to_user_id = $oUser->get_user_by_id($to_id);
        $supper_admin = $oUser->getSupperAdmin();
        $oTransactions->transfer($to_user_id['id'], $supper_admin['email'], $new_amount);

        $db->update('transactions', array('total_shipping' => 0), "id = '$id'");
    } else {
        $error_msg = l("There are no transaction selected !");
    }


    save_session_messages();

    go_to('?con=admin&page=admin-transactions');
    return;
}


if ($action == 'accept-withdraw') {
    $withdraw_id = empty2false($_GET['id']);

    if ($withdraw_id)
        $withdraw = $oTransactions->getWithdrawReqest($withdraw_id);
    //Close request and send email to user
    $subject = "Your request under processing";
    $msg_body = "Dear " . $withdraw['firstname'] . ' ' . $withdraw['lastname'] . "\n";
    $msg_body .= "Your withdraw request no : " . $withdraw['id'] . "\n";
    $msg_body .= "is under processing now \n";
    $msg_body .= "For more details visit the website please";
    AmazonEmail($withdraw['email'], $subject, $msg_body);
    //@mail($withdraw['email'], $subject, $msg_body, EMAIL_HEADERS);
    $oTransactions->acceptWithdraw($withdraw['id']);

    $notify_msg = l('This request is accepted');
    save_session_messages();

    go_to('?con=admin&page=withdraw-requests');
}


if ($page == 'reports') {
    $report = $oTransactions->getReport();
    $inner_page = 'views/admin/reports.php';
    include $master_page;
}


if ($page == 'mobile-charge') {


    $page_no = ifempty($_GET['page-no'], 1);
    $requests = $oTransactions->getMobileCharge($_GET, LIST_COUNT, $page_no);

    $pages_count = ceil($oTransactions->mobile_count / LIST_COUNT);
    $inner_page = "views/admin/mobile-charge.php";
    include $master_page;
}

if ($action == 'accept-mobile') {
    $reject = empty2false($_GET['reject']);
    $accept = $oTransactions->acceptMobile ($_GET['id'],$oUser->id,$reject);
    if ($accept < 0) {
        $error_msg = $oError->message($accept);
    } else {
        if(!$reject)
        $notify_msg = l('Mobile Transaction accepted');
        else
            $notify_msg = l('Mobile Transaction rejected');
    }

    save_session_messages();
    go_to('?con=admin&page=mobile-charge');
}
?>
