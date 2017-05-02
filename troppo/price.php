<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 3                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/price.php,v 1.07 2006/10/16
//

$wgb_rate = 89;
$smithy_rate = array();
$smithy_rate[1] = 60;
$smithy_rate[2] = 78;$ic_rate = 60;
$fc_rate = 60;// winter rates no longer applied from 28/04/2017
$w_wgb_rate = 79;
$w_smithy_rate = array();
$w_smithy_rate[1] = 60;
$w_smithy_rate[2] = 70;
$w_ic_rate = 55;$w_fc_rate = 50;$dog_rate = 13;
$legoland_price = 40;
$extra_guests_rate = 17;
$w_extra_guests_rate = 15;
$rowing_rate = 20;

// new winter tariff for 2011-12 (updated for 2015-16)// winter rates no longer applied from 28/04/2017
$winter_nights = 0;/*
if ($end_date > '2015-10-31' && $start_date < '2016-03-01') {
	// winter tariff may apply
	$day = $start_date;
	for ($i=0;$i<$n;$i++) {
		if ($day > '2015-10-31' && $day < '2015-12-19') {
			$winter_nights++;
		}
		if ($day > '2016-01-02' && $day < '2016-03-01') {
			$winter_nights++;
		}
		$day = date('Y-m-d', strtotime($day.' + 1 day'));
	}
}// */
$non_winter_nights = $n - $winter_nights;
if ($winter_nights > 0) { // winter tariff
	$tariff = '6';
} else {
	$tariff = '1'; // Assume Standard tariff and update if different
}
if (($n == 1)&& (!isset($o[2]))) { // One night stays for non-rowing groups have a supplement per apartment
    if ($tariff == '6') {
    	//winter: £10 supplement
		$supp = 10;
    } else {
    	//standard: £15 supplement 
		$supp = 15;
    }
	$wgb_rate += $supp;
    $smithy_rate[1] += $supp;
    $smithy_rate[2] += $supp;        $ic_rate += $supp;
    $w_wgb_rate += $supp;
    $w_smithy_rate[1] += $supp;
    $w_smithy_rate[2] += $supp;
    $w_ic_rate += $supp;    $additional_info .= 'Single night supplement of £'.$supp.' applies.<br>';
}
$w_cost_per_night = 0;
$discount = '0';
$negotiated = '';
$guests_remaining = $g + $c;
$w_guests_remaining = $guests_remaining;
if (isset($o[2])) { // rowing special offer - $rowing_rate
    $tariff = '3'; // rowing tariff
    $cost_per_night = $guests_remaining * $rowing_rate;        $w_cost_per_night = $cost_per_night; 
    $additional_info .= 'Based on special price for rowing group. We reserve the right to change the selected apartments for rowing groups to fit in with other bookings as required.<br>';
} else {
    $cost_per_night = 0;
    if (isset($r[1])) { // Wisteria
        $w_guests_remaining = $w_guests_remaining - 2;
        $guests_remaining = $guests_remaining - 2;
       	$cost_per_night = $cost_per_night + $wgb_rate;
       	$w_cost_per_night = $w_cost_per_night + $w_wgb_rate;
    }
    if (isset($r[2])) { // Gardeners Bothy
        $w_guests_remaining = $w_guests_remaining - 2;
        $guests_remaining = $guests_remaining - 2;
       	$cost_per_night = $cost_per_night + $wgb_rate;
       	$w_cost_per_night = $w_cost_per_night + $w_wgb_rate;
    }
    if (isset($r[5])) { // Imogens Cabin        $w_guests_remaining = $w_guests_remaining - 2;        $guests_remaining = $guests_remaining - 2;       	$cost_per_night = $cost_per_night + $ic_rate;       	$w_cost_per_night = $w_cost_per_night + $w_ic_rate;    }    if (isset($r[3])) { // The Smithy
        if ($guests_remaining < 2) {
        	$cost_per_night = $cost_per_night + $smithy_rate[1];
        	$w_cost_per_night = $w_cost_per_night + $w_smithy_rate[1];
        	$w_guests_remaining = 0;
        	$guests_remaining = 0;
        } else
		{
        	$w_guests_remaining = $w_guests_remaining - 2;
			$guests_remaining = $guests_remaining - 2;
			$cost_per_night = $cost_per_night + $smithy_rate[2];
			$w_cost_per_night = $w_cost_per_night + $w_smithy_rate[2];
		}
    }
    if (($guests_remaining > 0) && ($non_winter_nights > 0)) {
        $cost_per_night = $cost_per_night + ($guests_remaining * $extra_guests_rate);
        if ($non_winter_nights == $n) { // no winter tariff nights
	        if ($guests_remaining > 1) {
	    		$additional_info .= 'Includes '.$guests_remaining.' additional guests at £'.$extra_guests_rate.' per guest per night.<br>';
	        } else {
	        	$additional_info .= 'Includes one additional guest at £'.$extra_guests_rate.' per night.<br>';
	        }
        } else { // this booking has both winter tariff and non winter tariff nights
	        $nights_txt = $non_winter_nights > 1 ? $non_winter_nights.' nights' : 'one night';
        	if ($guests_remaining > 1) {
	    		$additional_info .= 'Includes '.$guests_remaining.' additional guests at £'.$extra_guests_rate.' per guest for '.$nights_txt.'.<br>';
	        } else {
	        	$additional_info .= 'Includes one additional guest at £'.$extra_guests_rate.' for '.$nights_txt.'.<br>';
	        }
        }
    }
    if (($w_guests_remaining > 0) && ($winter_nights > 0)) { 
        $w_cost_per_night = $w_cost_per_night + ($w_guests_remaining * $w_extra_guests_rate);
        if ($winter_nights == $n) { // all winter tariff nights
	        if ($w_guests_remaining > 1) {
	    		$additional_info .= 'Includes '.$w_guests_remaining.' additional guests at £'.$w_extra_guests_rate.' per guest per night.<br>';
	        } else {
	        	$additional_info .= 'Includes one additional guest at £'.$w_extra_guests_rate.' per night.<br>';
	        }
        } else { // this booking has both winter tariff and non winter tariff nights
	        $w_nights_txt = $winter_nights > 1 ? $winter_nights.' nights' : 'one night';
        	if ($w_guests_remaining > 1) {
	    		$additional_info .= 'Includes '.$w_guests_remaining.' additional guests at £'.$w_extra_guests_rate.' per guest for '.$w_nights_txt.'.<br>';
	        } else {
	        	$additional_info .= 'Includes one additional guest at £'.$w_extra_guests_rate.' for '.$w_nights_txt.'.<br>';
	        }
        }
    }
}if (isset($r[4])) { // Flo's Cabin	$cost_per_night = $cost_per_night + $fc_rate;	$w_cost_per_night = $w_cost_per_night + $w_fc_rate;	$additional_info .= 'Includes '.$fc.' additional guests in Flo&#039;s Cabin.<br>';}if (isset($o[3])) {	$cost_per_night = $cost_per_night + $dog_rate;	$w_cost_per_night = $w_cost_per_night + $dog_rate;		$additional_info .= 'Includes £'.$dog_rate.' per night pet supplement.<br>';}
$price = 0;
$price = $price + ($cost_per_night * $non_winter_nights) + ($w_cost_per_night * $winter_nights);
if ($lp > 0) {
	$price = $price + ($lp * $legoland_price);
}if ((isset($o[4])) && ($n == 2)) { // Hen/Stag Party special offer applies
    //$price = number_format(($price*0.75),2,'.','');
    $price = $price - 100; // changed from %discount to £100 off.
    $tariff = '7'; // negotiated tariff
    $additional_info .= 'Hen/Stag/Reunion Deal applied.<br>';
}
if (($ap != null) && ($ap != '')) { // there is an agreed price, which overrides the calculated price
    $price = number_format($ap,2,'.','');
    $ap = $price;
    $tariff = '5'; // negotiated tariff
    $additional_info = 'Based on a negotiated tariff.<br>';
}
if ($winter_nights > 0) {
	$additional_info .= 'Based on Winter Tariff.<br>';
}
if ($lp > 0) {
	// make sure admin gets notified in console
    if ($lp > 1) {
		$additional_info .= 'Includes '.$lp.' x 2-day Legoland passes.<br>';
    } else {
    	$additional_info .= 'Includes one 2-day Legoland pass.<br>';
    }
}$deposit = round($price * $deposit_rate, 2);
$balance = $price - $deposit;
?>