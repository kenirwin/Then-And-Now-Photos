<?php
namespace wittproj;

class LayeredImage {
  public function setBackground($file)
  {
    list($this->width,$this->height) = getimagesize($file);
    $this->background_img = imagecreatefromstring(file_get_contents($file));
    $this->image = $this->background_img;
  }
  public function setCover($file) 
  {
    $this->cover_img = imagecreatefromstring(file_get_contents($file));
    $this->imagecopymerge_alpha($this->image, $this->cover_img, 0, 0, 0, 0, $this->width, $this->height, 100);
  }
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
}