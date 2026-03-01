<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "needed/start.php";

force_login();
    $favorites_of_you = $conn->prepare(
	"SELECT * FROM favorites
	LEFT JOIN videos ON favorites.vid = videos.vid
	LEFT JOIN users ON users.uid = videos.uid
	WHERE favorites.uid = ? AND videos.converted = 1 AND videos.privacy = 1
	ORDER BY favorites.fid DESC"
);
$favorites_of_you->execute([$session['uid']]);

$videos_of_you = $conn->prepare(
	"SELECT * FROM videos
	LEFT JOIN users ON users.uid = videos.uid
	WHERE videos.uid = ? AND videos.converted = 1 AND videos.privacy = 1
	ORDER BY videos.uploaded DESC"
);
$videos_of_you->execute([$session['uid']]);

if (empty($_GET['user'])) {
    if (isset($_GET['thanks'])){
    alert("Message has been sent.");
    }
    $msgcount = $conn->prepare("SELECT * FROM messages WHERE sender = ? ORDER BY created DESC");
    $msgcount->execute([$session['uid']]);
    $msgcount = $msgcount->rowCount();
    $nocompose = 'yes';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $ppv = 35;
    $offs = ($page - 1) * $ppv;
    $inbox = $conn->prepare("SELECT * FROM messages LEFT JOIN users ON users.uid = messages.receiver WHERE sender = ? ORDER BY created DESC LIMIT $ppv OFFSET $offs");
$inbox->execute([$session['uid']]);
} else {
    $nocompose = 'no';
    $profile = $conn->prepare("SELECT * FROM users WHERE users.username = ?");
    $profile->execute([$_GET['user']]);
    if ($profile->rowCount() == 0) {
        header("Location: outbox.php");
    } else {
        $profile = $profile->fetch(PDO::FETCH_ASSOC);
    }
     if ($session['username'] == $profile['username']) {
        header("Location: my_messages.php");
        die();
     }
     // uh
   if ((isset($_POST['title']) || isset($_POST['comment'])) && strlen($_POST['title']) < 75 && strlen($_POST['comment']) < 50000 && strlen($_POST['title']) > 2 && strlen($_POST['comment']) > 2) {
  $pmid = generateId();
$message = $conn->prepare("INSERT IGNORE INTO messages (pmid, subject, sender, receiver, body) VALUES (:pmid, :subject, :sender, :receiver, :body)");
$message->execute([
	":pmid" => trim($pmid),
	":subject" => encrypt($_POST['title']),
	":sender" => $session['uid'],
    ":receiver" => $profile['uid'],
	":body" => encrypt($_POST['comment'])
]);
header("Location: outbox.php?thanks");
}
}
?>
<div class="pageTitle">Sent Messages</div>
<table width="45%" align="center" cellpadding="5" cellspacing="0" border="0">
         <tr align="center">
		 <td align="center" colspan="3">
                <a href="my_messages.php" >Inbox Messages</a> | <a href="outbox.php" class="bold">Sent Messages</a>
            </td></tr>
            </table>
			
<?php if($nocompose == 'yes') { ?>

<table width="91%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tbody>
	<tr>
		<td><img src="img/box_login_tl.gif" width="5" height="5"></td>
		<td width="100%"><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_tr.gif" width="5" height="5"></td>
	</tr>
	<tr>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
		<td>
		<div class="moduleTitleBar">
		<div class="moduleTitle"><? if($msgcount > 0) { ?><div style="float: right; padding: 1px 5px 0px 0px; font-size: 12px;">Messages <?php if ($offs > 0) { echo htmlspecialchars(trim($offs)); } else { echo "1"; } ?>-<? if($msgcount > $ppv) { $nextynexty = $offs + $ppv; } else {$nextynexty = $msgcount; } echo htmlspecialchars($nextynexty); ?> of <?php echo $inbox->rowCount(); ?></div><? } ?>
		Messages // Outbox
		</div>
		</div>
				
	<table width="100%" cellpadding="3" cellspacing="0" table="table" align="center">
                <tbody><tr><td colspan="5" height="10"></td></tr>
                                <tr>
                        <td width="20">&nbsp;</td>
                        <td><b>Subject</b></td>
                        <td width="20">&nbsp;</td>
                        <td width="70"><b>To<b></b></b></td>
                        <td width="160"><b>Date</b></td>
                </tr>
                <?php if($inbox->rowCount() > 0) {
				foreach($inbox as $message) { ?>
                 <tr bgcolor="<?php if($message['isRead'] == '0') { echo'#FFCC66'; } else { echo '#eeeeee'; } ?>">
                        <td width="5"><img src="/img/mail<?php if($message['isRead'] == '0') { echo'_unread'; } ?>.gif"></td>
                        <td><a href="/out_msg.php?id=<?php echo htmlspecialchars($message['pmid']);?>" <?php if($message['isRead'] == '0') { echo'class=bold'; } ?>><?php echo decrypt($message['subject']); ?></a></td>
                        <td width="20">&nbsp;</td>
						<td><a href="/profile.php?user=<?php echo htmlspecialchars($message['username']);?>"><?php echo htmlspecialchars($message['username']);?></a></td>
                        <td><?php echo retroDate($message['created'], "l, F j, Y"); ?>
                </tr>
                <? } ?>
                <? } ?>
                                                </tbody></table><!-- begin paging -->
				<?php if($msgcount > $ppv) { ?><div style="font-size: 13px; font-weight: bold; color: #444; text-align: right; padding: 5px 0px 5px 0px;">Browse Pages:
				
					<?php
    $totalPages = ceil($msgcount / $ppv);
    if (empty($_GET['page'])) { $_GET['page'] = 1; }
    $pagesPerSet = 10; // Set the number of pages per group
    $startPage = floor(($page - 1) / $pagesPerSet) * $pagesPerSet + 1;
    $endPage = min($startPage + $pagesPerSet - 1, $totalPages); ?>
    <?php if ($startPage < $totalPages && $page !== 1) { ?>
    <a href="outbox.php?page=<?php echo $_GET['page'] - 1; ?>"> < Previous</a>
    <?php } ?>

    <?php 
    
    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $page) {
            echo '<span style="color: #444; background-color: #FFFFFF; padding: 1px 4px 1px 4px; border: 1px solid #999; margin-right: 5px;">' . $i . '</span>';
        } else {
            echo '<span style="background-color: #CCC; padding: 1px 4px 1px 4px; border: 1px solid #999; margin-right: 5px;"><a href="outbox.php?page=' . $i . '">' . $i . '</a></span>';
        }
    }
    ?>
    <!-- Add "Next" link if there are more pages -->
    <?php if ($endPage < $totalPages) { ?>
            <a href="outbox.php?page=<?php echo $_GET['page'] + 1; ?>">Next ></a>
    <?php } ?>
</div>
<?php } ?>
				<!-- end paging -->
		
		</td>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		<td><img src="img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</tbody></table>
<?php } else if($nocompose == 'no') { ?>
<table width="100%" align="center" cellpadding="1" cellspacing="1" border="0" bgcolor="#EEEEEE">
	<tbody>
	<tr>
		
		<td width="100%"><img src="img/pixel.gif" width="1" height="5"> </td>
	</tr>
	<tr>
		
		<td>
				<form method="POST">
	<table width="75%" cellpadding="4" cellspacing="9" table="table" align="center">
                <tbody><tr><td colspan="1" height="10" width="35" align="right"></td></tr>
                                <tr valign="top">
					<td align="right" valign="top"><span class="label">To:</span></td>
					<td><input type="text" size="50" maxlength="75" name="user" value="<?php echo htmlspecialchars($profile['username']); ?>" disabled></td></tr>
                    <tr valign="top">
                </tr>
                <tr valign="top">
					<td align="right" valign="top"><span class="label">Sent:</span></td>
					<td><?php echo retroDate("now", "F j, Y, H:i A"); ?></td>
                </tr>
                <tr valign="top">
					<td align="right" valign="top"><span class="label">Subject:</span></td>
					<td><input type="text" size="50" maxlength="75" name="title" value="<?php if(isset($_GET['subject'])) { echo htmlspecialchars($_GET['subject']); } ?>"></td>
                </tr>
                <tr valign="top">
					<td align="right" valign="top"><span class="label">Message:</span></td>
					<td><textarea maxlength="50000" name="comment" cols="66" rows="6"></textarea></td>
                    
                </tr>
                <tr valign="top">
					<td align="right" valign="top"></td>
					<td><input type="submit" name="message" value="Send Message"></td>
                    
                </tr></form>
                                                </tbody></table>
		
		</td>
		<td><img src="img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		
		<td><img src="img/pixel.gif" width="1" height="5"></td>
		
	</tr>
</tbody></table>
<? } ?>
<br>
<?php require "needed/end.php"; ?>