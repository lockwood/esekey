<?php
// +----------------------------------------------------------------------+
// | GETBOOKINGDATA  - Esekey Admin Console get booking view              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getbookingdata.php,v 1.08 2006/11/25
//

// For current booking list, exclude cancelled bookings
if ($searchstring1 == ' AND t1.departure_date >= now()')
{
	$searchstring1 .= ' AND t1.booking_status  <> "Cancelled"';
}
if (isset($_GET['bb']))
{
	$searchstring1 .= ' AND t1.booking_type  = 2';
} else
{
	$searchstring1 .= ' AND t1.booking_type  = 1';
}

// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(t4.property_number, ' ', t4.property_name)) AS property_name";
} else
{
	$name_select = "t4.property_name";
}

// get view data and initialise array
$viewarray = $db_object->getAll("SELECT DISTINCT 
                                         t1.booking_reference,
                                         t1.contact_id AS customer_id,
                                         t1.guest_id,
                                         t2.title,
                                         t2.first_name,
                                         t2.last_name,
                                         t2.post_address,
                                         t2.post_code,
                                         t2.telephone,
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
                                         t1.created_date,
                                         t1.last_modified_on,
                                         t1.last_modified_by
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
                                     AND t1.booking_reference = t3.booking_reference
                                     AND t3.resource_id = t4.property_id
                                     AND t1.booking_reference = t5.booking_reference 
                                     ".$searchstring1."
                                     ORDER BY t1.arrival_date, t1.booking_reference");
$columns = $viewarray[0];
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
$i = 0;
foreach($viewarray as $viewrow) {
    if ($viewrow['booking_reference'] != $current_reference) {// new booking row
        $current_reference = $viewrow['booking_reference'];
        $newviewarray[$i] = $viewrow;
        $i++;
    } else { // booking row already exists - add property name to previous row
        $newviewarray[$i-1]['property_name'].= '<br>'.$viewrow['property_name'];
    }
}
if ($i > 0) { //array is not empty
    // echo 'viewarray created with '.$i.' rows<br>';
    $viewarray = $newviewarray;
}
?>