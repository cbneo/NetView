<?php 
if(isset($_GET['v'])) {
	header("Location: watch.php?v=".$_GET['v'], true, 303);
	die();
}
require "needed/start.php";

$tags_strings = $conn->query("SELECT * FROM videos LEFT JOIN users ON users.uid = videos.uid WHERE converted = 1 AND privacy = 1 AND users.termination = 0 ORDER BY uploaded DESC LIMIT 50");
$tag_list = [];
foreach($tags_strings as $result) $tag_list = array_merge($tag_list, explode(" ", $result['tags']));
$tag_list = array_slice(array_count_values($tag_list), 0, 100, true);
$featured = $conn->query("SELECT * FROM picks LEFT JOIN videos ON videos.vid = picks.video LEFT JOIN users ON users.uid = videos.uid WHERE videos.converted = 1 AND videos.privacy = 1 ORDER BY picks.featured DESC LIMIT 5");

$rec_viewed = $conn->query("SELECT * FROM views LEFT JOIN videos ON videos.vid = views.vid LEFT JOIN users ON users.uid = videos.uid AND videos.privacy = 1 AND videos.converted = 1 AND users.termination = 0 ORDER BY views.viewed DESC LIMIT 4");
if ($_SESSION['uid'] != NULL) {
//$y_views = $conn->prepare("SELECT COUNT(view_id) FROM views WHERE uid = ?");
$y_views = $conn->prepare("SELECT vids_watched FROM users WHERE uid = ?");
$y_views->execute([$session['uid']]);
$y_views = $y_views->fetchColumn();

/*$vids = $conn->prepare(
	"SELECT pub_vids FROM users
	WHERE uid = ?"
);
$vids->execute([$session['uid']]);*/

$fans = $conn->prepare(
	"SELECT SUM(fav_count) FROM videos
	WHERE videos.uid = ? AND videos.converted = 1"
);
$fans->execute([$session['uid']]);

$p_views = $conn->prepare(
	"SELECT SUM(views) FROM videos
	WHERE videos.uid = ? AND videos.converted = 1"
);
$p_views->execute([$session['uid']]);

/*$favs = $conn->prepare(
	"SELECT fav_count FROM users
	WHERE uid = ?"
);
$favs->execute([$session['uid']]);*/
}
?>
<script>
	function sf()
	{
		document.f.search.focus();
	}
</script>

<table width="80%" align="center" cellpadding="3" cellspacing="0" border="0">
	<tbody><tr>
		<td align="center">
			<img src="img/<? echo invokethConfig("logo"); ?>" width="180" height="71" hspace="12" vspace="12" alt="YuoToob">
			<br>
			<? echo invokethConfig("slogan"); ?>
			<br>
			<br>
		</td>
	</tr>

	<form name="f" method="GET" action="results.php">
	<tr>
		<td align="center"><input type="text" name="search" size="35" maxlength="128" style="color:#ff3333; font-size: 18px; padding: 3px;"></td>
	</tr>
	<tr>
		<td align="center"><input type="submit" value="Search Videos"></td>
	</tr>
	</form>
</tbody></table>

<div style="font-size: 16px; font-weight: bold; margin-top: 20px; margin-bottom: 30px; text-align: center;"><a href="my_videos_upload.php">Upload Videos</a> &nbsp; // &nbsp; <a href="browse.php">Browse Videos</a><img border="0" src="img/new.gif"></div>

<table width="70%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td align="center">
		<div style="font-size: 13px; color: #333333; margin-bottom: 30px;">
		
				
			<?php foreach($tag_list as $tag => $frequency	) {
        $freqindex = $frequency*2;
        $freqindex = $freqindex+10;
        if ($freqindex > 28) {
            $freqindex = 28;
        }
					echo '<a style="font-size: '.htmlspecialchars($freqindex).'px;" href="results.php?search='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a> :'."\r\n";
				} ?>
				
					
			<div style="font-size: 14px; font-weight: bold; margin-top: 10px;"><a href="tags.php">See More Tags</a></div>
		
		</div>
		</td>
	</tr>
</tbody></table>

<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tbody><tr>
		<td><img src="img/box_login_tl.gif" width="5" height="5"></td>
		<td width="100%"><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_tr.gif" width="5" height="5"></td>
	</tr>
	<tr>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
		<td>
		<div class="moduleTitleBar">
		<div class="moduleTitle"><div style="float: right; padding-right: 5px;"><a href="browse.php">See More Videos</a></div>
		Featured Videos
		</div>
		</div>
				
		<div class="moduleFeatured"> 
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr valign="top">

						
						
						<?php foreach($featured as $pick) { ?>
						<td width="20%" align="center"><a href="index.php?v=<?php echo htmlspecialchars($pick['vid']); ?>"><img src="get_still.php?still_id=2&amp;video_id=<?php echo htmlspecialchars($pick['vid']); ?>" class="moduleFeaturedThumb" width="120" height="90"></a>
						<div class="moduleFeaturedTitle"><a href="index.php?v=<?php echo htmlspecialchars($pick['vid']); ?>"><?php echo htmlspecialchars($pick['title']); ?></a></div>
						<div class="moduleFeaturedDetails">Added: <?php echo retroDate($pick['uploaded']); ?>						<br>by <a href="profile.php?user=<?php echo htmlspecialchars($pick['username']); ?>"><?php echo htmlspecialchars($pick['username']); ?></a><!-- (<a href="profile.php?user=<?php echo htmlspecialchars($pick['username']); ?>">10</a>) --></div>
						<div class="moduleFeaturedDetails">Views: <?php echo number_format($pick['views']); ?> | Comments: <?php echo getcommentcount($pick['vid']); ?></div></td>
						<?php } ?>
						
						
						
				</tr>
			</tbody></table>
		</div>
		
		</td>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</tbody></table>

<br>

<?php require "needed/end.php"; ?>
