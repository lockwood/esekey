<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 7                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 7/price.php,v 1.06 2007/05/04
//
// Data
// $start_date: booking start in CCYY-MM-DD format
// $n: Number of nights
// $r[]: Property array.  [1] = 26 New Road
// $g: Number of guests
//
// Processing Logic
// 1. identify basic charge.
//    If there is an exception rate (e.g. rowing tariff) check for this first
//    Else determine charge rate from $n, $start_date and $r[]
// 2. calculate base cost
// 3. Apply any additional costs, discounts and surcharges


// 1. No exception rates for 26 New Road
// 1(a)Get Current Daily rates array (charge type 1; may be 11 when extra properties added)

/*
 * Replaced DB pricing with inline code for individual days after request from RJS to change rates
 * 
 * $rates = $db_object->getAll("SELECT t2.charge_from,
 * 
							   		t2.charge_amount, 		
							  		t2.charge_parameter as max_nights		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 1
                              AND 	t2.charge_from <= '".$start_date."'
                         ORDER BY 	t2.charge_from, t2.charge_parameter
							");

// 1(b) Calculate daily rate based on $n, number of nights requested
$rate = 0;
$min_nights = 0;
$charge_from = 0;
for ($ct=0; $ct<count($rates); $ct++)
{
	if ($charge_from != $rates[$ct]['charge_from'])
	{
		$charge_from = $rates[$ct]['charge_from'];
		$min_nights = 0;
	}
	if (($start_date > $rates[$ct]['charge_from']) && ($rates[$ct]['max_nights'] >= $n) && $min_nights < $n)
	{
		$rate = $rates[$ct]['charge_amount'];
//		echo "Rate: ".$rate;
	}
	$min_nights = $rates[$ct]['max_nights'];
} */

// 1(a)Set up static Current Daily rates array (was charge type 1; may be 11 when extra properties added)

$rates = array(0,105,100,89,87,85,80,76,73,70,67,64,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43);

// 1(b) Calculate daily rate based on $n, number of nights requested

$rate = 43;
if ($n < count($rates)) {
	$rate = $rates[$n];
}

// 1(c) Get supplementary rates array (charge type 6)
$supp_rates = $db_object->getAll("SELECT t2.charge_from,
							   		t2.charge_amount, 		
							  		t2.charge_parameter as base_guests		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 6
                              AND 	t2.charge_from <= '".$start_date."'
                         ORDER BY 	t2.charge_from, t2.charge_parameter
							");

// 1(d) Find most recent supplementary rate per person (last row in array)
$supp_rate = 5; // default in case none provided in DB
$base_guests = 1; // default in case none provided in DB
if (count($supp_rates) > 0)
{
	$selected_row = count($supp_rates) - 1;
	$supp_rate = $supp_rates[$selected_row]['charge_amount'];
	$base_guests = $supp_rates[$selected_row]['base_guests'];
}
$rowing_rate = 18;
$smithy_rate = 60;
$wgb_rate = 78;
$wgb_supp_rate = 12;

// 2. We now have all the base rates - calculate the cost

$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';
if (isset($o[4])) { // rowing special offer - $rowing_rate; N/A for 26 New Road
    if ($g < 8) { // offer only valid for 8 or more people
        $error1.='Not enough guests to qualify for rowing offer.<br />';
        return;
    } else {
        $tariff = '3'; // rowing tariff
        $cost_per_night = $g * $rowing_rate;
        $additional_info .= 'Based on special price for rowing group. We reserve the right to change the selected apartments for rowing groups to fit in with other bookings as required.<br />';
    }    
} else {
    $guests_remaining = $g;
    $cost_per_night = 0;
    if (isset($r[3])) { // Not Known; N/A for 26 New Road 
        $guests_remaining = $guests_remaining - $base_guests;
        $cost_per_night = $cost_per_night + $smithy_rate;
        if ((!isset($r[1])) && (!isset($r[2]))) {
            if ($guests_remaining > 0) { // more than 2 adults
                $error1.='Not Known has a maximum of two adult guests.<br />';
                return;
            }
        } else { // 40% reduction per night if Smithy booked in conjunction with other apartment
            $tariff = '2'; // Combined tariff  
            $additional_info .= 'Price based on The Smithy in conjunction with another apartment.<br />';
            $cost_per_night = $cost_per_night - ($smithy_rate * 0.4);
        }
    }
    if (isset($r[1])) { // 26 New Road
        $guests_remaining = $guests_remaining - $base_guests;
        $cost_per_night = $cost_per_night + $rate;
        // echo '26 New Road base cost = '.$cost_per_night;
        if ($guests_remaining > 0) {
            if (!isset($r[2])) { //all remaining adults in 26 New Road
                if ($guests_remaining > 4) { // too many to fit in 
                    $error1.='26 New Road has a maximum of five adult guests.<br />';
                    return;
                } else {
                    $cost_per_night = $cost_per_night + ($guests_remaining * $supp_rate);
                    // echo '26 New Road final cost = '.$cost_per_night;
                }
            }
        }
    }
    if (isset($r[2])) { // Primrose House
        $guests_remaining = $guests_remaining - 2;
        $cost_per_night = $cost_per_night + $wgb_rate;
        // echo 'GB base cost = '.$cost_per_night;
        if ($guests_remaining > 0) { // all remaining adults in Gardeners Bothy
            if (($guests_remaining > 4) && (!isset($r[1]))) { // too many to fit in GB 
                $error1.='Primrose House has a maximum of six adult guests.<br />';
                return;
            } else {
                if ($guests_remaining > 6) { // too many to fit in GB + W
                    $error1.='Not Known and 26 New Road have a maximum of ten adult guests.<br />';
                    return;
                }
                $cost_per_night = $cost_per_night + ($guests_remaining * $wgb_supp_rate);
                // echo 'GB final cost = '.$cost_per_night;
            }
        }
    }
}
$price = $cost_per_night * $n;

// 3. Apply any additional costs, discounts and surcharges
// 3(a) Apply any optional extras

foreach ($labels as $index=>$label)
{
	if (isset($o[$index])) { // daily optional extra chosen
		if (isset($percents[$index])) { // percent surcharge chosen
			$price = $price + round($price * $percents[$index]/100, 2);
			$additional_info .= 'Includes '.$label.'<br />';
		} else { // daily optional extra chosen
			$price = $price + ($n * $dailies[$index]);
			$additional_info .= 'Includes '.$label.'<br />';
		}
	}
}
		
// 3(b) Get discount rates array (charge type 4)
$discounts = $db_object->getAll("SELECT t2.charge_from,
							   		t2.charge_amount 		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 4
                              AND 	t2.charge_from <= '".$start_date."'
                         ORDER BY 	t2.charge_from
							");

// 3(c) Find most recent discount rate (last row in array)
$discount = 0; // default in case none provided in DB
if (count($discounts) > 0)
{
	$selected_row = count($discounts) - 1;
	$discount = $discounts[$selected_row]['charge_amount'];
}
if ($discount > 0)
{
	$price = round($price * (100.00 - $discount)/100, 2);
    $additional_info .= 'Includes seasonal discount of '.$discount.'%.<br />';
}

if (($ap != null) && ($ap != '')) { // there is an agreed price, which overrides the calculated price
    $price = number_format($ap,2,'.','');
    $ap = $price;
    $tariff = '5'; // negotiated tariff
    $additional_info .= 'Based on a negotiated tariff.<br />';
} 
$deposit = round($price * $deposit_rate, 2);
$balance = $price - $deposit;
?>