<?php
// +----------------------------------------------------------------------+
// | VALIDATE  - EseSite booking validation - Company 4                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/validate.php,v 1.02 2004/11/15
//

if ((!isset($r[1])) && (!isset($r[2])) && (!isset($r[3]))) {
    $error1.='Please select a cottage.<br>';
    return;
}
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
// date has been supplied - validate before use
$start_date = $y.'-'.$m.'-'.$d; // set start date variable
if (($d > 0 && $d < 32) && ($m > 0 && $m < 13) && ($y >= $todayyear && $y <= ($todayyear + 1))) { // date format valid
    $day = $d;
    $month = $m;
    $year = $y; 
    $vdate = mktime(0, 0, 0, $month, $day, $year); // creates valid date from supplied dd mm yyyy values  //
} else { // shouldn't get this as date comes from dropdown selections
    $error1.='Please enter a valid date from the list provided.<br>';
    return;
}
$vy = date("Y",$vdate);
$vm = date("m",$vdate);
$vmx = 0 + $vm; // month excluding leading zero
$wday = date("w",$vdate);
$vd = date("d",$vdate);
$vdx = 0 + $vd; // day excluding leading zero
// echo $start_date.'<br>'.$vy.'-'.$vm.'-'.$vd.'<br>'.$todayyear.'-'.$todaymonth.'-'.$todayday; 
if ($start_date != $vy.'-'.$vmx.'-'.$vdx) { // selected date is not valid e.g. 30th Feb
    $error1.='Please enter a valid date.<br>';
    return;
} else {
    $start_date = $vy.'-'.$vm.'-'.$vd; // update date variable with leading zeros
}
if ($start_date < $todayyear.'-'.$todaymonth.'-'.$todayday) { // selected date is in the past
    $error1.='Requested date is in the past.<br>';
    return;
}
for ($i = 1; $i <= 3; $i++) {
    if (isset($r[$i])) {
        $datearray = $db_object->getAll("SELECT t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference,
                                        t2.display_status, 
                                        t2.expiry
                                   FROM calendar_booking AS t1, 
                                        booking AS t2
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$start_date."'
                                    AND t1.booking_date < date_add('".$start_date."', interval '".$n."' day)
                                    AND t1.company_id = t2.company_id
                                    AND t1.resource_id = '".$i."'
                                    AND t1.booking_reference = t2.booking_reference");
        if (count($datearray) != $n) {
            $error1.='Currently unable to check requested availability - please view requested dates on Availability page, then re-try.<br>';
            return;
        }
        foreach ($datearray as $daterow) {
            if (($daterow['display_status'] != 'E') && (!isset($_SESSION[$ss]['booking_reference']))) { //this date is NOT available 
                $booked_property = '';
                foreach($propertyarray as $propertyrow) { // get name of property for error message
                    if ($propertyrow['property_id'] == $i) {
                        if ($booked_property == '') {
                            $booked_property = $propertyrow['property_name'];
                        }
                    }
                } 
                $error1.='Sorry, '.$booked_property.' is not available on '.$daterow['booking_day'].'-'.$daterow['booking_month'].'-'.$daterow['booking_year'].'.<br>';
                return;
            }
        }
    }
}
// If booking is less than 4 weeks ahead, total balance must be paid //
// use seconds since the Unix Epoch / 86400 for reliable calculations including leap years etc.
if ((date("U",$vdate)/86400) - (date("U",$today)/86400) < 28) {
    $deposit_rate = 1;
    $additional_info.='As this booking is less than four weeks in advance, it can only be confirmed on payment of the full amount shown.<br>';
} else {
    $deposit_rate = 0.3;
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

    if ($q == '') {
        $error2.='Please enter a post code.<br>';
    } else { // post code should be of the form "X[X]n[n][X] nXX" with few variations. 
        if (!eregi("^[A-Z]{1,2}[0-9]{1,2}[A-Z]{0,1} [0-9][A-Z]{2}$", $q )) {
            $error2.='Please enter a valid post code.<br>';
        } else { // convert to uppercase 
            $q = strtoupper($q);
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
}
?>