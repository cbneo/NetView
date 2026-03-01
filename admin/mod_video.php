<?php
require "admin_head.php";

$video = $conn->prepare("SELECT uid FROM videos WHERE vid = ?");
$video->execute([$_GET['video_id']]);
$video = $video->fetch(PDO::FETCH_ASSOC);
if($video['converted'] === "0") {
    header("Location: index.php");
    exit;
}
if($video['privacy'] == 1) {
    $remove_fav = $conn->prepare("UPDATE users SET pub_vids = pub_vids - 1 WHERE uid = ?");
    $remove_fav->execute([$session['uid']]);
} else if($video['privacy'] == 2) {
    $remove_fav = $conn->prepare("UPDATE users SET priv_vids = priv_vids - 1 WHERE uid = ?");
    $remove_fav->execute([$session['uid']]);    
}
// $remove_fav = $conn->prepare("INSERT INTO rejections SELECT * FROM videos WHERE vid = ?");
// $remove_fav->execute([$_GET['video_id']]);
    
$rej = $conn->prepare("SELECT * FROM rejections WHERE vid = ?");
$rej->execute([$_GET['video_id']]);
$rej = $rej->fetch(PDO::FETCH_ASSOC);

// if($rej->rowCount() > 0) {
$remove_video = $conn->prepare("DELETE FROM videos WHERE vid = :vid");
$remove_video->execute([
	":vid" => $_GET['video_id']
]);
// }
session_error_index("Moderated!", "error");
