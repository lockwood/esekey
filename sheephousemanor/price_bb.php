<?php
// +----------------------------------------------------------------------+
// | PRICE  - EseSite booking price calculator - Company 4  b&b           |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/price_bb.php,v 1.00 2008/06/15
//
$price = 0;
if ($sgl > 0)
{
	foreach ($price1 as $day_price)
	{
		$price = $price + ($day_price*$sgl);
	}
}
$s2 = $dbl + $twn;
if ($s2 > 0)
{
	foreach ($price2 as $day_price)
	{
		$price = $price + ($day_price*$s2);
	}
}
// FIXME need to use correct price for each day as it can and will vary.
$tariff = '1'; // Assume Standard tariff and update if different
$discount = '0';
$negotiated = '';
$guests_remaining = $g + $c;
$cost_per_night = 0;
if ($sgl > 0) { // Sleeps One
    $guests_remaining = $guests_remaining - $sgl;
    if ($s2 == 0) {
        if ($guests_remaining > 0) { 
            $error1.='Too many guests for the requested number of rooms.<br>';
            return;
        }
    }
}
if ($s2 > 0) { // Sleeps Two
    $guests_remaining = $guests_remaining - ($s2*2);
    if ($guests_remaining > 0) { 
        $error1.='Too many guests for the requested number of rooms.<br>';
        return;
    }
}
if (($ap != null) && ($ap != '')) { // there is an agreed price, which overrides the calculated price
    $price = number_format($ap,2,'.','');
    $ap = $price;
    $tariff = '5'; // negotiated tariff
    $additional_info = 'Based on a negotiated/promotional tariff.<br>';
}
if ($n > 1 && $price > 0)
{ 
	// deposit is equal to cost of first night's accommodation
	$deposit = round($price * (1/$n), 2);
} else
{
	$deposit = $price;
}
$balance = $price - $deposit;
?>
