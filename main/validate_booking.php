<?php 
// +----------------------------------------------------------------------+
// | VALIcalendar_booking  - Validate Weekly Online Booking (Company 1)       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/valicalendar_booking.php,v 1.00 2003/10/01
// 

$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$j = 0 + substr($_SESSION[$ss]['booking_date'],5,2); // $j is integer index for montharray - cannot have leading zero
$_SESSION[$ss]['display_date'] = substr($_SESSION[$ss]['booking_date'],8,2).' '.$montharray[$j].' '.substr($_SESSION[$ss]['booking_date'],0,4);
if (!isset($_SESSION[$ss]['booking_duration'])) {
    $_SESSION[$ss]['booking_duration'] = 7; // create initial value of 7 for duration
}
$numrows = 0; // initialise 
foreach ($propertyarray as $propertyrow) { 
    if ($propertyrow[property_id] == $property_id) {
    	$property_name = '';
    	if ($propertyrow['property_number'] != '') {
    		$property_name = $propertyrow['property_number'].' ';
    	}
    	$property_name .= $propertyrow['property_name'];
        // set property name in request
        $price_found = false;
        foreach ($pricearray as $pricerow) { // find weekly price for this property
            if ($propertyrow[price_code] == $pricerow[price_code]
                && $pricerow[start_date] <= $_SESSION[$ss]['booking_date']
                && $pricerow[end_date] >= $_SESSION[$ss]['booking_date']) {
                $_SESSION[$ss]['total_cost'] = '�'.$pricerow[weekly_rate];
                $deposit = $pricerow[weekly_rate]/10;
                $_SESSION[$ss]['deposit'] = '�'.number_format($deposit,2);
                $price_found = true;
            }
        }
        if (!$price_found) {
            $_SESSION[$ss]['total_cost'] = 'POA';
            $_SESSION[$ss]['deposit'] = 'POA';
        }
        // double check that all or part of the slot has not already been booked
        // look for booking that starts before the end of this one and finishes after the start of this one...
        $check = $db_object->query("
          SELECT start_date
            FROM diary
           WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND
                 resource_id = '$property_id' AND
                 start_date < date_add('".$_SESSION[$ss]['booking_date']."', 
                                       interval '".$_SESSION[$ss]['booking_duration']."' day) AND 
                 end_date > '".$_SESSION[$ss]['booking_date']."' AND
                 expiry > now() AND
                 booking_reference <> '".$_SESSION[$ss]['booking_reference']."'");
        $numrows = $check->numRows();
    }
}
if ($numrows == 0) { //OK to proceed - no overlapping bookings
    if (($property_id > 0) && ($property_id != $_SESSION[$ss]['booking_property_id'])) {
        // set property_id and name in session
        $_SESSION[$ss]['booking_property_id'] = $property_id;
        $_SESSION[$ss]['booking_property_name'] = $property_name;
        $_SESSION[$ss]['booking_duration'] = 7; // create initial value of 7 for duration
    }
    // find next booking to establish maximum duration for this booking 
    $check = $db_object->query("SELECT start_date,
                                   end_date,
                                   DATE_FORMAT(start_date, '%d')AS start_day,
                                   DATE_FORMAT(start_date, '%m')AS start_month, 
                                   DATE_FORMAT(start_date, '%Y')AS start_year, 
                                   DATE_FORMAT(end_date, '%d')AS end_day,
                                   DATE_FORMAT(end_date, '%m')AS end_month,
                                   DATE_FORMAT(end_date, '%Y')AS end_year,
                                   entry_status,
                                   booking_reference,
                                   expiry
                              FROM diary
                             WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND
                                   resource_id = '".$_SESSION[$ss]['booking_property_id']."' AND
                                   start_date >= '".$_SESSION[$ss]['booking_date']."' AND
                                   expiry > now() AND
                                   booking_reference <> '".$_SESSION[$ss]['booking_reference']."'
                          ORDER BY start_date
                          FOR UPDATE");
    $diaryrow = $check->fetchRow();
    // a booking may not be for more than 21 days
    $latest_end_date = $db_object->getOne("SELECT DATE_ADD('".$_SESSION[$ss]['booking_date']."', interval 21 day)");
    if (isset($diaryrow[start_date])) {
        if ($diaryrow[start_date] < $latest_end_date) {// fewer than 21 days available
            $latest_end_date = $diaryrow[start_date];
        }
    }
    //create array for duration drop-down selection
    $duration_array = array(0);
    $i = 0;
    $nights = 0;
    $date_test = $db_object->getOne("SELECT DATE_ADD('".$_SESSION[$ss]['booking_date']."', interval 7 day)");
    while ($date_test <= $latest_end_date) {
        $nights = $nights + 7;
        $duration_array[$i] = $nights;
        $i++;
        $date_test = $db_object->getOne("SELECT DATE_ADD('".$date_test."', interval 7 day)");
    }
    if (!isset ($_SESSION[$ss]['booking_reference'])) { // create new booking reference with max duration to expire in 5 minutes
        $insert = "INSERT INTO diary 
                    VALUES ('".$_SESSION[$ss]['company_id']."',
                            '".$_SESSION[$ss]['booking_property_id']."',
                            '".$_SESSION[$ss]['booking_date']."', 
                            date_add('".$_SESSION[$ss]['booking_date']."', interval '".$nights."' day), 
                            1, 
                            'T', 
                            0, 
                            now(),
                            date_add(now(), interval 5 minute),
                            '".$_SESSION[$ss]['username']."', 
                            null)";

        $add_member = $db_object->query($insert);

        if (DB::isError($add_member)) {
            die($add_member->getMessage());
        }
        // return booking_reference and add it to SESSION //
        $_SESSION[$ss]['booking_reference'] = mysql_insert_id();  
        $db_object->disconnect();
    } else { // update booking reference with latest selection, to expire in 5 minutes
        $upcalendar_booking_reference = $db_object->query(
                     "UPDATE diary 
                    SET company_id = '".$_SESSION[$ss]['company_id']."',
                       resource_id = '".$_SESSION[$ss]['booking_property_id']."',
                        start_date = '".$_SESSION[$ss]['booking_date']."', 
                          end_date = date_add('".$_SESSION[$ss]['booking_date']."', interval '".$nights."' day), 
                     resource_type =  1, 
                      entry_status = 'T', 
                            expiry = date_add(now(), interval 5 minute),
                  last_modified_on = now()
                    WHERE booking_reference = '".$_SESSION[$ss]['booking_reference']."'");
        if (DB::isError($upcalendar_booking_reference)) {
            die($upcalendar_booking_reference->getMessage());
        }
    }
} else {
    unset($_SESSION[$ss]['booking_property_id']);
    unset($_SESSION[$ss]['booking_property_name']);
    unset($_SESSION[$ss]['booking_date']);
    unset($_SESSION[$ss]['booking_duration']);
    unset($_SESSION[$ss]['display_date']);
    include('redirect_booking.php');
    exit;
}
?>