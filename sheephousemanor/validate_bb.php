<?php
// +----------------------------------------------------------------------+
// | VALIDATE_BB  - EseSite booking validation for B&B - Company 4        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/validate_bb.php,v 1.00 2008/06/15
//
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

include ($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/getbbpricedata.php');

//print_r($viewarray);
    
$sgl_avail = array();
$dbl_avail = array();
$twn_avail = array();
$price1 = array();
$price2 = array();
$dispdate = array();
$unavailable = array();
foreach ($viewarray as $date=>$viewrow)
{
	$price1[$date] = $viewrow['price_1'];
	$price2[$date] = $viewrow['price_2'];
	$dispdate[$date] = $viewrow['display_date'];
	$sgl_avail[$date] = 0;
	$dbl_avail[$date] = 0;
	$twn_avail[$date] = 0;
	foreach ($combined_resourcearray as $resourcerow) 
	{
		if ($viewrow[$resourcerow['property_name'].'_sel']===true)
		{
			if ($viewrow[$resourcerow['property_name']] == 'E')
			{
				// resource is available - increment availability total
				if ($resourcerow['active_bb'] != 'Y')
				{
					// self catering property added into b&b - applies to dbl & sgl
					$sgl_avail[$date]++;
					$dbl_avail[$date]++;
				} else
				{
					if ($resourcerow['property_name'] == 'Dbl')
					{
						$sgl_avail[$date]++;
						$dbl_avail[$date]++;
					} else
					{
						$sgl_avail[$date]++;
						$twn_avail[$date]++;
					}
				}
			} else
			{
				$unavailable[$resourcerow['property_id']] = true;
			}
		} else
		{
			$unavailable[$resourcerow['property_id']] = true;
		}
	}
	if (!isset($sgl_avail['overall']))
	{
		$sgl_avail['overall'] = $sgl_avail[$date];
	} elseif($sgl_avail['overall'] > $sgl_avail[$date])
	{
		$sgl_avail['overall'] = $sgl_avail[$date];
	}
	if (!isset($dbl_avail['overall']))
	{
		$dbl_avail['overall'] = $dbl_avail[$date];
	} elseif($dbl_avail['overall'] > $dbl_avail[$date])
	{
		$dbl_avail['overall'] = $dbl_avail[$date];
	}
	if (!isset($twn_avail['overall']))
	{
		$twn_avail['overall'] = $twn_avail[$date];
	} elseif($twn_avail['overall'] > $twn_avail[$date])
	{
		$twn_avail['overall'] = $twn_avail[$date];
	}
}
if ($ss == 'User' && substr($departure_date, 0, 3) == 'Sun' && $n == 1) {
    $error1.='Saturday bookings must include a minimum of 2 nights.<br>';
    return;
}
if ($sgl + $dbl + $twn < 1) {
    $error1.='At least one room must be selected.<br>';
    return;
}

if ($g + $c + $inf < $sgl + $dbl + $twn) {
    $error1.='Not enough guests for the number of rooms selected.<br>';
    return;
}

if ($sgl_avail['overall'] < $sgl)
{
	if ($sgl_avail['overall'] == 0)
	{
		$error1.='Sorry, there are no rooms sleeping 1 person available for the requested dates.<br>';
	} elseif ($sgl_avail['overall'] == 1)
	{
		$error1.='Sorry, there is only one room sleeping 1 person available for the requested dates.<br>';
	} else
	{
		$error1.='Sorry, there are only '.$sgl_avail['overall'].' rooms sleeping 1 person available for the requested dates.<br>';
	}
}
if ($dbl_avail['overall'] < $dbl)
{
	if ($dbl_avail['overall'] == 0)
	{
		$error1.='Sorry, there are no double rooms available for the requested dates.<br>';
	} elseif ($dbl_avail['overall'] == 1)
	{
		$error1.='Sorry, there is only one double room available for the requested dates.<br>';
	} else
	{
		$error1.='Sorry, there are only '.$dbl_avail['overall'].' double rooms available for the requested dates.<br>';
	}
}
if ($twn_avail['overall'] < $twn)
{
	if ($twn_avail['overall'] == 0)
	{
		$error1.='Sorry, there are no twin rooms available for the requested dates.<br>';
	} elseif ($twn_avail['overall'] == 1)
	{
		$error1.='Sorry, there is only one twin room available for the requested dates.<br>';
	} else
	{
		$error1.='Sorry, there are only '.$twn_avail['overall'].' twin rooms available for the requested dates.<br>';
	}
}
if ($error1 != '') {
    return;
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