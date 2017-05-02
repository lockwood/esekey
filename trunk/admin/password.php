<?php
// +----------------------------------------------------------------------+
// | EDIT  - Esekey Admin Console change password page                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/password.php,v 1.08 2006/24/07
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');

$success = false;
$curpassmessage = '';
$newpassmessage = '';

// build titlebar string and populate any foreign key dropdowns
$edit_title = '[Change Password]';

// check for updated fields
if (isset($_POST['sid'])) { // if form has been submitted
    if (isset($_POST['curpass'])) {
        $curpass = stripslashes($_POST['curpass']);
        $md5pass = md5($curpass);
	    $check = $db_object->query("SELECT user_id,
                                             user_name, 
                                             password,
                                             permissions, 
                                             company_id 
                                        FROM user 
                                       WHERE user_name = '".$_SESSION[$ss]['username']."' AND active_flag = 'Y'");
        $userrow = $check->fetchRow();
        if ($md5pass != stripslashes($userrow['password'])) { // column is updated;
        	$curpassmessage = 'Current Password is incorrect';
        } else {
        	if ($_POST['newpass'] !='' && $_POST['twopass'] !='') {
        		if ($_POST['newpass'] != $_POST['twopass']) {
	        		$newpassmessage = 'Please enter the same new password in both the New Password fields';
        		} else {
        			$newpass = stripslashes($_POST['newpass']);
        			$md5newpass = md5($newpass);
				    $update = $db_object->query("UPDATE user
                                                    SET password = '".$md5newpass."'
      			                                  WHERE user_name = '".$_SESSION[$ss]['username']."' AND active_flag = 'Y'");
      			    $success = true;
        		}
        	} else {
        		$newpassmessage = 'Please enter your new password in both the New Password fields';
        	}
        }
    }
}


?>
<html>
<head>
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//JavaScript Edit Validation Code

//-->
</script>

</head>
<?php
if ($success) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false); alert('Password Successfully Changed')">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">
<form action="password.php" name="frmEdit" id="frmEdit" method="post">
<p style="color:red"><b><?=$curpassmessage?><?=$newpassmessage?>&nbsp;</b></p>
	
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="40%" class="header-left">Current Password</td>
                  <td width="60%" class="alt1"><input type="password" name="curpass" value="<?=$curpass?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                  </td>
                </tr>
                <tr>
                  <td width="40%" class="header-left">New Password</td>
                  <td width="60%" class="alt2"><input type="password" name="newpass" value="<?=$newpass?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                  </td>
                </tr>
                <tr>
                  <td width="40%" class="header-left">New Password Again</td>
                  <td width="60%" class="alt1"><input type="password" name="twopass" value="<?=$twopass?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                  </td>
                </tr>
		</table>

	</td></tr></table>		
	
	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.GoToURL('EseCompany&trade;','My User Profile', 'list.php?view=user&srch1=user_name&op1=EQ&val1=<?=$_SESSION[$ss]['username']?>&');">				
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="submit" name="btnUpdate" value="Update" class="button">
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
</div>

</body>
</html>
<?php
// $Log: edit.php,v $
?>