<?php
// +----------------------------------------------------------------------+
// | GETCLEANINGDATA  - Esekey Admin Console get data for AW cleaning rota|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getcleaningdata.php,v 1.00 2007/10/08
//


// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(t4.property_number, ' ', t4.property_name)) AS property_name";
} else
{
	$name_select = "t4.property_name";
}

if (isset($_GET[start_date]))
{
	$_SESSION[$ss]['start_date'] = $_GET[start_date];
} else
{
	$_SESSION[$ss]['start_date'] = date('Y-m-d H:i:s');
}

// get view data and initialise array
$viewarray = $db_object->getAll("SELECT DISTINCT 
										 DATE_FORMAT(t2.booking_date, '%a %d %b') AS booking_date,
                                         ".$name_select.",
                                         t3.number_adults,
                                         t3.number_children,
                                         t3.number_infants,
                                         t1.event_data,
										 t3.arrival_notes,
										 t3.booking_notes
                                    FROM calendar_event AS t1,
                                         calendar_booking AS t2,
										 booking AS t3,
                                         property AS t4
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.company_id = t4.company_id
                                     AND t1.event_date = t2.booking_date
									 AND t2.booking_reference = t3.booking_reference
									 AND t2.booking_date > date_sub('".$_SESSION[$ss]['start_date']."', interval 1 day)
                                     AND t1.resource_id = t2.resource_id
                                     AND t1.resource_id = t4.property_id
                                     AND t1.event_type = 'C'
                                     ORDER BY t2.booking_date, t4.property_name");
//print_r($db_object);

?>