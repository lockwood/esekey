<?php
// +----------------------------------------------------------------------+
// | EDITBOOKINGPROPERTY  - Esekey Admin Console change property on booking |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editbookingproperty.php,v 1.00 2006/11/20
//
// TODO delete calendar events for each property to be removed from a booking
// set display status on recently expired bookings to show available dates
$update_expired_bookings = $db_object->query("UPDATE booking".$_SESSION[$ss]['_test']." 
                                                 SET display_status = 'E',
                                                     last_modified_on = now()
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                                 AND display_status != 'E'
                                                 AND expiry < now()");
if (DB::isError($update_expired_bookings)) {
    die($update_expired_bookings->getMessage());
}
$date_today = $db_object->getOne("SELECT CURDATE()");

// get current arrival and departure dates for this booking
$dates = $db_object->getRow("SELECT arrival_date,
									departure_date
							   FROM booking".$_SESSION[$ss]['_test']."
							  WHERE booking_reference = '".$viewrow['booking_reference']."'
							  	AND company_id = '".$_SESSION[$ss]['company_id']."'");

$currentpropertyarray = $db_object->getAll("SELECT DISTINCT 
                                         t3.property_id,
                                         t3.property_number,
                                         t3.property_name
                                    FROM booking".$_SESSION[$ss]['_test']." AS t1,
                                         calendar_booking".$_SESSION[$ss]['_test']." AS t2,
                                         property AS t3
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.booking_reference = t2.booking_reference
                                     AND t2.resource_id = t3.property_id
                                     AND t1.booking_reference = '".$viewrow['booking_reference']."'");
$current_properties = array();
foreach ($currentpropertyarray as $currentpropertyrow)
{
	$current_properties[$currentpropertyrow['property_id']] = $currentpropertyrow['property_name'];
}
$date_today = $db_object->getOne("SELECT CURDATE()");
// get list of all properties
$propertyarray = $db_object->getAll("SELECT 
                                         property_id,
                                         property_number,
                                         property_name
                                    FROM property
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND active_flag = 'Y'
                                   ORDER BY ".$property_order); 
// check for available properties with same booking dates
// to determine whether to show the change property button
$all_properties = array();
$available_properties = array();
foreach ($propertyarray as $propertyrow){
    $datearray = $db_object->getAll("SELECT t1.day_of_week, 
                                    DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                    DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                    DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                    t1.booking_reference,
                                    t2.display_status, 
                                    t2.expiry
                               FROM calendar_booking".$_SESSION[$ss]['_test']." AS t1, 
                                    booking".$_SESSION[$ss]['_test']." AS t2
                              WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                AND t1.booking_date >= '".$viewrow['test_arrive']."'
                                AND t1.booking_date < '".$viewrow['test_depart']."'
                                AND t1.company_id = t2.company_id
                                AND t1.resource_id = '".$propertyrow['property_id']."'
                                AND t1.booking_reference = t2.booking_reference");
   	$available = true;
    foreach ($datearray as $daterow) {
    	if ($daterow['booking_reference'] != $viewrow['booking_reference'])
    	{
        	if (($daterow['display_status'] != 'E')) { //this date is NOT available 
            	$available = false;
        	}
        }
    }
	if ($show_property_number)
	{
        $fullname = ltrim($propertyrow['property_number'].' '.$propertyrow['property_name']);
	} else
	{
        $fullname = $propertyrow['property_name'];
	}
    if ($available)
    {
    	$available_properties[$propertyrow['property_id']] = $fullname;
    }
   	$all_properties[$propertyrow['property_id']] = $fullname;
}

// check for updated fields
$error = '';
$success = false;
$selected_properties = array();

if ($posted) { // if form has been submitted
	foreach($_POST as $postkey=>$postval)
	{
		if (!is_array($postval))
		{
			$error .= $postkey.': '.$postval.'<br />';
		} else
		{
			foreach ($postval as $k=>$v)
			{
				$error .= $postkey.'['.$k.']: '.$v.'<br />';
			}
		}
	}
	if (!isset($_POST['properties']))
	{
		$error = 'You must select at least one property.';
	} else
	{
		foreach ($_POST['properties'] as $property_id)
		{
			$selected_properties[$property_id] = $all_properties[$property_id];
		}
	}
	if ($current_properties != $selected_properties)
	{
		$error .= 'Selected properties changed.<br />';
		// include booking lock to prevent update conflicts with other users
		include('booking_lock.php');
		$inputdata .= 'booking changed.';
		// double check availability before updating
		$error = '';
		foreach ($selected_properties as $property_id=>$property_name){
	        $datearray = $db_object->getAll("SELECT t1.day_of_week, 
	                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
	                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
	                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
	                                        t1.booking_reference,
	                                        t2.display_status, 
	                                        t2.expiry
	                                   FROM calendar_booking".$_SESSION[$ss]['_test']." AS t1, 
	                                        booking".$_SESSION[$ss]['_test']." AS t2
	                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
	                                    AND t1.booking_date >= '".$dates['arrival_date']."'
	                                    AND t1.booking_date < '".$dates['departure_date']."'
	                                    AND t1.company_id = t2.company_id
	                                    AND t1.resource_id = '".$property_id."'
	                                    AND t1.booking_reference = t2.booking_reference");
	        foreach ($datearray as $daterow) {
	            if (($daterow['display_status'] != 'E') && ($daterow['booking_reference'] != $viewrow['booking_reference']) && ($error == '')) { //this date is NOT available 
	                $error.= $property_name.' is not available on '.$daterow['booking_day'].'-'.$daterow['booking_month'].'-'.$daterow['booking_year'].'.<br>';
	            }
	        }
		}
		if ($error == '')
		{
			//can go ahead and update
			// first create a new booking with the old properties and expired status and apply it to calendar_booking
			// then update the calendar_booking records for the new properties 
			// then insert an additional booking_audit record 

			$insert = "INSERT INTO booking 
			           VALUES ('".$_SESSION[$ss]['company_id']."',
			                   0, 
			                   1, 
			                   '".$dates['arrival_date']."', 
			                   '".$dates['departure_date']."', 
		                       0, 
		                       0, 
		                       0, 
		                       0, 
		                       0, 
		                       now(),
		                       now(),
		                       'E', 
		                       'D',
		                       '', 
							   '',
		                       '".$_SESSION[$ss]['username']."', 
			                   null,
							   null)";
			//      echo $insert; //
			$add_member = $db_object->query($insert);
			if (DB::isError($add_member)) {
			    die($add_member->getMessage());
			}
			// return booking_reference  //
			$cancel_ref = mysql_insert_id();  
			// put booking_reference and confirmation data on session  //
			foreach ($current_properties as $property_id=>$property_name) {
			    $update_calendar_booking = 
			    "UPDATE calendar_booking".$_SESSION[$ss]['_test']." 
			        SET booking_reference = '".$cancel_ref."',
			            last_modified_on = now(),
			            last_modified_by = '".$_SESSION[$ss]['username']."'
			      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        AND booking_date >= '".$dates['arrival_date']."'
			        AND booking_date < '".$dates['departure_date']."'
				    AND resource_id = '".$property_id."'";
				//  echo $update_calendar_booking; //
			    $update_member = $db_object->query($update_calendar_booking);
			    if (DB::isError($update_member)) {
			        die($update_member->getMessage());
			    }
			    if ($_SESSION[$ss]['company_id'] == '00009')
			    {
			    	// delete cleaning rota event record
					$delete_event = "DELETE from calendar_event 
									  WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND resource_id = '".$property_id."'
										AND event_date = '".$dates['arrival_date']."'
										AND event_type = 'C'
										AND event_data = 'FC'";
			   		$delete_member = $db_object->query($delete_event);
			   		if (DB::isError($delete_member)) {
			       		die($delete_member->getMessage());
			   		}
			    }
			}
		    // now update the calendar_booking records for the new properties
			foreach ($selected_properties as $property_id=>$property_name) {
			    $update_calendar_booking = 
			    "UPDATE calendar_booking".$_SESSION[$ss]['_test']." 
			        SET booking_reference = '".$viewrow['booking_reference']."',
			            last_modified_on = now(),
			            last_modified_by = '".$_SESSION[$ss]['username']."'
			      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        AND booking_date >= '".$dates['arrival_date']."'
			        AND booking_date < '".$dates['departure_date']."'
				    AND resource_id = '".$property_id."'";
				//  echo $update_calendar_booking; //
			    $update_member = $db_object->query($update_calendar_booking);
			    if (DB::isError($update_member)) {
			        die($update_member->getMessage());
			    }
			    if ($_SESSION[$ss]['company_id'] == '00009')
			    {
			    	// add Full Clean event record for start of booking (AW)
					$insert = "INSERT INTO calendar_event 
        		   	VALUES ('".$_SESSION[$ss]['company_id']."',
                   			'".$property_id."',
				   			'".$dates['arrival_date']."', 
                   			'C', 
                   			'FC',
                   			'".$_SESSION[$ss]['username']."', 
                   			null)";
					// echo $insert; //
					$add_member = $db_object->query($insert);
					if (DB::isError($add_member)) {
    					die($add_member->getMessage());
					}
			    }
			}
			// write a booking audit record
			// FIXME audit record doesn't contain property!!!
	        $insert = "INSERT into booking_audit SELECT 
                                         t1.company_id,
                                         t1.booking_reference,
                                         0,
                                         t1.arrival_date,
                                         t1.departure_date,
                                         t1.number_adults,
                                         t1.number_children,
                                         t1.number_infants,
                                         t1.contact_id,
                                         t1.guest_id,
                                         t1.display_status,
                                         t1.booking_status,
                                         t2.deposit_amount,
                                         t2.balance_amount,
                                         '".$_SESSION[$ss]['username']."',
                                         now()
                                    FROM booking AS t1,
                                         payment AS t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.booking_reference = '".$viewrow['booking_reference']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.booking_reference = t2.booking_reference";
	        $add_member = $db_object->query($insert);
	        if (DB::isError($add_member)) {
	            die($add_member->getMessage());
	        }
	        // now set the new properties as the current properties
	        $current_properties = $selected_properties;
			$success = true;
		}
		// last of all include the booking unlock to free the table after preventing conflicts with other users 
		include('booking_unlock.php');
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
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false); alert('Record Successfully Updated')">
<?php
} elseif ($emailmsg) { // display email result message 
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="top.Top.SetChangedFlag(false); alert('<?=$msgtext?>');">
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
                  <?=$label[14]?>
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[14]]?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[15]?>
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[15]]?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  Name
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[2]]." ".$viewrow[$column[3]]." ".$viewrow[$column[4]]?>
                </td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[9]?>
                </td>
                <td width="80%" class="alt2">
              <SELECT MULTIPLE NAME="properties[]" size="<?=min(30,count($available_properties))?>" style="font-size: 8pt" onFocus="ChangeMade();">
              <?php
              foreach($available_properties as $property_id=>$property_name) {
                if (isset($current_properties[$property_id])) { ?>
              <OPTION VALUE="<?=$property_id?>" SELECTED><?=$property_name?></OPTION><?php
                } else { ?>
              <OPTION VALUE="<?=$property_id?>"><?=$property_name?></OPTION><?php
                }
              } ?>
              </SELECT></td>
              </tr>
              <?php
              if ($error != '')
              {
              ?>
              <tr>
                <td width="20%" class="header-left">
                  Error
                </td>
                <td width="80%" class="alt1"><span style="color: red; font-weight:bold;">
                  <?=$error?>
                </td>
              </tr>
              <?php
              } ?>
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
</div>

</body>
</html>