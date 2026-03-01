<?php
require "admin_head.php";

$staff = $conn->prepare("SELECT * FROM users WHERE users.uid = ? AND staff = 1");
$staff->execute([$_GET['user_id']]);

if($staff->rowCount() == 1) {
    session_error_index("The action of terminating a staff member is forbidden.", "error");
    die();
} else {
    $terminatehim = $conn->prepare("UPDATE users SET termination = 1 WHERE uid = ?");
	$terminatehim->execute([$_GET['user_id']]);
    session_error_index("Terminated!", "error");
}