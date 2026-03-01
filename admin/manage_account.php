<?php
require "admin_head.php";

$profile = $conn->prepare("SELECT * FROM users WHERE users.username = ?");
$profile->execute([$_GET['user']]);

if($profile->rowCount() == 0) {
    if(empty($_GET['user'])) {
	redirect("index_down.php");
    } else {
    session_error_index("Invalid username", "error");
    }
} else {
	$profile = $profile->fetch(PDO::FETCH_ASSOC);

    $profile['videos'] = $conn->prepare("SELECT vid FROM videos WHERE uid = ? AND privacy = 1 AND converted = 1");
    $profile['videos']->execute([$profile["uid"]]);
    $profile['videos'] = $profile['videos']->rowCount();
/*
    $profile['priv_videos'] = $conn->prepare("SELECT vid FROM videos WHERE uid = ? AND privacy = 2 AND converted = 1");
    $profile['priv_videos']->execute([$profile["uid"]]);
    $profile['priv_videos'] = $profile['priv_videos']->rowCount();
*/
    
    $view_profile = $conn->prepare("UPDATE users SET profile_views = profile_views + 1 WHERE uid = ?");
	$view_profile->execute([$profile['uid']]);


    $profile['favorites'] = $conn->prepare("SELECT fid FROM favorites WHERE uid = ?");
    $profile['favorites']->execute([$profile["uid"]]);
    $profile['favorites'] = $profile['favorites']->rowCount();

/*
    $profile['watched'] = $conn->prepare("SELECT COUNT(view_id) FROM views WHERE uid = ?");
    $profile['watched']->execute([$profile['uid']]);
    $profile['watched'] = $profile['watched']->fetchColumn();

    $profile['friends'] = $conn->prepare("SELECT COUNT(relationship) FROM relationships WHERE (sender = ? OR respondent = ?) AND accepted = 1");
    $profile['friends']->execute([$profile["uid"],$profile["uid"]]);
    $profile['friends'] = $profile['friends']->fetchColumn();
*/

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
	
	$profile_latest_video['comments'] = $conn->prepare("SELECT COUNT(cid) AS comments FROM comments WHERE vidon = ?");
	$profile_latest_video['comments']->execute([$profile_latest_video['vid']]);
	$profile_latest_video['comments'] = $profile_latest_video['comments']->fetchColumn();*/
    $videos = $conn->prepare(
	"SELECT * FROM videos
	LEFT JOIN users ON users.uid = videos.uid
	WHERE videos.uid = ? AND videos.converted = 1
	ORDER BY videos.uploaded DESC"
);
if($profile_latest_video['privacy'] !== 1) {
    $profile_latest_video = false;
}
$videos->execute([$profile['uid']]);
$favorites = $conn->prepare(
	"SELECT * FROM favorites
	LEFT JOIN videos ON favorites.vid = videos.vid
	LEFT JOIN users ON users.uid = videos.uid
	WHERE favorites.uid = ? AND videos.converted = 1
	ORDER BY favorites.fid DESC"
);
$favorites->execute([$profile['uid']]);
}
}

if($profile['closure'] == 1) { $term_text = 'This user account is closed.'; } else { $term_text = 'This user account is suspended.'; } if($profile['termination'] == 1) { session_error_index($term_text, "error"); } else { ?>
<table width="80%" align="center" cellpadding="5" cellspacing="0" border="0">
	<tbody><tr valign="top">

		
		<td width="200">
		<div style="background-color: #D5E5F5; padding: 10px; padding-top: 5px; border: 6px double #FFFFFF;">
				
								
            
				<table width="100%" bgcolor="#D5E5F5" cellpadding="5" cellspacing="0" border="0">
			<tbody><tr>
				<td align="center">
				<? if($profile_latest_video) { ?>
				<div class="highlight">Last Video Added</div>
				<a href="../watch.php?v=<?php echo htmlspecialchars($profile_latest_video['vid']) ?>"><img src="../get_still.php?video_id=<?php echo htmlspecialchars($profile_latest_video['vid']) ?>" class="moduleFeaturedThumb" width="120" height="90"></a>
				<div class="moduleFeaturedTitle"><a href="watch.php?v=<?php echo htmlspecialchars($profile_latest_video['vid']) ?>"><?php echo shorten(htmlspecialchars($profile_latest_video['title']), 15); ?></a></div>
				<div class="moduleFeaturedDetails">Added: <?php echo retroDate($profile_latest_video['uploaded'], "F j, Y") ?>				<br>by <a href="profile.php?user=<?php echo htmlspecialchars($profile_latest_video['username']) ?>"><?php echo htmlspecialchars($profile_latest_video['username']) ?></a></div>
				<div class="moduleFeaturedDetails">Views: <?php echo $profile_latest_video['views']; ?></div>
				<div class="moduleFeaturedDetails">Comments: <?php echo $profile_latest_video['comm_count']; ?></div>

				<br><? } ?><form method="post" action="../outbox.php?user=<?php echo htmlspecialchars($profile['username']) ?>">
				<input type="submit" value="Contact User">
				</form><br>
				<form method="post" action="./user_terminate.php?user_id=<?php echo htmlspecialchars($profile['uid']) ?>">
				<input type="submit" value="Terminate User">
				</form><br>
				<form method="post" action="../profile.php?user=<?php echo htmlspecialchars($profile['username']) ?>">
				<input type="submit" value="View Profile">
				</form><br>

				<span style="font-size: 11px; margin-right: 3px;">Like my videos?<br>
				<a href="../rss/user/<?php echo htmlspecialchars($profile['username']) ?>/my_videos.rss">Subscribe to my RSS Feed.</a></span>
				</td>
			</tr>
		</tbody></table>
		</div>
		</td>

			
		<td>

		<div class="tableSubTitle">User Details: <span style="float:right; font-size: 12px; font-weight: normal;"><a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'])?>">Back to 'admin panel'</a></span></div>

		<table width="100%" cellpadding="5" cellspacing="0" border="0">
			<tbody><tr>
				<td width="150" align="right"><span class="label">User Name:</span></td>
				<td><?php echo htmlspecialchars($profile['username']) ?></td>
			</tr>
			
			<!-- Personal Information: -->
			
			<? if (!empty($profile['name'])) { ?>
						<tr>
				<td align="right"><span class="label">Name:</span></td>
				<td><?php echo htmlspecialchars($profile['name']) ?></td>
			</tr>			
            <? } ?>
					
			<? if ($profile['birthday'] != '0000-00-00' && $profile['birthday'] != NULL) { ?>
						<tr>
				<td align="right"><span class="label">Age:</span></td>
				<td><?php echo str_replace('ago', 'old', timeAgo($profile['birthday'])); ?></td>
			</tr>
			<? } ?>
			
			<? if(!empty($profile['gender']) && $profile['gender'] !== 0) { ?>
						<tr>
				<td align="right"><span class="label">Gender:</span></td>
				<td><?php
					switch($profile['gender']) {
						case '0':
							break;
						case '1':
							echo "Male";
							break;
						case '2':
							echo "Female";
							break;
                        case '3':
						echo "Other";
						break;
                        default:
                        echo "Prefer not to say";
                        break;
					}
				?></td>
			</tr>
			<? } ?>
					
			<?php if(!empty($profile['relationship']) && $profile['relationship'] !== 0) { ?>
						<tr>
				<td align="right"><span class="label">Relationship Status:</span></td>
				<td><?php
					    switch($profile['relationship']) {
						case '0':
							break;
						case '1':
							echo "Single";
							break;
						case '2':
							echo "Taken";
							break; 
                            default:
                        echo "Prefer not to say";
                         break; } ?></td>
			</tr>
			<? } ?>
					
			<? if (!empty($profile['about'])) { ?>
						<tr>
				<td align="right"><span class="label">About Me:</span></td>
				<td><?php echo nl2br(htmlspecialchars($profile['about'])); ?></td>
			</tr>		
			<? } ?>		
			
			<? if (!empty($profile['website'])) { ?>
						<tr>
				<td align="right"><span class="label">Personal Website:</span></td>
				<td><a href="<?php echo htmlspecialchars($profile['website']) ?>"><?php echo htmlspecialchars($profile['website']) ?></a></td>
			</tr>
			<? } ?>
					
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
			<!-- Location Information -->
		
			<? if (!empty($profile['hometown'])) { ?>
						<tr>
				<td align="right"><span class="label">Hometown:</span></td>
				<td><?php echo htmlspecialchars($profile['hometown']) ?></td>
			</tr>
			<? } ?>
			
			<? if (!empty($profile['city'])) { ?>
						<tr>
				<td align="right"><span class="label">Current City:</span></td>
				<td><?php echo htmlspecialchars($profile['city']) ?></td>
			</tr>
			<? } ?>
			
			<? if (!empty($profile['country'])) { ?>
						<tr>
				<td align="right"><span class="label">Current Country:</span></td>
				<td><? echo htmlspecialchars(getCountryName($profile['country'])) ?></td>
			</tr>
			<? } ?>
					
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
			<!-- Random Information -->
		
			<? if (!empty($profile['occupations'])) { ?>
						<tr>
				<td align="right"><span class="label">Occupations:</span></td>
				<td><?php echo htmlspecialchars($profile['occupations']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['companies'])) { ?>
						<tr>
				<td align="right"><span class="label">Companies:</span></td>
				<td><?php echo htmlspecialchars($profile['companies']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['schools'])) { ?>
						<tr>
				<td align="right"><span class="label">Schools:</span></td>
				<td><?php echo htmlspecialchars($profile['schools']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['hobbies'])) { ?>
						<tr>
				<td align="right"><span class="label">Interests &amp; Hobbies:</span></td>
				<td><?php echo htmlspecialchars($profile['hobbies']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['fav_media'])) { ?>
						<tr>
				<td align="right"><span class="label">Favorite Movies &amp; Shows:</span></td>
				<td><?php echo htmlspecialchars($profile['fav_media']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['music'])) { ?>
						<tr>
				<td align="right"><span class="label">Favorite Music:</span></td>
				<td><?php echo htmlspecialchars($profile['music']) ?></td>
			</tr>
			<? } ?>
						
			<? if (!empty($profile['books'])) { ?>
						<tr>
				<td align="right"><span class="label">Favorite Books:</span></td>
				<td><?php echo htmlspecialchars($profile['books']) ?></td>
			</tr>
			<? } ?>
			
			<tr>
				<td align="right"><span class="label">Last Login:</span></td>
				<td><? echo timeAgo($profile['lastlogin']) ?></td>
			</tr>
		</tbody></table>
		
		</td>
	</tr>
</tbody></table>

<? } ?>
