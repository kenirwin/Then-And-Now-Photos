<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ('config.php');
$frame = SECURE_UPLOAD_PATH . 'frame.png';
$old = SECURE_UPLOAD_PATH . 'Ken.jpg';
$new = SECURE_UPLOAD_PATH . 'IMG_8657.JPG';
$overlay = SECURE_UPLOAD_PATH . 'frame_transparent';

list($old_width,$old_height) = getimagesize($old);
list($new_width,$new_height) = getimagesize($new);
list($frame_width,$frame_height) = getimagesize($frame);
$frame_img = imagecreatefromstring(file_get_contents($frame));
$old_img = imagecreatefromstring(file_get_contents($old));
$new_img = imagecreatefromstring(file_get_contents($new));
$new_img = imagerotate($new_img, -90, 0);
//$overlay_img = imagecreatefromstring(file_get_contents($overlay));

$dim = getDimensions ($new, 260, 300, true);
imagecopyresampled($frame_img, $new_img, 300, 10, 0, 0, $dim['width'], $dim['height'], $dim['width_orig'], $dim['height_orig']);



$max_width  = ($frame_width/2) - 10;

$new_ratio = $new_width / $new_height; 


imagecopy($frame_img, $old_img, 10,10,0,0, $old_width, $old_height);
//imagecopymerge($frame_img, $overlay_img, 0,0,0,0, $frame_width, $frame_height);




header('Content-Type: image/png');
imagepng($frame_img);



function getDimensions ($filename, $max_width, $max_height, $gonna_rotate=false) {
// Get new dimensions
list($width_orig, $height_orig) = getimagesize($filename);
$width = $width_orig;
$height= $height_orig;

if ($gonna_rotate) {
  $tmp_width = $width_orig;
  $tmp_height = $height_orig;
  $width_orig = $tmp_height;
  $height_orig = $tmp_width;
}

$height_scale = $max_width/$width_orig;
$width_scale  = $max_height/$height_scale;

if ($height_scale < $width_scale) {
  $scale = $height_scale;
}
else {
  $scale = $width_scale;
}

return array('height' => floor($height_orig * $scale),
	     'width'  => floor($width_orig * $scale),
	     'width_orig' => $width_orig,
	     'height_orig' => $height_orig
	     );

}

?>