<?php 
require_once __DIR__ . '/start.php';

force_login();

if(!isset($session['staff']) || $session['staff'] != 1) {
	redirect("Location: /index.php"); 
    exit;
}

$inbox = $conn->prepare("SELECT * FROM messages WHERE receiver = ? AND isRead = 0 ORDER BY created DESC");
$inbox->execute([$session['uid']]);
$inbox = $inbox->rowCount();
?>
<div class="pageTitle">ManagerToob</div>

<table align="center" cellspacing="0">
<tbody><tr style="border-radius: 10px 10px 0px 0px;">
	<td style="background: #D5E5F5; font-weight: bold; padding: 9px; text-align: center; border-radius: 4px 0px 0px 0px;"><?= retroDate("now", "l") ?></td>
	<td style="background: #D5E5F5; font-weight: bold; padding: 9px; text-align: center;"><?= retroDate("now", "F j, Y") ?></td>
	<td style="background: #D5E5F5; font-weight: bold; padding: 9px; text-align: center; border-radius: 0px 4px 0px 0px;"><?= retroDate("now", "h:i:s") ?> <?= retroDate("now", 'I') ? 'PDT' : 'PST'; ?></td>
</tr>
<tr>
	<td style="width: 113px;height: 44px;background: #eeeedd; font-size: 20px; font-weight: bold; padding: 1px 12px;text-align: center; border: 1px dashed #666633; border-left: none;"><a style="text-decoration: none;" href="/admin/index.php">Home</a></td>
	<td style="width: 113px;height: 44px;background: #eeeedd; font-size: 20px; font-weight: bold; padding: 1px 12px;text-align: center; border: 1px dashed #666633; border-left: none;"><a style="text-decoration: none;" href="/admin/tickets.php">Support</a></td>
	<td style="width: 113px;height: 44px;background: #eeeedd; font-size: 20px; font-weight: bold; padding: 1px 12px;text-align: center; border: 1px dashed #666633; border-left: none;"><a style="text-decoration: none;" href="https://discord.gg/jJpA3BcVaq">Discord</a></td>
</tr>
</tbody></table>

<br>
