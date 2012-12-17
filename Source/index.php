<?php

// timer of script
$start_time = microtime(true);  
register_shutdown_function('my_shutdown');

function my_shutdown() {
	global $db, $start_time, $page;	
	if ($page) {
		$duration = (microtime(true) - $start_time);
			//echo "\n\n\n<pre class=''>script time: $duration</pre>";
	}
};





require_once 'init.php';







// what u want
$page = empty2false($_REQUEST['page']);
if (! $page) $page = empty2false($_REQUEST['p']);

$ajax = empty2false($_REQUEST['ajax']);
$action = empty2false($_REQUEST['action']);

$controller = empty2false($_REQUEST['con']);
if (! $controller) $controller = empty2false($_REQUEST['controller']);

$module = empty2false($_REQUEST['mod']);
if (! $module) $module = empty2false($_REQUEST['module']);

if (! ($page or $ajax or $action)) $page = 'default';
if (! ($module or $controller)) $controller = 'default';

$con = $controller;
$mod = $module;









// default master page
$master_page = 'views/master.php';
















// direct to the right handler
if ($controller) require "controllers/{$controller}.php";
if ($module) require "modules/{$module}/controller.php";
