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
$chalet1_rate = 60; // 86 for Olympics
$chalet2_rate = 120; // 172 for Olympics
$chalet3_rate = 75; // 114 for Olympics
$southlands_rate = 150; // 172 for Olympics
$ww_rate = 140; // 214 for Olympics
// peak rates re-instated for 2014-15$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");$chalet1_rate_p = 70; // 86 for Olympics$chalet2_rate_p = 120; // 172 for Olympics$chalet3_rate_p = 85; // 114 for Olympics$southlands_rate_p = 170; // 172 for Olympics$ww_rate_p = 140; // 214 for Olympics$peak_rate = false;$peak_start = array();$peak_end = array();// latest peak dates here$peak_start[] = '2017-06-12';$peak_end[] = '2017-09-07';$peak_start[] = '2017-12-21';$peak_end[] = '2018-01-05';$peak_start[] = '2018-06-18';$peak_end[] = '2018-09-09';$peak_start[] = '2018-12-19';$peak_end[] = '2019-01-06';$peak_days = 0;for ($i=0;$i<count($peak_start);$i++){	if ($start_date < $peak_end[$i] && $end_date > $peak_start[$i])	{		// falls within a peak period		for ($j=0;$j<$n;$j++)		{			$test_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$j."' day)");			if (!($test_date < $peak_start[$i]) && ($test_date < $peak_end[$i]))			{				$peak_days++;			}		}	}}$olympic_nights = 0;/*if (isset($_GET['n'])) {	// echo 'end_date='.$end_date.'; start_date='.$start_date;	if ($end_date > '2018-06-17' && $start_date < '2018-07-02') {		// Olympic rates and restrictions apply		$day = $start_date;		for ($i=0;$i<$n;$i++) {			if ($day > '2018-06-17' && $day < '2018-07-02') {				$olympic_nights++;			}			$day = date('Y-m-d', strtotime($day.' + 1 day'));		}	}}// *///if ($olympic_nights > 0 && $n < 7) {//	$error1 = 'Olympics booking restrictions apply (26 Jul - 12 Aug 2012).<br>Any Olympics booking must include a minimum of 7 nights.<br>';//}$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';
$guests_remaining = $g + $c;
$cost_per_night = 0;$cost_per_night_p = 0;
if (isset($r[1])) { // Chalet One
    $guests_remaining = $guests_remaining - 2;
    $cost_per_night = $cost_per_night + $chalet1_rate;    $cost_per_night_p = $cost_per_night_p + $chalet1_rate_p;    
    if ((!isset($r[2])) && (!isset($r[3])) && (!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) {
        if ($guests_remaining > 0) { // more than 2 adults
            $error1.='Cottage One has a maximum of two adult guests.<br>';
            return;
        }
    }
}
if (isset($r[2])) { // Chalet Two
    $guests_remaining = $guests_remaining - 5;
    $cost_per_night = $cost_per_night + $chalet2_rate;    $cost_per_night_p = $cost_per_night_p + $chalet2_rate_p;    
    if ($guests_remaining > 0) {
        if ((!isset($r[3])) && (!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Two
            $error1.='Cottage Two has a maximum of five adult guests.<br>';
            return;
        }
    }
}
if (isset($r[3])) { // Chalet Three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;    $cost_per_night_p = $cost_per_night_p + $chalet3_rate_p;    
    if ($guests_remaining > 0) {
        if ((!isset($r[4])) && (!isset($r[5])) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Three
            $error1.='Cottage Three has a maximum of three adult guests.<br>';
            return;
        }
    }
}
if (isset($r[4])) { // Chalet Four - same rate as chalet three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;    $cost_per_night_p = $cost_per_night_p + $chalet3_rate_p;    
    if ($guests_remaining > 0) {
        if (!isset($r[5]) && (!isset($r[9])) && (!isset($r[10]))) { //all remaining adults in Chalet Four
	        $error1.='Cottage Four has a maximum of three adult guests.<br>';
    	    return;
        }
    }
}
if (isset($r[10])) { // Chalet Five - same rate as chalet three
    $guests_remaining = $guests_remaining - 3;
    $cost_per_night = $cost_per_night + $chalet3_rate;    $cost_per_night_p = $cost_per_night_p + $chalet3_rate_p;    
    if ($guests_remaining > 0) {
        if (!isset($r[5]) && (!isset($r[9]))) { //all remaining adults in Chalet Five
	        $error1.='Cottage Five has a maximum of three adult guests.<br>';
    	    return;
        }
    }
}
if (isset($r[5])) { // Southlands Cottage 	/*
    if ($n < 28) { // minimum stay 4 weeks for Southlands    	$error1.='Southlands Cottage has a minimum stay of four weeks.<br>';    	return;    }	// */	$guests_remaining = $guests_remaining - 4;
    $cost_per_night = $cost_per_night + $southlands_rate;    $cost_per_night_p = $cost_per_night_p + $southlands_rate_p;    
    if ($guests_remaining > 0) {
        if (!isset($r[9])) { //all remaining adults in Southlands Cottage
    		$error1.='Southlands Cottage has a maximum of four adult guests.<br>';
        	return;
        }
    }
}
if (isset($r[9])) { // The West Wing 
    $guests_remaining = $guests_remaining - 6;
    $cost_per_night = $cost_per_night + $ww_rate;    $cost_per_night_p = $cost_per_night_p + $ww_rate_p;    
    if ($guests_remaining > 0) {
        $error1.='The West Wing has a maximum of six adult guests.<br>';
        return;
    }
}
if ($peak_days > 0) {	$price = ($cost_per_night_p * $peak_days) + ($cost_per_night * ($n - $peak_days)); } else {
	$price = $cost_per_night * $n;}

if ($olympic_nights > 0) {
	// Olympic rates apply - double price
	//$chalet1_rate = 60; // 86 for Olympics
	//$chalet2_rate = 110; // 172 for Olympics
	//$chalet3_rate = 75; // 114 for Olympics
	//$southlands_rate = 120; // 172 for Olympics
	//$ww_rate = 140; // 214 for Olympics
	if (isset($r[1])) { // Chalet One 
		$price = $price + ($olympic_nights * 25);
	}
	if (isset($r[2])) { // Chalet Two
		$price = $price + ($olympic_nights * 60);
	}
	if (isset($r[3])) { // Chalet Three
		$price = $price + ($olympic_nights * 65);
	}
	if (isset($r[4])) { // Chalet Four
		$price = $price + ($olympic_nights * 65);
	}
	if (isset($r[10])) { // Cottage 5
		$price = $price + ($olympic_nights * 65);
	}
	if (isset($r[9])) { // The West Wing - add £270 per day
		$price = $price + ($olympic_nights * 135);
	}
    $additional_info .= 'Based on extra peak tariff.<br>';
}

//*

/* no 10% .....
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
// */

if (($peak_days > 0) && ($olympic_nights == 0))
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
