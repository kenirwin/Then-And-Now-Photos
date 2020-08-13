<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<?php
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
#counts-wrapper {
float: right;
margin-right: 100px;
z-index:100;
}

table#year-counts td {
padding: .5em 1.5em;
border-bottom: 1px solid black;
}
table#year-counts {
border-collapse: collapse;
border: 1px solid black;
}
</style>

<?php
  include('nav.php');
?>
<h1>Homecoming Photo Pairing</h1>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
print '<form action="layers.php">'.PHP_EOL;
print '<select name="old" id="old"><option>Select one</option>'.$old_opts.'</select>';
print '<select name="new" id="new"><option>Select one</option>'.$new_opts.'</select>';
print '<select name="rotation" id="rotation">
<option value="0">None</option>
<option value="-90">Clockwise</option>
<option value="90">Counterclockwise</option>
<option value="180">180 degrees</option>
</select>';
print '<input type="hidden" name="year" id="year" />'.PHP_EOL;
print '<input type="hidden" name="path" id="path" value="'.$path.'">'.PHP_EOL;
print '<input type="submit">'.PHP_EOL;
print '</form>'.PHP_EOL;
?>

<div id="counts-wrapper">
<table id="year-counts">
  <tr><th>Year</th><th>Photos</th></tr>
<?php
 $results = $db->countByYear();
foreach ($results as $i => $row) {
print '<tr><td>'.$row['year'].'</td><td>'.$row['yearCount'].'</td></tr>'.PHP_EOL;
}
?>
</table>
</div>

<div id="pair">
<div id="photo1" class="preview"></div>
<div id="photo2" class="preview"></div>
</div>

