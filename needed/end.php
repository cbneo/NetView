<table bgcolor="#FFFFFF" align="center" cellpadding="10" border="0">
	<tbody><tr>
		<td align="center" valign="center"><span class="footer"><a href="about.php">About Us</a> | <a href="help.php">Help</a> | <a href="terms.php">Terms of Use</a> | <a href="privacy.php">Privacy Policy</a> | Copyright &copy; <?php echo date("Y"); ?> OldVid, LLC&#8482; | <a href="rss/global/recently_added.rss"><img src="<?php echo $siteurl; ?>/img/rss.gif" width="36" height="14" border="0" style="vertical-align: text-top;"></a></span></td>
	</tr>
</tbody></table>
<? $ads_show = rand(0, 100);
 if($ads_show > 30) {
if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') { ?>
<br>
<center>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2537513323123758"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:800px;height:150px"
     data-ad-client="ca-pub-2537513323123758"
     data-ad-slot="5657657371"
     ></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</center>
<? } } ?>