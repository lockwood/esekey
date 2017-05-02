<?php
// +----------------------------------------------------------------------+
// | GETBBPRICEDATA  - Sheephouse Manor co 4 get data for B&B prices      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/getbbpricedata.php,v 1.00 2008/06/08
//

// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(t4.property_number, ' ', t4.property_name)) AS property_name";
} else
{
	$name_select = "t4.property_name";
}


// get view data and initialise array
$view_all = $db_object->getAll("SELECT DISTINCT
										 t2.resource_id,
										 t2.booking_date, 
										 DATE_FORMAT(t2.booking_date, '%a %d %b %y') AS display_date,
                                         ".$name_select.",
										 t4.sleeps,
										 t4.active_flag,
										 t3.display_status,
										 t3.booking_reference
                                    FROM calendar_booking AS t2,
										 booking AS t3,
                                         property AS t4
                                   WHERE t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t2.company_id = t3.company_id
                                     AND t2.company_id = t4.company_id
									 AND t2.booking_reference = t3.booking_reference
									 AND t2.booking_date > date_sub('".$start_date."', interval 1 day)
									 AND t2.booking_date < date_add('".$start_date."', interval '".$n."' day)
                                     AND t2.resource_id = t4.property_id
									 AND t4.sleeps < 3
                                     ORDER BY t2.booking_date, t4.sleeps, t4.property_name");

$combined_resourcearray = $db_object->getAll("SELECT * 
									 FROM property
									WHERE company_id = '".$_SESSION[$ss]['company_id']."'
									  AND (active_bb = 'Y' OR active_flag = 'Y')
									  AND sleeps < 3
									  ORDER BY sleeps ASC, active_bb DESC, property_id DESC");

$price_1 = (int)$db_object->getOne("SELECT daily_rate FROM price WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND price_code = 'D'");
$price_2 = (int)$db_object->getOne("SELECT daily_rate FROM price WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND price_code = 'E'");
//$pricearray = $db_object->getAll("SELECT * FROM price WHERE company_id = '".$_SESSION[$ss]['company_id']."' ORDER BY price_code, start_date, max_nights");
// FIXME need to use correct price for each day as it can and will vary.

$view_prices = $db_object->getAll("SELECT * 
									 FROM calendar_event
									WHERE company_id = '".$_SESSION[$ss]['company_id']."'
									  AND event_type = 'B'
									  AND event_date > date_sub('".$start_date."', interval 1 day)
									  AND event_date < date_add('".$start_date."', interval '".$n."' day)");

$date_price = array();
foreach ($view_prices as $view_price)
{
	$date_price[$view_price['event_date']][$view_price['resource_id']] = explode(',',$view_price['event_data']);
}
//print_r($date_price);
//die;

$viewarray = array();
foreach ($view_all as $row)
{
	$viewarray[$row['booking_date']][$row['property_name']] = $row['display_status'];
	$viewarray[$row['booking_date']][$row['property_name'].'_ref'] = $row['booking_reference'];
	$viewarray[$row['booking_date']]['display_date'] = $row['display_date'];
	/* previous version was for sleeps 1 and sleeps 2 only
	if (isset($date_price[$row['booking_date']][$row['resource_id']]))
	{
		if ($row['sleeps'] ==1)
		{
			// b&b sleeps 1 price only
			$viewarray[$row['booking_date']]['price_1'] = $date_price[$row['booking_date']][$row['resource_id']][0];
		} elseif ($row['active_flag'] == 'N')
		{
			// b&b sleeps 2 price only
			$viewarray[$row['booking_date']]['price_2'] = $date_price[$row['booking_date']][$row['resource_id']][0];
		} else
		{
			// sc - both sleeps 1 and 2 prices
			$viewarray[$row['booking_date']]['price_1'] = $date_price[$row['booking_date']][$row['resource_id']][0];
			$viewarray[$row['booking_date']]['price_2'] = $date_price[$row['booking_date']][$row['resource_id']][1];
		}
		$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = true;
	} else
	{
		if ($row['sleeps'] ==1)
		{
			// b&b sleeps 1 price only
			$viewarray[$row['booking_date']]['price_1'] = $price_1;
			$date_price[$row['booking_date']][$row['resource_id']][0] = $price_1;
			$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = true;
		} elseif ($row['active_flag'] == 'N')
		{
			// b&b sleeps 2 price only
			$viewarray[$row['booking_date']]['price_2'] = $price_2;
			$date_price[$row['booking_date']][$row['resource_id']][0] = $price_2;
			$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = true;
		} else
		{
			// sc - not specified for B&B
			$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = false;
		}
		
	}
	// */
	//  new version allows for sleeps 1, double and twin options for sleeps 2
	if (isset($date_price[$row['booking_date']][$row['resource_id']]))
	{
		// fix for data transition problem
		if (count($date_price[$row['booking_date']][$row['resource_id']]) > 1) {
			$viewarray[$row['booking_date']]['price_1'] = $date_price[$row['booking_date']][$row['resource_id']][0];
			$viewarray[$row['booking_date']]['price_2'] = $date_price[$row['booking_date']][$row['resource_id']][1];
		} else {
			if ($row['property_name'] == 'Dbl') {
				$viewarray[$row['booking_date']]['price_1'] = $price_1;
				$viewarray[$row['booking_date']]['price_2'] = $date_price[$row['booking_date']][$row['resource_id']][0];
			} else {
				$viewarray[$row['booking_date']]['price_1'] = $date_price[$row['booking_date']][$row['resource_id']][0];
				$viewarray[$row['booking_date']]['price_2'] = $price_2;
			}
		}
		$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = true;
	} else
	{
		if ($row['active_flag'] == 'N')
		{
			// b&b options
			$viewarray[$row['booking_date']]['price_1'] = $price_1;
			$viewarray[$row['booking_date']]['price_2'] = $price_2;
			$date_price[$row['booking_date']][$row['resource_id']][0] = $price_1;
			$date_price[$row['booking_date']][$row['resource_id']][1] = $price_2;
			$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = true;
		} else
		{
			// sc - not specified for B&B
			$viewarray[$row['booking_date']][$row['property_name'].'_sel'] = false;
		}
		
	}
}
?>