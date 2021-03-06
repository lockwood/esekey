<?php  
// +----------------------------------------------------------------------+
// | AVAILABILITY  - Calculate Start Date for Daily Availability          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/availability_daily.php,v 1.01 2004/11/18
//
if ($_SESSION[$ss]['availability_flag'] == 'N') { // View Availability is not available to public
    if ($ss == 'Admin') { // administrator can view availability while closed to public
        echo '<p style="color: red">Note: Availability is currently only available to the administrator.</p>';
    } else { ?>
<table width="750" cellspacing="0" align="center" cellpadding="4">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4">Availability</th>
  </tr>
  <tr>
    <td colspan="4">We are temporarily unable to show current availability here. Please call us on <?=$_SESSION[$ss]['company_telephone']?> for latest availability information.</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
        <?php
        return;
    }
}
$today = mktime(); // get today's date as timestamp //
$todayday = date("d",$today); // get today's day including leading zero
$todaymonth = date("m",$today); // get today's month including leading zero
$todayyear = date("Y",$today); // get today's 4 digit year
$_SESSION[$ss]['todaydate'] = $todayyear.'-'.$todaymonth.'-'.$todayday; // set today's date in session
if (isset($_GET['sd'])) {
    $_SESSION[$ss]['selecteddate'] = $_GET['sd'];
} else {
    $_SESSION[$ss]['selecteddate'] = $_SESSION[$ss]['todaydate'];
}
if ($_SESSION[$ss]['selecteddate'] > $_SESSION[$ss]['todaydate']) {// future date has been supplied - validate before use
    $dy = substr($_SESSION[$ss]['selecteddate'],8,2);
    if ($dy > 0 && $dy < 32) { // day valid
        $mnth = (int) substr($_SESSION[$ss]['selecteddate'],5,2);
        if ($mnth > 0 && $mnth < 13) { // month valid
            $yr = (int) substr($_SESSION[$ss]['selecteddate'],0,4);
            if ($yr >= $todayyear && $yr < ($todayyear + 3)) { // year valid
                //if ($yr > $todayyear && $mnth < $todaymonth) { // year valid
                if ($yr > $todayyear) { // year valid
                	$today = mktime(0, 0, 0, $mnth, $dy, $yr); // replaces today with valid future date //
                }
                if ($yr == $todayyear && $mnth >= $todaymonth) { // year valid
                    $today = mktime(0, 0, 0, $mnth, $dy, $yr); // replaces today with valid future date //
                }
            }
        }
    }
}
$year = date("Y",$today);
$month = date("m",$today);
$wday = date("w",$today);
$day = date("d",$today);
if ($wday < 6) { // if today is not Saturday
    // set date to last Saturday
    $mday = $day - $wday - 1;
} else {
    $mday = $day;
}
//test month endings //
//$mday = $mday - 7;
//comment above out after test //

$prevsat = mktime(0, 0, 0, $month, $mday, $year);
$prevsatyear = date("Y",$prevsat);
$prevsatmonth = date("m",$prevsat);
$prevsatday = date("d",$prevsat);

// Format start dates for display //
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$monthnumarray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');
$daynamearray = array('Su','Mo','Tu','We','Th','Fr','Sa','Su','Mo');
$j = 0 + $todaymonth; // $j is integer index for montharray - cannot have leading zero
$display_nav[] = $montharray[$j].' '.$todayyear;
$nav[] = $_SESSION[$ss]['todaydate'];
for ($k = 1; $k <= 17; $k++) {
    $j++;
    if ($j > 12) {
        $todayyear++;
        $j = 1;
    }
    $display_nav[$k] = $montharray[$j].' '.$todayyear;
    $nav[$k] = $todayyear.'-'.$monthnumarray[$j].'-01';
}


if (!isset($select_property)) {
    $select_property = '';
}
//$select_property = " AND t1.resource_id IN ('2') ";

$_SESSION[$ss]['selecteddate'] = $year.'-'.$month.'-'.$day; // set current date in session
$_SESSION[$ss]['prevsatdate'] = $prevsatyear.'-'.$prevsatmonth.'-'.$prevsatday; // set previous Saturday date in session

// set display status on recently expired bookings to show available dates
$update_expired_bookings = $db_object->query("UPDATE booking
                                                 SET display_status = 'E',
                                                     last_modified_on = now()
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                                 AND display_status != 'E'
                                                 AND expiry < now()");
if (DB::isError($update_expired_bookings)) {
    die($update_expired_bookings->getMessage());
}

//read from table where date > start date and date < start date + 92 days (~3 months) 
//if records not found, insert new ones up to end date for selected period using mysql date_add (interval) function. 

$datearray = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.property_number,
                                        t3.property_name
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.active_flag = 'Y'
                                    AND t3.property_id = t1.resource_id
									AND t3.property_id IN(1,2,3,4,10)
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t3.property_id,
                                        booking_day");

$datearray_2 = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.property_number,
                                        t3.property_name
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.active_flag = 'Y'
                                    AND t3.property_id = t1.resource_id
									AND t3.property_id NOT IN(1,2,3,4,10)
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t3.property_id,
                                        booking_day");

// echo 'Date Count: '.count($datearray).'<br><br>';
// echo 'Prop Count: '.count($resourcearray).'<br><br>';

if ($select_property == '') {
    $property_count = count($resourcearray);
} else {
    $property_count = 1;
} 
$total_count = count($datearray) + count($datearray_2);
if ($total_count < ($property_count*92)) { // need to add some dates
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
                                            DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                            DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                            DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                            t1.booking_reference, 
                                            t2.display_status, 
                                            t2.expiry,
	                                        t3.property_number,
                                            t3.property_name 
                                       FROM calendar_booking".$_test." AS t1, 
                                            booking".$_test." AS t2,
                                            property AS t3 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
	                                    AND t3.active_flag = 'Y'
                                        AND t3.property_id = t1.resource_id
										AND t3.property_id IN(1,2,3,4,10)
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t3.property_id,
                                        booking_day");

    $datearray_2 = $db_object->getAll("SELECT t1.resource_id,
                                            t1.day_of_week,
                                            DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                            DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                            DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                            t1.booking_reference, 
                                            t2.display_status, 
                                            t2.expiry,
	                                        t3.property_number,
                                            t3.property_name 
                                       FROM calendar_booking".$_test." AS t1, 
                                            booking".$_test." AS t2,
                                            property AS t3 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
	                                    AND t3.active_flag = 'Y'
                                        AND t3.property_id = t1.resource_id
										AND t3.property_id NOT IN(1,2,3,4,10)
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t3.property_id,
                                        booking_day");

    // echo 'New Date Count: '.count($datearray).'<br><br>';
 
}
// compatibility issue MYSQL 4.0 and 4.1 - add 0 to timestamp to return number rather than string
$last_updated = $db_object->getOne("SELECT MAX(last_modified_on + 0)
                                      FROM booking
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'");

$c_year = $datearray[0]['booking_year'];
$disp_year = $datearray[0]['booking_year'];
$c_month = $datearray[0]['booking_month'];
$month_count = 1;
$c_name = $datearray[0]['property_name'];
$c_day = 1; // start at beginning of row
$i = 0;
if (isset($popup) && $popup == 1) {
	$popup_string = '<input type="hidden" name="popup" value="1" />'; 
} else {
	$popup_string = ""; 
}
if ($start_booking) {
	if ($_SESSION[$ss]['booking_flag'] == 'Y') {
		$bk_string = '<input type="hidden" name="bk" value="1" /><b>Click on an available date to begin a booking.</b><br />&nbsp;<br />';
	} else {
		$bk_string = '<input type="hidden" name="bk" value="1" /><b>Sorry, online booking is currently unavailable.</b><br />&nbsp;<br />';
	} 
} else {
	$bk_string = "&nbsp;"; 
}
if (isset($selected_id) && $selected_id > 0) {
	$property_string = '<b>Choose:</b><SELECT NAME="property" onChange="submit();">';
	foreach ($resourcearray as $propertyrow) {
    	$full_name = $propertyrow['property_name'];
		if ($propertyrow['property_id'] == $selected_id) {
			$property_string .= '
      <OPTION VALUE="'.$propertyrow['property_id'].'" SELECTED>'.$full_name.'</OPTION>';
		} else {
			$property_string .= '
      <OPTION VALUE="'.$propertyrow['property_id'].'">'.$full_name.'</OPTION>';
		}
	}
	$property_string .= '</SELECT><br />';
} else {
	$property_string = ""; 
}

include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/date_form.php');

$b_and_b_flag = $db_object->getOne("SELECT b_and_b_flag FROM company WHERE company_id = '".$_SESSION[$ss]['company_id']."'"); 
if ($ss == 'Admin')
{
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/view_bb.php');
	echo '<p>&nbsp;<b>Self&nbsp;Catering</b></p>';
}
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/view_daily.php');
//include 'view_daily.php';
?>
