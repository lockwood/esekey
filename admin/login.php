<?php
// +----------------------------------------------------------------------+
// | LOGIN  - Esekey Admin Console Login Page                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/login.php,v 1.02 2004/11/05
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

require ('db_connect.php');
// require our database connection

if (isset($_POST['username'])) { // if form has been submitted
      if (isset ($_POST['password'])) { //password specified on url
          $password = $_POST['password']; 
          unset($_POST['password']);
      }

      $_SESSION[$ss]['error_message'] = null;
	/* check they filled in what they were supposed to and authenticate */
	if(!$_POST['username'] | !$password) {
		$_SESSION[$ss]['error_message'] = 'You did not fill in a required field.';
	} else {

	    // authenticate.

	    if (!get_magic_quotes_gpc()) {
		    $_POST['username'] = addslashes($_POST['username']);
	    }

	    $check = $db_object->query("SELECT user_id,
                                             user_name, 
                                             password,
                                             permissions, 
                                             company_id 
                                        FROM user 
                                       WHERE user_name = '".$_POST['username']."' AND active_flag = 'Y'");
          $info = $check->fetchRow();
	    if ($info == null) {
              $_SESSION[$ss]['error_message'] = 'Incorrect username or password, please try again.';
              $insert_userlog = $db_object->query("INSERT INTO userlog
                                                  VALUES(0,
                                                         now(),
                                                         'fail',
                                                         'bad username', 
                                                         '".$_POST['username']."')");
	    } else {

	        // check passwords match

	        $password = stripslashes($password);
	        $info['password'] = stripslashes($info['password']);
	        $md5password = md5($password); 

	        if ($md5password != $info['password']) {
		      $_SESSION[$ss]['error_message'] = 'Incorrect username or password, please try again.';
	            $insert_userlog = $db_object->query("INSERT INTO userlog
                                                  VALUES($info[user_id],
                                                         now(),
                                                         'fail',
                                                         'bad password', 
                                                         '".$password."')");
              }
	    }
	}
      // additional security to lock out repeated attempts
      $failcount = $db_object->getOne("SELECT COUNT(*)
                                         FROM userlog 
                                        WHERE user_id = '".$info[user_id]."'
                                          AND result = 'fail'
                                          AND userlog_timestamp > date_sub(now(), INTERVAL 1 HOUR)");
      if ($failcount > 3) { // don't allow login - 3 failed attempts within last hour
	    $_SESSION[$ss]['error_message'] = 'Login attempt limit exceeded: username locked.';
      }
      if ($_SESSION[$ss]['error_message'] == null) {
	    // if we get here username and password are correct, 
	    //register session variables and set last login time.

	    $insert_userlog = $db_object->query("INSERT INTO userlog
                                                  VALUES('".$info['user_id']."',
                                                         now(),
                                                         'success',
                                                         'login', 
                                                         '".$_COOKIE['PHPSESSID']."')");

	    $_POST['username'] = stripslashes($_POST['username']);
		$_SESSION[$ss] = array();
	    $_SESSION[$ss]['username'] = $info['user_name'];
	    $_SESSION[$ss]['permissions'] = $info['permissions'];
          $_SESSION[$ss]['company_id'] = $info['company_id'];
          if ($_SESSION[$ss]['company_id'] > 0) { // find company details in DB
              $row = $db_object->getRow("SELECT company_name,
                                                company_telephone,
                                                company_fax,
                                                company_email,
                                                company_code 
                                           FROM company 
                                          WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                            AND active_flag = 'Y'");

              $_SESSION[$ss]['company_code'] = $row['company_code']; 
              $_SESSION[$ss]['company_name'] = $row['company_name']; 
              $_SESSION[$ss]['company_telephone'] = $row['company_telephone'];
              $_SESSION[$ss]['company_fax'] = $row['company_fax'];
              $_SESSION[$ss]['company_email'] = $row['company_email'];
          } else { //company 0 details
              $_SESSION[$ss]['company_code'] = '00000'; 
              $_SESSION[$ss]['company_name'] = 'Esekey Limited'; 
              $_SESSION[$ss]['company_telephone'] = '07860 832741';
              $_SESSION[$ss]['company_fax'] = 'None';
              $_SESSION[$ss]['company_email'] = 'info@esekey.com';
          }
          unset($_SESSION[$ss]['error_message']);
          header("Location: ".$servername."/admin/goto_main.php");
      }
} else {
      $pos = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'); // check if user agent is Internet Explorer
      //if ($pos === false) {
        //  $_SESSION[$ss]['error_message'] = 'WARNING: You are not using Internet Explorer. At the current time, Esekey&trade; Administration only supports Internet Explorer users. Users of other browsers may experience unpredictable results.';
      //} else { 
          $_SESSION[$ss]['error_message'] = null;
      //}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Login Frame</TITLE>
<link href="theme/menu.css" rel="stylesheet" type="text/css">
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

if(window.parent.frames["Menu"].location != window.location)
{
	window.parent.location = 'login_frame.html';
}


function body_onLoad() {

	document.loginform.username.focus();
	
	document.loginform.username.onkeypress = function ()	{
		if (event.keyCode == 13) document.loginform.password.focus();
	}

	document.loginform.password.onkeypress = function () {
		if (event.keyCode == 13) {
			if (CheckLogin()) document.loginform.submit();
		}
	}
	
}


function CheckLogin() {

	var objUsername = document.loginform.username;
	var objPassword = document.loginform.password;
	
	if (objUsername.value == '') {
		alert('Please enter a User Name');
		objUsername.focus();
		return;		
	}
	
	if (objPassword.value == '') {
		alert('Please enter a Password');
		objPassword.focus();
		return;
	}
	
	document.loginform.submit();
}	

//-->
</script>

</HEAD>
<body bgcolor="#CACACC" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onLoad="body_onLoad();">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
      <table border="0" cellspacing="0" cellpadding="1">		
        <form name="loginform" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <tr>
          <td height="23" valign="bottom" class="text"><b>User Name</b></td>
        </tr>
        <tr>
          <td><input type="text" name="username" size="20" maxlength="20" class="input"></td>
        </tr>
        <tr>
          <td height="25" valign="bottom" class="text"><b>Password</b></td>
        </tr>
        <tr>
          <td><input type="password" name="password" size="20" maxlength="20" class="input"></td>
        </tr>
        <tr>
          <td align="right" class="text">
            <b><a class="blanklink" href="javascript:CheckLogin();">Enter</a></b>
            <a class="blanklink" href="javascript:CheckLogin();">
            <img src="images/enter_arrow.gif" alt="" width="11" height="11" border="0"></a>
          </td>
        </tr>
        <tr>
          <td align="right" class="text">&nbsp;</td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>			
        <?php 
        if ($_SESSION[$ss]['error_message'] != null) { ?>
          <tr><td> 
            <p align ="center"><br>
            <b style="color: red"><?php echo $_SESSION[$ss]['error_message'] ?></b></p>
          </td></tr><?php 
        }
        //display session parameters //
        //foreach ($_SESSION as $key => $value) {
        //    echo $key.': '.$value.'<br>';
        //}
        //foreach ($_POST as $key => $value) {
        //    echo $key.': '.$value.'<br>';
        //}
        ?>
</body>
</html>
