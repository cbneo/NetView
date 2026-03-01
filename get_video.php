<?php
if (empty($_REQUEST['video_id'])) exit("no video id");
require "needed/scripts.php";
$v = $conn->prepare("SELECT * FROM videos WHERE vid = :vid");
$v->bindParam(':vid', $_REQUEST['video_id'], PDO::PARAM_STR);
$v->execute();
$v2 = $v->fetch();
if ($v->rowCount() == 0) {
 exit("video does NOT exist");
} else {
    if ($v2['converted'] == 0) {
      exit("video is processing");
    } else {
        switch ($_REQUEST['format']) {
            case "webm":
                $f = "webm";
                $type = "video/webm";
                break;
            default:
                $f = "flv";
                $type = "video/x-flv";
                break;
        }
        $p = __DIR__ . "/data/videos/" . $_REQUEST['video_id'] . "." . $f;

        if (!file_exists($p)) {
            exit("vid exists but no video file was found");
        } else {
            header("Content-Type: " . $type);
            header('HTTP/1.1 200 OK');
            header("Content-Length: " . filesize($p));
            readfile($p);
            exit;
        }
    }
}
?>