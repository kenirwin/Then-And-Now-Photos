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
print '<select name="old">'.$opts.'</select>';
print '<select name="new">'.$opts.'</select>';
print '<select name="rotation">
<option value="0">None</option>
<option value="-90">Clockwise</option>
<option value="90">Counterclockwise</option>
<option value="180">180 degrees</option>
</select>';
print '<input type="submit">'.PHP_EOL;
print '</form>'.PHP_EOL;
?>