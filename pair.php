<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ('config.php');


$frame = SECURE_UPLOAD_PATH . 'frame.png';
$old = SECURE_UPLOAD_PATH . $_REQUEST['old'];
$new = SECURE_UPLOAD_PATH . $_REQUEST['new'];
$overlay = SECURE_UPLOAD_PATH . 'frame_transparent.png';

if (array_key_exists('rotation', $_REQUEST)) {
  $rotation = $_REQUEST['rotation'];
  if ($rotation == 90 || $rotation == -90) {
    $rotate = true;
  }
  else {
    $rotate = false;
  }
}
else { $rotate = false; } 

list($old_width,$old_height) = getimagesize($old);
list($new_width,$new_height) = getimagesize($new);
list($frame_width,$frame_height) = getimagesize($frame);
$frame_img = imagecreatefromstring(file_get_contents($frame));
$old_img = imagecreatefromstring(file_get_contents($old));
$new_img = imagecreatefromstring(file_get_contents($new));
if ($rotate) { $new_img = imagerotate($new_img, $rotation, 0); }
$overlay_img = imagecreatefromstring(file_get_contents($overlay));


/* constrain new_img to set dimensions */
$dim = getDimensions ($new, 260, 300, $rotate);
imagecopyresampled($frame_img, $new_img, 310, 130, 0, 0, $dim['width'], $dim['height'], $dim['width_orig'], $dim['height_orig']);

$max_width  = ($frame_width/2) - 10;

$new_ratio = $new_width / $new_height; 


imagecopy($frame_img, $old_img, 10,130,0,0, $old_width, $old_height);
imagecopymerge_alpha($frame_img, $overlay_img, 0,0,0,0, $frame_width, $frame_height,100);



header('Content-Type: image/png');
imagepng($frame_img);

getimagesize($new);


function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
  if(!isset($pct)){ 
    return false; 
  } 
  $pct /= 100; 
  // Get image width and height 
  $w = imagesx( $src_im ); 
  $h = imagesy( $src_im ); 
  // Turn alpha blending off 
  imagealphablending( $src_im, false ); 
  // Find the most opaque pixel in the image (the one with the smallest alpha value) 
  $minalpha = 127; 
  for( $x = 0; $x < $w; $x++ ) 
    for( $y = 0; $y < $h; $y++ ){ 
      $alpha = ( imagecolorat( $src_im, $x, $y ) >> 24 ) & 0xFF; 
      if( $alpha < $minalpha ){ 
	$minalpha = $alpha; 
      } 
    } 
  //loop through image pixels and modify alpha for each 
  for( $x = 0; $x < $w; $x++ ){ 
    for( $y = 0; $y < $h; $y++ ){ 
      //get current alpha value (represents the TANSPARENCY!) 
      $colorxy = imagecolorat( $src_im, $x, $y ); 
      $alpha = ( $colorxy >> 24 ) & 0xFF; 
      //calculate new alpha 
      if( $minalpha !== 127 ){ 
	$alpha = 127 + 127 * $pct * ( $alpha - 127 ) / ( 127 - $minalpha ); 
      } else { 
	$alpha += 127 * $pct; 
      } 
      //get the color index with new alpha 
      $alphacolorxy = imagecolorallocatealpha( $src_im, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha ); 
      //set pixel with the new color + opacity 
      if( !imagesetpixel( $src_im, $x, $y, $alphacolorxy ) ){ 
	return false; 
      } 
    } 
  } 
  // The image copy 
  imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h); 
} 


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