<?php
define('HOST','localhost');
define('DATABASE','');
define('USER','');
define('PASS','');
define('CHARSET','utf8');
define('DSN', 'mysql:host='.HOST.';dbname='.DATABASE.';charset='.CHARSET);

define('SECURE_UPLOAD_PATH',''); //outside the public web space
define('ARCHIVES_FILE_PATH',''); //in the web space
define('EXTRACT_FILE_PATH',''); //in the web space
define('OUTPUT_FILE_PATH',''); //in the web space 
define('OUTPUT_HTTP_PATH',''); //corresponds to OUTPUT_FILE_PATH
define('ALLOWED_FILE_TYPES',array('image/png','image/jpeg'));

define('MAIL_FROM',''); //email address
define('MAIL_SUBJECT','Homecoming Photo Pair');
define('MAIL_BODY','Thank you for participating! Your file is attached.');
define('BACKGROUND_IMG',''); //full file path
define('COVER_IMG',''); //full file path

define('FONT', 
       //'fonts/arial.ttf'
       //'fonts/coolvetica rg.ttf'
       'fonts/Mont-HeavyDEMO.otf'
       );

?>