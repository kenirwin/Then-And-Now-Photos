<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\LayeredImage;

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
header('Content-type: image/png');
imagepng($img->image);
?>