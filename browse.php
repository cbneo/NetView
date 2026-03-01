<?php
require "needed/start.php";
// It's just old code made compatible with kamtape because i was tired and lazy :P
// If it doesn't work too well development wise I'll rewrite it later
if(isset($_GET['s']) && in_array($_GET['s'], ["mr", "mp", "md", "mf", "r", "rf", "tr"])) {
	$browse_sort = $_GET['s'];
} else {
	$browse_sort = "mr";
}

if(isset($_GET['t']) && in_array($_GET['t'], ["t", "w", "m", "a"])) {
	$time = $_GET['t'];
} else {
	$time = "t";
}
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$ppv = 20;
$offs = ($page - 1) * $ppv;

if($browse_sort == "mr") {
	$videos = $conn->query("SELECT * FROM videos LEFT JOIN users ON users.uid = videos.uid WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) ORDER BY uploaded DESC LIMIT $ppv OFFSET $offs");
} elseif($browse_sort == "mp") {
	if($time == "t") {
		$videos = $conn->query(
			"SELECT * FROM videos
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0)
			ORDER BY views DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "w") {
		$videos = $conn->query(
			"SELECT * FROM videos
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0)
			ORDER BY views DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "m") {
		$videos = $conn->query(
			"SELECT * FROM videos
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) 
			ORDER BY views DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "a") {
		$videos = $conn->query(
			"SELECT * FROM videos
			LEFT JOIN users ON users.uid = videos.uid
			WHERE videos.converted = 1
			ORDER BY views DESC LIMIT $ppv OFFSET $offs"
		);
	}
} elseif($browse_sort == "md") {
	        $videos = $conn->query(
			"SELECT * FROM comments
			LEFT JOIN videos ON videos.vid = comments.vidon
			LEFT JOIN users ON users.uid = videos.uid
			WHERE ((videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) AND users.termination = 0) GROUP BY comments.vidon
			ORDER BY COUNT(comments.cid) DESC LIMIT $ppv OFFSET $offs"
		);
} elseif($browse_sort == "mf") {
	if($time == "t") {
		$videos = $conn->query(
			"SELECT * FROM favorites
			LEFT JOIN videos ON videos.vid = favorites.vid
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0)  GROUP BY favorites.vid
			ORDER BY COUNT(favorites.fid) DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "w") {
		$videos = $conn->query(
			"SELECT * FROM favorites
			LEFT JOIN videos ON videos.vid = favorites.vid
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) GROUP BY favorites.vid
			ORDER BY COUNT(favorites.fid) DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "m") {
		$videos = $conn->query(
			"SELECT * FROM favorites
			LEFT JOIN videos ON videos.vid = favorites.vid
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) AND videos.privacy = 1   GROUP BY favorites.vid
			ORDER BY COUNT(favorites.fid) DESC LIMIT $ppv OFFSET $offs"
		);
	} elseif($time == "a") {
		$videos = $conn->query(
			"SELECT * FROM favorites
			LEFT JOIN videos ON videos.vid = favorites.vid
			LEFT JOIN users ON users.uid = videos.uid
			WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) GROUP BY favorites.vid
			ORDER BY COUNT(favorites.fid) DESC LIMIT $ppv OFFSET $offs"
		);
	}
} elseif($browse_sort == "r") {
	$videos = $conn->query("SELECT * FROM videos LEFT JOIN users ON users.uid = videos.uid WHERE (videos.converted = 1 AND videos.privacy = 1 AND users.termination = 0) ORDER BY RAND() DESC LIMIT $ppv OFFSET $offs");
}
?>
<table align="center" cellpadding="5" cellspacing="0" border="0">
	<tbody><tr>
		<? if (empty($_GET['s']) || $_GET['s'] == 'mr') { ?><td class="bold">Most Recent</td><? } else { ?><td><a href="browse.php?s=mr" class="bold">Most Recent</a></td><? } ?><td>|</td><? if ($_GET['s'] == 'mp') { ?><td class="bold">Most Popular</td><? } else { ?><td><a href="browse.php?s=mp" class="bold">Most Popular</a></td><? } ?><td>|</td><? if ($_GET['s'] == 'md') { ?><td class="bold">Most Discussed</td><? } else { ?><td><a href="browse.php?s=md" class="bold">Most Discussed</a></td><? } ?><td>|</td><? if ($_GET['s'] == 'mf') { ?><td class="bold">Most Added to Favorites</td><? } else { ?><td><a href="browse.php?s=mf" class="bold">Most Added to Favorites</a></td><? } ?><td>|</td><? if ($_GET['s'] == 'r') { ?><td class="bold">Random</td><? } else { ?><td><a href="browse.php?s=r" class="bold">Random</a></td><? } ?>
		</tr>
</tbody></table>

<br>

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
			<div class="moduleTitle">
				<?php
				switch($browse_sort) {
					case 'mp':
						echo "Most Viewed";
						break;
					case 'md':
						echo "Most Discussed";
						break;
					case 'mf':
						echo "Most Added to Favorites";
						break;
					case 'r':
						echo "Random";
						break;
					default:
						echo "Most Recent";
				}
				?>
			</div>
		</div>
		
		<div class="moduleFeatured"> 
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tbody><?php $i = 0;
        foreach($videos as $video) { 		
                $i = $i + 1;
						if($i == 1) {
							echo '<tr valign="top">';
						}
		?><td width="20%" align="center"><a href="watch.php?v=<?php echo $video['vid']; ?>"><img src="get_still.php?video_id=<?php echo $video['vid']; ?>" width="120" height="90" class="moduleFeaturedThumb"></a><div class="moduleFeaturedTitle"><a href="watch.php?v=<?php echo $video['vid']; ?>"><?php echo htmlspecialchars($video['title']); ?></a></div><div class="moduleFeaturedDetails">Added: <?php echo retroDate($video['uploaded']); ?><br>by <a href="profile.php?user=<?php echo htmlspecialchars($video['username']); ?>"><?php echo htmlspecialchars($video['username']); ?></a></div><div class="moduleFeaturedDetails">Views: <?php echo number_format($video['views']); ?> | Comments: <?php echo getcommentcount($video['vid']); ?></div></td><? if($i == 5) { echo '</tr>'; $i = 0; } } ?>
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