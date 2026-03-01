<?php 
require "needed/start.php";
if (isset($_GET['tags'])) {
    alert("You need at least three keywords!", "error");
}

if (isset($_GET['title'])) {
    alert("Title is too short.", "error");
}

if (isset($_GET['desc'])) {
    alert("Please fill in a description.", "error");
}
?>
<div class="formTitle">Video Upload (Step 1 of 2)</div>
<form method="post" action="my_videos_upload_2.php">
<div class="pageTable">
		<table width="100%" cellpadding="5" cellspacing="0" border="0">
			<input type="hidden" name="field_command" value="upload_video">
			<tbody>
				<tr>
					<td width="200" align="right"><span class="label">Title:</span></td>
					<td><input type="text" size="30" maxlength="60" name="field_upload_title" autocomplete="on"></td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="label">Description:</span></td>
					<td><textarea name="field_upload_description" cols="40" rows="4"></textarea></td>
				</tr>
				<tr>
					<td width="200" align="right"><span class="label">Tags:</span></td>
					<td><input type="text" size="30" maxlength="60" name="field_upload_tags" autocomplete="on"></td>
				</tr>
				<tr align="left">
					<td></td>
					<td><div class="formFieldInfo"><strong>Enter three or more keywords, separated by spaces, describing your video.</strong> <br>It helps to use relevant keywords so others can find your video!<br></div></td>
				</tr>
			</tbody>
		</table>
</div>
<div class="formTitle">Date & Address Details</div>
<div class="pageTable">
		<table width="100%" cellpadding="5" cellspacing="0" border="0">
			<tbody>
				<tr>
					<td width="200" align="right"><span class="label">Date Recorded:</span><br><span class="formFieldInfo">(Optional)</span></td>
					<td><select name="addr_month" tabindex="13">
							<option value="---" selected>---</option>
							<option value="1"> Jan  </option>
							<option value="2"> Feb  </option>
							<option value="3"> Mar  </option>
							<option value="4"> Apr  </option>
							<option value="5"> May  </option>
							<option value="6"> Jun  </option>
							<option value="7"> Jul  </option>
							<option value="8"> Aug  </option>
							<option value="9"> Sep  </option>
							<option value="10"> Oct  </option>
							<option value="11"> Nov  </option>
							<option value="12"> Dec  </option>
						</select>
						<select name="addr_day" tabindex="14">
							<option value="---" selected>---</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
							<option>13</option>
							<option>14</option>
							<option>15</option>
							<option>16</option>
							<option>17</option>
							<option>18</option>
							<option>19</option>
							<option>20</option>
							<option>21</option>
							<option>22</option>
							<option>23</option>
							<option>24</option>
							<option>25</option>
							<option>26</option>
							<option>27</option>
							<option>28</option>
							<option>29</option>
							<option>30</option>
							<option>31</option>
						</select>					
						<select name="addr_yr" tabindex="15">
							<option value="---" selected>---</option>
							<?php
								$selectedYear = date('Y', strtotime($video['recorddate']));
								$years = range(date("Y"), 1900);
								foreach ($years as $year) {
									echo '<option>' . $year . '</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="200" align="right"><span class="label">Address Recorded:</span><br><span class="formFieldInfo">(Optional)</span></td>
					<td><input type="text" size="30" maxlength="160" name="field_upload_address" value="<?php echo htmlspecialchars($video['address']); ?>"></td>
				</tr>
		</table><span style="margin-left: 214px" class="formFieldInfo">Examples: "165 University Ave, Palo Alto, CA" "New York City, NY" "Tokyo"</span>
		<table width="100%" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td width="200" align="right"><span class="label">Country:</span><br><span class="formFieldInfo">(Optional)</span></td>
					<td><?php echo '<select name="field_upload_country" tabindex="5">';
								foreach ($_COUNTRIES as $code => $name) {
									echo '<option ';
									echo ($video['addrcountry'] == $name) ? ' selected' : '';
									echo '>' . $name . '</option>';
								}
								echo '</select>';
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><br></td>
				</tr>
                <tr>
                    <td></td>
                    <td><input type="submit" id="continue" name="continue" value="Continue ->"></td>
                </tr>
		</table>
</div>
</form>

<br>

<?php require "needed/end.php"; ?>