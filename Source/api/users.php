<?php
require 'Zend/Soap/Server.php';
require 'Zend/Soap/AutoDiscover.php';
require '../includes/app_common.php';

define ('LOCAL_MODE', true);


if (LOCAL_MODE)
{
	// test configuration
	define("BASE_URL", 'http://localhost/bankphonet/Source/');
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "123@qwe");
	define("DB_DATABASE", "bankphonet");
} 
else {
	// production configuration
	define("BASE_URL", 'http://www.bankphonet.com/');

	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "Hlun&922Urwzq'");
	define("DB_DATABASE", "bankphonet");	
}
        
require_once __DIR__.'/../includes/db.php';
// db
$db = Cdb::singleton();//initiate singlton class from db
$db->execute("SET time_zone = '+02:00'");


require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/cas.php';

$oUser = new User();

//$oUser = new User($db);

//API CALL
if(isset($_GET['wsdl'])) {
    $autodiscover = new Zend_Soap_AutoDiscover();
    $autodiscover->setClass('cas');
    $autodiscover->handle();
} else {
    // pointing to the current file here
    $soap = new Zend_Soap_Server(BASE_URL."api/users.php?wsdl");
    $soap->setClass('cas');
    $soap->handle();
}




?>
