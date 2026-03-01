<?php
require "needed/start.php";
ob_get_clean();

// Make sure the user is logged in.
force_login();
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
} else {

// Check if the video in question exists.
$video_exists = $conn->prepare("SELECT vid FROM videos WHERE vid = :video_id AND converted = 1");
$video_exists->execute([
	":video_id" => $_POST['video_id']
]);

if($video_exists->rowCount() == 0) {
	die();
} else {

$comments_disabled = $conn->prepare("SELECT * FROM videos WHERE vid = :video_id AND converted = 1");
$comments_disabled->execute([
	":video_id" => $_POST['video_id']
]);

if($comments_disabled->rowCount() == 0) {
	die();
} else {
	$comments_disabled = $comments_disabled ->fetch(PDO::FETCH_ASSOC);
}

$author = $comments_disabled['uid'];
$comments_disabled = $comments_disabled['comms_allow'];

if($session['uid'] == $author) { 
// Delete that comment!
$delete_comment = $conn->prepare("UPDATE comments SET removed = :removed WHERE cid = :comment_id AND vidon = :video_id AND uid = :author");
$delete_comment->execute([
	":removed" => "1",
	":comment_id" => $_POST['comment_id'],
	":video_id" => $_POST['video_id'],
	":author" => $author
]);
header("Location: watch.php?v=".$_POST['video_id']);
} else { die(); }
}
}
?>