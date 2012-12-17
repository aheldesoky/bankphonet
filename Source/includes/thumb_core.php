<?php

// thumb configurations
define ('THUMBS_URL', 'cache/thumbnails/');

define ('THUMB_WIDTH', 100);
define ('THUMB_HEIGHT', 100);
define ('THUMB_FORMAT', 'png');
define ('THUMB_CROP', 1);


function thumb ($src_file, $width = false, $height = false, $crop = false, $format = false)
{
	// parameters
	if (! $src_file) return false;
	
	// check exist file
	if (! (strpos($src_file, 'http://') === 0))
		if (! file_exists ($src_file)) return false;
		
	
	$width = empty ($width) ? 0 : $width;
	$height = empty ($height) ? 0 : $height;
	$format = empty ($format) ? THUMB_FORMAT : $format;
	$crop = ($crop === false) ? THUMB_CROP : $crop;
	
	// special case
	if (! ($width or $height)){
		$width = THUMB_WIDTH;
		$height = THUMB_HEIGHT;
	}
	
	
	// generate target file name
	$pos = strrpos($src_file, '.');
	$ext = substr($src_file, $pos + 1, 10);
	$ext = strtolower($ext);
	$base_file = substr($src_file, 0, $pos);
	
	$last_modified = (strpos($src_file, 'http://') === 0) ? 0 : filemtime($src_file); 
	
	$thumb_file = $base_file;
	$thumb_file = str_replace('/', '__', $thumb_file);
	$thumb_file = str_replace(':', '', $thumb_file);
	$thumb_file = str_replace('.', '_', $thumb_file);
	$thumb_file = THUMBS_URL . $thumb_file . "__{$width}__{$height}__{$crop}__{$last_modified}.{$format}";
	
	
	// if exist before then return the image
	if ( file_exists($thumb_file) ) return $thumb_file;
	
	
	// read file
	switch($ext){
		case 'jpg':
			$src_img = imagecreatefromjpeg($src_file);
			break;
		case 'jpeg':
			$src_img = imagecreatefromjpeg($src_file);
			break;
		case 'png':
			$src_img = imagecreatefrompng($src_file);
			break;
		case 'gif':
			$src_img = imagecreatefromgif($src_file);
			break;
	}
	
	if (! $src_img) return false;
	
	// read coords of original image
	$org_width = imageSX($src_img);
	$org_height = imageSY($src_img);
	
	
	// claculate the outer width, height of the thumbnail
	if ($width and $height) {
		$new_width = $width;
		$new_height = $height;
	}
	elseif ($width) {
		$new_width = $width;
		$new_height = $width * $org_height / $org_width;
	}
	elseif ($height) {
		$new_height = $height;
		$new_width = $height * $org_width / $org_height;
	}
	else {
		$new_width = THUMB_WIDTH;
		$new_height = THUMB_HEIGHT;
	}
	
	
	// calc ratio for cropping the source image to $new_height and $new_width
	$ratio1 = ($org_height / $new_height);
	$ratio2 = ($org_width / $new_width);
	
	// ratio depend on croping or not
	if ($crop) {
		$ratio = ($ratio1 > $ratio2) ? $ratio2 : $ratio1;
	} else {
		$ratio = ($ratio1 > $ratio2) ? $ratio1 : $ratio2;
	}
	
	
	// claculate the inner width, height of the thumbnail
	$thumb_width = (int) ($org_width / $ratio);
	$thumb_height = (int) ($org_height / $ratio);
	$thumb_left = (int) (($new_width - $thumb_width) / 2);
	$thumb_top = (int) (($new_height - $thumb_height) / 2);
	
	
	// create thumb image
	$dst_img = imagecreatetruecolor($new_width, $new_height);
	if ($format == 'png') {
		// alpha transparency
		imagesavealpha($dst_img, true);
		$transparent = imagecolorallocatealpha($dst_img, 0, 0, 0, 127);
		imagefill($dst_img, 0, 0, $transparent);
	}	
	elseif ($format == 'jpg') {
		$bg_color = imagecolorallocate($dst_img, 255, 255, 255);
		imagefill($dst_img, 0, 0, $bg_color);
	}
	
	
	// generate thumb
	imagecopyresampled($dst_img, $src_img, $thumb_left, $thumb_top, 0, 0, $thumb_width, $thumb_height, $org_width, $org_height); 
	
	
	// save file
	if ($format == 'png') {
		imagepng($dst_img, $thumb_file, 9);
	}	
	elseif ($format == 'jpg') {
		imagejpeg($dst_img, $thumb_file, 85);
	}
	
	
	// free memory
	imagedestroy($dst_img);
	imagedestroy($src_img);
	
	return $thumb_file;
}







/* ----------------- delete thumbnails from cache ----------------- */
function delete_thumbs($src_file)
{
	// generate target file name
	$pos = strrpos($src_file, '.');
	$base_file = substr($src_file, 0, $pos);
	
	$thumb_file = $base_file;
	$thumb_file = str_replace('/', '__', $thumb_file);
	$thumb_file = str_replace(':', '', $thumb_file);
	$thumb_file = str_replace('.', '_', $thumb_file);
	$thumb_file = THUMBS_URL . $thumb_file . "__*.*";
	
	// now delete this pattern
	foreach (glob($thumb_file) as $filename) {
		unlink ($filename);
	}
}



?>