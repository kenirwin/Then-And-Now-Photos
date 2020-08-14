<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit','526M');
require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\Database;
$db = new Database;

if (! array_key_exists('name',$_REQUEST)) {
  $hiddens = '';
  foreach ($_REQUEST as $k=>$v) {
    $hiddens .= '<input type="hidden" name="'.$k.'" value="'.$v.'">'.PHP_EOL;
  }
  print '<form>';
  print '<label for="name">Name</label>'.PHP_EOL;
  print '<input type="text" name="name" id="name" />'.PHP_EOL;
  print '<input type="submit">'.PHP_EOL;
  print $hiddens;
  print '</form>'.PHP_EOL;
}

else { // process file
  print "<p>I'm inside</p>";
  $source = GROUP_IMAGE_FILE;
  
  $im = imagecreatefromstring(file_get_contents($source));
  list($x_orig,$y_orig) = getimagesize($source);
  $x_viewfinder=GROUP_IMAGE_WIDTH; 
  $ratio = $x_orig/$x_viewfinder;
  print '<li>'.$_REQUEST['y'].'</li>';
  print "<li>$ratio</li>";
  print '<li>'.$_REQUEST['lens_height'].'</li>';
  print '<li>'.($_REQUEST['y'] - $_REQUEST['lens_height']/2 )* $ratio .'</li>';
  $im2 = imagecrop($im, [
			 'x' => ($_REQUEST['x'] - $_REQUEST['lens_width']/2 )*$ratio, 
			 'y' => ($_REQUEST['y'] - $_REQUEST['lens_height']/2 )*$ratio, 
			 'width' => $_REQUEST['lens_width']*$ratio, 
			 'height' => $_REQUEST['lens_height']*$ratio
			 ]
		   );
  
  
  //header('Content-Type: image/jpeg');
  $filename = time(). '.jpg';
  if (imagejpeg($im2,'images/extracts/'.$filename) ) {
    $db->submitExtract($filename,$source,$_REQUEST['name'],$_REQUEST['year']);
  //  header('Location: index.php?path=extracts');
    print 'This is ridiculous what am i doint here im in the wrong story';
  }
  else{ 
    print 'failed to extract image';
  }
  imagedestroy($im);
  imagedestroy($im2);
}