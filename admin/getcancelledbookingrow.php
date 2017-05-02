<?php
// +----------------------------------------------------------------------+
// | GETCANCELLEDBOOKINGDATA  - Esekey Admin Console get booking view     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2011 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getcancelledbookingdata.php,v 1.0 2011/08/15
//
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
                                         t2.telephone_alt,
                                         t2.email,
                                         t3.email_body AS property_name,
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
                                    FROM booking AS t1,
                                         customer AS t2,
                                         email AS t3,
                                         payment AS t5
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.company_id = t5.company_id
                                     AND t1.contact_id = t2.customer_id
                                     AND t1.booking_reference = '".$value."'
                                     AND t1.booking_reference = t3.booking_reference
                                     AND t3.email_sequence = 1
                                     AND t1.booking_reference = t5.booking_reference 
                                     ORDER BY t1.arrival_date");
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
// apartment name needs to be formatted after extraction from email_body
foreach($viewarray as $i=>$viewrow) {
    $bits = explode('<tr>',$viewrow['property_name']);
    //property name is in row 6
	if (count($bits) > 5) {
	    $unformatted_name = explode('<td align="right"><b>',$bits[6]);
	    if (count($unformatted_name) > 1) {
	    	$formatted_name = substr($unformatted_name[1], 0, strpos($unformatted_name[1],'</b>'));
	    } else {
	    	$formatted_name = 'Unknown';
	    }
	} else {
		$formatted_name = 'Unknown';
	}
	$viewarray[$i]['property_name'] = $formatted_name;
	// booking is cancelled - don't show card details
	$viewarray[$i]['deposit_field1'] = 'Deleted';
}
$viewrows = $viewarray;
?>