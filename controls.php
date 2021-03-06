<?php
require_once 'config.php';
if (!defined('APP_NAME')) { define('APP_NAME','Then-And-Now Photos'); } 
if (defined('DEBUG') && DEBUG == true) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php print(APP_NAME); ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php 
include('bootstrap.php'); 

/* the $path variable defines which of several possible sources 
   are used for the old/original file
*/

if (array_key_exists('path',$_REQUEST)) {
  $path = $_REQUEST['path'];
}
else { 
  $path = 'archives';
}
?>

<script>
   $(document).ready(function() {
       $('#pair-form').one('submit', function(e) {
	   e.preventDefault();
	   var year = $('#old').find(':selected').data('year');
	   $('input#year').val(year);
	   $(this).submit();
	   });
       $('#old').change(function() {
	   var img = $(this).val();
	   var year = $(this).find(':selected').data('year');
	   LoadPhoto('photo1',img,'<?php print $path;?>',year);
	   $('input#year').val(year);
	 });
       $('#new').change(function() {
	   var img = $(this).val();
	   LoadPhoto('photo2',img,'upload',null);
	 });
       $('#rotation').change(function() {
	   var rot = $(this).val() * -1;//css reckons degrees opposite of php
	   $('#photo2 img').css('transform', 'rotate('+rot+'deg)');
	 });
       function LoadPhoto(destination,filename,path,year) {
	 $('#'+destination).empty().append('<img src="deliver.php?filename='+filename+'&path='+path+'&year='+year+'">');	 
       }
     });
</script>

<style>
body {
  font-family: Calibri, Helvetica, sans-serif;
  }
.preview img {
 width:250px;
  }
#pair div {
display: inline;
}
#year-counts { text-align:right }
</style>
</head>
<body>
<?php
  include('nav.php');
?>
<div id="main" class="container">
<h1><?php print(APP_NAME);?></h1>
<?php
if (array_key_exists('alert',$_REQUEST)) {
  print '<div class="alert '.$_REQUEST['alert_type'].'">';
  print $_REQUEST['alert'];
  print '</div>';
}

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\Database;
use wittproj\Error;

try {
  $db = new Database();
} catch (PDOException $e) {
  $err = new Error($e, 'Unable to connect to database', false);
  print $err->alert;
  die();
  }
$old_opts = '';
$new_opts = '';
try {
  if ($path == "extracts") {
    $rows = $db->getFileInfo('photo_extracts', 'student_name');
  }
  else{ 
    $rows = $db->getFileInfo('yearbook_photos', 'student_name');
  }
  
  foreach ($rows as $row) {
    $old_opts .= '<option value="'.$row['filename'].'" data-year="'.$row['grad_year'].'">'.$row['student_name'].' ('.$row['filename'].')</option>'.PHP_EOL;
  }
  
  $rows = $db->getFileInfo('submissions');
  foreach ($rows as $row) {
    $new_opts .= '<option value="'.$row['filename'].'">'.$row['subject'].' ('.$row['filename'].')</option>'.PHP_EOL;
  }
} catch (Exception $e) {
  $err = new Error($e, "Error retrieving data from Database");
  print $err->alert;
  die();
  }
print '<form action="layers.php" id="pair-form" class="form-inline mb-3">'.PHP_EOL;
print '<select name="old" id="old" class="form-control mr-2 mb-1"><option>Select "Before" photo</option>'.$old_opts.'</select>';
print '<select name="new" id="new" class="form-control mr-2 mb-1"><option>Select "After" photo</option>'.$new_opts.'</select>';
print '<select name="rotation" id="rotation" class="form-control mr-2 mb-1">
<option value="0">Rotation: None</option>
<option value="-90">Clockwise</option>
<option value="90">Counterclockwise</option>
<option value="180">180 degrees</option>
</select>';
print '<input type="hidden" name="year" id="year" />'.PHP_EOL;
print '<input type="hidden" name="path" id="path" value="'.$path.'">'.PHP_EOL;
print '<input type="submit" class="form-control btn btn-success md-ml-2 mb-1 mr-3">'.PHP_EOL;
print '<div class="form-check">'.PHP_EOL;
if (defined('MAIL_DEFAULT_SEND') && MAIL_DEFAULT_SEND == true) {
  $send_checked = " checked";
}
else {
  $send_checked = "";
  
}
print '<input type="checkbox" name="mail_img_to_user" id="mail_img_to_user" class="form-check-input md-ml-1"'.$send_checked.'>'.PHP_EOL;
print '<label for="mail_img_to_user" class="form-check-label ml-2">Send finished image to user</label>'.PHP_EOL;
print '</div>'.PHP_EOL;
print '</form>'.PHP_EOL;
?>

<div class="row" id="main-content" style="padding-bottom:100px">
<div id="pair" class="col-md-9">
<div id="photo1" class="preview"></div>
<div id="photo2" class="preview"></div>
</div>

<div id="counts-wrapper" class="col-md-3">
<table id="year-counts" class="table">
<thead class="thead-light">
  <tr><th>Year</th><th>Photos</th></tr>
</thead>
<tbody>
<?php
  $results = $db->countByYear();
foreach ($results as $i => $row) {
  print '<tr><td>'.$row['year'].'</td><td>'.$row['yearCount'].'</td></tr>'.PHP_EOL;
}
?>
</tbody>
</table>
</div>
</div>


</div>
  <?php include('footer.php'); ?>
</body>
</html>
