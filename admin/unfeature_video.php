<?php
require "admin_head.php";

// Make sure variables are set
if(!isset($_GET['video_id'])) {
	die();
} else {

$featured_video_exists = $conn->prepare("SELECT video FROM picks WHERE video = :video_id");
$featured_video_exists->execute([
	":video_id" => $_GET['video_id']
]);

if($featured_video_exists->rowCount() == 0) {
    session_error_index("This video wasn't featured!", "error");
	die();
}

$unfeature = $conn->prepare("DELETE FROM picks WHERE video = :video_id");
$unfeature->execute([
	":video_id" => $_GET['video_id']
]);

session_error_index("Unfeatured!", "success");

}
?>