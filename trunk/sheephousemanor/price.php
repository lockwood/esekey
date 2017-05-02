<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 4                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/price.php,v 1.04 2006/09/03
//

$chalet1_rate = 50; // 86 for Olympics
$chalet2_rate = 100; // 172 for Olympics
$chalet3_rate = 65; // 114 for Olympics
$southlands_rate = 110; // 172 for Olympics
$ww_rate = 125; // 214 for Olympics
// set up end dates in price array to make logic easier
/*
for ($i=0;$i<count($pricearray);$i++) {
	$pricearray[$i]['end_date'] = '';
	$j=$i+1;
	while ($pricearray[$i]['end_date'] == '') {
		if ($j < count($pricearray)) {
			if ($pricearray[$j]['price_code'] == $pricearray[$i]['price_code']) {
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

foreach($pricearray as $pricerow) {
    if (($pricerow[start_date] <= $start_date) && ($pricerow[end_date] >= $start_date)) {
        if ($pricerow[price_code] == 'A') {
            $chalet1_rate = $pricerow[daily_rate];
        } elseif ($pricerow[price_code] == 'B') {
            $chalet2_rate = $pricerow[daily_rate];
        } elseif ($pricerow[price_code] == 'C') {
            $chalet3_rate = $pricerow[daily_rate];
        } elseif ($pricerow[price_code] == 'F') {
            $southlands_rate = $pricerow[daily_rate];
        }
    }
}
// */
$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';
$guests_remaining = $g + $c;
$cost_per_night = 0;
if (isset($r[1])) { // Chalet One
    $guests_remaining = $guests_remaining - 2;
    $cost_per_night = $cost_per_night + $chalet1_rate;
    if ((!isset($r[2])) && (!isset($r[3])) && (!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) {
        if ($guests_remaining > 0) { // more than 2 adults
            $error1.='Cottage One has a maximum of two adult guests.<br>';
            return;
        }
    }
}
if (isset($r[2])) { // Chalet Two
    $guests_remaining = $guests_remaining - 5;
    $cost_per_night = $cost_per_night + $chalet2_rate;
    if ($guests_remaining > 0) {
        if ((!isset($r[3])) && (!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Two
            $error1.='Cottage Two has a maximum of five adult guests.<br>';
            return;
        }
    }
}
if (isset($r[3])) { // Chalet Three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;
    if ($guests_remaining > 0) {
        if ((!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Three
            $error1.='Cottage Three has a maximum of three adult guests.<br>';
            return;
        }
    }
}
if (isset($r[4])) { // Chalet Four - same rate as chalet three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;
    if ($guests_remaining > 0) {
        if (!isset($r[5]) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Four
	        $error1.='Cottage Four has a maximum of three adult guests.<br>';
    	    return;
        }
    }
}
if (isset($r[10])) { // Chalet Five - same rate as chalet three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;
    if ($guests_remaining > 0) {
        if (!isset($r[5]) && (!isset($r[9]))) { //all remaining adults in Chalet Five
	        $error1.='Cottage Five has a maximum of three adult guests.<br>';
    	    return;
        }
    }
}
if (isset($r[5])) { // Southlands Cottage 
    $guests_remaining = $guests_remaining - 5;
    $cost_per_night = $cost_per_night + $southlands_rate;
    if ($guests_remaining > 0) {
        if (!isset($r[9])) { //all remaining adults in Southlands Cottage
    		$error1.='Southlands Cottage has a maximum of five adult guests.<br>';
        	return;
        }
    }
}
if (isset($r[9])) { // The West Wing 
    $guests_remaining = $guests_remaining - 6;
    $cost_per_night = $cost_per_night + $ww_rate;
    if ($guests_remaining > 0) {
        $error1.='The West Wing has a maximum of six adult guests.<br>';
        return;
    }
}

$price = $cost_per_night * $n;

if ($olympic_nights > 0) {
	// Olympic rates apply - double price
	//$chalet1_rate = 60; // 86 for Olympics
	//$chalet2_rate = 110; // 172 for Olympics
	//$chalet3_rate = 75; // 114 for Olympics
	//$southlands_rate = 120; // 172 for Olympics
	//$ww_rate = 140; // 214 for Olympics
	if (isset($r[1])) { // Chalet One 
		$price = $price + ($olympic_nights * 26);
	}
	if (isset($r[2])) { // Chalet Two
		$price = $price + ($olympic_nights * 62);
	}
	if (isset($r[3])) { // Chalet Three
		$price = $price + ($olympic_nights * 39);
	}
	if (isset($r[4])) { // Chalet Four
		$price = $price + ($olympic_nights * 39);
	}
	if (isset($r[5])) { // Southlands
		$price = $price + ($olympic_nights * 52);
	}
	if (isset($r[9])) { // The West Wing - add £270 per day
		$price = $price + ($olympic_nights * 74);
	}
    $additional_info .= 'Based on Olympics tariff.<br>';
}

/*
// peak rates removed - simplified High Season/Low Season prices in price table for 2010.
$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");
$peak_rate = false;

// temporary fix pending implementation of charge and rates tables for Sheephouse
// 20% first
$peak_start = array();
$peak_end = array();
// latest peak dates here
$peak_start[] = '2009-02-14';
$peak_end[] = '2009-02-21';
$peak_start[] = '2009-06-13';
$peak_end[] = '2009-06-20';
$peak_start[] = '2009-06-27';
$peak_end[] = '2009-07-04';
$peak_start[] = '2009-07-18';
$peak_end[] = '2009-09-02';
$peak_start[] = '2009-10-25';
$peak_end[] = '2009-11-01';
$peak_start[] = '2009-12-20';
$peak_end[] = '2010-01-04';
$peak_start[] = '2010-04-01';
$peak_end[] = '2010-04-17';
$peak_start[] = '2010-05-29';
$peak_end[] = '2010-06-05';
$peak_start[] = '2010-06-12';
$peak_end[] = '2010-06-19';
$peak_start[] = '2010-06-26';
$peak_end[] = '2010-09-09';

$peak_days = 0;
for ($i=0;$i<count($peak_start);$i++)
{
	if ($start_date < $peak_end[$i] && $end_date > $peak_start[$i])
	{
		// falls within a peak period
		for ($j=0;$j<$n;$j++)
		{
			$test_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$j."' day)");
			if (!($test_date < $peak_start[$i]) && ($test_date < $peak_end[$i]))
			{
				$peak_days++;
			}
		}
	}
}

if ($peak_days > 0)
{
	$peak_rate = true;
	// add 20% for each peak day
	$price = $price + round($cost_per_night * $peak_days * 0.2, 2);
}


// Do it again for 10%
$peak_start = array();
$peak_end = array();
// latest peak dates here
$peak_start[] = '2010-02-13';
$peak_end[] = '2010-02-20';

$peak_days = 0;

for ($i=0;$i<count($peak_start);$i++)
{
	if ($start_date < $peak_end[$i] && $end_date > $peak_start[$i])
	{
		// falls within a peak period
		for ($j=0;$j<$n;$j++)
		{
			$test_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$j."' day)");
			if (!($test_date < $peak_start[$i]) && ($test_date < $peak_end[$i]))
			{
				$peak_days++;
			}
		}
	}
}

if ($peak_days > 0)
{
	$peak_rate = true;
	// add 10% for each peak day
	$price = $price + round($cost_per_night * $peak_days * 0.1, 2);
}


if ($peak_rate)
{
	$additional_info .= 'Based on peak rate.<br>';
}

// */



// Apply any optional extras

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
		
if (($ap != null) && ($ap != '')) { // there is an agreed price, which overrides the calculated price
    $price = number_format($ap,2,'.','');
    $ap = $price;
    $tariff = '5'; // negotiated tariff
    $additional_info .= 'Based on a negotiated tariff.<br>';
} 
$deposit = round($price * $deposit_rate, 2);
$balance = $price - $deposit;
?>
