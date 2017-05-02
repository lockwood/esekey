<?php
$msg = 'If you do not already have a username and password and you would like to take a look at the EseBooking Administration Console, please take a moment to register your details with us. <br/><br/>Please note that you must provide an email address to which you have access so that we can email your login details to you.';
$errmsg = '';
$checked = '';
if (isset($_POST['submit'])) { // if form has been submitted
	if ($_POST['agree']) {
		// set input field value so that the "agree" checkbox stays checked
		$checked = 'CHECKED';
	}
		
	/* check they filled in what they supposed to, 
	passwords matched, username
	isn't already taken, etc. */
	if (!$_POST['uname'] | !$_POST['name'] | !$_POST['email'] | !$_POST['agree']) {
		$errmsg = 'Please fill in all the fields.';
	} else {
		// check if username exists in database.
	
		if (!get_magic_quotes_gpc()) {
			$_POST['uname'] = addslashes($_POST['uname']);
		}
	
		$name_check = $db_object->query("SELECT user_name FROM user WHERE user_name = '".$_POST['uname']."'");
	
		if (DB::isError($name_check) && $errmsg == '') {
			$errmsg = $name_check->getMessage();
		}
	
		$name_checkk = $name_check->numRows();
	
		if ($name_checkk != 0 && $errmsg == '') {
			$errmsg = 'Sorry, the username: <strong>'.$_POST['uname'].'</strong> is already taken, please pick another one.';
		}
	
		// check e-mail format
	
		if ((!preg_match("/.*@.*..*/", $_POST['email']) | preg_match("/(<|>)/", $_POST['email'])) && $errmsg == '') {
			$errmsg = 'Please enter a valid email address.';
		}
	
		// no HTML tags in username, name, password
	
		$_POST['uname'] = strip_tags($_POST['uname']);
		$_POST['name'] = strip_tags($_POST['name']);
	
		if ($errmsg == '')
		{
			// now we can add them to the database.
			// generate password
			srand(time());
			$cons = "bcdfghjklmnpqrstvwxz";
			$voy = "eaiou";
			$chi = "23456789";
			$spe = "ABCDEFGHJKLMNOTSP";

			$password = substr($cons, rand(0, (strlen($cons) - 1)), 1).substr($voy, rand(0, (strlen($voy) - 1)), 1).substr($cons, rand(0, (strlen($cons) - 1)), 1).substr($voy, rand(0, (strlen($voy) - 1)), 1).substr($spe, rand(0, (strlen($spe) - 1)), 1).substr($chi, rand(0, (strlen($chi) - 1)), 1).substr($chi, rand(0, (strlen($chi) - 1)), 1).substr($cons, rand(0, (strlen($cons) - 1)), 1);
		
			if (!get_magic_quotes_gpc()) {
				$_POST['email'] = addslashes($_POST['email']);
				$_POST['name'] = addslashes($_POST['name']);
			}
		
			$regdate = date('Y-m-d');
			
			$insert = "INSERT INTO user (
					user_name,
					password,
					email,
					company_id,
					given_name,
					permissions,
					active_flag,
					created_date,
					last_modified_by)
					VALUES (
					'".$_POST['uname']."',
					'".md5($password)."',
					'".$_POST['email']."',
					'00008',
					'".$_POST['name']."',
					'NoSite',
					'Y',
					'$regdate',
					'".$_POST['uname']."')";
			$add_member = $db_object->query($insert);
		
			if (DB::isError($add_member)) {
				$errmsg = $add_member->getMessage();
			} else {
				// email details
				/* recipients */
				$to  = $_POST['email'];

				/* subject */
				$subject = "Thank you for registering with AllMyBookings.co.uk";

				$email_top_text = "Dear ".$_POST['name']."\r\n

Thank you for registering with "
.$_SESSION[$ss]['company_name'].$_test.". Your login details are as follows:\r\n";
				$email_body = "

Username: ".$_POST['uname']."\r\n
Password: ".$password."\r\n\r\n
If you need any help with the Administration Console, please call 07860 832741.\r\n
Dave Lockwood\r\n
All My Bookings\r\n
Esekey Limited\r\n";

				$complete_message = $email_top_text.$email_body;
				$headers  = "MIME-Version: 1.0\r\n";
				/* additional headers */
				$headers .= "From: All My Bookings <register@allmybookings.co.uk>\r\n";
				$headers .= "Bcc: dave@esekey.com\r\n";

				/* and now mail it */
			    if (!(@mail($to, $subject, $complete_message, $headers))) { // email sent
			    	$errmsg .= 'Sorry, we were unable to send the email. Please try again.';
					$delete = "DELETE FROM user
					WHERE user_name = 
					'".$_POST['uname']."'";
					$del_member = $db_object->query($delete);
		
			    }
			}
		}
	}
	if ($errmsg == '') {
	?>
	<h4>Registration Successful</h4>
	<p>Thank you. Your information has been added to the database and an email containing your login details has been sent to the address you provided. You may now use the information provided in that email to:</p><p style="text-align:center"><a href="javascript:DoEseAdmin('<?=$servername?>');">Login and access the EseBooking&trade; Administration Console</a><br><br>.</p>
	
	<?php
	
		return;
	}

}

?>
<?=$msg?><br /><br /><br />  
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="0" cellspacing="0" cellpadding="3">
<tr><td colspan="2" align="left">
<h4>I am already registered and would like to login</h4>
</td></tr>
<tr><td colspan="2" align="left">
<input type="button" name="login" value="Login" onClick="DoEseAdmin('<?=$servername?>');">
</td></tr>
<tr><td colspan="2" align="right">
&nbsp;</td></tr>
<tr><td colspan="2" align="left">
<h4>I would like to register now</h4><p style="color:red;"><?=$errmsg?></p>
</td></tr>
<tr><td colspan="2" class="input"><input type="checkbox" name="agree" <?=$checked?> value="1">I agree that I will use this site responsibly at all times. I understand that I will <br />be granted access solely for the purposes of evaluating the EseBooking Services.</td></tr>
<tr><td>Choose A Username:</td><td>
<input type="text" name="uname" maxlength="40" value="<?=$_POST['uname']?>">
</td></tr>
<tr><td>Enter Your Email Address:</td><td>
<input type="text" name="email" maxlength="100" value="<?=$_POST['email']?>">
</td></tr>
<tr><td>Enter Your Full Name:</td><td>
<input type="text" name="name" maxlength="150" value="<?=$_POST['name']?>">
</td></tr>
<tr><td colspan="2" align="left">
<input type="submit" name="submit" value="Register">
</td></tr>
</table>

</form>
