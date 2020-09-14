<?php
define('HOST','localhost');
define('DATABASE','');
define('USER','');
define('PASS','');
define('CHARSET','utf8');
define('DSN', 'mysql:host='.HOST.';dbname='.DATABASE.';charset='.CHARSET);

define('SECURE_UPLOAD_PATH',''); //outside the public web space
define('WEB_FILE_PATH',''); // absolute file path on the server-side, no trailing slash, e.g. '/home/myaccount/public_html/projects/now-and-then'
define('WEB_HTTP_PATH',''); // URL path, no trailing slash, corresponds to the previous entry, e.g. '/projects/now-and-then'
define('ARCHIVES_FILE_PATH', WEB_FILE_PATH.'/images/archives/'); //in the web space
define('EXTRACT_FILE_PATH', WEB_FILE_PATH.'/images/extracts/'); //in the web space
define('OUTPUT_FILE_PATH', WEB_FILE_PATH.'/images/composites/'); //in the web space 
define('OUTPUT_HTTP_PATH', WEB_HTTP_PATH.'/images/composites/'); //corresponds to OUTPUT_FILE_PATH
define('ALLOWED_FILE_TYPES',array('image/png','image/jpeg'));

/* settings for an individual group photo */
define('GROUP_IMAGE_FILE', ''); //http relative or absolute path
define('GROUP_IMAGE_YEAR', ''); //year of photo
define('GROUP_IMAGE_WIDTH', ''); //number of pixels wide
define('GROUP_LENS_WIDTH',''); //width of selection (face size) in px
define('GROUP_LENS_HEIGHT','');//height of selection (face size) in px

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