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
$file = file_get_contents($path. $_REQUEST['filename']);
$img = imagecreatefromstring($file);

if (preg_match('/\.png$/i',$_REQUEST['filename'])) {
  header('Content-type: image/png');
  imagepng($img);
}
elseif (preg_match('/(\.jpe*g|\.jfif)$/i',$_REQUEST['filename'])) {
  header('Content-type: image/jpeg');
  imagejpeg($img);
}
imagedestroy($img);

?>