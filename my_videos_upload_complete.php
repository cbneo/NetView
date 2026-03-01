<?php 
require "needed/start.php";

force_login();

$video = $conn->prepare("SELECT * FROM videos WHERE vid = ? AND converted = 0");
$video->execute([$_GET['v']]);

if($video->rowCount() == 0) {
	redirect("index.php");
	die();
} else {
	$video = $video->fetch(PDO::FETCH_ASSOC);
}

if($video['uid'] != $session['uid']){
    redirect("index.php");
}

?>
<div class="pageTitle">Thank You</div>
<span class="success">Your video was successfully added!</span>
<p>Your video is currently being processed and will be available to view in a few minutes.</p>
Want to upload more videos? <a href="/my_videos_upload.php">Click here</a>

<br>

<?php require "needed/end.php"; ?>