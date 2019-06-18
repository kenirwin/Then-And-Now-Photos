<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
   $(document).ready(function() {
       $('#old').change(function() {
	   var img = $(this).val();
	   LoadPhoto('photo1',img,'upload');
	 });
       
       $('#new').change(function() {
	   console.log('change is coming');
	   var img = $(this).val();
	   LoadPhoto('photo2',img,'upload');
	 });
       $('#rotation').change(function() {
	   var rot = $(this).val() * -1;//css reckons degrees opposite of php
	   $('#photo2 img').css('transform', 'rotate('+rot+'deg)');
	 });
       function LoadPhoto(destination,filename,path) {
	 $('#'+destination).empty().append('<img src="deliver.php?filename='+filename+'">');	 
       }
     });
</script>

<style>
.preview img {
 width:250px;
  }
#pair div {
display: inline;
}
</style>
<h1>Homecoming Photo Pairing</h1>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\Database;

$db = new Database();
$opts = '';
$rows = $db->getFileInfo();
foreach ($rows as $row) {
  $opts .= '<option value="'.$row['filename'].'">'.$row['subject'].' ('.$row['filename'].')</option>'.PHP_EOL;
}

print '<form action="pair.php">'.PHP_EOL;
print '<select name="old" id="old"><option>Select one</option>'.$opts.'</select>';
print '<select name="new" id="new"><option>Select one</option>'.$opts.'</select>';
print '<select name="rotation" id="rotation">
<option value="0">None</option>
<option value="-90">Clockwise</option>
<option value="90">Counterclockwise</option>
<option value="180">180 degrees</option>
</select>';
print '<input type="submit">'.PHP_EOL;
print '</form>'.PHP_EOL;
?>
<div id="pair">
<div id="photo1" class="preview"></div>
<div id="photo2" class="preview"></div>
</div>