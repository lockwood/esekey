<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 5                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 5/price.php,v 1.00 2005/01/12
//

$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';
if (isset($o[2])) { // rowing special offer - £15 per head
    if ($g < 8) { // offer only valid for 8 or more people
        $error1.='Not enough guests to qualify for rowing offer.<br>';
        return;
    } else {
        $tariff = '3'; // rowing tariff
        $cost_per_night = $g * 15;
        $additional_info .= 'Based on special price for rowing group. We reserve the right to change the selected apartments for rowing groups to fit in with other bookings as required.<br>';
    }    
} else {
    $guests_remaining = $g;
    $cost_per_night = 0;
    if (isset($r[3])) { // The Smithy
        $guests_remaining = $guests_remaining - 2;
        $cost_per_night = $cost_per_night + 50;
        if ((!isset($r[1])) && (!isset($r[2]))) {
            if ($guests_remaining > 0) { // more than 2 adults
                $error1.='The Smithy has a maximum of two adult guests.<br>';
                return;
            }
        } else { // £20 reduction per night if Smithy booked in conjunction with other apartment
            $tariff = '2'; // Combined tariff  
            $additional_info .= 'Price based on The Smithy in conjunction with another apartment.<br>';
            $cost_per_night = $cost_per_night - 20;
        }
    }
    if (isset($r[1])) { // The Chantry
        $guests_remaining = $guests_remaining - 2;
        $cost_per_night = $cost_per_night + 65;
        // echo 'The Chantry base cost = '.$cost_per_night;
        if ($guests_remaining > 0) {
            if (!isset($r[2])) { //all remaining adults in The Chantry
                if ($guests_remaining > 3) { // too many to fit in 
                    $error1.='The Chantry has a maximum of five adult guests.<br>';
                    return;
                } else {
                    $cost_per_night = $cost_per_night + ($guests_remaining * 10);
                    // echo 'The Chantry final cost = '.$cost_per_night;
                }
            }
        }
    }
    if (isset($r[2])) { // Church Brow Cottage
        $guests_remaining = $guests_remaining - 2;
        $cost_per_night = $cost_per_night + 65;
        // echo 'CB base cost = '.$cost_per_night;
        if ($guests_remaining > 0) { // all remaining adults in CB
            if (($guests_remaining > 3) && (!isset($r[1]))) { // too many to fit in CB 
                $error1.='Church Brow Cottage has a maximum of five adult guests.<br>';
                return;
            } else {
                if ($guests_remaining > 6) { // too many to fit in GB + W
                    $error1.='The Chantry and Church Brow Cottage have a maximum of ten adult guests.<br>';
                    return;
                }
                $cost_per_night = $cost_per_night + ($guests_remaining * 10);
                // echo 'CB final cost = '.$cost_per_night;
            }
        }
    }
}
$price = $cost_per_night * $n;
if (($price < 80) && (!isset($o[1]))) { // minimum charge £80 unless waived by administrator
    $price = 80;
    $additional_info .= 'Minimum charge of £80 applies.<br>';
}
$deposit = round($price * $deposit_rate, 2);
$balance = $price - $deposit;
?>