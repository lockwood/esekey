<?php
// +----------------------------------------------------------------------+
// | GETBOOKINGROW  - Esekey Admin Console get booking view row           |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getbookingrow.php,v 1.04 2006/11/25
//

// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(t4.property_number, ' ', t4.property_name)) AS property_name";
} else
{
	$name_select = "t4.property_name";
}
	
$cleaning_events = $db_object->getAll("SELECT t1.event_date, t2.day_of_week 
										 FROM calendar_event AS t1,
                                              calendar_booking AS t2
										WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     	  AND t1.company_id = t2.company_id
										  AND t1.resource_id = t2.resource_id
										  AND t1.event_type = 'C'
										  AND t1.event_data = 'WS'
										  AND t1.event_date = t2.booking_date
										  AND t2.booking_reference = '".$value."'");	

$cds = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat','N/A');

if (count($cleaning_events) > 0) {
	$cleaning_option = 'Weekly Service';
	$cleaning_day = $cleaning_events[0]['day_of_week'];
} else {
	$cleaning_option = 'No Weekly Service';
	$cleaning_day = 7;
}

// get view row and initialise array
$viewrows = $db_object->getAll("SELECT DISTINCT 
                                         t1.booking_reference,
                                         t1.contact_id AS customer_id,
                                         t1.guest_id,
                                         t2.customer_company_id,
                                         t2.title,
                                         t2.first_name,
                                         t2.last_name,
                                         t2.post_address,
                                         t2.post_code,
                                         t2.telephone,
                                         t2.telephone_alt,
                                         t2.email,
                                         ".$name_select.",
                                         t1.number_adults,
                                         t1.number_children,
                                         t1.number_infants,
                                         (TO_DAYS(t1.departure_date) - TO_DAYS(t1.arrival_date)) AS number_nights,
                                         DATE_FORMAT(t1.arrival_date, '%a %D %b %y') AS arrival_date,
                                         DATE_FORMAT(t1.departure_date, '%a %D %b %y') AS departure_date,
                                         t1.booking_status,
                                         t5.payment_method,
                                         AES_DECRYPT(t5.deposit_box, '".$_SESSION[$ss]['company_id']."') AS deposit_field1,
                                         t5.deposit_field2,
                                         t5.deposit_amount,
                                         t5.balance_amount,
                                         t5.deposit_amount+t5.balance_amount AS total_amount,
                                         t5.tariff,
                                         t5.tariff_field1,
                                         t5.tariff_field2,
                                         t1.booking_notes,
                                         t1.arrival_notes,
										 '".$cleaning_option."' AS cleaning_option,
										 '".$cleaning_day."' AS cleaning_day,
                                         t1.created_date,
                                         t1.last_modified_on,
                                         t1.last_modified_by,
                                         t1.arrival_date AS test_arrive,
                                         t1.departure_date AS test_depart
                                    FROM booking".$_SESSION[$ss]['_test']." AS t1,
                                         customer AS t2,
                                         calendar_booking".$_SESSION[$ss]['_test']." AS t3,
                                         property AS t4,
                                         payment".$_SESSION[$ss]['_test']." AS t5
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.company_id = t4.company_id
                                     AND t1.company_id = t5.company_id
                                     AND t1.contact_id = t2.customer_id
                                     AND t1.booking_reference = '".$value."'
                                     AND t1.booking_reference = t3.booking_reference
                                     AND t3.resource_id = t4.property_id
                                     AND t1.booking_reference = t5.booking_reference 
                                     ORDER BY t1.arrival_date");

if (count($viewrows) < 1) {
	// no results for selected row - must be a cancelled booking and the property has been re-booked
	include ('getcancelledbookingrow.php');
}

$columns = $viewrows[0];
if (count($columns) > 0) {
  foreach ($columns as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
}
// Create array with only one row per booking even for multiple apartments
$current_reference = null;
foreach($viewrows as $viewrow) {
    if ($viewrow['booking_reference'] != $current_reference) {// new booking row
        $current_reference = $viewrow['booking_reference'];
        $newviewrow = $viewrow;
    } else { // booking row already exists - add property name to previous row
        $newviewrow['property_name'].= '<br>'.$viewrow['property_name'];
    }
}
$viewrow = $newviewrow;
$expiry_test = $db_object->getOne("SELECT CURDATE()");
if ($_SESSION[$ss]['company_id'] == '00003') {
	$expiry_test = $db_object->getOne("SELECT DATE_SUB(CURDATE(), INTERVAL 4 day)");
}
if ($viewrow['test_depart'] < $expiry_test)
{
	// booking is in the past - don't show card details
	$viewrow['deposit_field1'] = 'Deleted';
}
if ($view_name == 'newemail')
{
	// got here because user clicked Create Email - 
	// need to create an initial email viewrow from the booking viewrow
	$bookingrow = $viewrow;
	$viewrow = array();
	$column = array();
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/general_email.php'); // generate general email
}

?>