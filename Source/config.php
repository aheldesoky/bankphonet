<?php
// where now ?
define ('LOCAL_MODE',true);



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



define("CONTACT_EMAIL", "moozidan@hotmail.com,bankphonet@gmail.com,bankphonet@yahoo.com");
define("ADMIN_EMAIL", "admin@bankphonet.com");
define("SETTINGS_FILE", 'settings.txt');

define("EMAIL_HEADERS", "From: bankphonet.com <no-reply@bankphonet.com> \r\n
						 Reply-To: no-reply@bankphonet.com \r\n");


define("LIST_COUNT", 10);
define("LIST_COUNT_MINI", 5);
define("LIST_COUNT_MICRO", 2);

//Minimal credit to request withdraw
define("MIN_WITHDRAW_EG",101);
define("MIN_WITHDRAW_OUT",201);
define ('MAX_WITHDRAW_LIMIT', 20000);


define('ADMIN_IP','');
// ------------------------ minor options --------------------------
// timezone
date_default_timezone_set ('Africa/Cairo');

// local
setlocale(LC_ALL, 'Arabic'); 

// use unicode
mb_internal_encoding("UTF-8");

// hide notices
error_reporting(E_ALL ^ E_NOTICE);



// defaults
define ('DEFAULT_UPLOAD_DIR', 'uploads/');











?>


