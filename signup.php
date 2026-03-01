<?php 
require "needed/start.php";

if($_SESSION['uid'] != NULL) {
	header("Location: index.php");
}
// Define variables and initialize with empty values
$captcha = generateId();
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = $captcha_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("SELECT uid FROM users WHERE ip = :address");
    $stmt->execute([
        ':address' => $_SERVER['REMOTE_ADDR']
    ]);
    if($stmt->rowCount() > 15){
        $username_err = "Sorry, you have too many accounts.";
    }
    // Validate username
    if(empty(trim($_POST["field_signup_username"]))) {
        $username_err = "Please enter a username.";
    } else if(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["field_signup_username"]))) {
        $username_err = "Sorry, that user name contains special characters.";
    } else if (strlen(trim($_POST["field_signup_username"])) > 20) {
		$username_err = "Sorry, that user name is too long.";
    } else {
        // Prepare a select statement and bind variables to the prepared statement as parameters
        $param_username = trim($_POST["field_signup_username"]);
        $stmt = $conn->prepare("SELECT uid FROM users WHERE username = :username");
        $stmt->execute([
            ':username' => $param_username,
        ]);
        if($stmt->rowCount() > 0){
            $username_err = "Sorry, that user name has already been taken.";
        }
    }
    // if (isset($_POST["field_signup_username"]) && stripos($_POST["field_signup_username"], "yuotoob") !== false) {
    //        $username_err = 'Sorry, a user name can not contain the word "yuotoob".';
    // }
    // Validate password
    if(empty(trim($_POST["field_signup_password_1"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["field_signup_password_1"])) < 3) {
        $password_err = "Your password is too short.";
    } else{
        $password = trim($_POST["field_signup_password_1"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["field_signup_password_2"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["field_signup_password_2"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Your passwords didn't match; try retyping them.";
        }
    }
	
	// Validate email
    if (substr($_POST['field_signup_email'], -strlen($sitedomain)) === $sitedomain) {
		$email_err = "Sorry, this email is invalid.";
    }
	if(empty(trim($_POST['field_signup_email']))) {
		$email_err = "Please enter an email.";
	} elseif(!filter_var(trim($_POST['field_signup_email']), FILTER_VALIDATE_EMAIL)) {
		$email_err = "Sorry, this email is invalid.";
	} else {
		$param_email = trim($_POST['field_signup_email']);
		
		// Prepare a select statement and bind variables to the prepared statement as parameters
		$email_in_use = $conn->prepare("SELECT uid FROM users WHERE email = ?");
		$email_in_use->execute([$param_email]);
		if($email_in_use->rowCount() > 0) {
			$email_err = "Sorry, somebody is already using this e mail.";
		}
	}
    $emailValidator = new \enricodias\EmailValidator\EmailValidator();
    $validate = $emailValidator->validate($param_email);
    if ($validate) {
    if ($emailValidator->isDisposable()) {
       $email_err = "Sorry, somebody is already using this e mail.";
    }
    } else {
		$email_err = "Sorry, somebody is already using this e mail.";
    }
    
    // Validate captcha
    if($_POST['field_signup_captcha'] != $_SESSION['captcha']) {
        $captcha_err = "Incorrect or expired CAPTCHA answer.";  
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($captcha_err)){ 
		// Set parameters
        $param_id = generateId();
		$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

		$stmt = $conn->prepare("INSERT IGNORE INTO users (uid, username, password, email) VALUES (:uid, :username, :password, :email)");
		$stmt->execute([
            ':uid' => $param_id,
			':username' => $param_username,
			':password' => $param_password,
			':email' => $param_email
		]);
        $_SESSION['uid'] = $param_id;
		// Redirect to the intended page
        $location = "/index.php";

        if(!empty($_POST['v'])) {
        $location = '/watch.php?v='.$_POST['v'];
        }
        
        redirect($location);
    }
}

if(!empty($username_err) || !empty($password_err) || !empty($confirm_password_err) || !empty($email_err) || !empty($captcha_err)) { 
	if(!empty($username_err)) { alert(htmlspecialchars($username_err), "error"); }
	if(!empty($password_err)) { alert(htmlspecialchars($password_err), "error"); }
	if(!empty($confirm_password_err)) { alert(htmlspecialchars($confirm_password_err), "error"); }
	if(!empty($email_err)) { alert(htmlspecialchars($email_err), "error"); }
	if(!empty($captcha_err)) { alert(htmlspecialchars($captcha_err), "error"); }
}
?>	
<div class="formTitle">Sign Up</div>

<div class="formTable">
					
		<div class="formIntro">Please enter your account information below. All fields are required.</div>

			<table width="720" cellpadding="5" cellspacing="0" border="0">
			<form method="post" action="signup.php">
			<? if(!empty($_GET['v']) && !empty($_GET['r'])) { ?><input type="hidden" name="v" value="<? echo htmlspecialchars($_GET['v']); ?>"><? } ?>
			<input type="hidden" name="field_command" value="signup_submit">
			<input type="hidden" name="captcha" value="<?php echo $captcha; ?>">
				<tbody><tr>
					<td width="200" align="right"><span class="label">Email Address:</span></td>
					<td><input type="text" size="30" maxlength="60" name="field_signup_email" value=""></td>
				</tr>
				<tr>
					<td align="right"><span class="label">User Name:</span></td>
					<td><input type="text" size="20" maxlength="20" name="field_signup_username" value=""></td>
				</tr>
				<tr>
					<td align="right"><span class="label">Password:</span></td>
					<td><input type="password" size="20" maxlength="20" name="field_signup_password_1" value=""></td>
				</tr>
				<tr>
					<td align="right"><span class="label">Retype Password:</span></td>
					<td><input type="password" size="20" maxlength="20" name="field_signup_password_2" value=""></td>
				</tr>
				<tr>
					<td align="right"><span class="label">CAPTCHA:</span></td>
					<td><a href="#" onclick="document.verificationImg.src='cimg.php?c=<?php echo $captcha; ?>&amp;'+Math.random();return false"><img name="verificationImg" src="cimg.php?c=<?php echo $captcha; ?>" border="0" align="texttop"></a><br><br><input type="text" size="20" maxlength="20" name="field_signup_captcha" value=""></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><br>- I certify I am over 12 years old.
					<br>- I agree to the <a href="terms.php" target="_blank">terms of use</a> and <a href="privacy.php" target="_blank">privacy policy</a>.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="Sign Up"></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><br>Or, <a href="index.php">return to the homepage</a>.</td>
				</tr>
			</tbody></table>
		</div>
<br></form>

<?php require "needed/end.php"; ?>