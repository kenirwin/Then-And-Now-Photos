<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//require_once 'config.php';
require_once 'vendor/autoload.php';

use wittproj\LayeredImage;
$img = new LayeredImage;
$img->setBackground('tests/testBackground.png');
$img->placeImage('tests/testPortraitLeft.png',37,136,260,300);
$img->placeImage('tests/testPortraitSideways.png',310,136,260,300,-90);
$img->setCover('tests/testCover.png');
header('Content-type: image/png');
imagepng($img->image);
?>