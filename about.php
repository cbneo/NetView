<?php require "needed/start.php"; ?>
<div class="formTitle">About Us</div>

<div class="pageTable">

<span class="highlight">What is YuoToob?</span>

<br><br>

YuoToob is a way to get your videos to the people who matter to you. With YuoToob you can:

<ul>
<li> Show off your favorite videos to the world
</li><li> Take videos of your dogs, cats, and other pets
</li><li> Blog the videos you take with your digital camera or cell phone
</li><li> Securely and privately show videos to your friends and family around the world
</li><li> ... and much, much more!
</li></ul>

<?php if(empty($_SESSION['uid'])) { ?>
<br><span class="highlight"><a href="signup.php">Sign up now</a> and open a free account.</span>

<br><br><?php } ?><br>

To learn more about our service, please see our <a href="help.php">Help</a> section.<br><br>

Please feel free to <a href="contact.php">contact us</a>.<br><br><br>

</div>

<?php require "needed/end.php"; ?>