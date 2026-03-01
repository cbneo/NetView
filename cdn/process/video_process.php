<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

var_dump($argv);
die();
require(__DIR__ . '/../needed/scripts.php');

// Set timezone so everything matches up.
date_default_timezone_set('America/Los_Angeles');
 $conn->exec("SET time_zone = '-7:00'");

$request = (object) [
    "targetdir" => $argv[1],
    "vext" => $argv[2],
    "v_id" => $argv[3],
    "thumbdir" => __DIR__ . '/../../data/thmbs/',
];
//$testlog = fopen("testlog.txt", "w");
//web.archive.org/web/20251219105749/https://fwrite($testlog, var_dump($argv));
//web.archive.org/web/20251219105749/https://fclose($testlog);
try {
    // FLV
    exec($config['ffmpeg'] . ' -i '.$request->targetdir.$request->v_id.'_temp.'.$request->vext.' -c:v flv -vf "scale=320:240:force_original_aspect_ratio=decrease,pad=320:240:(ow-iw)/2:(oh-ih)/2:color=black" -c:v flv1 -b:a 80k  -c:a mp3 -ar 22050 data/videos/'.$request->v_id.'.flv');

    // WEBM
    // exec(
    // $config['ffmpeg'] . 
    // ' -i '.$request->targetdir.$request->v_id.'_temp.'.$request->vext.
    // ' -c:v libvpx -vf "scale=320:240:force_original_aspect_ratio=decrease,pad=320:240:(ow-iw)/2:(oh-ih)/2:color=black" '.
    // ' -b:v 170k -c:a libvorbis -b:a 80k -ar 22050 -ac 1 '.
    // ' data/videos/'.$request->v_id.'.webm'
    // );
    
    // Experiment: Getting more accurate video quality by converting the flv to webm
    exec(
    $config['ffmpeg'] . 
    ' -i ' . $request->targetdir . $request->v_id . '.flv' .
    ' -c:v libvpx -vf scale=-2:240,format=yuv420p' .
    ' -q:v 10 -c:a libvorbis -b:a 80k -ar 22050 -ac 1' .
    ' data/videos/' . $request->v_id . '.webm'
);




    // Duration
    $duration = round((int) exec($config['ffprobe'] . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '.$request->targetdir.$request->v_id.'_temp.'.$request->vext));
    // Still 1
    exec($config['ffmpeg'] . ' -i '.$request->targetdir.$request->v_id.'_temp.'.$request->vext.' -c:v mjpeg -ss '.($duration*0.25).' -vframes 1 -vf "scale=120:90:force_original_aspect_ratio=decrease,pad=120:90:(ow-iw)/2:(oh-ih)/2" -an -q:v 5 data/thmbs/'.$request->v_id.'_1.jpg');
    
    // Still 2
    exec($config['ffmpeg'] . ' -i '.$request->targetdir.$request->v_id.'_temp.'.$request->vext.' -c:v mjpeg -ss '.($duration*0.50).' -vframes 1 -vf "scale=120:90:force_original_aspect_ratio=decrease,pad=120:90:(ow-iw)/2:(oh-ih)/2" -an -q:v 5 data/thmbs/'.$request->v_id.'_2.jpg');

    // Still 3
    exec($config['ffmpeg'] . ' -i '.$request->targetdir.$request->v_id.'_temp.'.$request->vext.' -c:v mjpeg -ss '.($duration*0.75).' -vframes 1 -vf "scale=120:90:force_original_aspect_ratio=decrease,pad=120:90:(ow-iw)/2:(oh-ih)/2" -an -q:v 5 data/thmbs/'.$request->v_id.'_3.jpg');

	$stmt = $conn->prepare('UPDATE videos SET time = :duration, converted = 1 WHERE vid = :video_id');
	$stmt->execute([':duration' => $duration, ':video_id' => $request->v_id]);
	unlink($request->targetdir.$request->v_id."_temp.".$request->vext);
} catch (Exception $e) {
	$stmt = $conn->prepare('UPDATE videos SET converted = 3 WHERE vid = :video_id');
	$stmt->execute([':video_id' => $request->v_id]);
    unlink($request->targetdir.$request->v_id."_temp.".$request->vext);
}
?>