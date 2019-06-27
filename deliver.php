<?php
include ('config.php');
if ($_REQUEST['path'] == 'archives') {
  $path = ARCHIVES_FILE_PATH;
}
elseif ($_REQUEST['path'] == 'extracts') {
  $path = EXTRACT_FILE_PATH;
}
else {
  $path = SECURE_UPLOAD_PATH;
}
$img = file_get_contents($path. $_REQUEST['filename']);
if (preg_match('/\.png/i',$_REQUEST['filename'])) {
  $ctype = 'image/png';
}
elseif (preg_match('/\.jpg/i',$_REQUEST['filename'])) {
  $ctype = 'image/jpeg';
}
if (isset($ctype)) {
  header('Content-type: '.$ctype);
  print $img;
}

?>