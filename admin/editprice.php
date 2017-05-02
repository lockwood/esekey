<?php
// +----------------------------------------------------------------------+
// | EDITPRICE  - Esekey Admin Console edit/prices in one                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editprice.php,v 1.00 2007/03/05
//
// retrieve additional price data for editing
$price_array = $db_object->getAll("SELECT *
									  FROM price
									 WHERE price_code = '".$valuearray[0]."'
									   AND company_id = '".$_SESSION[$ss]['company_id']."'");
$i = 0;
if (count($price_array) > 6)
{
	// only display the two most recent groups of 3 prices
	$i = count($price_array) - 6;
}
$date_today = $db_object->getOne("SELECT CURDATE()");
$next_date = '';
if (isset($price_array[$i+3]['start_date']))
{
	if ($price_array[$i+3]['start_date'] > $date_today) {
		// last set of rates are in the future, so show both sets of rates
		$next_date = substr($price_array[$i+3]['start_date'],8,2).'-'.substr($price_array[$i+3]['start_date'],5,2).'-'.substr($price_array[$i+3]['start_date'],0,4);
	} else
	{
		// last set of rates is the most recent, but not a future set, so only show these rates.
		$i = $i+3;
	}
}
$current_date = substr($price_array[$i]['start_date'],8,2).'-'.substr($price_array[$i]['start_date'],5,2).'-'.substr($price_array[$i]['start_date'],0,4);

$success = false;
$errormsg1 = '';
$errormsg2 = '';
$errormsg3 = '';
$errormsg4 = '';
$errormsg5 = '';
$errormsg6 = '';
$errormsg7 = '';
$query1 = '';
$query2 = '';
$query3 = '';
$query4 = '';
$query5 = '';
$query6 = '';
$query7 = '';
// check for updated fields
if ($posted) { // if form has been submitted
	$errors = false;
    if (is_numeric($_POST['weekly_rate_1']) && is_integer($_POST['weekly_rate_1']+0)) {
        if ($_POST['weekly_rate_1'] != $price_array[$i]['weekly_rate']) { // column is updated;
			$field_changed = true;
        	$query1 = "UPDATE price
						  SET weekly_rate = ".$_POST['weekly_rate_1'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i]['start_date']."'
						  AND max_nights = ".$price_array[$i]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
        }
    } else {
    	$errors = true;
    	$errormsg1 = 'Not a valid amount';
  	}
  	$price_array[$i]['weekly_rate'] = $_POST['weekly_rate_1'];
  	if (is_integer($_POST['weekly_rate_2']+0)) {
        if ($_POST['weekly_rate_2'] != $price_array[$i+1]['weekly_rate']) { // column is updated;
			$field_changed = true;
        	$query2 = "UPDATE price
						  SET weekly_rate = ".$_POST['weekly_rate_2'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+1]['start_date']."'
						  AND max_nights = ".$price_array[$i+1]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
        }
    } else {
    	$errors = true;
    	$errormsg2 = 'Not a valid amount';
  	}
  	$price_array[$i+1]['weekly_rate'] = $_POST['weekly_rate_2'];
  	if (is_integer($_POST['weekly_rate_3']+0)) {
        if ($_POST['weekly_rate_3'] != $price_array[$i+2]['weekly_rate']) { // column is updated;
			$field_changed = true;
        	$query3 = "UPDATE price
						  SET weekly_rate = ".$_POST['weekly_rate_3'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+2]['start_date']."'
						  AND max_nights = ".$price_array[$i+2]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
        }
    } else {
    	$errors = true;
    	$errormsg3 = 'Not a valid amount';
  	}
  	$price_array[$i+2]['weekly_rate'] = $_POST['weekly_rate_3'];
  	
  	// check for new set of prices being added for this code or updated future prices
  	if ($_POST['sd'] != '')
  	{
  		// TODO validate date in case user has keyed it in instead of using javascript popup
		$update = true;
  		if ($_POST['sd'] != $next_date) {
  			$insert_date = substr($_POST['sd'],6,4).'-'.substr($_POST['sd'],3,2).'-'.substr($_POST['sd'],0,2);
			$update = false;
			$field_changed = true;
			if ($next_date != '') {
        		$query7 = "DELETE FROM price
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+3]['start_date']."'
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
			}
  		}
	    if (is_numeric($_POST['next_weekly_rate_1']) && is_integer($_POST['next_weekly_rate_1']+0)) {
    	    if ($_POST['next_weekly_rate_1'] != $price_array[$i+3]['weekly_rate']) { // column is updated;
				$field_changed = true;
				if ($update) {
        			$query4 = "UPDATE price
						  SET weekly_rate = ".$_POST['next_weekly_rate_1'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+3]['start_date']."'
						  AND max_nights = ".$price_array[$i+3]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
				}
        	}
        	if (!$update) {
					// need to insert, even if rate has not changed, because date has changed
        			$query4 = "INSERT INTO price (`company_id`,
												  `price_code`,
												  `start_date`,
												  `max_nights`,
												  `cumulative`,
												  `weekly_rate`,
												  `daily_rate`,
												  `created_date`,
												  `last_modified_by`,
												  `last_modified_on`)
						       VALUES ('".$_SESSION[$ss]['company_id']."',
									   '".$valuearray[0]."',
									   '".$insert_date."',
									   ".$price_array[$i]['max_nights'].",
									   'N',
									   ".$_POST['next_weekly_rate_1'].",
									   0,
									   now(),
									   '".$_SESSION[$ss]['username']."',
									   now())";
        	}
    	} else {
    		$errors = true;
    		$errormsg5 = 'Not a valid amount';
  		}
	    if (is_numeric($_POST['next_weekly_rate_2']) && is_integer($_POST['next_weekly_rate_2']+0)) {
    	    if ($_POST['next_weekly_rate_2'] != $price_array[$i+4]['weekly_rate']) { // column is updated;
				$field_changed = true;
				if ($update) {
        			$query5 = "UPDATE price
						  SET weekly_rate = ".$_POST['next_weekly_rate_2'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+4]['start_date']."'
						  AND max_nights = ".$price_array[$i+4]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
				}
        	}
        	if (!$update) {
					// need to insert, even if rate has not changed, because date has changed
        			$query5 = "INSERT INTO price (`company_id`,
												  `price_code`,
												  `start_date`,
												  `max_nights`,
												  `cumulative`,
												  `weekly_rate`,
												  `daily_rate`,
												  `created_date`,
												  `last_modified_by`,
												  `last_modified_on`)
						       VALUES ('".$_SESSION[$ss]['company_id']."',
									   '".$valuearray[0]."',
									   '".$insert_date."',
									   ".$price_array[$i+1]['max_nights'].",
									   'N',
									   ".$_POST['next_weekly_rate_2'].",
									   0,
									   now(),
									   '".$_SESSION[$ss]['username']."',
									   now())";
        	}
    	} else {
    		$errors = true;
    		$errormsg6 = 'Not a valid amount';
  		}
	    if (is_numeric($_POST['next_weekly_rate_3']) && is_integer($_POST['next_weekly_rate_3']+0)) {
    	    if ($_POST['next_weekly_rate_3'] != $price_array[$i+5]['weekly_rate']) { // column is updated;
				$field_changed = true;
				if ($update) {
        			$query6 = "UPDATE price
						  SET weekly_rate = ".$_POST['next_weekly_rate_3'].",
							  last_modified_on = now(), 
							  last_modified_by = '".$_SESSION[$ss]['username']."' 
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+5]['start_date']."'
						  AND max_nights = ".$price_array[$i+5]['max_nights']."
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
				}
        	}
        	if (!$update) {
					// need to insert, even if rate has not changed, because date has changed
        			$query6 = "INSERT INTO price (`company_id`,
												  `price_code`,
												  `start_date`,
												  `max_nights`,
												  `cumulative`,
												  `weekly_rate`,
												  `daily_rate`,
												  `created_date`,
												  `last_modified_by`,
												  `last_modified_on`)
						       VALUES ('".$_SESSION[$ss]['company_id']."',
									   '".$valuearray[0]."',
									   '".$insert_date."',
									   ".$price_array[$i+2]['max_nights'].",
									   'N',
									   ".$_POST['next_weekly_rate_3'].",
									   0,
									   now(),
									   '".$_SESSION[$ss]['username']."',
									   now())";
        	}
    	} else {
    		$errors = true;
    		$errormsg7 = 'Not a valid amount';
  		}
  	} else
  	{
  		// no future data should be present as there is no date
  		if ($_POST['next_weekly_rate_1'] != '' || $_POST['next_weekly_rate_2'] != '' || $_POST['next_weekly_rate_3'] != '')
  		{
  			$errors = true;
    		$errormsg4 = 'Please specify a date';
  		} else
  		{
  			// no values for future date - delete records if they existed
  			if (isset($price_array[$i+3]['start_date']))
  			{
				$field_changed = true;
        		$query7 = "DELETE FROM price
						WHERE price_code = '".$valuearray[0]."'
						  AND start_date = '".$price_array[$i+3]['start_date']."'
						  AND company_id = '".$_SESSION[$ss]['company_id']."'";
  			}
  		}
  	}
  	$next_date = $_POST['sd'];
  	$price_array[$i+3]['weekly_rate'] = $_POST['next_weekly_rate_1'];
  	$price_array[$i+4]['weekly_rate'] = $_POST['next_weekly_rate_2'];
  	$price_array[$i+5]['weekly_rate'] = $_POST['next_weekly_rate_3'];
  	
  	if ($field_changed == true && $errors == false) 
  	{
        // echo $query1.$query2.$query3.$query4.$query5.$query6.$query7;
  		if ($query1 != '')
        {
        	$update_table = $db_object->query($query1);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query2 != '')
        {
        	$update_table = $db_object->query($query2);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query3 != '')
        {
        	$update_table = $db_object->query($query3);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query4 != '')
        {
        	$update_table = $db_object->query($query4);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query5 != '')
        {
        	$update_table = $db_object->query($query5);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query6 != '')
        {
        	$update_table = $db_object->query($query6);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
        if ($query7 != '')
        {
        	$update_table = $db_object->query($query7);
        	if (DB::isError($update_table)) {
        	    die($update_table->getMessage());
        	}
        	$success = true;
        }
  	}
}

?>
<html>
<head>
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<script language="JavaScript" src="js/calendar1.js"></script><!-- Date only with year scrolling -->
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
} elseif (!$field_changed) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false);">
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
                  <?=$label[0]?> <?=$viewrow[$column[0]]?>
                </td>
                <td width="40%" class="alt1">
                  Current
                </td>
                <td width="40%" class="alt1">
                  Next
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  Valid From
                </td>
                <td width="40%" class="alt1">
                  <?=$current_date?>
                </td>
                <td width="40%" class="alt1">
                  <input type="Text" class="input" name="sd" value="<?=$next_date?>" onFocus="ChangeMade();"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click here to select a date"></a>&nbsp;<span style="color:red;"><?=$errormsg4?></span>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  1-3 Wks
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="weekly_rate_1" value="<?=$price_array[$i]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg1?></span>
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="next_weekly_rate_1" value="<?=$price_array[$i+3]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg5?></span>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  4-11 Wks
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="weekly_rate_2" value="<?=$price_array[$i+1]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg2?></span>
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="next_weekly_rate_2" value="<?=$price_array[$i+4]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg6?></span>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  12+ Wks
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="weekly_rate_3" value="<?=$price_array[$i+2]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg3?></span>
                </td>
                <td width="40%" class="alt2">
                  <input type="text" name="next_weekly_rate_3" value="<?=$price_array[$i+5]['weekly_rate']?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">&nbsp;<span style="color:red;"><?=$errormsg7?></span>
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
				<input type="submit" name="btnUpdate" value="Update" class="button">
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
 			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="key" value="<?=$key?>">
      <input type="hidden" name="value" value="<?=$value?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
	<script language="JavaScript">
	<!-- // create calendar object(s) just after form tag closed
		 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
		 // note: you can have as many calendar objects as you need for your application
		var cal1 = new calendar1(document.forms['frmEdit'].elements['sd']);
		cal1.year_scroll = true;
		cal1.time_comp = false;
	//-->
	</script>
</div>

</body>
</html>