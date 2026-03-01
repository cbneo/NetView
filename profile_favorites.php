<?php
require "needed/start.php";
$profile = $conn->prepare("SELECT * FROM users WHERE users.username = ?");
$profile->execute([$_GET['user']]);

if($profile->rowCount() == 0) {
	die('Profile was not found.');
} else {
	$profile = $profile->fetch(PDO::FETCH_ASSOC);
    
	$profile['videos'] = $conn->prepare("SELECT vid FROM videos WHERE uid = ? AND converted = 1");
    $profile['videos']->execute([$profile["uid"]]);
    $profile['videos'] = $profile['videos']->rowCount();
	
	/*
    $profile['priv_videos'] = $conn->prepare("SELECT vid FROM videos WHERE uid = ? AND privacy = 2 AND converted = 1");
    $profile['priv_videos']->execute([$profile["uid"]]);
    $profile['priv_videos'] = $profile['priv_videos']->rowCount();
	*/
	
	$profile['favorites'] = $conn->prepare("SELECT fid FROM favorites WHERE uid = ?");
	$profile['favorites']->execute([$profile["uid"]]);
	$profile['favorites'] = $profile['favorites']->rowCount();
	
	/*
	$profile['friends'] = $conn->prepare("SELECT COUNT(relationship) FROM relationships WHERE (sender = ? OR respondent = ?) AND accepted = 1");
	$profile['friends']->execute([$profile["uid"],$profile["uid"]]);
	$profile['friends'] = $profile['friends']->fetchColumn();
	*/
	
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$ppv = 10;
$offs = ($page - 1) * $ppv;

$profile_latest_video = $conn->prepare(
	"SELECT * FROM videos
	LEFT JOIN users ON users.uid = videos.uid
	WHERE videos.uid = ? AND videos.converted = 1
	GROUP BY videos.vid
	ORDER BY videos.uploaded DESC LIMIT 1"
);
$profile_latest_video->execute([$profile['uid']]);

if($profile_latest_video->rowCount() == 0) {
	$profile_latest_video = false;
} else {
	$profile_latest_video = $profile_latest_video->fetch(PDO::FETCH_ASSOC);
	
	/*$profile_latest_video['views'] = $conn->prepare("SELECT COUNT(view_id) AS views FROM views WHERE vid = ?");
	$profile_latest_video['views']->execute([$profile_latest_video['vid']]);
	$profile_latest_video['views'] = $profile_latest_video['views']->fetchColumn();
	
	$profile_latest_video['comments'] = $conn->prepare("SELECT COUNT(cid) AS comments FROM comments WHERE vid = ?");
	$profile_latest_video['comments']->execute([$profile_latest_video['vid']]);
	$profile_latest_video['comments'] = $profile_latest_video['comments']->fetchColumn();*/
}
    $vidocount = $conn->prepare(
	"SELECT * FROM favorites
	LEFT JOIN videos ON favorites.vid = videos.vid
	LEFT JOIN users ON users.uid = videos.uid
	WHERE favorites.uid = ?
	ORDER BY favorites.fid DESC"
);
$vidocount->execute([$profile['uid']]);
$vidocount = $vidocount->rowCount();
$videos = $conn->prepare(
    "SELECT * FROM favorites
    INNER JOIN videos ON favorites.vid = videos.vid
    INNER JOIN users ON users.uid = videos.uid
    WHERE favorites.uid = ? AND videos.converted = 1 AND videos.privacy = 1 AND videos.rejected = 0
    ORDER BY favorites.fid DESC LIMIT $ppv OFFSET $offs"
);
$videos->execute([$profile['uid']]);
/*$favorites = $conn->prepare(
	"SELECT * FROM favorites
	LEFT JOIN videos ON favorites.vid = videos.vid
	LEFT JOIN users ON users.uid = videos.uid
	WHERE favorites.uid = ?
	ORDER BY favorites.fid DESC LIMIT $ppv OFFSET $offs"
);
$favorites->execute([$profile['uid']]);*/
}
$related_tags = [];

$vidquery = $conn->prepare("SELECT COUNT(*) FROM videos WHERE uid=?");
$vidquery->execute([$profile['uid']]);
$vids = $vidquery->rowCount();

$favquery = $conn->prepare("SELECT COUNT(*) FROM favorites WHERE uid=?");
$favquery->execute([$profile['uid']]);
$favs = $favquery->rowCount();
?>
<div class="pageTitle">User Profile</div>

<div style="text-align:center; margin-bottom: 5px;">
<a href="profile.php?user=<?php echo htmlspecialchars($profile['username']) ?>">Profile</a>
<span style="padding-right: 5px; padding-left: 5px;">|</span>
<a href="profile_videos.php?user=<?php echo htmlspecialchars($profile['username']) ?>">Videos</a> (<?php echo $profile['videos']; ?>)
<span style="padding-right: 5px; padding-left: 5px;">|</span>
<a href="profile_favorites.php?user=<?php echo htmlspecialchars($profile['username']) ?>" class="bold">Favorites</a> (<?php echo $profile['favorites']; ?>)
</div>

<div class="pageTable">

<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tbody><tr>
		<td><img src="img/box_login_tl.gif" width="5" height="5"></td>
		<td width="100%"><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_tr.gif" width="5" height="5"></td>
	</tr>
	<tr>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
		<td>
		
		<div class="watchTitleBar">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr valign="top">
					<td><div class="watchTitle">Favorites // <span style="text-transform: capitalize;"><?php echo htmlspecialchars($profile['username']) ?></span></div></td>
				</tr>
			</tbody></table>
		</div>


		<?php foreach($videos as $video) { ?>
		<?php
			$related_tags = array_merge($related_tags, explode(" ", $video['tags']));
				
			/*$video['views'] = $conn->prepare("SELECT COUNT(view_id) FROM views WHERE vid = ?");
			$video['views']->execute([$video['vid']]);
			$video['views'] = $video['views']->fetchColumn();
						
			$video['comments'] = $conn->prepare("SELECT COUNT(cid) FROM comments WHERE vidon = ?");
			$video['comments']->execute([$video['vid']]);
			$video['comments'] = $video['comments']->fetchColumn();*/
		?>
		<div class="moduleEntry"> 
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr valign="top">
					<td><a href="watch.php?v=<?php echo $video['vid']; ?>"><img src="get_still.php?video_id=<?php echo $video['vid']; ?>" class="moduleEntryThumb" width="120" height="90"></a></td>
					<td width="100%"><div class="moduleEntryTitle"><a href="watch.php?v=<?php echo $video['vid']; ?>"><?php echo htmlspecialchars($video['title']); ?></a></div>
					<div class="moduleEntryDescription"><?php
$description = htmlspecialchars($video['description']);
$description = (strlen($description) > 100) ? substr($description, 0, 100) . '...' : $description;
echo $description;
?></div>
					<div class="moduleEntryTags">

					Tags // <?php foreach(explode(" ", $video['tags']) as $tag) echo '<a href="results.php?search='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a> : '; ?>					</div>

					<div class="moduleEntryDetails">Added: <?php echo retroDate($video['uploaded']); ?> by <a href="profile.php?user=<?php echo htmlspecialchars($video['username']); ?>"><?php echo htmlspecialchars($video['username']); ?></a></div>
					<div class="moduleEntryDetails">Views: <?php echo $video['views']; ?> | Comments: <?php echo getcommentcount($video['vid']); ?></div>
					</td>

				</tr>
			</tbody></table>
		</div>
		<?php } ?>

		
		</td>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</tbody></table>

</div>

<br>

<?php require "needed/end.php"; ?>