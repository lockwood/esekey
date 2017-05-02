<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 8                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/price.php,v 1.05 2006/02/14
//
// Data
// $start_date: booking start in CCYY-MM-DD format
// $n: Number of nights
// $end_date: booking departure date in CCYY-MM-DD format
// $r[]: Property array.  [1] = Cottage One, etc...
// $g: Number of guests
//
// Processing Logic
// 1. identify basic price.
//    If there is an exception rate (e.g. rowing tariff) check for this first
//    Else determine basic price from $n, $start_date and $r[]
// 2. calculate base cost
// 3. Apply any additional costs, discounts and surcharges


// 1. No exception rates - yet...
// 1(b) Calculate base price
// set up end dates in price array to make logic easier
for ($i=0;$i<count($pricearray);$i++) {
	$pricearray[$i]['end_date'] = '';
	$j=$i+1;
	while ($pricearray[$i]['end_date'] == '') {
		if ($j < count($pricearray)) {
			if ($pricearray[$j]['price_code'] == $pricearray[$j]['price_code']) {
				if ($pricearray[$j]['start_date'] > $pricearray[$i]['start_date']) {
					$pricearray[$i]['end_date'] = $pricearray[$j]['start_date'];
				} 
			} else {
				$pricearray[$i]['end_date'] = '9999-01-01';
			}
		} else {
			$pricearray[$i]['end_date'] = '9999-01-01';
		}
		$j++;
	}
}
$rate = 100; // just in case there are no matching entries in pricearray...
$price = 0;
$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");
foreach ($resourcearray as $propertyrow) { // find selected property
	$i = 1;
	$nights_remaining = $n;
	if (isset($r[$propertyrow['property_id']])) {
		foreach ($pricearray as $pricerow) {
		    if ($pricerow['price_code'] == $propertyrow['price_code']) {
		    	// get daily rate for this row
	        	if ($pricerow['weekly_rate'] > 0) {
	        		$rate = ($pricerow['weekly_rate']/7);
	        	} else {
    	    		$rate = $pricerow['daily_rate'];
        		}
		        if ((($pricerow['start_date'] <= $start_date)
		        && ($pricerow['end_date'] > $start_date))
		        || (($pricerow['start_date'] < $end_date)
		       	&& ($pricerow['end_date'] > $start_date))) {
		        	// this is the rate in effect at the start
		        	// or it comes into effect within the duration
		        	if (($pricerow['max_nights'] >= $n)
		        	&& ($pricerow['end_date'] >= $end_date)) {
		        		// simplest case - single rate for entire duration
	    	    		$price += $rate*$nights_remaining;
	        			$nights_remaining = 0;
		        	} elseif (($pricerow['max_nights'] < $n)
		        	&& ($pricerow['end_date'] >= $end_date)) {
		        		// this rate has a limited number of days
		        		if ($pricerow['cumulative'] == 'Y') {
		        			// use this rate up to max_nights
		        			$price += $rate*($pricerow['max_nights']-($n - $nights_remaining));
		        			$nights_remaining = $n - $pricerow['max_nights'];
		        		}
		        	} elseif (($pricerow['max_nights'] < $n)
		        	&& ($pricerow['end_date'] < $end_date)) {
		        		// this rate has a limited number of days and expires
		        		// find whether expiry is before or after max_nights
						$nights_to_expiry = $db_object->getOne("SELECT (TO_DAYS('".$pricerow['end_date']."') - (TO_DAYS('".$start_date."'))");
						if (($nights_to_expiry <= $pricerow['max_nights'])
						&& ($pricerow['cumulative'] == 'Y')) {
		        			// use this rate up to nights to expiry
		        			$price += $rate*($nights_to_expiry-($n - $nights_remaining));
		        			$nights_remaining = $n - $nights_to_expiry;
						}
						if (($nights_to_expiry > $pricerow['max_nights'])
						&& ($pricerow['cumulative'] == 'Y')) {
		        			// use this rate up to max nights
		        			$price += $rate*($pricerow['max_nights']-($n - $nights_remaining));
		        			$nights_remaining = $n - $pricerow['max_nights'];
						}
		        	} elseif (($pricerow['max_nights'] >= $n)
		        	&& ($pricerow['end_date'] < $end_date)) {
		        		// this rate expires within duration
	        			// use this rate up to expiry
						$nights_to_expiry = $db_object->getOne("SELECT TO_DAYS('".$pricerow['end_date']."') - TO_DAYS('".$start_date."')");
	        			$price += $rate*($nights_to_expiry-($n - $nights_remaining));
	        			$nights_remaining = $n - $nights_to_expiry;
		        	}
	        	}
		    }
		} // end foreach ($pricearray as $pricerow)
		if ($nights_remaining > 0) {
			// there has been a discrepancy - use the last saved rate for the remaining days...
			$price += $rate*$nights_remaining;
		}
	}// end (isset($r[$propertyrow['property_id']]))
}
// 2. We now have all the base rates - calculate the cost

$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';

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