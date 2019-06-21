#!/usr/local/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\Database;
use PhpMimeMailParser\Parser;

$parser = new PhpMimeMailParser\Parser();
$parser->setStream(fopen('php://stdin','r'));
$db = new Database;
//$db->logError('this is a test','sender','subject');

$subject = $parser->getHeader('subject');
$sender = $parser->getHeader('from');

error_log('about to get attachments');
$attachments = $parser->getAttachments();
foreach ($attachments as $a) {
  $filename = $a->getFilename();
  $filetype = $a->getContentType();
  if (in_array($filetype, ALLOWED_FILE_TYPES)) {
    error_log('saving file');
    $a->save(SECURE_UPLOAD_PATH, Parser::ATTACHMENT_DUPLICATE_SUFFIX);
    $db->submitFile($filename,$sender,$subject);
  }
  else { 
    error_log('unable to submit');
    //    $db->logError('Error: could not attach '.$filetype, $sender, $subject);
    $db->logError('Error: could not attach: static error', 'sender', 'subject');
    //    print ('Error: could not attach ' . $filetype. $sender. $subject);
  }
}


/*
$content = get_current_user();

try { 
$db = new Database;
$db->rawEmail($content);
} catch (Exception $e) {
  print $e->getMessage();
  }
*/

?>