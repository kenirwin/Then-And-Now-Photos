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
}
else {
  $path = ARCHIVES_FILE_PATH;
}
$old = $path . $_REQUEST['old'];
$new = SECURE_UPLOAD_PATH . $_REQUEST['new'];


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

/* output image */
if (isset($_REQUEST['filename'])) {
  $filename = ValidateFilename($_REQUEST['filename']);
  imagepng($img->image, OUTPUT_FILE_PATH.$filename.'.png');
  print '<img src="'.OUTPUT_HTTP_PATH.$filename.'.png" >';
  
  //  $db->submitPair($pair, $old, $new, $old_table);
}
else {
  header('Content-type: image/png');
  imagepng($img->image);
}

function ValidateFilename($filename) {
  if (preg_match('/[^a-zA-Z0-9\.\-\_]/',$filename)) {
    die();
  }
  return $filename;
}
?>