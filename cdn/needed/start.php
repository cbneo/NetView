<?php 
require "needed/scripts.php";
$inbox = $conn->prepare("SELECT * FROM messages WHERE receiver = ? AND isRead = 0 ORDER BY created DESC");
$inbox->execute([$session['uid']]);
$inbox = $inbox->rowCount();
?>
<html>

<body<?php if ($current_page == 'index') { echo " onLoad=javascript:sf(); return false;"; } ?>>

<table align="center" width="100%" bgcolor="#D5E5F5" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="../img/box_login_tl.gif" width="5" height="5"></td>
		<td><img src="../img/pixel.gif" width="1" height="5"></td>
		<td><img src="../img/box_login_tr.gif" width="5" height="5"></td>
	</tr>
	<tr>
		<td><img src="../img/pixel.gif" width="5" height="1"></td>
		
		<td width="100%">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
										<table cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td>&nbsp;<a href="index.php" <?php if ($current_page == 'index') { echo 'class=bold'; }?>>Home</a></td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_videos.php" <?php if ($current_page == 'my_videos') { echo 'class=bold'; }?>>My Videos</a></td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_favorites.php" <?php if ($current_page == 'my_favorites') { echo 'class=bold'; }?>>My Favorites</a></td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_messages.php" <?php if ($current_page == 'my_messages') { echo 'class=bold'; }?>>My Messages</a>
														</td>
							<td>&nbsp;|&nbsp;</td>
							<td><a href="my_profile.php" <?php if ($current_page == 'my_profile') { echo 'class=bold'; }?>>My Profile</a></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			
			</td>
	
		<td><img src="../img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="../img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="../img/pixel.gif" width="1" height="5"></td>
		<td><img src="../img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</table>

<div class="tableLinkBar">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<?php if ($current_page !== 'index') { ?>
				<td width="130" rowspan="2"><a href="../index.php"><img src="../img/logo_sm.gif" width="136" height="48" alt="YuoToob" border="0" hspace="5" vspace="8"></a></td>
			<?php } ?> 
		<td width="100%" align="right">
		<table align="right" cellpadding="2" cellspacing="0" border="0">
			<tr> <?php if(isset($session)) { ?>
                <td>Hello, <a href="profile.php?user=<?php echo htmlspecialchars($session['username']) ?>" class="bold"><?php echo htmlspecialchars($session['username']) ?></a>!&nbsp;<img src="../img/mail<? if($inbox == '1') { echo '_unread'; } ?>.gif" id="mailico" border="0">&nbsp;(<a href="/my_messages.php"><?php echo htmlspecialchars($inbox) ?></a>)</td>
                <td>&nbsp;|&nbsp;</td>
                <td><a href="/logout.php?next=<?php echo $_SERVER['REQUEST_URI'] ?>">Log Out</a></td>
            <?php } else if(!isset($session)){ ?>
                            <td><a href="signup.php" class="bold">Sign Up</a></td>
                <td>&nbsp;|&nbsp;</td>
                <td><a href="login.php">Log In</a></td>
                <?php } ?>
				<td>&nbsp;|&nbsp;</td>
				<td><a href="help.php">Help</a>&nbsp;</td>
						</tr>
		</table>
		</td>
	</tr>

		<tr>
        <?php if ($current_page !== 'login' && $current_page !== 'signup' && $current_page !== 'index') { ?>
		<td width="100%">
		<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<form method="GET" action="results.php">
				<td>
					<input type="text" value="" name="search" size="30" maxlength="128" style="color:#ff3333; font-size: 16px; padding: 3px;">
				</td>
				<td>
					<input type="submit" value="Search Videos">
				</td>

				<td width="100%">
				<div style="font-size: 13px; font-weight: bold; text-align: right; margin-right: 5px;"><a href="my_videos_upload.php">>>> Upload Your Videos</a></div>
				</td>
<?php } ?>
				</form>
			</tr>
		</table>
		</td>
	</tr>
		
</table></div>

