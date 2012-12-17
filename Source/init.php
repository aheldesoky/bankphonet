<?php

session_start();

// config file
require_once __DIR__.'/config.php';

// includes
require_once __DIR__.'/includes/common.php';
require_once __DIR__.'/includes/app_common.php';
require_once __DIR__.'/includes/locals.php';


//require_once __DIR__.'/includes/db.php';

require_once __DIR__.'/includes/upload.php';
require_once __DIR__.'/includes/thumb_core.php';
//require_once 'includes/auth.php';

require_once __DIR__.'/models/Errors.php';
require_once __DIR__.'/models/User.php';
require_once __DIR__.'/models/transactions.php';
require_once __DIR__.'/models/cms.php';



// ------------------------ start --------------------------
// db
//$db = Cdb::singleton();//initiate singlton class from db
//$db->execute("SET time_zone = '+02:00'");


//Models

//user object
//$oUser = new User($db);

$oTransactions = new transactions($db);

$oCms = new cms($db);




$oError = new return_from_error();




// ------------------------ error and notification messages --------------------------
$error_msg = "";
$notify_msg = "";

if ($_SESSION['error_msg']) {
	$error_msg = $_SESSION['error_msg'];
	$_SESSION['error_msg'] = '';
}

if ($_SESSION['notify_msg']) {
	$notify_msg = $_SESSION['notify_msg'];
	$_SESSION['notify_msg'] = '';
}


// ------------------------ anti injection hacking --------------------------
clean_html ($_POST);
clean_html ($_GET);










?>