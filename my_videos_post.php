<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "needed/scripts.php";



if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['fileToUpload'])) {
    die("Requisição inválida");
}

if (!isset($conn) || !isset($session)) {
    die("Conexão ou sessão não carregada.");
}

$maxFileSize = 100 * 1024 * 1024;

if ($_FILES['fileToUpload']['error'] !== 0) {
    die("Erro no upload: " . $_FILES['fileToUpload']['error']);
}

if ($_FILES['fileToUpload']['size'] > $maxFileSize) {
    die("Arquivo muito grande.");
}

if (!is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
    die("Upload inválido.");
}

$video_id = uniqid();
$ext = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));

$targetDir = __DIR__ . '/data/videos/';
$thumbDir = __DIR__ . '/data/thmbs/';

if (!is_dir($targetDir) || !is_writable($targetDir)) {
    die("Pasta videos não existe ou sem permissão.");
}

if (!is_dir($thumbDir) || !is_writable($thumbDir)) {
    die("Pasta thumbs não existe ou sem permissão.");
}

$tempFile = $targetDir . $video_id . "_temp." . $ext;

if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $tempFile)) {
    die("Falha ao mover arquivo.");
}

/* ========= VERIFICA FFMPEG ========= */

$ffmpeg = trim(shell_exec("which ffmpeg"));
$ffprobe = trim(shell_exec("which ffprobe"));

if (empty($ffmpeg) || empty($ffprobe)) {
    die("FFmpeg ou FFprobe não encontrados no servidor.");
}

/* ========= CONVERSÃO ========= */

$flvOutput = $targetDir . $video_id . ".flv";
$webmOutput = $targetDir . $video_id . ".webm";

exec("$ffmpeg -i \"$tempFile\" -c:v flv1 -c:a mp3 \"$flvOutput\" 2>&1", $out1, $ret1);

if ($ret1 !== 0) {
    echo "<pre>";
    print_r($out1);
    die("Erro na conversão FLV");
}

exec("$ffmpeg -i \"$flvOutput\" -c:v libvpx -c:a libvorbis \"$webmOutput\" 2>&1", $out2, $ret2);

if ($ret2 !== 0) {
    echo "<pre>";
    print_r($out2);
    die("Erro na conversão WEBM");
}

/* ========= DURAÇÃO ========= */

$duration = trim(shell_exec("$ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \"$tempFile\""));
$duration = round((float)$duration);

/* ========= THUMB ========= */

exec("$ffmpeg -i \"$tempFile\" -ss 2 -vframes 1 \"$thumbDir{$video_id}_1.jpg\" 2>&1");

/* ========= BANCO ========= */

try {

$stmt = $conn->prepare("INSERT IGNORE INTO videos 
    (uid, vid, tags, title, description, file, privacy, cdn, recorddate, address, addrcountry) 
    VALUES 
    (:uid, :vid, :tags, :title, :description, :file, :privacy, :cdn, :recorddate, :address, :country)
");

$stmt->execute([
    ':uid' => $session['uid'],
    ':vid' => $video_id,
    ':tags' => $tags ?? 'video',
    ':title' => $_POST['field_upload_title'] ?? 'Sem título',
    ':description' => $_POST['field_upload_description'] ?? '',
    ':file' => $_FILES['fileToUpload']['name'],
    ':privacy' => $privacy ?? 1,
    ':cdn' => $video_CDN ?? 14,
    ':recorddate' => $recorddate ?? null,
    ':address' => $_POST['field_upload_address'] ?? null,
    ':country' => $_POST['field_upload_country'] ?? null
]);

} catch (PDOException $e) {
    die("Erro banco: " . $e->getMessage());
}

unlink($tempFile);

$stmt = $conn->prepare("
    UPDATE videos
    SET converted = 1, privacy = 1, rejected = 0
    WHERE vid = :vid
");
$stmt->execute([':vid' => $video_id]);

 $successful = "/my_videos_upload_complete.php?v=" . $video_id;

    header("Location: $successful");
    exit();

    }

?>