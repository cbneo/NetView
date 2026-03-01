<?php
require "needed/scripts.php";
$video_info = $conn->prepare("SELECT * FROM videos WHERE vid = ? AND converted = 1");
$video_info->execute([$_GET['video_id']]);
if ($video_info->rowCount() == 0) {
header("Content-Type: image/jpg");
$resource = fopen(__DIR__ . "/unavail.jpg", 'rb');
fpassthru($resource);
exit;
} else {
if(!isset($_GET['still_id'])) $_GET['still_id'] = 2;
if(isset($_GET['still_id']) && $_GET['still_id'] == 0) $_GET['still_id'] = 2; 
if(!isset($_GET['video_id'])) $_GET['video_id'] = false;
$still_file = __DIR__ . "/data/thmbs/".$_GET['video_id']."_".$_GET['still_id'].".jpg";
if(isset($_GET['video_id']) && file_exists($still_file)) {
header("Content-Type: ".mime_content_type($still_file));
$resource = fopen($still_file, "rb");
fpassthru($resource);
exit;
} else {
header("Content-Type: image/jpg");
$resource = fopen(__DIR__ . "/unavail.jpg", 'rb');
fpassthru($resource);
exit;
}
}
?>