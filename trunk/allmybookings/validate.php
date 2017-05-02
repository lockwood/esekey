<?php
// +----------------------------------------------------------------------+
// | VALIDATE  - EseSite booking validation - Company 8                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/validate.php,v 1.06 2006/02/06
//

// look for optional daily surcharges and extras in charge tables
$surcharges = $db_object->getAll("SELECT t1.charge_name,
							   		t2.charge_from, 		
							   		t2.charge_amount 		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 15
                              AND 	t2.charge_from <= CURDATE()
                         ORDER BY 	t1.charge_name, t2.charge_from
							");

$extras = $db_object->getAll("SELECT t1.charge_name,
							   		t2.charge_from, 		
							   		t2.charge_amount 		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 16
                              AND 	t2.charge_from <= CURDATE()
                         ORDER BY 	t1.charge_name, t2.charge_from
							");


// Set up most recent surcharge and extras rates for later use
$i=0;
$charge_name = "";
$labels = array();
$dailies = array();
$percents = array();
for ($ct=0; $ct<count($surcharges); $ct++)
{
	if ($charge_name != $surcharges[$ct]['charge_name'])
	{
		$charge_name = $surcharges[$ct]['charge_name'];
		$i++;
	}
	$labels[$i] = $charge_name." (".$surcharges[$ct]['charge_amount']."%)";
	$percents[$i] = $surcharges[$ct]['charge_amount'];
}
for ($ct=0; $ct<count($extras); $ct++)
{
	if ($charge_name != $extras[$ct]['charge_name'])
	{
		$charge_name = $extras[$ct]['charge_name'];
		$i++;
	}
	$labels[$i] = $charge_name." (".$extras[$ct]['charge_amount']." per day)";
	$dailies[$i] = $extras[$ct]['charge_amount'];
}

if (!$property_selected) {
    $error1.='At least one property must be selected.<br>';
    return;
}
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
foreach ($resourcearray as $propertyrow) {
    if (isset($r[$propertyrow['property_id']])) {
        $datearray = $db_object->getAll("SELECT t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference,
                                        t2.display_status, 
                                        t2.expiry
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$start_date."'
                                    AND t1.booking_date < date_add('".$start_date."', interval '".$n."' day)
                                    AND t1.company_id = t2.company_id
                                    AND t1.resource_id = '".$propertyrow['property_id']."'
                                    AND t1.booking_reference = t2.booking_reference");
        if (count($datearray) != $n) {
            $error1.='Currently unable to check requested availability - please view requested dates on Availability page, then re-try.<br>';
            return;
        }
        foreach ($datearray as $daterow) {
            if (($daterow['display_status'] != 'E') && (!isset($_SESSION[$ss]['booking_reference']))) { //this date is NOT available 
                $error1.='Sorry, '.$propertyrow['property_name'].' is not available on '.$daterow['booking_day'].'-'.$daterow['booking_month'].'-'.$daterow['booking_year'].'.<br>';
                return;
            }
        }
    }
}
// Web user cannot make booking online if booking is less than 3 days ahead //
// use seconds since the Unix Epoch / 86400 for reliable calculations including leap years etc.
if ($ss == 'User') {
    if ((date("U",$vdate)/86400) - (date("U",$today)/86400) < 3) {
        $error1.='Bookings within three days can only be made by telephone.<br>';
        return;
    }
}
// Look up deposit rate if present
$deposits = $db_object->getAll("SELECT t2.charge_from,
							   		t2.charge_amount, 		
							   		t2.charge_parameter as advance_days 		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 5
                              AND 	t2.charge_from <= '".$start_date."'
                         ORDER BY 	t2.charge_from
							");

// Find most recent deposit rate (last row in array)
$deposit_pc = 25; // default in case none provided in DB
$advance_days = 28; // default in case none provided in DB
if (count($deposits) > 0)
{
	$selected_row = count($deposits) - 1;
	$deposit_pc = $deposits[$selected_row]['charge_amount'];
	$advance_days = $deposits[$selected_row]['advance_days'];
}


// use seconds since the Unix Epoch / 86400 for reliable calculations including leap years etc.
if ((date("U",$vdate)/86400) - (date("U",$today)/86400) < $advance_days) {
    $deposit_rate = 1;
    $additional_info.='As this booking is less than '.$advance_days.' days in advance, it can only be confirmed on payment of the full amount shown.<br>';
} else {
    $deposit_rate = round($deposit_pc/100, 2);
}

if ((isset($_GET['requestBooking'])) && (!isset($error1))) { // user has confirmed valid booking request
    if ($f == '') {
        $error2.='Please enter your first name.<br>';
    }
    if ($l == '') {
        $error2.='Please enter your last name.<br>';
    }

    if ($a == '') {
        $error2.='Please enter a postal address.<br>';
    }

    if (($q == '') && ($ouk != 'CHECKED')) {
        $error2.='Please enter a post code, or tick if the address is outside the UK.<br>';
    } else { // post code should be of the form "X[X]n[n][X] nXX" with few variations.
        if ($q != '') {
            if ($ouk == 'CHECKED') {
                $error2.='Please do not enter a post code if the address is outside the UK.<br>';
            } else { 
                if (!eregi("^[A-Z]{1,2}[0-9]{1,2}[A-Z]{0,1} [0-9][A-Z]{2}$", $q )) {
                    $error2.='Please enter a valid post code.<br>';
                } else { // convert to uppercase 
                    $q = strtoupper($q);
                }
            }
        }
    }

    if ($u == '') {
        $error2.='Please enter a telephone or mobile number.<br>';
    }

    if ($e == '') {
        $error2.='Please enter an email address.<br>';
    } else { // email address should contain a single '@', at least one '.' and no imbedded spaces. 
        if (!ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $e )) {
            $error2.='Please enter a valid email address.<br>';
        }
    }
    if ($z == '') {
        $error2.='Please enter your credit/debit card number.<br>';
    } else { // credit/debit card number should be at least 16 digits all numeric. 
        $z_no_spaces = str_replace(' ', '', $z); // remove all imbedded spaces 
        $z = $z_no_spaces; 
        if (!ereg("[0-9]{16,19}", $z )) {
            $error2.='Please enter a valid credit/debit card number.<br>';
        }
    }
    if (($cardarray[$w] == 'Switch') && (!ereg("[0-9]{1,2}", $v ))) {
        $error2.='Please enter a valid Switch Issue Number.<br>';
    }
    if (($cardarray[$w] == 'Maestro') && (!ereg("[0-9]{1,2}", $v ))) {
        $error2.='Please enter a valid Maestro Issue Number.<br>';
    }
    if ($cv2 == '') {
        $error2.='Please enter the last 3 digits shown in the signature strip on the reverse of the card.<br>';
    } else { // security code should be exactly 3 digits all numeric. 
        if (!ereg("[0-9]{3}", $cv2 )) {
	        $error2.='Please enter the last 3 digits shown in the signature strip on the reverse of the card.<br>';
        }
    }
}
?>