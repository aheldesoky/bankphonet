<?php

function escape($expr)
{
	return addslashes ($expr);
}




function reverse_escape($str)
{
	$search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
	$replace=array("\\","\0","\n","\r","\x1a","'",'"');
	return str_replace($search,$replace,$str);
}





function generate_select_options ($data, $title_field, $value_field, $selected_value = false)
{
	$html = '';
	foreach ($data as $record) {
		$title = $record[$title_field];
		$value = $record[$value_field];
		
		$selected = ($value == $selected_value) ? 'selected="selected"' : "";
		
		$html .= "<option value='$value' $selected>$title</option>\n";
	}
	
	return $html;	
}





function generate_select_options_simple ($data, $selected_item = false, $use_local = false)
{
	$html = '';
	foreach ($data as $item) {
		
		$selected = ($item == $selected_item) ? 'selected="selected"' : "";
		
		$display_item = ($use_local) ? l($item) : $item;
		$html .= "<option value=\"{$item}\" {$selected}>{$display_item}</option>\n";
	}
	
	return $html;	
}








// ---------------------------------- array saving, loading using file -------------------------------------------
function read_array_from_file($file_name)
{
	// if data file exists, load 
	if (! file_exists($file_name)) return array();
	
	$body = file_get_contents ($file_name);
	$array = unserialize($body);
	
	if (! is_array($array)) return array();
	return $array;
}





function save_array_to_file($file_name, $array)
{
	$body = serialize($array);
	$result = file_put_contents ($file_name, $body);
	return $result;
}








// ---------------------------------- date functions -------------------------------------------
// date time formating
function format_short_datetime($expr)
{
	$expr = strtotime($expr);
	//return date('Y/m/d h:i a', $expr);
	return iconv('windows-1256', 'UTF-8', strftime('%d/%m/%Y %H:%M %p', $expr));
}


function format_long_datetime($expr)
{
	$expr = strtotime($expr);
	//return date('D d/m/Y h:i a', $expr);
	return iconv('windows-1256', 'UTF-8', strftime('%a %d %b %Y %H:%M %p', $expr));
}

function format_short_date($expr)
{
	$expr = strtotime($expr);
	//return date('Y/m/d', $expr);
	return iconv('windows-1256', 'UTF-8', strftime('%d/%m/%Y', $expr));
}


function format_long_date($expr)
{
	$expr = strtotime($expr);
	//return date('D d/m/Y', $expr);
	return iconv('windows-1256', 'UTF-8', strftime('%a %d %b %Y', $expr));
}



// date parsing functions
function date_parse_dmy($expr)
{
	$date = explode("/", $expr);
	return mktime(0,0,0,$date[1],$date[0],$date[2]);
}



// date conversion functions
function dmy2ymd($expr)
{
	if (! $expr) return false;
	
	$date = explode("/", $expr);
	$date = mktime(0,0,0,$date[1],$date[0],$date[2]);
	return date("Y/m/d", $date);
}








// ------------------------------------- validation functions ----------------------------------------
// any empty changed to be false
function empty2false ($var) {
	if (empty($var)) 
		return false;
	else
		return $var;
}




// check empty
function ifempty ($var, $empty_value, $not_empty_value = 'x.x') {
	if (empty($var)) 
		return $empty_value;
	else
		return ($not_empty_value != 'x.x') ? $not_empty_value : $var;
}



// for each element if element is emty remove from array
function array_empty ($array) {
	$ret_array = array();
	foreach($array as $key => $value){
		if(isset($value) && ($value != null) && ($value != ''))
		$ret_array[$key] = $value;
	}
	return $ret_array;
}




// email checking
function is_valid_email($email){
	return (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $email));	
}









// --------------------------------------- math --------------------------------------
// calculate total of field in data
function total ($data, $field) {
	$result = 0;
	if (is_array($data))
		foreach ($data as $record)
			$result += (float) $record[$field];
			
	return $result;
}




// ------------------------------------- file ----------------------------------------
// file functions

function file_ext ($filename) {
	$pos = strrpos ($filename, '.');
	$ext = substr ($filename, $pos + 1, strlen($filename) - $pos);
	$ext = strtolower ($ext);
	return $ext;
}


function file_base ($filename) {
	// where / or \ starts
	$pos1 = strrpos($filename, '/');
	$pos2 = strrpos($filename, '\\');
	$pos1 = ($pos1 > $pos2) ? $pos1 : $pos2;
	
	// where . starts
	$pos2 = strrpos($filename, '.');
	
	return substr($filename, $pos1, $pos2 - $pos1);	
}


function file_delete_if_exist ($filename) {
	if (file_exists ($filename)) return unlink ($filename);
	return true;
}









// ---------------------- simple template engine solutions ----------------------

// ---------------------- render, simple template engine ---------------------- 
function render ($template_file, $global_variable_names = '') {
	
	// activiate global variables
	if ($global_variable_names) {
		$vars = explode (',', $global_variable_names);
		foreach ($vars as $var) {
			$var = trim($var);
			if ($var) global $$var;
		}		
	} else {
		foreach ($GLOBALS as $key => $value) {
			$$key = $value;
		}
	}
	
	// start caching the results
	ob_start();
	
	include ($template_file);

	$result = ob_get_contents();
	ob_end_clean();
	
	return $result;
}






// ---------------------- another template engine idea, by start_rebder then do our work, ----------------------
// ---------------------- then end_render, this gives our work html as a seperate variable ----------------------
function start_render () {
	ob_start();
}

function end_render () {
	$result = ob_get_contents();
	ob_end_clean();
	
	return $result;
}







/* ----------------- clean all html ----------------- */
function clean_html(&$var,Cdb $db=null)
{
    $skipp_arr = array ('description_en','description_ar');
	if (is_array($var)) {
		foreach ($var as $key => $value ) {
			if (!is_array($value) && !in_array($key, $skipp_arr)){
				$var[$key] = mysqli_real_escape_string($db->connection,strip_tags($value));
                        }
		}
	} else
		$var = mysqli_real_escape_string($db->connection,strip_tags($var));
}





/* ----------------- Lookup data ----------------- */
function getLookup ($data, $keyField, $lookupField, $keyValue) {
	if (! is_array($data)) return false;
	foreach ($data as $record) {
		$key = $record[$keyField];
		if ($key == $keyValue) return $record[$lookupField];
	}
	return false;
}







/* ----------------- is_image_ext ----------------- */
function is_image_ext ($filename)
{
	$types = array('jpg', 'gif', 'jpeg', 'png');
	
	$ext = file_ext ($filename);
	return in_array ($ext, $types);	
}








// ------------------------------------- strings ----------------------------------------
// extract 1st 20 character of long string
function brief ($expr, $char_count = 100, $strip_tags = true)
{
	if ($strip_tags) $expr = strip_tags($expr);
	if (mb_strlen ($expr) > $char_count) $expr = mb_substr ($expr, 0, $char_count) . ' ...';

	return $expr; 
}






// ------------------------------------- youtube_id ----------------------------------------
function youtube_id ($youtube_url)
{
	preg_match ('/[\\?\\&]v=([^\\?\\&]+)/', $youtube_url, $matches);
	return $matches[1];
}











/* -----------------  ----------------- */
function limit ($count = false, $page_no = false, $simpler = false) {
	if ((! $page_no) and (! $count)) return '';
	
	if (! $simpler) $limit = " LIMIT ";
	if (! $page_no) 
		$limit .= " {$count} ";
	else
		$limit .= ' ' . (($page_no - 1) * $count) . ", {$count} ";
	
	return $limit;
}










/* ----------------- this function converts $_FILES['item'] if it is array to be more simple, each file in array ----------------- */
function simplify_files_array($files)
{
	$result = array();
	$j = 0;
	
	for ($i = 0; $i < count($files['name']); $i++) {
		if ($files['name'][$i]) {
			$result[$j]['name'] = $files['name'][$i];
			$result[$j]['type'] = $files['type'][$i];
			$result[$j]['tmp_name'] = $files['tmp_name'][$i];
			$result[$j]['error'] = $files['error'][$i];
			$result[$j]['size'] = $files['size'][$i];
			$j++;
		}
	}
	
	return $result;	
}











/* ----------------- get_month_string, converts 2 to Jan ----------------- */
function get_month_string ($n)
{
	$timestamp = mktime(0, 0, 0, $n, 1, 2005);
	return date("F", $timestamp);
}











/* -----------------  ----------------- */
function pre ($var)
{
	echo "\n\n<pre>";
	if (is_array($var))
		print_r ($var);
	else
		echo $var;
	echo "</pre>\n\n";
}








/* ----------------- return thr full url of this page ----------------- */
function page_url ()
{
	return 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}






/* ----------------- iso_date ----------------- */
function iso_date ($date_str)
{
	return date('c', strtotime($date_str));	
}






/* -----------------  ----------------- */
function object_to_array($data) 
{
	if ((! is_array($data)) and (! is_object($data))) return 'xxx'; //$data;
	
	$result = array();
	
	$data = (array) $data;
	foreach ($data as $key => $value) {
	if (is_object($value)) $value = (array) $value;
	if (is_array($value)) 
	$result[$key] = object_to_array($value);
	else
	$result[$key] = $value;
	}
	
	return $result;
}








/* -----------------  ----------------- */
function save_session_messages()
{
	global $notify_msg, $error_msg;
	
	$_SESSION['notify_msg'] = $notify_msg;
	$_SESSION['error_msg'] = $error_msg;
}









/* -----------------  ----------------- */
// template contains {page} and {active}
// ex. 		'href="index.php?page-no={page}" class="{active}"'

function mypaging($pages_count, $page_no, $attr_template, $prev_text = '&lt;', $next_text = '&gt;') {
    if ($pages_count == 1)
        return;

    $start_page = $page_no - 3;
    if ($start_page < 1)
        $start_page = 1;

    $end_page = $page_no + 3;
    if ($end_page > $pages_count)
        $end_page = $pages_count;

    /** Fix pagin with small numbers of pages * */
    if ($end_page <= 3)
        $start_page = 1;

    echo '<div class="paging">';
    $fhtml = str_replace('{page}', 1, $attr_template);
    if ($page_no != 1)
        echo "<a {$fhtml}> &lt;&lt; </a>";


    if (($page_no > 1) and ($prev_text)) {
        $html = str_replace('{page}', $page_no - 1, $attr_template);
        $html = str_replace('{active}', '', $html);
        echo "<a {$html}>{$prev_text}</a>";
    }

    for ($page = $start_page; $page <= $end_page; $page++) {
        $html = str_replace('{page}', $page, $attr_template);
        if ($page == $page_no)
            $html = str_replace('{active}', 'current', $html);
        else
            $html = str_replace('{active}', '', $html);

        echo "<a {$html}>{$page}</a>";
    }

    if (($page_no < $pages_count) and ($next_text)) {
        $html = str_replace('{page}', $page_no + 1, $attr_template);
        $html = str_replace('{active}', '', $html);
        echo "<a {$html}>{$next_text}</a>";
    }

    $lhtml = str_replace('{page}', $pages_count, $attr_template);
    if ($page_no != $pages_count)
        echo "<a {$lhtml}> &gt;&gt; </a>";
    echo '</div>';
}







/* -----------------  ----------------- */
function str_word ($expr, $index = 0)
{
	$data = explode (' ', $expr);
	return $data[$index]; 	
}

/* -----------------  ----------------- */
function go_to ($place =false,$permenant =false)
{
	if($permenant)
		header ('HTTP/1.1 301 Moved Permanently');
	
	if(!$place)
		header('location: .');
	else
		header('Location: '.$place);
	
	//Fucken exit is here
	exit();
}


/* -----------------  ----------------- */
// formats money to a whole number or with 2 decimals; includes a dollar sign in front
function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
  if (is_numeric($number)) { // a number
    if (!$number) { // zero
      $money = ($cents == 2 ? '0.00' : '0'); // output zero
    } else { // value
      if (floor($number) == $number) { // whole number
        $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
      } else { // cents
        $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
      } // integer or decimal
    } // value
    return $money;
  } // numeric
} // formatMoney

/* -----------------  Return normal upload array from multible files ----------------- */
function multiple(array $_files, $top = TRUE)
{
    $files = array();
    foreach($_files as $name=>$file){
        if($top) $sub_name = $file['name'];
        else    $sub_name = $name;
        
        if(is_array($sub_name)){
            foreach(array_keys($sub_name) as $key){
                $files[$name][$key] = array(
                    'name'     => $file['name'][$key],
                    'type'     => $file['type'][$key],
                    'tmp_name' => $file['tmp_name'][$key],
                    'error'    => $file['error'][$key],
                    'size'     => $file['size'][$key],
                );
                $files[$name] = multiple($files[$name], FALSE);
            }
        }else{
            $files[$name] = $file;
        }
    }
    return $files;
}
/* -----------------Get Page url  ----------------- */
function getURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return urlencode($pageURL);
}


/*- ----- Ck Editor Function --- */
function ckeditor()
{
    global $CKeditor;
    //Ckeditor
    require_once 'views/assets/ckeditor/ckeditor.php';
    require_once 'views/assets/ckfinder/ckfinder.php';
    $CKeditor = new CKEditor();
    CKFinder::SetupCKEditor($ckeditor, 'views/assets/ckfinder/');
    $CKeditor->config['width'] = '650';
    $CKeditor->config['height'] = '300';
    $ckeditor->config['filebrowserBrowseUrl'] = 'views/assets/ckfinder/ckfinder.html';
    $CKeditor->config['filebrowserImageBrowseUrl'] = 'views/assets/ckfinder/ckfinder.html?type=Images';
    $CKeditor->config['filebrowserFlashBrowseUrl'] = 'views/assets/ckfinder/ckfinder.html?type=Flash';
    $CKeditor->config['filebrowserUploadUrl'] = 'views/static/assets/core/connector/php/connector.php?command=QuickUpload&type=Files';
    $CKeditor->config['filebrowserImageUploadUrl'] = 'views/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    $CKeditor->config['filebrowserFlashUploadUrl'] = 'views/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    $CKeditor->basePath = 'views/assets/ckeditor/';
	//End Ck Editor
}


/*--------------------------- Extract get to url ---------------------*/
function extractUrl ($url_array){
    
    if(!is_array($url_array))
        return false;
    
    //Fix multi page no
    unset ($url_array['page-no']);
    foreach ($url_array as $k=>$r){
        
        if($url)$url.='&';
        $url .= $k.'='. $r;
    }
    
    return $url;
}