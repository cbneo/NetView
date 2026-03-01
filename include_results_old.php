<link href="styles.css" rel="stylesheet" type="text/css">
<style>
body {background-color: #DDD;}
</style>
<?php
require __DIR__ . "/needed/scripts.php";

if (!empty($_GET['search']) && !empty($_GET['v'])) {
    $search = preg_quote($_GET['search']); // Escape special characters for regular expression
    $search = str_replace(" ", "|", $search);   
    $videos = $conn->prepare("
        SELECT * 
        FROM videos 
        LEFT JOIN users ON users.uid = videos.uid 
        WHERE (videos.tags REGEXP ? OR videos.description REGEXP ? OR videos.title REGEXP ? OR users.username REGEXP ?) 
		AND videos.vid != ?
        AND videos.privacy = 1 
        AND videos.converted = 1 
        AND users.termination = 0 
        ORDER BY ABS(videos.vid - ?) ASC
        LIMIT 10
    ");
    $videos->execute([$search, $search, $search, $search, $_GET['v'], $_GET['v']]);
} else {
    class videos { // Placeholder class when search is empty
        function rowCount() {
            return 0;
        }
    }
    $videos = new videos;
}

$watching = $conn->prepare("
	SELECT * 
	FROM videos 
    LEFT JOIN users ON users.uid = videos.uid 
	WHERE videos.vid = ? 
	AND videos.privacy = 1 
	AND videos.converted = 1 
");
$watching->execute([$_GET['v']]);
foreach($watching as $playing) {
?>
<div class="moduleFrameEntrySelected">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td><a href="watch.php?v=<?php echo htmlspecialchars($playing['vid']); ?>" class="bold" target="_parent"><img src="get_still.php?video_id=<?php echo htmlspecialchars($playing['vid']); ?>" class="moduleEntryThumb" width="80" height="60"></a></td>
		<td width="100%"><div class="moduleFrameTitle"><a href="watch.php?v=<?php echo htmlspecialchars($playing['vid']); ?>" target="_parent"><?php echo htmlspecialchars($playing['title']); ?></a></div>
		<div class="moduleFrameDetails">Added: <?php echo retroDate($playing['uploaded']); ?>		<br>by <a href="profile.php?user=<?php echo htmlspecialchars($playing['username']); ?>" target="_parent"><?php echo htmlspecialchars($playing['username']); ?></a></div>
		<div class="moduleFrameDetails">Views: <?php echo $playing['views']; ?> <br> Comments: <?php echo $playing['comm_count']; ?></div>
        <div style="font-size: 13px;font-weight: bold;padding: 4px 6px 4px 6px;background-color:#FFCC66;color: #AA7733;width: 125px;">&#60;&#60;&#60; NOW PLAYING!</div>
		</td>    
	</tr>
</table>
</div>
<?php } foreach($videos as $video) { ?>
<div class="moduleFrameEntry">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td><a href="watch.php?v=<?php echo htmlspecialchars($video['vid']); ?>" class="bold" target="_parent"><img src="get_still.php?video_id=<?php echo htmlspecialchars($video['vid']); ?>" class="moduleEntryThumb" width="80" height="60"></a></td>
		<td width="100%"><div class="moduleFrameTitle"><a href="watch.php?v=<?php echo htmlspecialchars($video['vid']); ?>" target="_parent"><?php echo htmlspecialchars($video['title']); ?></a></div>
		<div class="moduleFrameDetails">Added: <?php echo retroDate($video['uploaded']); ?>		<br>by <a href="profile.php?user=<?php echo htmlspecialchars($video['username']); ?>" target="_parent"><?php echo htmlspecialchars($video['username']); ?></a></div>
		<div class="moduleFrameDetails">Views: <?php echo $video['views']; ?> <br> Comments: <?php echo $video['comm_count']; ?></div>
		</td>    
	</tr>
</table>
</div>
<? } ?>
