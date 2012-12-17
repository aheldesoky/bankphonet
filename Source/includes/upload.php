<?php
/*
	Product :		   upload functions
	Developed by :	  Khalid Ahmed
	eMail :			 contact@khalidpeace.com
	Web Site :		  www.khalidpeace.com
	Creation Date :	 19/11/2010
	Last Update :	   19/11/2010


*/

// defaults
define ('DEFAULT_UPLOAD_DIR', 'uploads/');





function upload($file, $target_path = false, $basename = false, $overwrite = false)
{
	if (! $file) return false;
	if (! $target_path) $target_path = DEFAULT_UPLOAD_DIR;
	
	// end with /
	$endwith = substr($target_path, strlen($target_path) - 1, 1);
	if (($endwith <> '/') and ($endwith <> '\\')) $target_path .= '/';
	
	$tmp_name = $file['tmp_name'];
	$name = $file['name'];
	
	if (! $name) return false;
	
	// security
	if (in_array(file_ext ($name), array('php', 'exe', 'com'))) {
		unlink ($tmp_name);
		return false;
	}
	
	// either upload with same file, or using basename
	if ($basename) {
		$fullname = $basename . '.' . file_ext ($name);
	} else {
		$fullname = $name;
	}
	
	// delete old file if exist
	if (file_exists($fullname)) {
		if (! $overwrite) return false;
		unlink ($fullname);
	}
	

		// check if the folder is exsit or not
		if(!is_dir($target_path)){
			mkdir($target_path, 0777,true);
		}


	$result = move_uploaded_file($tmp_name, $target_path . $fullname);

	return ($result) ? $fullname : $result;
}





?>