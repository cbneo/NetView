<?php
require "needed/scripts.php";

if($session['uid'] == NULL) {
    header("Location: login.php?next=". $_SERVER['REQUEST_URI']);
}

if(isset($_GET['next'])) {
    $redirect = $_GET['next'];    
} else {
    $redirect = '/index.php';
}

$opening_date = new DateTime($session['confirm_expire']);
$current_date = new DateTime();

if($session['em_confirmation'] == false) {
    //if($opening_date < $current_date) {
        if($session['confirm_id'] == $_GET['cid']) {
            $confirm_you = $conn->prepare("UPDATE users SET em_confirmation = 'true' WHERE uid = ?");
            $confirm_you->execute([$session['uid']]);
            session_error_index("Your email has been confirmed", "success", $redirect);
        } else {
            session_error_index("This confirmation link is no longer valid. ERROR: 31235", "error");
        }
    //} else {
    //    session_error_index("This confirmation link is no longer valid. ERROR: 56712", "error");
    //} 
} else {
    session_error_index("This confirmation link is no longer valid. ERROR: 43272", "error");    
}