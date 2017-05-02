<?php
// +----------------------------------------------------------------------+
// | EDITEMAIL  - Esekey Admin Console edit/send email                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editemail.php,v 1.03 2006/11/23
//
// check for updated email address on customer table
$latest_email = $db_object->getOne("SELECT b.email
									  FROM booking as a,
									       customer as b
									 WHERE a.booking_reference = '".$valuearray[0]."'
									   AND a.company_id = '".$_SESSION[$ss]['company_id']."' 
									   AND b.company_id = '".$_SESSION[$ss]['company_id']."' 
									   AND a.contact_id = b.customer_id");
if (!$posted && $latest_email != $viewrow[$column[7]] && $viewrow['sent_flag'] == 'N') {
	$field_changed = true;
	$send_disabled = true;
}

// check for updated fields
if ($posted) { // if form has been submitted
  for ($i = 0; $i < count($column); $i++) {
    if (isset($_POST[$column[$i]])) {
        $formfield[$i] = stripslashes($_POST[$column[$i]]);
        if (mysql_real_escape_string($formfield[$i]) != $viewrow[$column[$i]]) { // column is updated;
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " SET ".$column[$i]." = '".mysql_real_escape_string($formfield[$i])."'"; 
            } else {
                $setparms .= ", ".$column[$i]." = '".mysql_real_escape_string($formfield[$i])."'"; 
            }
        }
    } else {
        if (($type[$i] == 'C') && ($viewrow[$column[$i]] == 'Y')) { // checkbox has been unset
            $formfield[$i] = 'N';
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " SET ".$column[$i]." = '".$formfield[$i]."'"; 
            } else {
                $setparms .= ", ".$column[$i]." = '".$formfield[$i]."'"; 
            }
        } else { // field unchanged; set formfield value to database value
            $formfield[$i] = $viewrow[$column[$i]];
        }
    }
  }
  if ($viewrow['sent_flag'] == '0')
  {
		// this is an insert request not an update
		$insert = "INSERT INTO email".$_SESSION[$ss]['_test']." 
		               VALUES ('".$_SESSION[$ss]['company_id']."',
		                       '".$viewrow['booking_reference']."',
		                       0, 
		                       '".$viewrow['email_type']."', 
		                       '".$_POST['email_subject']."', 
		                       '".$viewrow['email_top']."', 
		                       '".$_POST['email_top_text']."', 
		                       '".$viewrow['email_body']."', 
		                       '".$_POST['email_tail_text']."', 
		                       '".$viewrow['email_tail']."', 
		                       '".$_POST['email_to']."',
		                       '".$viewrow['email_headers']."', 
		                       'N',
		                       now(),
		                       '".$_SESSION[$ss]['username']."', 
		                       null)";
		//  echo $insert; //
		$add_member = $db_object->query($insert);
		if (DB::isError($add_member)) {
		    die($add_member->getMessage());
		} else {
		    $msgtext = '\nNew General Email saved';
		}
		// insert successful so switch from newemail to email 
		$view_name = 'email';
        $success = true;
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
		$viewrow['created_date'] = $db_object->getOne("SELECT CURDATE()");
        $viewrow['last_modified_on'] = $db_object->getOne("SELECT now()");
        $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
  } elseif ($field_changed == true) 
  {
        $setparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'";
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."'"; 
        for ($i = 0; $i < count($column); $i++) {
            if ($unique[$i] == 'Y') { // this is a key field
                $whereparms .= " AND ".$column[$i]." = '".$viewrow[$column[$i]]."'";
            }
        }
        //echo "UPDATE  ".$view_name.$_SESSION[$ss]['_test'].$setparms.$whereparms;
        $update_table = $db_object->query(
                     "UPDATE  ".$view_name.$_SESSION[$ss]['_test'].$setparms.$whereparms); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
        $success = true;
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
        $viewrow['last_modified_on'] = $db_object->getOne("SELECT now()");
        $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
  }

}
$_SESSION[$ss]['email_sent'] = false; // set flag that sendemail uses to ensure that an email is sent only once

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
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false); alert('Record Successfully Updated<?=$msgtext?>')">
<?php
} elseif ($emailmsg) { // display email result message 
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="top.Top.SetChangedFlag(false); alert('<?=$msgtext?>');">
<?php
} elseif ($view_name == 'newemail') { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(true);">
<?php
} elseif (!$field_changed) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false);">
<?php
} elseif ($send_disabled) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(true);">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">
<form action="edit.php" name="frmEdit" id="frmEdit" method="post">
	
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[0].' / '.$label[1].' / '.$label[2]?>
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[0]].' / '.$viewrow[$column[1]].' / '.$viewrow[$column[2]]?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[7]?>
                </td>
                <td width="80%" class="alt2">
                <?php
                if ($viewrow['sent_flag'] == 'Y') {
                  if ($latest_email != $viewrow[$column[7]])
                  {
                  	// email address has changed on customer table since this email was sent
                  	echo $latest_email.' [latest supplied email address]';
                    echo '<br /><span style="color:red">'.$viewrow[$column[7]].'</span> [previously used email address]';
                  } else 
                  {
                    echo $viewrow[$column[7]];
                  }
                } else { 
                  if ($latest_email != $viewrow[$column[7]])
                  {
                  	$display_email = $latest_email;
                  } else
                  {
                  	$display_email = $viewrow[$column[7]];
                  }
                	?>
                  <input type="text" name="<?=$column[7]?>" value="<?=$display_email?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                <?php
                } ?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[3]?>
                </td>
                <td width="80%" class="alt1">
                <?php
                if ($viewrow['sent_flag'] == 'Y') {
                  echo $viewrow[$column[3]];
                } else { ?>
                  <input type="text" name="<?=$column[3]?>" value="<?=$viewrow[$column[3]]?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                <?php
                } ?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[4]?>
                </td>
                <td width="80%" class="alt2">
                <?php
                if ($viewrow['sent_flag'] == 'Y') {
                  echo nl2br($viewrow[$column[4]]);
                } else { ?>
                  <textarea name="<?=$column[4]?>" cols="80" rows="6" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[4]]?></textarea> 
                <?php
                } ?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[5]?>
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[5]]?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[6]?>
                </td>
                <td width="80%" class="alt2">
                <?php
                if ($viewrow['sent_flag'] == 'Y') {
                  echo nl2br($viewrow[$column[6]]);
                } else { ?>
                  <textarea name="<?=$column[6]?>" cols="80" rows="8" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[6]]?></textarea> 
                <?php
                } ?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  Created / Mod / User
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[9]].' / '.$viewrow[$column[10]].' / '.$viewrow[$column[11]]?>
                </td>
              </tr>
		</table>

	</td></tr></table>		
	
	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button"
                         onClick="top.Top.BackToURL('');">
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
                <?php 
                if ($viewrow['sent_flag'] == 'Y' && $latest_email != $viewrow[$column[7]])
                  { ?>
				<input type="hidden" name="btnUpdate" value="Confirm" class="button">
				<input type="button" name="btnSend1" value="Send to latest(<?=$latest_email?>)" class="button-cust"
                         onClick="top.Top.SendEmail('edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&send=Y&newemail=Y&sid=<?=$sid?>');">
             </td>
          </tr>
          <tr>
			<td height="33" valign="bottom" nowrap>&nbsp;
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnSend" value="Resend to previous (<?=$viewrow[$column[7]]?>)" class="button-cust"
                         onClick="top.Top.SendEmail('edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&send=Y&sid=<?=$sid?>');">
             </td>
          </tr>
          <tr>
			<td height="33" valign="bottom" nowrap>&nbsp;
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
                <?php
                  } else
                  { ?>
				<input type="submit" name="btnUpdate" value="Confirm" class="button">
				<input type="button" name="btnSend" value="Send" class="button"
                         onClick="top.Top.SendEmail('edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&send=Y&sid=<?=$sid?>');">
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
                <?php
                  } ?>
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="key" value="<?=$key?>">
      <input type="hidden" name="value" value="<?=$value?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
</div>

</body>
</html>