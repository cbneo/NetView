<?php
require "needed/start.php";
if($session['staff'] == 1 && isset($_POST['field_qa'])) {
  $sql = "INSERT INTO questions_and_answers (question, answer) VALUES (:question, :answer)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":question", $_POST['field_qa']);
  $stmt->bindParam(":answer", $_POST['field_qa_answer']);
  
  try {
    $stmt->execute();
    $posted = 1;
  } catch (PDOException $e) {
    alert("Failed to submit.", "error");
    exit;
  }
}

$stmt = $conn->query("SELECT * FROM questions_and_answers ORDER BY id ASC");
$rowCount = $stmt->rowCount(); 

if(isset($_GET['flash'])) {
    if($_GET["flash"] == 1) {
    	setcookie("flash", true, 2147483647);
		alert("Videos will now be displayed in the Macromedia Flash Player.");
    } 
    if($_GET["flash"] == 0) {
    	setcookie("flash", "", time()-3600);
		alert("Videos will now be displayed in the HTML5 Video Player.");
    }
}

if($posted == 1) {
    alert("Question Answered!");
}
?>
<div class="pageTitle">Help</div>

<div class="pageTable">

<span class="highlight">Q: I have an old computer, how do i enable the Flash video player?</span>

<br><br>A: Click <a href="help.php?flash=<?php if($_GET['flash'] == 1 || isset($_COOKIE['flash'])) { ?>0<? } else { ?>1<? } ?>">here</a> to turn <?php if($_GET['flash'] == 0 || isset($_COOKIE['flash'])) { ?>on<? } else { ?>off<? } ?> the Flash video player.

<br><br><span class="highlight">Q: What kind of videos can I upload?</span>

<br><br>A: You may upload any kind of personal video that you'd like to share with the world. We don't allow any nudity and your video must be appropriate for all audiences. 
<br>
<br>
However, this still leaves a lot of room for creativity!! Do you own a <a href="results.php?search=dog">dog</a> or a <a href="results.php?search=cat">cat</a>? Have you gone on vacationing in <a href="results.php?search=mexico">Mexico</a>? Do you live in <a href="results.php?search=netherlands">The Netherlands</a>?
<br>
<br>
These are just some examples of the videos that our users are uploading. In the end, you know yourself best. What would <i>you</i> like to capture on video?

<br><br><span class="highlight">Q: How long can my video be?</span>

<br><br>A: There is no time limit on your video, but the video file you upload must be less than 100 MB in size.

<br><br><span class="highlight">Q: What video file formats can I upload?</span>

<br><br>A: YuoToob accepts video files from most digital cameras and from cell phones in the .AVI, .MOV, and .MPG file formats.

<br><br><span class="highlight">Q: How can I improve my videos?</span>

<br><br>A: We encourage you to edit your videos with software such as <a href="https://web.archive.org/web/20050715234755/http://www.microsoft.com/windowsxp/using/moviemaker/default.mspx" target="_blank">Windows MovieMaker</a> (included with every Windows installation), or <a href="https://web.archive.org/web/20050715234755/http://www.apple.com/ilife/imovie/" target="_blank">Apple iMovie</a>. Using these programs you can easily edit
your videos, add soundtracks, etc.

<br><br><span class="highlight">Q: How do I link to my YuoToob videos from my homepage?</span>

<br><br>A: Any video you upload to YuoToob is still <b>your</b> video. We want to enable YuoToob users to link to their videos in every way possible. By placing a small snippet of HTML code in your webpage, you can pull up a list of all your YuoToob videos in a neat, little window. Take a look at the example below, on the left is the HTML snippet you would copy+paste into your webpage. As a result, a small box with your videos will be rendered as shown on the right.
<br>
<br>

	<table width="100%">
	<tbody><tr>
		<td valign="top" align="center">
			<span class="highlight">HTML Snippet (iframe version)</span>
			<br>
			<br>
			<textarea cols="65" rows="8" id="snippet_iframe" wrap="soft">&lt;iframe id="videos_list" name="videos_list" src="http://www.<?php echo $sitedomain; ?>/videos_list.php?user=YOUR_USERNAME" scrolling="auto" width="265" height="400" frameborder="0" marginheight="0" marginwidth="0"&gt;
&lt;/iframe&gt;</textarea>
			<br>
			<!--
			<br/>
			<span class="highlight">HTML Snippet (embed version)</span>
			<br/>
			<br/>
			<textarea cols="65" rows="8" id="snippet_embed" wrap="soft"><embed src="http://www.<?php echo $sitedomain; ?>/videos_list.php?user=YOUR_USERNAME" scrolling="auto" width="265" height="400" frameborder="0" marginheight="0" marginwidth="0"></textarea>
			<br/>
			-->
		</td>
		<td valign="top" align="center">
			<span class="highlight">What Shows Up</span>
			<br>
			<br>
			<iframe id="videos_list" name="videos_list" src="videos_list_sample.html" scrolling="auto" width="265" height="400" frameborder="0" marginheight="0" marginwidth="0">
			</iframe>
		</td>
	</tr>
</tbody></table>

<?php
	// Loop through the results and display each post
	$currentRow = 1; // Variable to keep track of the current row
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$question = $row['question'];
        $answer = $row['answer'];
?>
<br><br><span class="highlight">Q: <?php echo $question; ?></span>

<br><br>A: <?php echo $answer; ?>
<? } ?>

<br><br><br><span class="highlight">Contact YuoToob</span>
<br><br>If you have any account or video issues, please contact us <a href="contact.php">here</a>.
Also, if you have any ideas or suggestions to make our service better, please don't hesitate to drop us a line.
						
<?php if($session['staff'] == 1) { ?>
   <br><br><br>
   <div class="pageTable">
    <table width="100%" cellpadding="5" cellspacing="0" border="0">
	<form method="post">
	<tbody>
    <td width="200" align="right"><span class="highlight">Help Answer The Community!</span></td>
    <tr>
		<td width="200" align="right"><span class="label">Q:</span></td>
		<td><input type="text" size="30" maxlength="350" name="field_qa" placeholder="How long can my video be?"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><span class="label">A:</span></td>
		<td><textarea name="field_qa_answer" cols="40" rows="4" placeholder="There is no time limit on your video, but the video file you upload must be less than 100 MB in size."></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Answer Now"></td>
	</tr>
    </form>
</tbody></table>

</div>
    </div>
<?php } ?>	

</div>

<br>

<?php require "needed/end.php"; ?>