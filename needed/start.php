<?php 
require __DIR__ . "/scripts.php";
$inbox = $conn->prepare("SELECT * FROM messages WHERE receiver = ? AND isRead = 0 ORDER BY created DESC");
$inbox->execute([$session['uid']]);
$inbox = $inbox->rowCount();
?>
<?php if ($current_page !== 'sharing')  { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<? } ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>YuoToob - Your Digital Video Repository</title>
<meta name="description" content="Share your videos with friends and family">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href="styles.css" rel="stylesheet" type="text/css">
<link rel="alternate" type="application/rss+xml" title="YuoToob "" Recently Added Videos [RSS]" href="<?php echo $siteurl; ?>/rss/global/recently_added.rss">
<script language="javascript" type="text/javascript">
	onLoadFunctionList = new Array();
	function performOnLoadFunctions()
	{
		for (var i in onLoadFunctionList)
		{
			onLoadFunctionList[i]();
		}
	}
</script>
<?php if ($current_page == 'watch') { ?>
<script src="flashobject.js" language="javascript"></script>
<? } ?>
<? if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') { ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2537513323123758" crossorigin="anonymous"></script>
<? } ?>
</head>


<body onload="javascript:sf();" return="" false;="">

<table align="center" width="100%" bgcolor="#D5E5F5" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td><img src="img/box_login_tl.gif" width="5" height="5"></td>
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_tr.gif" width="5" height="5"></td>
	</tr>
	<tr>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
		
		<td width="100%">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tbody><tr>
				<td>
					<table cellpadding="2" cellspacing="0" border="0">
						<tbody><tr>
							<td>&nbsp;<a href="index.php"<?php if ($current_page == 'index') { ?> class="bold"<? } ?>>Home</a></td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_videos.php"<?php if ($current_page == 'my_videos') { ?> class="bold"<? } ?>>My Videos</a></td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_favorites.php"<?php if ($current_page == 'my_favorites') { ?> class="bold"<? } ?>>My Favorites</a></td>
							<!--
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_friends.php" >My Friends</a></td>
							-->
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_messages.php"<?php if ($current_page == 'my_messages' || $current_page == 'outbox') { ?> class="bold"<? } ?>>My Messages</a>
														</td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_profile.php"<?php if ($current_page == 'my_profile') { ?> class="bold"<? } ?>>My Profile</a></td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table>
			
		</td>
	
		<td><img src="img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</tbody></table>
<script>
	function sf()
	{
		document.f.search.focus();
	}
</script>
<div class="tableLinkBar">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr valign="top">
		<?php if ($current_page != 'index') { ?>
		<td width="130" rowspan="2"><a href="index.php"><img src="img/<? echo invokethConfig("logo_sm"); ?>" width="120" height="48" alt="YuoToob" border="0" hspace="5" vspace="8"></a></td>
		<? } ?>
		<td width="100%" align="right">
		<table align="right" cellpadding="2" cellspacing="0" border="0">
			<tbody><tr>
				<?php if(isset($session)) { ?>
                <td>Hello, <a href="/profile.php?user=<?php echo htmlspecialchars($session['username']) ?>"><?php echo htmlspecialchars($session['username']) ?></a>!&nbsp;<a href="my_messages.php"><img src="img/mail<? if($inbox > 0) { echo '_unread'; } ?>.gif" id="mailico" border="0"></a>&nbsp;(<a href="my_messages.php"><?php echo htmlspecialchars($inbox) ?></a>)</td>
                <? if ($session['staff'] == 1) {?><td style="padding: 0px 5px 0px 5px;">|</td>
                <td><a href="/admin/" class="bold" style="color: #ff3333;">ManagerToob</a></td><? } ?>
                <td style="padding: 0px 5px 0px 5px;">|</td>
                <td><a href="logout.php?next=<?php echo $_SERVER['REQUEST_URI'] ?>">Log Out</a></td>
            <?php } else if(!isset($session)){ ?>
                            <td><a href="signup.php" class="bold">Sign Up</a></td>
				<td>&nbsp;|&nbsp;</td>
				<td><a href="login.php">Log In</a></td>
                <?php } ?>
				<td>&nbsp;|&nbsp;</td>
				<td><a href="help.php">Help</a>&nbsp;</td>
						</tr>
		</tbody></table>
		</td>
	</tr>
	<?php if ($current_page != 'index' && $current_page != 'login') { ?>
	<tr>
		<td width="100%">
		<table cellpadding="2" cellspacing="0" border="0">
			<tbody><tr>
				<form method="GET" action="results.php">
				<td>
					<input type="text" value="<?php if ($current_page == 'results' && !empty($_GET['search'])) { echo $_GET['search']; } ?>" name="search" size="30" maxlength="128" style="color:#ff3333; font-size: 16px; padding: 3px;">
				</td>
				<td>
					<input type="submit" value="Search Videos">
				</td>

				<td width="100%">
					<div style="font-size: 13px; font-weight: bold; text-align: right; margin-right: 5px;"><a href="browse.php">Browse Videos</a><img border="0" src="img/new.gif"> &nbsp;//&nbsp; <a href="my_videos_upload.php">Upload Videos</a></div>
				</td>
				</form>
			</tr>
		</tbody></table>
		</td>
	</tr>
	<? } ?>
</tbody></table></div>
<? if(!empty(invokethConfig("notice"))) { alert("Notice: ".invokethConfig("notice")); } 
if (isset($_COOKIE['hates__dwntime']) && invokethConfig("maintenance") == 1){
    alert("The website is currently in maintenance.");
    }
    if (isset($_GET['session'])) {
	require_once "needed/phpickle/phpickle.php";
	$base64urltobase64 = strtr($_GET['session'], '-_', '+/');
	$string = phpickle::loads(base64_decode($base64urltobase64));
    if (implode(" ",$string['messages']) != NULL) {
	$type = "success";
	$message = $string['messages']['0'];
    } elseif (implode(" ",$string['errors']) != NULL) {
	$type = "error";
	$message = $string['errors']['0'];
    }
    alert(htmlspecialchars($message), htmlspecialchars($type));
    }
    if ($current_page == 'profile' && $_GET['user'] == 'YuoToob') { alert("dookie", "success"); }
    //if ($current_page == 'index') { alert("i've confirmed everyones email", "success"); }
    //if ($current_page == 'index') { alert("Make sure to join our partner! <a href='http://www.epiktube.xyz/'>http://www.epiktube.xyz/</a>", "success"); }
?>
