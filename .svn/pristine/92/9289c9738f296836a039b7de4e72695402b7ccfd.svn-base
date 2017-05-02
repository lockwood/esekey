<?php 
// +----------------------------------------------------------------------+
// | CUSTOMER_DETAILS_VALIDATE  - shared with bookings and enquiries co 9 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 9/customer_details_validate.php,v 1.00 2007/08/24
//

    if ($co_id == '0' && $co == '') {
        $error2.='Company name required.<br>';
    }
    if ($f == '') {
        $context == 'booking' ? $error2.='Booking contact first name required.<br>' : $error2.='First name is required.<br>';
    }
    if ($l == '') {
        $context == 'booking' ? $error2.='Booking contact last name required.<br>' : $error2.='Last name is required.<br>';
    }

    if ($a == '' && $context == 'booking') {
        $error2.='Booking contact address required.<br>';
    }

    if (($q == '') && ($ouk != 'CHECKED') && ($context == 'booking')) {
        $error2.='Booking contact postcode required, or tick box if the address is outside the UK.<br>';
    } else { // post code should be of the form "X[X]n[n][X] nXX" with few variations.
        if (($q != '') && ($context == 'booking')) {
            if ($ouk == 'CHECKED') {
                $error2.='Do not enter a postcode if the booking contact address is outside the UK.<br>';
            } else { 
                if (!eregi("^[A-Z]{1,2}[0-9]{1,2}[A-Z]{0,1} [0-9][A-Z]{2}$", $q )) {
                    $error2.='Booking contact postcode is not valid.<br>';
                } else { // convert to uppercase 
                    $q = strtoupper($q);
                }
            }
        }
    }

    if ($u == '') {
        $context == 'booking' ? $error2.='Booking contact phone number required.<br>' : $error2.='Phone number is required.<br>';
    }

    if ($e == '') {
        $context == 'booking' ? $error2.='Booking contact email address required.<br>' : $error2.='Email address is required.<br>';
    } else { // email address should contain a single '@', at least one '.' and no imbedded spaces. 
        if (!ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $e )) {
            $context == 'booking' ? $error2.='Booking contact email address is not valid.<br>' : $error2.='Email address is not valid.<br>';
        }
    }

    if ($add_tenant == 'yes')
    {
	    if ($f_t == '') {
	        $error2.='Tenant first name required.<br>';
    	}
    	if ($l_t == '') {
        	$error2.='Tenant last name required.<br>';
	    }

		// post code should be of the form "X[X]n[n][X] nXX" with few variations.
   	    if ($q_t != '') {
       	    if ($ouk_t == 'CHECKED') {
           	    $error2.='Do not enter a postcode if the tenant address is outside the UK.<br>';
           	} else { 
               	if (!eregi("^[A-Z]{1,2}[0-9]{1,2}[A-Z]{0,1} [0-9][A-Z]{2}$", $q_t )) {
                   	$error2.='Tenant postcode is not valid.<br>';
                } else { // convert to uppercase 
                   	$q_t = strtoupper($q_t);
               	}
           	}
    	}

	    if ($u_t == '') {
    	    $error2.='Tenant phone number required.<br>';
    	}

	    if ($e_t == '') {
        	$error2.='Tenant email address required.<br>';
    	} else { // email address should contain a single '@', at least one '.' and no imbedded spaces. 
        	if (!ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $e_t )) {
            	$error2.='Tenant email address is not valid.<br>';
        	}
    	}
    }

?>