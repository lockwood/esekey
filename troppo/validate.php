<?php
// +----------------------------------------------------------------------+
// | VALIDATE  - EseSite booking validation - Company 3                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/validate.php,v 1.09 2007/09/20
//
if (isset($r[4])) { // Flo's Cabin	if (!isset($r[1]) && !isset($r[2]) && !isset($r[3]) && !isset($r[5])) {		$error1.='Flo&#039;s Cabin cannot be booked on its own.<br>';    	return;			}}
if ((!isset($r[1])) && (!isset($r[2])) && (!isset($r[3])) && (!isset($r[5]))) {
    $error1.='At least one apartment must be selected.<br>';
    return;
}
$guests_remaining = $g + $c + $inf;
if (isset($o[2])) { // rowing special offer - $rowing_rate
    if (($inf > 0) && ($ss == 'User')) { 
    	// offer not valid for under 3's, can be overridden by Admin
        $error1.='Rowing offer is not open to under 3s.<br>';
        return;
    }    
    if (($guests_remaining < 10) && ($ss == 'User')) { 
    	// offer only valid for 10 or more people, can be overridden by Admin
        $error1.='Not enough guests to qualify for rowing offer.<br>';
        return;
    }    
    if (($guests_remaining > 16) && ($ss == 'User')) { 
    	// offer only valid for up to 16 people, can be overridden by Admin
        $error1.='A maximum of 16 guests allowed for rowing offer.<br>';
        return;
    }    
    $a_ct = 0;
   	if (isset($r[1])) $a_ct++; 
   	if (isset($r[2])) $a_ct++; 
   	if (isset($r[3])) $a_ct++; 
   	if (isset($r[5])) $a_ct++;    	if ($guests_remaining < 10) {
    	if ($a_ct > 2) { 
    		// For bookings of up to 10 rowers, a maximum of two apartments only may be booked
        	$error1.='For bookings of 8 or 9 rowers, only two apartments may be booked.<br>';
        	return;
    	}
    } else {
    	if ($a_ct < 3) { 
    		// For bookings of over 9 rowers, at least three apartments must be booked
        	$error1.='For bookings of over 9 rowers, at least three apartments must be booked.<br>';
        	return;
    	}
    	
    }
	if ($a_ct < 2) { 
		// For all rowing bookings, a minimum of two apartments must be booked
   		$error1.='For rowing group bookings, a minimum of two apartments must be booked.<br>';
   		return;
	}
} else 
{
    $guests_allowed = 0;
    $apartments = array();
    if (isset($r[1])) { // Wisteria
		$guests_allowed += 5;
		$apartments[] = 'Wisteria';
		$guests_remaining = $guests_remaining - 2;
        if ($guests_remaining > 3) {
            if ((!isset($r[3])) && (!isset($r[2]))  && (!isset($r[5]))) { //all remaining adults in Wisteria
                $error1.='Wisteria has a maximum of five guests.<br>';
                return;
            }
        }
    }
    if (isset($r[2])) { // Gardeners Bothy
		$guests_allowed += 7;
		$apartments[] = 'Gardener&#039;s Bothy';
		$guests_remaining = $guests_remaining - 2;
        if ($guests_remaining > 5) {
            if ((!isset($r[3])) && (!isset($r[1]))) { //all remaining adults in GB
                $error1.='Gardener&#039;s Bothy has a maximum of seven guests.<br>';
                return;
            }
        }
    }
    if (isset($r[5])) { // Imogens Cabin		$guests_allowed += 4;		$apartments[] = 'Imogen&#039;s Cabin';		$guests_remaining = $guests_remaining - 2;        if ($guests_remaining > 2) {            if ((!isset($r[3])) && (!isset($r[1])) && (!isset($r[2]))) { //all remaining adults in IA                $error1.='Imogen&#039;s Cabin has a maximum of four guests.<br>';                return;            }        }    }    if (isset($r[3])) { // The Smithy
		$guests_allowed += 4;
		$apartments[] = 'The Smithy';
        $guests_remaining = $guests_remaining - 2;
        if ((!isset($r[1])) && (!isset($r[2])) && (!isset($r[5]))) {
            if ($guests_remaining > 2) { // more than 4 in total for Smithy
                $error1.='The Smithy has a maximum of four guests.<br>';
        		return;
            }
        }
    }
   	if (isset($r[4])) { // Flo's Cabin   		$guests_allowed += 3;   		$apartments[] = 'Flo&#039;s Cabin';   	}    		    if (($g + $c + $inf) > $guests_allowed) {    	
    	// too many guests for apartment combination
		$error1 .= implode(' and ', $apartments).' have a combined maximum of '.$guests_allowed.' guests.<br>';
    	return;
    }
}
if (isset($o[4])) { // stag/hen nights special offer - second night half price
    if (($g + $c < 14) && ($ss == 'User')) { 
    	// offer only valid for 14 or more people, can be overridden by Admin
        $error1.='Not enough guests to qualify for Hen/Stag/Reunion Deal.<br>';
        return;
    }    
    if (($g + $c > 16) && ($ss == 'User')) { 
    	// offer only valid for up to 16 people, can be overridden by Admin
        $error1.='A maximum of 16 guests allowed for Hen/Stag/Reunion Deal.<br>';
        return;
    }    
   	if (!isset($r[1]) || !isset($r[2]) || !isset($r[3])) {
   		// All apartments must be booked
       	$error1.='All apartments must be booked for Hen/Stag/Reunion Deal.<br>';
       	return;
    }
   	if (($n != 2) && ($ss == 'User')) {
   		// Only applies for 2 night bookings
       	$error1.='Hen/Stag/Reunion Weekend Deal only applies to two-night stays.<br>';
       	return;
    }
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

$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");
// Web user cannot make booking online if booking is less than 3 days ahead //
// use seconds since the Unix Epoch / 86400 for reliable calculations including leap years etc.
if ($ss == 'User') {
    if (($end_date > '2013-06-17' ) && ($start_date < '2013-06-20' )) {
    	if (isset($r[3])) {
    		$error1.='Sorry - due to essential maintenance work The Smithy is not available between 17th and 19th June.<br>';
        	return;
    	}
    }
	if ((date("U",$vdate)/86400) - (date("U",$today)/86400) < 3) {
        $error1.='Bookings within three days can only be made by telephone.<br>';
        return;
    }
    if (($end_date > '2017-12-19' ) && ($start_date < '2018-01-03' )) {        	$error1.='Sorry, we cannot take online bookings for the Christmas period. Please call us on 01753 827037 if you wish to stay during this time.<br>';        	return;        }        if (($end_date > '2018-03-29' ) && ($start_date < '2018-04-03' )) {           $error1.='Sorry, we cannot take online bookings for the Easter period. Please call us on 01753 827037 if you wish to stay during this time.<br>';        return;    }    if (($end_date > '2018-12-19' ) && ($start_date < '2019-01-03' )) {        	$error1.='Sorry, we cannot take online bookings for the Christmas period. Please call us on 01753 827037 if you wish to stay during this time.<br>';        	return;        }        if (($end_date > '2019-03-18' ) && ($start_date < '2019-03-23' )) {        	$error1.='Sorry, we cannot take online bookings for the Easter period. Please call us on 01753 827037 if you wish to stay during this time.<br>';        	return;        }    
}
// validate any request for legoland passes here
if ( $n == 1 && $lp > 0)
{
	$error1.='Legoland passes are not available with one-night bookings';
}
if ($lp > ($g + $c))
{
	$error1.='Only one Legoland pass is allowed per person';
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
    }	if (!isset($_GET['pgt'])) {
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
    	}		}
    if ($wyhau < 1) {
        $error2.='Please indicate where you heard about us.<br>';
    }

}
?>