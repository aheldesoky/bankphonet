<?php
/*
	Product :		   localization functions
	Developed by :	  Khalid Ahmed
	eMail :			 contact@khalidpeace.com
	Web Site :		  www.khalidpeace.com
	Creation Date :	 27/01/2011
	Last Update :	   27/01/2011


*/


// configurations
define ("LOCALS_URL", 'locals/');
$design_local = 'en';
$default_local = 'en';




// handle change local action
if ($_GET['lang'])
{
	$_SESSION['local'] = empty2false($_GET['lang']);
	
	header ('Location:'.$_GET['ref']);
	exit;
}





// read $local from session
$local = (empty($_SESSION['local'])) ? $default_local : $_SESSION['local'];
$local_file = LOCALS_URL . $local . '.php';
$local_strings = array();


// load local file
if ($local != $design_local) {
	if (file_exists($local_file))
		require_once ($local_file);
}




// main localization function
function l ($expr)
{
	global $local, $local_file, $design_local, $default_local, $local_strings;
	
	// if same design local, do nothing
	if ($local == $design_local) return $expr;
	
	
	// check it is in local strings array then return translated value
	$expr = escape ($expr);
	if (isset($local_strings[$expr])) return reverse_escape ($local_strings[$expr]);
	
	
	// now add it to the local php file, and add it to the locals
	$local_strings[$expr] = $expr;
	
	// generate php line
	$line = '$local_strings[\'' . $expr . "'] = \n\t'" . $expr . '\';' . "\n\n";
	
	
	// save php file
	if (! file_exists($local_file))	file_put_contents ($local_file, "<?php\n\n");
	
	
	// save to file
	$fh = fopen($local_file, "a");
	fwrite($fh, $line);
	fclose($fh);
	
	// return same expr
	return reverse_escape ($expr);
}




?>