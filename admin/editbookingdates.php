<?php
// +----------------------------------------------------------------------+
// | EDITBOOKINGDATES  - Esekey Admin Console edit start/end dates        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editbookingdates.php,v 1.00 2006/11/16
//
// TODO remove calendar_events that fall outside the new booking dates
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

$propertyarray = $db_object->getAll("SELECT DISTINCT 
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

// check for updated fields
$inputdata = '';
$success = false;

if ($posted) { // if form has been submitted
	foreach($_POST as $postkey=>$postval)
	{$inputdata .= $postkey.': '.$postval.'<br />';
	}
	if ($_POST['arrival_date'] != $dates['arrival_date'] || $_POST['departure_date'] != $dates['departure_date'])
	{
		// include booking lock to prevent update conflicts with other users
		include('booking_lock.php');
		$inputdata .= 'booking changed.';
		// double check availability before updating
		$error = '';
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
	                                    AND t1.booking_date >= '".$_POST['arrival_date']."'
	                                    AND t1.booking_date < '".$_POST['departure_date']."'
	                                    AND t1.company_id = t2.company_id
	                                    AND t1.resource_id = '".$propertyrow['property_id']."'
	                                    AND t1.booking_reference = t2.booking_reference");
	        foreach ($datearray as $daterow) {
	            if (($daterow['display_status'] != 'E') && ($daterow['booking_reference'] != $viewrow['booking_reference']) && ($error == '')) { //this date is NOT available 
					// set property name preference
					if ($show_property_number)
					{
		                $error.= ltrim($propertyrow['property_number'].' '.$propertyrow['property_name']).' is not available on '.$daterow['booking_day'].'-'.$daterow['booking_month'].'-'.$daterow['booking_year'].'.<br>';
					} else
					{
		                $error.= $propertyrow['property_name'].' is not available on '.$daterow['booking_day'].'-'.$daterow['booking_month'].'-'.$daterow['booking_year'].'.<br>';
					}
	            }
	        }
		}
		if ($error == '')
		{
			//can go ahead and update
			// first create a new booking with the old booking dates and expired status and apply it to calendar_booking
			// then update the current booking with the new booking dates and and apply it to calendar_booking 
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
			foreach ($propertyarray as $propertyrow) {
			    $update_calendar_booking = 
			    "UPDATE calendar_booking".$_SESSION[$ss]['_test']." 
			        SET booking_reference = '".$cancel_ref."',
			            last_modified_on = now(),
			            last_modified_by = '".$_SESSION[$ss]['username']."'
			      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        AND booking_date >= '".$dates['arrival_date']."'
			        AND booking_date < '".$dates['departure_date']."'
				    AND resource_id = '".$propertyrow['property_id']."'";
				//  echo $update_calendar_booking; //
			    $update_member = $db_object->query($update_calendar_booking);
			    if (DB::isError($update_member)) {
			        die($update_member->getMessage());
			    }
			    // reset full clean record if necessary (AW)
				if ($dates['arrival_date'] != $_POST['arrival_date'] && $_SESSION[$ss]['company_id'] == '00009')
				{
					$update_event = "UPDATE calendar_event 
									    SET event_date = '".$_POST['arrival_date']."', 
				  				            last_modified_on = now(),
			        					    last_modified_by = '".$_SESSION[$ss]['username']."'
									  WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND resource_id = '".$propertyrow['property_id']."'
										AND event_date = '".$dates['arrival_date']."'
										AND event_type = 'C'
										AND event_data = 'FC'";
			    	$update_member = $db_object->query($update_event);
			    	if (DB::isError($update_member)) {
			        	die($update_member->getMessage());
			    	}
				}
			}
			// now update the current booking with the new dates
		    $updated_booking = 
		    "UPDATE booking".$_SESSION[$ss]['_test']." 
		        SET arrival_date = '".$_POST['arrival_date']."',
		            departure_date = '".$_POST['departure_date']."',
		            expiry = '".$_POST['departure_date']."',
		            last_modified_on = now(),
		            last_modified_by = '".$_SESSION[$ss]['username']."'
		      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
		        AND booking_reference = '".$viewrow['booking_reference']."'";
			//  echo $updated_booking; //
		    $update_member = $db_object->query($updated_booking);
		    if (DB::isError($update_member)) {
		        die($update_member->getMessage());
		    }
		    // now update the calendar_booking records for the new dates
			foreach ($propertyarray as $propertyrow) {
			    $update_calendar_booking = 
			    "UPDATE calendar_booking".$_SESSION[$ss]['_test']." 
			        SET booking_reference = '".$viewrow['booking_reference']."',
			            last_modified_on = now(),
			            last_modified_by = '".$_SESSION[$ss]['username']."'
			      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        AND booking_date >= '".$_POST['arrival_date']."'
			        AND booking_date < '".$_POST['departure_date']."'
				    AND resource_id = '".$propertyrow['property_id']."'";
				//  echo $update_calendar_booking; //
			    $update_member = $db_object->query($update_calendar_booking);
			    if (DB::isError($update_member)) {
			        die($update_member->getMessage());
			    }
			}
			// write a booking audit record
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
	        // now set the new dates as the current dates
	        $dates['arrival_date'] = $_POST['arrival_date'];
	        $dates['departure_date'] = $_POST['departure_date'];
			$success = true;

		} else
		{
			$inputdata .= $error;
		}
		// last of all include the booking unlock to free the table after preventing conflicts with other users 
		include('booking_unlock.php');
	}
}




foreach ($propertyarray as $propertyrow)
{
	// for each property, get formatted and unformatted dates and daily booking status from day after current arrival until 28 days after current departure
    $departarray[] = $db_object->getAll("SELECT DISTINCT t1.booking_date, 
                                        DATE_FORMAT(t1.booking_date, '%a %D %b %y')AS f_booking_date,
                                        t1.booking_reference,
                                        t2.display_status, 
                                        t2.expiry
                                   FROM calendar_booking AS t1, 
                                        booking AS t2,
                                        property AS t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$dates['arrival_date']."'
                                    AND t1.booking_date < date_add('".$dates['departure_date']."', interval 28 day)
                                    AND t1.company_id = t2.company_id
                                    AND t1.resource_id = t3.property_id
                                    AND t1.resource_id = '".$propertyrow['property_id']."'
                                    AND t1.booking_reference = t2.booking_reference");
}

$departlist = array();
// build an array of departure date options for each property 
for ($i=0;$i<count($departarray);$i++)
{
	$departlist_complete = false;
	$j=0;
	while (!$departlist_complete)
	{
		if ($departarray[$i][$j]['booking_reference'] == $viewrow['booking_reference'])
		{
			if ($departarray[$i][$j+1]['booking_date'] >= $date_today)
			{
				$departlist[$i][$departarray[$i][$j+1]['booking_date']] = $departarray[$i][$j+1]['f_booking_date'];
			}
		} elseif ($departarray[$i][$j]['display_status'] == 'E')
		{
			$departlist[$i][$departarray[$i][$j+1]['booking_date']] = $departarray[$i][$j+1]['f_booking_date'];
		} else
		{
			$departlist_complete = true;
		}
		$j++;
		if ($j == count($departarray[$i])-1) $departlist_complete = true; 
	}
}
$departoptions = array();
$departvalues = array();
// choose the property with least availability
for ($i=0;$i<count($departarray);$i++)
{
	if (count($departoptions) == 0)
	{
		$departoptions = array_values($departlist[$i]);
		$departvalues = array_keys($departlist[$i]);
	} else
	{
		if (count($departlist[$i]) < count($departoptions))
		{
			// use the list with the least number of available dates
			$departoptions = array_values($departlist[$i]);
			$departvalues = array_keys($departlist[$i]);
		}
	}
}


if ($dates['arrival_date'] < $date_today)
{
	// this booking has already started, so the arrival date cannot be changed
	// just get the current arrival date to put in the dropdown...
	foreach ($propertyarray as $propertyrow)
	{
	    $arrivearray[] = $db_object->getAll("SELECT DISTINCT t1.booking_date, 
	                                        DATE_FORMAT(t1.booking_date, '%a %D %b %y')AS f_booking_date,
	                                        t1.booking_reference,
	                                        t2.display_status, 
	                                        t2.expiry
	                                   FROM calendar_booking AS t1, 
	                                        booking AS t2,
	                                        property AS t3
	                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
	                                    AND t1.booking_date = '".$dates['arrival_date']."'
	                                    AND t1.company_id = t2.company_id
	                                    AND t1.resource_id = t3.property_id
	                                    AND t1.resource_id = '".$propertyrow['property_id']."'
	                                    AND t1.booking_reference = t2.booking_reference");
	}
} else
{
	foreach ($propertyarray as $propertyrow)
	{
		// for each property, get formatted and unformatted dates and daily booking status from day 28 days before arrival until day before current departure
	    $arrivearray[] = $db_object->getAll("SELECT DISTINCT t1.booking_date, 
	                                        DATE_FORMAT(t1.booking_date, '%a %D %b %y')AS f_booking_date,
	                                        t1.booking_reference,
	                                        t2.display_status, 
	                                        t2.expiry
	                                   FROM calendar_booking AS t1, 
	                                        booking AS t2,
	                                        property AS t3
	                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
	                                    AND t1.booking_date >= date_sub('".$dates['arrival_date']."', interval 28 day)
	                                    AND t1.booking_date < '".$dates['departure_date']."'
	                                    AND t1.company_id = t2.company_id
	                                    AND t1.resource_id = t3.property_id
	                                    AND t1.resource_id = '".$propertyrow['property_id']."'
	                                    AND t1.booking_reference = t2.booking_reference");
	}
}
$arrivelist = array();
// build an array of arrival date options for each property 
for ($i=0;$i<count($arrivearray);$i++)
{
	$arrivelist_complete = false;
	$j=count($arrivearray[$i]);
	while (!$arrivelist_complete)
	{
		$j--;
		if ($arrivearray[$i][$j]['booking_date'] < $date_today) 
		{
			if ($arrivearray[$i][$j]['booking_date'] == $dates['arrival_date'])
			{
				$arrivelist[$i][$arrivearray[$i][$j]['booking_date']] = $arrivearray[$i][$j]['f_booking_date'];
				$arrivelist_complete = true;
			}
		} elseif ($arrivearray[$i][$j]['booking_reference'] == $viewrow['booking_reference'])
		{
			$arrivelist[$i][$arrivearray[$i][$j]['booking_date']] = $arrivearray[$i][$j]['f_booking_date'];
		} elseif ($arrivearray[$i][$j]['display_status'] == 'E')
		{
			$arrivelist[$i][$arrivearray[$i][$j]['booking_date']] = $arrivearray[$i][$j]['f_booking_date'];
		} else
		{
			$arrivelist_complete = true;
		}
		if ($j == 0) $arrivelist_complete = true; 
	}
}
$arriveoptions = array();
$arrivevalues = array();
// choose the property with least availability
for ($i=0;$i<count($arrivearray);$i++)
{
	if (count($arriveoptions) == 0)
	{
		$arriveoptions = array_values($arrivelist[$i]);
		$arrivevalues = array_keys($arrivelist[$i]);
	} else
	{
		if (count($arrivelist[$i]) < count($arriveoptions))
		{
			// use the list with the least number of available dates
			$arriveoptions = array_values($arrivelist[$i]);
			$arrivevalues = array_keys($arrivelist[$i]);
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
                  <?=$label[9]?>
                </td>
                <td width="80%" class="alt1">
                  <?=$viewrow[$column[9]]?>
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
                  <?=$label[14]?>
                </td>
                <td width="80%" class="alt2">
              <SELECT NAME="<?=$column[14]?>" style="font-size: 8pt" onFocus="ChangeMade();">
              <?php
              for ($j=count($arriveoptions)-1; $j>-1; $j--) {
                if ($arrivevalues[$j] == $dates['arrival_date']) { ?>
              <OPTION VALUE="<?=$arrivevalues[$j]?>" SELECTED><?=$arriveoptions[$j]?></OPTION><?php
                } else { ?>
              <OPTION VALUE="<?=$arrivevalues[$j]?>"><?=$arriveoptions[$j]?></OPTION><?php
                }
              } ?>
              </SELECT></td>
              </tr>
              <tr>
                <td width="20%" class="header-left">
                  <?=$label[15]?>
                </td>
                <td width="80%" class="alt1">
              <SELECT NAME="<?=$column[15]?>" style="font-size: 8pt" onFocus="ChangeMade();">
              <?php
              for ($j=0; $j<count($departoptions); $j++) {
                if ($departvalues[$j] == $dates['departure_date']) { ?>
              <OPTION VALUE="<?=$departvalues[$j]?>" SELECTED><?=$departoptions[$j]?></OPTION><?php
                } else { ?>
              <OPTION VALUE="<?=$departvalues[$j]?>"><?=$departoptions[$j]?></OPTION><?php
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