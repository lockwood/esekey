<?php 
// +----------------------------------------------------------------------+
// | VIEW_WEEKLY  - Calculate and Layout Weekly Availability              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/view_weekly.php,v 1.02 2005/07/20
//
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$monthnumarray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');
$daynamearray = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat','Sun','Mon');
$_SESSION[$ss]['selecteddate'] = $year.'-'.$month.'-'.$day; // set current date in session
$_SESSION[$ss]['prevsatdate'] = $prevsatyear.'-'.$prevsatmonth.'-'.$prevsatday; // set previous Saturday date in session
// set display status on recently expired bookings to show available dates
$update_expired_bookings = $db_object->query("UPDATE booking".$_test." 
                                                 SET display_status = 'E',
                                                     last_modified_on = now()
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                                 AND display_status != 'E'
                                                 AND expiry < now()");
if (DB::isError($update_expired_bookings)) {
    die($update_expired_bookings->getMessage());
}

//read from table where date > start date and date < start date + 98 days (>3 months) 
//if records not found, insert new ones up to end date for selected period using mysql date_add (interval) function. 
$masterquery = "SELECT t1.resource_id,
                       t1.day_of_week,
                       t1.booking_date, 
                       DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                       DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                       DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                       t1.booking_reference, 
                       t1.day_of_week, 
                       t2.display_status, 
                       t2.expiry,
                       t2.contact_id,
                       t2.guest_id,
                       t3.price_code,
                       t3.booking_pattern,
                       t3.property_number, 
                       t3.property_name,
                       t3.sleeps,
					   t4.area
                  FROM calendar_booking".$_test." AS t1, 
                       booking".$_test." AS t2,
                       property AS t3,
					   location AS t4 
                 WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                   AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                   AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 98 day)
                   AND t1.company_id = t2.company_id
                   AND t3.company_id = t2.company_id
                   AND t4.company_id = t2.company_id
                   AND t3.property_id = t1.resource_id
				   AND t3.active_flag = 'Y'
				   AND t3.postcode = t4.postcode
                   AND t1.booking_reference = t2.booking_reference
                   		".$select_property."
                 ORDER BY t3.property_name,
                          t3.property_number,
                          booking_year,
                          booking_month,
                          booking_day";

$datearray = $db_object->getAll($masterquery);

$eventquery = "SELECT  resource_id,
					   event_date,
					   event_type,
					   event_data
                  FROM calendar_event 
                 WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                   AND event_date >= '".$_SESSION[$ss]['selecteddate']."'
                   AND event_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 98 day)
                 ORDER BY resource_id,
                          event_date,
                          event_type";


$eventresults = $db_object->getAll($eventquery);
$eventarray = array();
foreach ($eventresults as $eventrow) {
	$eventarray[$eventrow['resource_id']][$eventrow['event_date']][$eventrow['event_type']] = $eventrow['event_data'];
}

// echo 'Date Count: '.count($datearray).'<br><br>';
 
if ($select_property == '') {
    $property_count = count($resourcearray);
} else {
    $property_count = 1;
} 
// echo 'Prop Count: '.$property_count.'<br><br>';
//	print_r($datearray);

if (count($datearray) < ($property_count*98)) { // need to add some dates
	//echo count($datearray)."<".($property_count*98);
    $number_inserted = 0;
    // insert from prev sat with interval 6 more than interval used in masterquery - this covers all variations of
    // todays date versus prev sat date. 
    $insert = "INSERT INTO booking
                VALUES ('".$_SESSION[$ss]['company_id']."',
                        0, 
	                    1, 
                        '".$_SESSION[$ss]['prevsatdate']."', 
                        date_add('".$_SESSION[$ss]['prevsatdate']."', interval 104 day), 
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
    $add_member = $db_object->query($insert);

    if (DB::isError($add_member)) {
        die($add_member->getMessage());
    }
    // return booking_reference  //
    $booking_reference = mysql_insert_id();  
    // echo 'Booking Ref: '.$booking_reference.'<br><br>';
    foreach ($resourcearray as $propertyrow) {
        $dow = 6; // set day of week to Saturday
        for ($i = 0; $i <= 105; $i++) {
            $insert = "INSERT INTO calendar_booking 
                        VALUES ('".$_SESSION[$ss]['company_id']."',
                                '".$propertyrow['property_id']."', 
                                date_add('".$_SESSION[$ss]['prevsatdate']."', interval '".$i."' day), 
                                '".$dow."', 
                                '".$booking_reference."', 
                                '".$_SESSION[$ss]['username']."', 
                                null)";
            $add_member = $db_object->query($insert);
            if (!DB::isError($add_member)) {
                $number_inserted++;
            }
            $dow++;
            if ($dow > 6) { // day of week starts at Sunday = 0 thru Saturday = 6
                $dow = 0;
            }
        }
    }
    //print_r($add_member);
    //echo 'Rows Inserted: '.$number_inserted.'<br><br>';
    $datearray = $db_object->getAll($masterquery);
    //echo 'New Date Count: '.count($datearray).'<br><br>';
 
}
// compatibility issue MYSQL 4.0 and 4.1 - add 0 to timestamp to return number rather than string
$last_updated = $db_object->getOne("SELECT MAX(last_modified_on + 0)
                                      FROM booking".$_test."
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'");

// Format start dates for display //
$j = 0 + $todaymonth; // $j is integer index for montharray - cannot have leading zero
$display_nav[] = $montharray[$j].' '.$todayyear;
$nav[] = $_SESSION[$ss]['todaydate'];
for ($k = 1; $k <= 11; $k++) {
    $j++;
    if ($j > 12) {
        $todayyear++;
        $j = 1;
    }
    $display_nav[$k] = $montharray[$j].' '.$todayyear;
    $nav[$k] = $todayyear.'-'.$monthnumarray[$j].'-01';
}
$c_year = $datearray[0]['booking_year'];
$c_month = $datearray[0]['booking_month'];
$c_name = '';
if ($datearray[0]['property_number'] != ''){
	$c_name = $datearray[0]['property_number']." ";
}
$c_name .= $datearray[0]['property_name'];
$i = 0;
if (isset($popup) && $popup == 1) {
	$popup_string = '<input type="hidden" name="popup" value="1" />'; 
} else {
	$popup_string = ""; 
}

if ($ss == 'User') {
?>
<form action="<?=$_SERVER[PHP_SELF]?>" name="frmAvail" id="frmAvail" method="get">
  <table width="100%">
   <tr>
    <td valign="top" nowrap><b>From: 
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 11; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
              <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php
  }
} ?>
    </SELECT><?=$popup_string?></b>
   </td>
   <td valign="top" width="10%" align="right"><b>Key:<b></td>
   <td>
    <table>
     <tr><td width="22" class="E" nowrap>&nbsp;</td><td class="fill" nowrap>Available</td></tr>
     <tr><td class="P" nowrap>&nbsp;</td><td class="fill" nowrap>Provisionally Booked</td></tr>
     <tr><td class="C" nowrap>&nbsp;</td><td class="fill" nowrap>Booked</td></tr>
    </table>
   </td>
   <td>&nbsp;</td>
  </tr>
 </table>
</form>
<?php
} else {
?>
<form action="admin_availability.php" name="frmAdAvail" id="frmAdAvail" method="get">
For 3 month period beginning (Select from list) &nbsp;
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 11; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
              <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php
  }
} ?>
    </SELECT>
	<input type="hidden" name="sid" value="<?=$sid?>" />
</form>
<br>
<?php
}
?>
<table>
  <tr>
    <td>
    <div>
    <table border="0">
      <tr>
        <td class="awpropfill" valign="middle" nowrap>&nbsp;<br />&nbsp;</td>
     </tr>
    </table>
    </div>
    </td>
    <td>
    <div id="static_top">
    <table>
      <tr><?php 
$next_name = '';
if ($datearray[$i]['property_number'] != ''){
	$next_name = $datearray[$i]['property_number']." ";
}
$next_name .= $datearray[$i]['property_name'];
while ($next_name == $c_name) {
    if (($i < 98)) { ?><td class="awday-center" nowrap><?=$daynamearray[$datearray[$i]['day_of_week']]?><br /><?=$datearray[$i]['booking_day']?>/<?=$c_month?></td>
          <?php
    }
    $i++;
	$next_name = '';
	if ($datearray[$i]['property_number'] != ''){
		$next_name = $datearray[$i]['property_number']." ";
	}
	$next_name .= $datearray[$i]['property_name'];
    if (($datearray[$i]['booking_month'] != $c_month) && ($next_name == $c_name)) { // change of month
        $c_month = $datearray[$i]['booking_month'];
        $monthcol++;
    }
}

echo '</tr>
	</table>
	</div></td>
  </tr>
</table>
<table>
  <tr>
    <td style="vertical-align:top;">
	<div id="static_left">
    <table style="vertical-align:top;">';
$c_year = $datearray[0]['booking_year'];
$c_month = $datearray[0]['booking_month'];
$c_name = '';
if ($datearray[0]['property_number'] != ''){
	$c_name = $datearray[0]['property_number']." ";
}
$c_name .= $datearray[0]['property_name'];
$i=0; 
$row = 1;
$propertyrows = '';
$calendarrows = '';
$bookings = array();
$invoices = array();
$payments = array();
$cleanings = array();
$b_cols = 0;
$i_cols = 0;
$p_cols = 0;
$c_cols = 0;
$b_stat = '';
$i_stat = '';
$p_stat = '';
$c_stat = '';
while ($i < count($datearray)) {
	$propertyrows .= '
	  <tr>
    	<td class="property_top" colspan="2" nowrap>'.$c_name.'</td>
	  </tr>
	  <tr>
    	<td class="property_left" nowrap><span style="width:95px;overflow:hidden;">'.$datearray[$i]['area'].'</span><br/>Sleeps&nbsp;'.$datearray[$i]['sleeps'].'<br/>&nbsp;</td>
		<td class="property_right" nowrap><span style="height:15px;">Inv Customer</span><br/>Paid LL<br/>Cleaning Req</td>
	  </tr>';
	$next_name = '';
	if ($datearray[$i]['property_number'] != ''){
		$next_name = $datearray[$i]['property_number']." ";
	}
	$next_name .= $datearray[$i]['property_name'];
	$bookings[$row] = '
      <tr>';
	$invoices[$row] = '
      <tr>';
	$payments[$row] = '
      <tr>';
	$cleanings[$row] = '
      <tr>';
	while ($next_name == $c_name) {
        if ($i < (98 * $row)) {
        	if ($datearray[$i]['display_status'] != $b_stat) {
        		$b_stat = $datearray[$i]['display_status'];
        		if ($b_cols > 0) {
            		if (($datearray[$i-1]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
						$tenant_name = '';
            			if ($datearray[$i-1]['guest_id'] > 0) {
							$tenant_name = $db_object->getOne("SELECT last_name from customer WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND customer_id = '".$datearray[$i-1]['guest_id']."'");
						} else {
							$tenant_name = $db_object->getOne("SELECT last_name from customer WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND customer_id = '".$datearray[$i-1]['contact_id']."'");
						}
            			$bookings[$row] .= 'colspan="'.$b_cols.'" onMouseOver="doHover(this);return window.status=&#039;EseBooking&trade; &amp;gt; Selected Booking&#039;;" onMouseOut="noHover(this);return window.status=&#039;&#039;;" onClick="top.Top.GoToURL(&#039;1&#039;, &#039;Edit Booking [Ref='.$datearray[$i-1]['booking_reference'].']&#039;, &#039;edit.php?view=booking_view&key=booking_reference&value='.$datearray[$i-1]['booking_reference'].'&&#039;);" nowrap><span style="width:'.(($b_cols*64)-5).'px;overflow:hidden;text-align:left;padding-left:5px">'.$datearray[$i-1]['booking_reference'].'&nbsp;'.$tenant_name.'</span></td>';
            		} else {
                		$bookings[$row] .= 'colspan="'.$b_cols.'" nowrap>&nbsp;</td>';
            		}
        		}
				$b_cols = 0;
				if ($b_stat == 'E') {
					$bookings[$row] .= '<td class="awB" ';
				} else {
					$bookings[$row] .= '<td class="aw'.$b_stat.'" ';
				}
        	}
        	$b_cols++;
        	$celltext = '&nbsp;';
        	if (isset($eventarray[$datearray[$i]['resource_id']][$datearray[$i]['booking_date']]['I'])) {
        		// invoice reminder is set - show the invoice number
				$celltext = $eventarray[$datearray[$i]['resource_id']][$datearray[$i]['booking_date']]['I'];
        	}
        	$celltext1 = '&nbsp;';
        	if (isset($eventarray[$datearray[$i]['resource_id']][$datearray[$i]['booking_date']]['C'])) {
        		// weekly clean is set - show it
				$celltext1 = '<span class="cell" style="background-color:orange;">'.$eventarray[$datearray[$i]['resource_id']][$datearray[$i]['booking_date']]['C'].'</span>';
        	}
        	if ($datearray[$i]['display_status'] != 'E') {
				$invoices[$row] .= '<td class="aw'.$datearray[$i]['display_status'].'" onMouseOver="doHover(this);" onMouseOut="noHover(this);" onClick="invSet(&#039;'.$datearray[$i]['booking_date'].'&#039;)"><span class="cell">'.$celltext.'</span><br/>&nbsp;<br/>'.$celltext1.'</td>';
        	} else {
				$invoices[$row] .= '<td class="awE"><span class="cell">'.$celltext.'</span><br/>&nbsp;<br/>&nbsp;</td>';
        	}
        }
        $i++;
		$next_name = '';
		if ($datearray[$i]['property_number'] != ''){
			$next_name = $datearray[$i]['property_number']." ";
		}
		$next_name .= $datearray[$i]['property_name'];
        if (($datearray[$i]['booking_month'] != $c_month) && ($next_name == $c_name)) { // change of month
            $c_month = $datearray[$i]['booking_month'];
            $monthcol++;
        }
    }
    if (($datearray[$i-1]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
		$tenant_name = '';
        if ($datearray[$i-1]['guest_id'] > 0) {
			$tenant_name = $db_object->getOne("SELECT last_name from customer WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND customer_id = '".$datearray[$i-1]['guest_id']."'");
		} else {
			$tenant_name = $db_object->getOne("SELECT last_name from customer WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND customer_id = '".$datearray[$i-1]['contact_id']."'");
		}
		$bookings[$row] .= 'colspan="'.$b_cols.'" onMouseOver="doHover(this);return window.status=&#039;EseBooking&trade; &amp;gt; Selected Booking&#039;;" onMouseOut="noHover(this);return window.status=&#039;&#039;;" onClick="top.Top.GoToURL(&#039;1&#039;, &#039;Edit Booking [Ref='.$datearray[$i-1]['booking_reference'].']&#039;, &#039;edit.php?view=booking_view&key=booking_reference&value='.$datearray[$i-1]['booking_reference'].'&&#039;);" nowrap><span style="width:'.($b_cols*60).'px;overflow:hidden;text-align:left;padding-left:5px">'.$datearray[$i-1]['booking_reference'].'&nbsp;'.$tenant_name.$datearray[$i-1]['booking_reference'].'&nbsp;'.$tenant_name.'</span></td>';
    } else {
       	$bookings[$row] .= 'colspan="'.$b_cols.'" nowrap>&nbsp;</td>';
    }
    $bookings[$row] .= '</tr>';
    $invoices[$row] .= '</tr>';
    $calendarrows .= $bookings[$row].$invoices[$row];
    $row++;
	$b_cols = 0;
	$i_cols = 0;
	$p_cols = 0;
	$c_cols = 0;
	$b_stat = '';
	$i_stat = '';
	$p_stat = '';
	$c_stat = '';
    $c_name = '';
	if ($datearray[$i]['property_number'] != ''){
		$c_name = $datearray[$i]['property_number']." ";
	}
	$c_name .= $datearray[$i]['property_name'];
    $c_year = $datearray[$i]['booking_year'];
    $c_month = $datearray[$i]['booking_month'];
}
echo $propertyrows;
echo '
	</table>
	</div>
  </td>
  <td>
  <div id="scrollmaster">
    <table>'.html_entity_decode($calendarrows);
?>
	</table>
    </div>
    </td>
  </tr>
</table> 
<table width="100%">
  <tr>
    <td class="fill"><i>The information in this table is current and is updated online.&nbsp;
    <?='Last real time update '.substr($last_updated,6,2).'/'.substr($last_updated,4,2).'/'.substr($last_updated,0,4).' '.substr($last_updated,8,2).':'.substr($last_updated,10,2).':'.substr($last_updated,12)?></i>  
    </td>
	<td height="33" align="right" valign="bottom" nowrap>
		<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">
	</td>
  </tr>
</table>