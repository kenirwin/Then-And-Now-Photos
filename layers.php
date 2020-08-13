<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\LayeredImage;
use wittproj\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Email\Parse; 

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
$this_year = date('Y');
$set_format = numfmt_create( 'en_US', NumberFormatter::ORDINAL );
$year_diff = numfmt_format($set_format, $this_year-$year);
$text = $year . ' - '. $this_year .': '.($year_diff).' Reunion';
$white = imagecolorallocate($img->image, 255, 255, 255);
$font = FONT;
imagettftext($img->image, 25, 0, 95, 100, $white, $font, $text);

/* output file */
$filename = preg_replace('/\.(jpg|jpeg|png)/i','',$old_nopath) 
  . '__' 
  . preg_replace('/\.(jpg|jpeg|png)/i','',$new_nopath)
  . '.png';
$filename = ValidateFilename($filename);
$db = new Database;
$db->submitPair($filename, $old_nopath, $new_nopath, $old_table);
imagepng($img->image, OUTPUT_FILE_PATH . $filename);
print '<img src="'.OUTPUT_HTTP_PATH.$filename.'" />'.PHP_EOL;
$emails = Parse::getInstance()->parse($db->getSubmissionEmail($new_nopath));
$mailTo = ($emails['email_addresses'][0]['simple_address']);

$filepath = OUTPUT_FILE_PATH.$filename;
/*
print "<li>$filepath</li>";
print "<li>$filename</li>";
print "<li>$mailTo</li>";
print "<li>".MAIL_FROM."</li>";
print "<li>".MAIL_SUBJECT."</li>";
print "<li>".MAIL_BODY."</li>";
*/
if (DoMail($mailTo,OUTPUT_FILE_PATH.$filename,$filename)) {
  print "<h1>Mail Sent: $mailTo</h1>";
}

else {
  print "<h1>Could NOT send mail!</h1>";
}

function DoMail ($mailTo,$filepath,$filename) {
  $email = new PHPMailer();
  $email->SetFrom(MAIL_FROM); //Name is optional
  $email->Subject   = MAIL_SUBJECT;
  $email->Body      = MAIL_BODY;
  $email->AddAddress( $mailTo );
  $email->AddAttachment( $filepath , $filename );
  return $email->Send();
}

function ValidateFilename($filename) {
  if (preg_match('/[^a-zA-Z0-9\.\-\_]/',$filename)) {
    die();
  }
  return $filename;
}
?>