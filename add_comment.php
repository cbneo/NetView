<?php
require "needed/start.php";
ob_get_clean();

// Make sure the user is logged in.
force_login();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}

// Make sure variables are set
if(!isset($_POST['video_id']) || !isset($_POST['comment'])) {
	die();
}

// Check if the video in question exists.
$video_exists = $conn->prepare("SELECT vid FROM videos WHERE vid = :video_id AND converted = 1");
$video_exists->execute([
	":video_id" => $_POST['video_id']
]);

if($video_exists->rowCount() == 0) {
	die();
}

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

if($comments_disabled < 1 && $session['uid'] != $author) { die(); }
// Post that comment!
$post_comment = $conn->prepare("INSERT IGNORE INTO comments (cid, vidon, uid, body) VALUES (:comment_id, :video_id, :uid, :body)");
$post_comment->execute([
	":comment_id" => generateId(),
	":video_id" => $_POST['video_id'],
	":uid" => $session['uid'],
	":body" => trim($_POST['comment'])
]);
?>