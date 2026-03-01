<?php
require "admin_head.php";

force_login();
$_SITECONF = $conn->prepare('UPDATE yuotoob_web SET maintenance = 0 WHERE version = ?');
$_SITECONF->execute([$version_of_site]);