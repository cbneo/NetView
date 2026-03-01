<?php
require "admin_head.php";

// Make sure variables are set
if(!isset($_GET['video_id'])) {
	die();
} else {

// Check if the video in question exists.
$video_exists = $conn->prepare("SELECT vid FROM videos WHERE vid = :video_id AND converted = 1");
$video_exists->execute([
	":video_id" => $_GET['video_id']
]);

if($video_exists->rowCount() == 0) {
    session_error_index("This video does not exist!", "error");
	die();
}

$featured_video_exists = $conn->prepare("SELECT video FROM picks WHERE video = :video_id");
$featured_video_exists->execute([
	":video_id" => $_GET['video_id']
]);

if($featured_video_exists->rowCount() == 1) {
    session_error_index("The video was already featured!", "error");
	die();
} else {

$feature = $conn->prepare("INSERT IGNORE INTO picks (video, special) VALUES (:video_id, :special)");
$feature->execute([
	":video_id" => $_GET['video_id'],
	":special" => '0'
]);

session_error_index("Featured!", "success");

}

}
?>