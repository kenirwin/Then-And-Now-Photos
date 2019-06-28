<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\LayeredImage;
use wittproj\Database;

/* set variables */
if ($_REQUEST['path'] == 'extracts') {
  $path = EXTRACT_FILE_PATH;
  $old_table = 'photo_extracts';
}
else {
  $path = ARCHIVES_FILE_PATH;
  $old_table = 'yearbook_photos';
}
$old = $path . $_REQUEST['old'];
$old_nopath = $_REQUEST['old'];
$new = SECURE_UPLOAD_PATH . $_REQUEST['new'];
$new_nopath = $_REQUEST['new'];

/* composite output image */
$img = new LayeredImage;
$img->setBackground(BACKGROUND_IMG);
$img->placeImage($old,37,136,260,300); // left
$img->placeImage($new,310,136,260,300,$_REQUEST['rotation']); //right
$img->setCover(COVER_IMG);

/* add text */
$year = $_REQUEST['year'];
$text = $year . ' - 2019: '.(date('Y')-$year).'th Reunion';
$white = imagecolorallocate($img->image, 255, 255, 255);
$font = FONT;
imagettftext($img->image, 25, 0, 95, 100, $white, $font, $text);

/* output file */
$filename = preg_replace('/\.(jpg|png)/','',$old_nopath) 
  . '__' 
  . preg_replace('/\.(jpg|png)/','',$new_nopath)
  . '.png';
$filename = ValidateFilename($filename);
$db = new Database;
$db->submitPair($filename, $old_nopath, $new_nopath, $old_table);
imagepng($img->image, OUTPUT_FILE_PATH . $filename);
print '<img src="'.OUTPUT_HTTP_PATH.$filename.'" />'.PHP_EOL;


function ValidateFilename($filename) {
  if (preg_match('/[^a-zA-Z0-9\.\-\_]/',$filename)) {
    die();
  }
  return $filename;
}
?>