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

$datearray = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week,
                                        t1.booking_date, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference,
                                        t1.day_of_week, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.price_code,
                                        t3.booking_pattern,
                                        t3.property_number,
                                        t3.property_name
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 98 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.property_id = t1.resource_id
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY t1.resource_id,
                                        booking_year,
                                        booking_month,
                                        booking_day");

// echo 'Date Count: '.count($datearray).'<br><br>';
// echo 'Prop Count: '.count($resourcearray).'<br><br>';

if ($select_property == '') {
    $property_count = count($resourcearray);
} else {
    $property_count = 1;
} 

if (count($datearray) < ($property_count*98)) { // need to add some dates
    $number_inserted = 0;
    $insert = "INSERT INTO booking 
                VALUES ('".$_SESSION[$ss]['company_id']."',
                        0, 
	                    1, 
                        '".$_SESSION[$ss]['prevsatdate']."', 
                        date_add('".$_SESSION[$ss]['prevsatdate']."', interval 98 day), 
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
        for ($i = 0; $i <= 99; $i++) {
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
    // echo 'Rows Inserted: '.$number_inserted.'<br><br>';
    $datearray = $db_object->getAll("SELECT t1.resource_id,
                                            t1.day_of_week,
                                            t1.booking_date, 
                                            DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                            DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                            DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                            t1.booking_reference, 
                                            t1.day_of_week, 
                                            t2.display_status, 
                                            t2.expiry,
                                            t3.price_code,
                                            t3.booking_pattern,
                                            t3.property_number, 
                                            t3.property_name 
                                       FROM calendar_booking".$_test." AS t1, 
                                            booking".$_test." AS t2,
                                            property AS t3 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 98 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
                                        AND t3.property_id = t1.resource_id
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY t1.resource_id,
                                        booking_year,
                                        booking_month,
                                        booking_day");

    // echo 'New Date Count: '.count($datearray).'<br><br>';
 
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
if ($datearray[$i]['booking_pattern'] == 5) {// Friday changeover
    $start_day = 5;
} elseif ($datearray[$i]['booking_pattern'] == 6) {// Saturday
    $start_day = 6;
} elseif ($datearray[$i]['booking_pattern'] == 0) {// Sunday
    $start_day = 0;
} else { // Monday
    $start_day = 1; 
}
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
</form>
<br>
<?php
}
?>
<table border="0">
<?php
$week_ct = 1;
while ($i < count($datearray)) { ?>
  <tr>
    <td class="year" valign="top" nowrap><?=$c_name?><br><?=$daynamearray[$start_day]?>&nbsp;changeover</td>
        <?php 
	$next_name = '';
	if ($datearray[$i]['property_number'] != ''){
		$next_name = $datearray[$i]['property_number']." ";
	}
	$next_name .= $datearray[$i]['property_name'];
    while ($next_name == $c_name) {
		// logic to prevent some rows having more columns than others
		// due to differences between no. of start days within the datearray
		// gives a maximum of 13 weeks per row
        if (($datearray[$i]['day_of_week'] == $start_day) && ($week_ct < 14)) { ?>
    <td class="<?=$datearray[$i]['display_status']?>"><?=$datearray[$i]['booking_day']?>/<?=$c_month?><br>
          <?php
            $display_price = 'POA'; // initialise to Price On Application
            foreach ($pricearray as $pricerow) { // get price for this week - not very efficient code
                if (($pricerow['price_code'] == $datearray[$i]['price_code']) &&
                   ($pricerow['start_date'] <= $datearray[$i]['booking_date'])) {
                    if ($pricerow['weekly_rate'] > 0) {
                    	$display_price = "&pound;".$pricerow['weekly_rate'];
                    } else {
                    	$display_price = "&pound;".round($pricerow['daily_rate'] * 7);
                    }
                }
            }
            if (($datearray[$i]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
                echo '<a href="#"
                onClick="top.Top.GoToURL(&quot;EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view&srch1=t1.booking_reference&op1=EQ&val1='.$datearray[$i]['booking_reference'].'&quot;);"
                onMouseOver="return window.status=&quot;EseBooking&trade; &gt; Selected Booking&quot;;"
                onMouseOut="return window.status=&quot;&quot;;">'.$display_price.'</a></td>';
            } else {
                echo $display_price.'</td>';
            }
	        $week_ct++;
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
	$week_ct = 1;
	$c_name = '';
	if ($datearray[$i]['property_number'] != ''){
		$c_name = $datearray[$i]['property_number']." ";
	}
	$c_name .= $datearray[$i]['property_name'];
    $c_year = $datearray[$i]['booking_year'];
    $c_month = $datearray[$i]['booking_month'];
	if ($datearray[$i]['booking_pattern'] == 5) {// Friday changeover
	    $start_day = 5;
	} elseif ($datearray[$i]['booking_pattern'] == 6) {// Saturday
	    $start_day = 6;
	} elseif ($datearray[$i]['booking_pattern'] == 0) {// Sunday
	    $start_day = 0;
	} else { // Monday
	    $start_day = 1; 
	}
    ?>
  </tr><?php
} 
?>
  <tr>
    <td colspan="<?=round(count($datearray)/(count($resourcearray)*7))+1?>" class="fill"><i>The information in this table is current and is updated online.&nbsp;
    <?='Last real time update '.substr($last_updated,6,2).'/'.substr($last_updated,4,2).'/'.substr($last_updated,0,4).' '.substr($last_updated,8,2).':'.substr($last_updated,10,2).':'.substr($last_updated,12)?></i>  
    </td>
  </tr>
</table> 
