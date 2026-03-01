<?php
require __DIR__ . "/needed/scripts.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    die(header("Location: http://".$sitedomain."/my_videos_upload.php"));
} 

$request = (object) [
    "targetdir" => __DIR__ . '/data/videos/',
    "vfile" => $_FILES["fileToUpload"],
    "vext" => strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION)),
    "vtitle" => trim($_POST['field_upload_title']),
    "vdesc" => trim($_POST['field_upload_description']),
    "vtags" => trim($_POST['field_upload_tags']),
    "v_id" =>  trim($_POST['video_id'])
];
    if(move_uploaded_file($request->vfile['tmp_name'], $request->targetdir.$request->v_id."_temp.".$request->vext)) {
system(sprintf('php ' . __DIR__ . '/cdn/process/video_process.php "%s" "%s" "%s" > %s 2>&1 &', $request->targetdir, $request->vext, $request->v_id, './data/.log'));
    }
?>
