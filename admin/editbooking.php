<?php
// +----------------------------------------------------------------------+
// | EDITBOOKING  - Esekey Admin Console edit booking view                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editbooking.php,v 1.08 2006/11/23
//
$set_tenant = null;
$success = false;
$customer_field_changed = false;
$booking_field_changed = false;
$payment_field_changed = false;
$emailflag = null;
$statusarray = array('Unconfirmed','Deposit Due','Deposit Payment Error','Deposit Paid','Balance Due', 'Balance Payment Error', 'Balance Paid', 'Pay On Arrival', 'Cancelled', 'Expired');
$tariffarray = array('','Standard','Combined','Rowing','Discount','Negotiated','Winter','Hen/Stag');
$typearray = array('','In Total','Per Week','Per Calendar Month');
$cleaningarray = array('','No Weekly Service','Weekly Service');
$cleandayarray = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat','N/A');
$cardarray = array();
include ('cardarray.php');
$nothing_changed = true; // to reset javascript changed flag to false on loading if nothing changed
$date_today = $db_object->getOne("SELECT CURDATE()");
// get list of properties
$propertyarray = $db_object->getAll("SELECT 
                                         property_id,
                                         property_name
                                    FROM property
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND active_flag = 'Y'");
// check for available properties with same booking dates
// to determine whether to show the change property button
$currentpropertyarray = $db_object->getAll("SELECT DISTINCT 
                                         t3.property_id,
                                         t3.property_name
                                    FROM booking".$_SESSION[$ss]['_test']." AS t1,
                                         calendar_booking".$_SESSION[$ss]['_test']." AS t2,
                                         property AS t3
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.booking_reference = t2.booking_reference
                                     AND t2.resource_id = t3.property_id
                                     AND t1.booking_reference = '".$viewrow['booking_reference']."'");
if (count($currentpropertyarray) > 1)
{
	// if more than 1 property on booking, allow properties to be removed
	// check if this field is still editable 
	if ($viewrow['test_depart'] >= $date_today)
	{
		$change_property = true;
	} else 
	{
		$change_property = false;
	}
} else 
{
	$change_property = false;
	foreach ($propertyarray as $propertyrow){
	    $datearray = $db_object->getAll("SELECT t1.day_of_week, 
	                                    DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
	                                    DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
	                                    DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
	                                    t1.booking_reference,
	                                    t2.display_status, 
	                                    t2.expiry
	                               FROM calendar_booking".$_SESSION[$ss]['_test']." AS t1, 
	                                    booking".$_SESSION[$ss]['_test']." AS t2
	                              WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
	                                AND t1.booking_date >= '".$viewrow['test_arrive']."'
	                                AND t1.booking_date < '".$viewrow['test_depart']."'
	                                AND t1.company_id = t2.company_id
	                                AND t1.resource_id = '".$propertyrow['property_id']."'
	                                AND t1.booking_reference = t2.booking_reference");
	   	$available = true;
	    foreach ($datearray as $daterow) {
	    	if ($daterow['booking_reference'] == $viewrow['booking_reference'])
	    	{
	    		// this property is on the current booking
	    		$available = false;
	    	} else
	    	{
	        	if (($daterow['display_status'] != 'E')) { //this date is NOT available 
	            	$available = false;
	        	}
	        }
	    }
	    if ($available && ($viewrow['test_depart'] >= $date_today))
	    {
	    	$change_property = true;
	    }
	}
}

if ($company_contacts)
{
	$company = $db_object->getOne("SELECT customer_company_name
                                    FROM customer_company
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND customer_company_id = '".$viewrow['customer_company_id']."'");
	if ($company == '') $company = 'N/A';
              	
	$tenantrow = $db_object->getRow("SELECT *
                                    FROM customer
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND customer_id = '".$viewrow['guest_id']."'");
	$set_tenant = "SetTenantId('".$viewrow['guest_id']."');";

	$event_type = 'I';
	//TODO include ('geteventarray.php');
	$eventarray = $db_object->getAll("SELECT DISTINCT 
                                         t1.resource_id,
                                         t1.event_date,
                                         t1.event_type,
                                         t1.event_data,
                                         t1.last_modified_on,
                                         t1.last_modified_by
                                    FROM calendar_event AS t1,
                                         calendar_booking AS t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.event_date = t2.booking_date
                                     AND t1.resource_id = t2.resource_id
                                     AND t2.booking_reference = '".$viewrow['booking_reference']."'
									 AND t1.event_type = 'I'");
	$invoicearray = $eventarray;
	
	// make sure that checkboxes are initialised correctly if form not posted yet
	if ($viewrow['tariff'] > '1') {
		$i_rem_selected = 'CHECKED';
	} else {
		$i_rem_selected = '';
	}
}

// check for updated fields
if (isset($posted)) { // if form has been submitted
  for ($i = 0; $i < count($column); $i++) {
    if (isset($_POST[$column[$i]])) {
        $formfield[$i] = stripslashes($_POST[$column[$i]]);
        if (htmlentities($formfield[$i], ENT_QUOTES) != $viewrow[$column[$i]]) { // column is updated;
          if (($column[$i] == 'title')
          or  ($column[$i] == 'first_name')
          or  ($column[$i] == 'last_name')
          or  ($column[$i] == 'post_address')
          or  ($column[$i] == 'post_code')
          or  ($column[$i] == 'telephone')
          or  ($column[$i] == 'email')) {
            // customer table update
            if ($customer_field_changed == false) { // first field
                $customer_field_changed = true;
                $custparms = " SET ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            } else {
                $custparms .= ", ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            }
          } elseif (($column[$i] == 'payment_method')
                or  ($column[$i] == 'deposit_field1')
                or  ($column[$i] == 'deposit_field2')
                or  ($column[$i] == 'tariff_field1')
                or  ($column[$i] == 'tariff_field2')
                or  ($column[$i] == 'deposit_amount')
                or  ($column[$i] == 'balance_amount')) {
            // payment table update
            if ($payment_field_changed == false) { // first field
                $payment_field_changed = true;
	            if ($column[$i] == 'deposit_field1') { // encrypt value for update
    	            $payparms = "SET deposit_box = AES_ENCRYPT('".htmlentities($formfield[$i], ENT_QUOTES)."', '".$_SESSION[$ss]['company_id']."')"; 
        	    } else {
                	$payparms = " SET ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'";
	            } 
            } else {
	            if ($column[$i] == 'deposit_field1') { // encrypt value for update
    	            $payparms .= ", deposit_box = AES_ENCRYPT('".htmlentities($formfield[$i], ENT_QUOTES)."', '".$_SESSION[$ss]['company_id']."')"; 
        	    } else {
                	$payparms .= ", ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'";
	            } 
            }
            if ($column[$i] == 'deposit_amount') { // deposit amount changed - update total amount as well.
                // get balance from POST field, then total = deposit + balance 
                $total = $formfield[$i] + stripslashes($_POST[$column[($i + 1)]]);
                $formfield[($i + 2)] = number_format($total,2);
                // set database value and form value equal
                $viewrow[$column[($i + 2)]] = $formfield[($i + 2)];
            }
            if ($column[$i] == 'balance_amount') { // balance amount changed - update total amount as well.
                // deposit alread set up as formfield so total = balance + deposit
                $total = $formfield[$i] + $formfield[($i - 1)];
                $formfield[($i + 1)] = number_format($total,2);
                $viewrow[$column[($i + 1)]] = $formfield[($i + 1)]; // set database value and form value equal
            }
          } else {
            // booking table update
            if ($booking_field_changed == false) { // first field
                $booking_field_changed = true;
                $bookparms = " SET ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            } else {
                $bookparms .= ", ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            }
            if ($column[$i] == 'booking_status') { 
                // (1) set emailflag to status value so that email is sent after update successful
                $emailflag = $formfield[$i];
                // (2) change display status to match
                if (($formfield[$i] == $statusarray[0])
                or ($formfield[$i] == $statusarray[1])
                or ($formfield[$i] == $statusarray[2])) {// provisional
                    $bookparms .= ", display_status = 'P'";
                } elseif (($formfield[$i] == $statusarray[8])
                or ($formfield[$i] == $statusarray[9])) {// expired
                    $bookparms .= ", display_status = 'E'";
                } else {// confirmed
                    $bookparms .= ", display_status = 'C'";
                }
            }
          }
        }
    } else { // field is unchanged - set formfield to database value
        $formfield[$i] = $viewrow[$column[$i]];
        if ($column[$i] == 'last_modified_by') { // update stats if necessary
            if (($customer_field_changed == true) or 
                 ($booking_field_changed == true) or
                 ($payment_field_changed == true)) {
                $formfield[$i] = $_SESSION[$ss]['username'];
                $viewrow[$column[$i]] = $_SESSION[$ss]['username'];
            }
        }
        if ($column[$i] == 'last_modified_on') { // update stats if necessary
            if (($customer_field_changed == true) or 
                 ($booking_field_changed == true) or
                 ($payment_field_changed == true)) {
                $formfield[$i] = $db_object->getOne("SELECT NOW()");
                $viewrow[$column[$i]] = $formfield[$i];
            }
        }
    }
    if ($column[$i] == 'balance_amount') { // need to check balance amount to decide which email to send
        $bal_amt = number_format($formfield[$i],2);
    }
  }
  if ($company_contacts)
  {
  	//check all additional company contact fields for posted data here...
	if (isset($_POST['invoice_reminder'])) {
		$i_rem_selected = 'CHECKED';
		if ($viewrow['tariff'] < '2') {
			$viewrow['tariff'] = '2';
			$nothing_changed = false;		
            if ($payment_field_changed == false) { // first field
                $payment_field_changed = true;
               	$payparms = " SET tariff = '".$viewrow['tariff']."'";
            } else {
               	$payparms .= ", tariff = '".$viewrow['tariff']."'";
            }
		}
	} else {
		$i_rem_selected = '';		
		if ($viewrow['tariff'] > '1') {
			$viewrow['tariff'] = '0';
			$nothing_changed = false;		
            if ($payment_field_changed == false) { // first field
                $payment_field_changed = true;
               	$payparms = " SET tariff = '".$viewrow['tariff']."'";
            } else {
               	$payparms .= ", tariff = '".$viewrow['tariff']."'";
            }
            // user has chosen to have NO invoice reminders - delete existing reminders if present
			$event_type = 'I';
			//TODO include ('removeeventarray.php');
		}
	}
  	if (isset($_POST['telephone_alt'])) {
        $alt_tel_field = stripslashes($_POST['telephone_alt']);
        if (htmlentities($alt_tel_field, ENT_QUOTES) != $viewrow['telephone_alt']) { // column is updated;
			$nothing_changed = false;
            if ($customer_field_changed == false) { // first field
                $customer_field_changed = true;
                $custparms = " SET telephone_alt = '".htmlentities($alt_tel_field, ENT_QUOTES)."'"; 
            } else {
                $custparms .= ", telephone_alt = '".htmlentities($alt_tel_field, ENT_QUOTES)."'"; 
            }
            $viewrow['telephone_alt'] = htmlentities($alt_tel_field, ENT_QUOTES);
        }
  	}
  	if (isset($_POST['arrival_notes'])) {
        $arrival_notes = stripslashes($_POST['arrival_notes']);
        if (htmlentities($arrival_notes, ENT_QUOTES) != $viewrow['arrival_notes']) { // column is updated;
			$nothing_changed = false;
            if ($booking_field_changed == false) { // first field
                $booking_field_changed = true;
                $bookparms = " SET arrival_notes = '".htmlentities($arrival_notes, ENT_QUOTES)."'"; 
            } else {
                $bookparms .= ", arrival_notes = '".htmlentities($arrival_notes, ENT_QUOTES)."'"; 
            }
            $viewrow['arrival_notes'] = htmlentities($arrival_notes, ENT_QUOTES);
        }
  	}
  	if (isset($_POST['cleaning_option']) && isset($_POST['cleaning_day'])) {
        if (($_POST['cleaning_option'] != $viewrow['cleaning_option']) || ($_POST['cleaning_day'] != $viewrow['cleaning_day'])) { // column is updated;
			$nothing_changed = false;
			$event_type = 'C';
			$event_data = 'WS';
			// TODO include ('updatecleaningevents.php');
			$eventarray = $db_object->getAll("SELECT DISTINCT 
                                         t1.resource_id,
                                         t1.event_date,
                                         t1.event_type,
                                         t1.event_data,
                                         t1.last_modified_on,
                                         t1.last_modified_by
                                    FROM calendar_event AS t1,
                                         calendar_booking AS t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.event_date = t2.booking_date
                                     AND t1.resource_id = t2.resource_id
                                     AND t2.booking_reference = '".$viewrow['booking_reference']."'
									 AND t1.event_type = '".$event_type."'
									 AND t1.event_data = '".$event_data."'");
			$clneventarray = $eventarray;
			if (count($clneventarray) > 0) {
				foreach ($clneventarray as $cleaningrow) {
					$delete = $db_object->query("DELETE from calendar_event 
                                                  WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                                    AND event_type = '".$event_type."'
                                                    AND resource_id = '".$cleaningrow['resource_id']."'
													AND event_date = '".$cleaningrow['event_date']."'");
				}
			}
			// echo 'Option: '.$_POST['cleaning_option'].'; day: '.$_POST['cleaning_day'];
			// echo '<br/>Compare: '.$cleaningarray[2].'; day: '.$cleandayarray[7];
			if (($_POST['cleaning_option'] == $cleaningarray[2]) && ($_POST['cleaning_day'] != 7))  {
				// set up cleaning event entries
				$dayarray = $db_object->getAll("SELECT resource_id, booking_date
                                                  FROM calendar_booking
                                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			                                       AND booking_reference = '".$viewrow['booking_reference']."'
                                                   AND day_of_week = '".$_POST['cleaning_day']."'");
				// print_r($dayarray);
				if (count($dayarray) > 0) {
					foreach ($dayarray as $property_day) {
						$cal_insert = $db_object->query("INSERT INTO calendar_event
										                 VALUES ('".$_SESSION[$ss]['company_id']."',
								                		       	 '".$property_day['resource_id']."', 
								                		       	 '".$property_day['booking_date']."',
																 '".$event_type."', 
																 '".$event_data."',
                		       									 '".$_SESSION[$ss]['username']."', 
		                       									 null)");
					}
				}
			}
			$viewrow['cleaning_option'] = $_POST['cleaning_option'];
			$viewrow['cleaning_day'] = $_POST['cleaning_day'];
			$success = true;
        }
  	}
  	// tenant fields validated in javascript - if we get here the values are OK...
	$title_t = htmlentities(stripslashes($_POST['title_t']), ENT_QUOTES);
	$first_name_t = htmlentities(stripslashes($_POST['first_name_t']), ENT_QUOTES);
	$last_name_t = htmlentities(stripslashes($_POST['last_name_t']), ENT_QUOTES);
	$post_address_t = htmlentities(stripslashes($_POST['post_address_t']), ENT_QUOTES);
	$post_code_t = htmlentities(stripslashes($_POST['post_code_t']), ENT_QUOTES);
	$telephone_t = htmlentities(stripslashes($_POST['telephone_t']), ENT_QUOTES);
	$telephone_alt_t = htmlentities(stripslashes($_POST['telephone_alt_t']), ENT_QUOTES);
	$email_t = htmlentities(stripslashes($_POST['email_t']), ENT_QUOTES);
	if (($last_name_t != '') || ($tenantrow != '')) { // there is data to compare
	    if (($title_t != $tenantrow['title'])
    	 or ($first_name_t != $tenantrow['first_name'])
	     or ($last_name_t != $tenantrow['last_name'])
    	 or ($post_address_t != $tenantrow['post_address'])
	     or ($post_code_t != $tenantrow['post_code'])
    	 or ($telephone_t != $tenantrow['telephone'])
	     or ($telephone_alt_t != $tenantrow['telephone_alt'])
    	 or ($email_t != $tenantrow['email']) ) { // tenant is updated;
			$nothing_changed = false;
    	 	if ($tenantrow == '') { // this is an insert (unless match found), also need to update booking with new guest_id 
				$tenantrow = $db_object->getRow("SELECT *
                             FROM customer 
                            WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                              AND customer_company_id = '".$viewrow['customer_company_id']."'
                              AND last_name = '".$last_name_t."'
                              AND email = '".$email_t."'
                              AND active_flag = 'Y'");
				if ($tenantrow == '') { // does not already exist as a customer
    				$insert = "INSERT INTO customer 
		               VALUES ('".$_SESSION[$ss]['company_id']."',
        		               	0,
                		       	'".$viewrow['customer_company_id']."', 
                       			'".$title_t."', 
		                       	'".$first_name_t."', 
        		               	'".$last_name_t."', 
                		       	'".$post_address_t."', 
								'".$post_code_t."', 
		                       	'".$telephone_t."',
        		               	'".$telephone_alt_t."',
                		       	'".$email_t."', 
		                       	'Y',
        		               	now(),
                		       	'".$_SESSION[$ss]['username']."', 
		                       	null)";
				//  echo $insert; //
    				$add_member = $db_object->query($insert);
    				if (DB::isError($add_member)) {
        				die($add_member->getMessage());
    				}
			    	// return customer_id  //
			    	$guest_id = mysql_insert_id();
			    	// put changed values into tenantrow  
			    	$tenantrow['title'] = $title_t;
		        	$tenantrow['first_name'] = $first_name_t;
	     			$tenantrow['last_name'] = $last_name_t;
    	 			$tenantrow['post_address'] = $post_address_t;
	    	 		$tenantrow['post_code'] = $post_code_t;
    		 		$tenantrow['telephone'] = $telephone_t;
		     		$tenantrow['telephone_alt'] = $telephone_alt_t;
    	 			$tenantrow['email'] = $email_t;
				} else {
    				$guest_id = $tenantrow['customer_id'];
				}
		        $update_table = $db_object->query(
                     "UPDATE booking 
						 SET guest_id = '".$guest_id."',
							 last_modified_on = now(), 
							 last_modified_by = '".$_SESSION[$ss]['username']."'
					   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
						 AND booking_reference = '".$viewrow['booking_reference']."'"); 
        		if (DB::isError($update_table)) {
            		die($update_table->getMessage());
        		}
        		$success = true;
			} elseif ($last_name_t == '') { // remove guest_id from booking.
		        $update_table = $db_object->query(
                     "UPDATE booking 
						 SET guest_id = '0',
							 last_modified_on = now(), 
							 last_modified_by = '".$_SESSION[$ss]['username']."'
					   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
						 AND booking_reference = '".$viewrow['booking_reference']."'"); 
        		if (DB::isError($update_table)) {
            		die($update_table->getMessage());
        		}
        		$success = true;
        		$tenantrow = '';
			} else { // this is an update.
		        $update_table = $db_object->query(
                     "UPDATE customer 
						 SET title = '".$title_t."',
						     first_name = '".$first_name_t."',
						     last_name = '".$last_name_t."',
						     post_address = '".$post_address_t."',
						     post_code = '".$post_code_t."',
						     telephone = '".$telephone_t."',
						     telephone_alt = '".$telephone_alt_t."',
						     email = '".$email_t."', 
							 last_modified_on = now(), 
							 last_modified_by = '".$_SESSION[$ss]['username']."'
					   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
						 AND customer_id = '".$viewrow['guest_id']."'"); 
        		if (DB::isError($update_table)) {
            		die($update_table->getMessage());
        		}
        		$success = true;
        		// put changed values into tenantrow
				$tenantrow['title'] = $title_t;
	        	$tenantrow['first_name'] = $first_name_t;
	     		$tenantrow['last_name'] = $last_name_t;
    	 		$tenantrow['post_address'] = $post_address_t;
	     		$tenantrow['post_code'] = $post_code_t;
    	 		$tenantrow['telephone'] = $telephone_t;
	     		$tenantrow['telephone_alt'] = $telephone_alt_t;
    	 		$tenantrow['email'] = $email_t;
			}
    	 }
      }
	}
	if ($customer_field_changed == true) {
        $nothing_changed = false;
        $custparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'"; 
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                          AND customer_id = '".$viewrow['customer_id']."'";
        // echo "UPDATE customer ".$custparms.$whereparms;
		// print_r($viewrow);
        $update_table = $db_object->query(
                     "UPDATE customer ".$custparms.$whereparms); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
        $success = true;
	}
	if ($booking_field_changed == true) {
        $nothing_changed = false;
        $bookparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'"; 
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                          AND booking_reference = '".$viewrow['booking_reference']."'";
        // echo "UPDATE booking".$_SESSION[$ss]['_test']." ".$bookparms.$whereparms;
        $update_table = $db_object->query(
                     "UPDATE booking".$_SESSION[$ss]['_test']." ".$bookparms.$whereparms); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
        $success = true;
	}
	if ($payment_field_changed == true) {
        $nothing_changed = false;
        $payparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'"; 
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                          AND booking_reference = '".$viewrow['booking_reference']."'";
        // echo "UPDATE payment".$_SESSION[$ss]['_test']." ".$payparms.$whereparms;
        $update_table = $db_object->query(
                     "UPDATE payment".$_SESSION[$ss]['_test']." ".$payparms.$whereparms); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
        $success = true;
	}
	if ($success == true) {
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
        // write booking_audit record
        $insert = "INSERT into booking_audit SELECT 
                                         t1.company_id,
                                         t1.booking_reference,
                                         0,
                                         t1.arrival_date,
                                         t1.departure_date,
                                         t1.number_adults,
                                         t1.number_children,
                                         t1.number_infants,
                                         t1.contact_id,
                                         t1.guest_id,
                                         t1.display_status,
                                         t1.booking_status,
                                         t2.deposit_amount,
                                         t2.balance_amount,
                                         '".$_SESSION[$ss]['username']."',
                                         now()
                                    FROM booking AS t1,
                                         payment AS t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.booking_reference = '".$viewrow['booking_reference']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.booking_reference = t2.booking_reference";
        $add_member = $db_object->query($insert);
        if (DB::isError($add_member)) {
            die($add_member->getMessage());
        }
        if ($emailflag == $statusarray[3]) { // deposit paid
            if ($bal_amt > 0) { // deposit only - there will be balance to pay later
                include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/deposit_email.php'); // generate deposit confirmation email
            } else { // deposit includes the whole balance - no balance to pay later
                include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/final_email.php'); // generate final confirmation email
            }
            unset($emailflag);
        }
        if ($emailflag == $statusarray[6]) { // final amount paid
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/final_email.php'); // generate final confirmation email
            unset($emailflag);
        }
    }
}

$emailarray = $db_object->getAll("SELECT * FROM email".$_SESSION[$ss]['_test']." 
                                          WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                            AND booking_reference = '".$viewrow[$column[0]]."' ");

?>
<html>
<head>
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//JavaScript Edit Validation Code

//-->
</script>

</head>
<?php
if ($success) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false);<?=$set_tenant?>alert('Record Successfully Updated<?=$msgtext?>');">
<?php
} elseif ($nothing_changed) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="top.Top.SetChangedFlag(false);<?=$set_tenant?>">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">
<form action="edit.php" name="frmEdit" id="frmEdit" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="50%" height="100%">

      <!-- Black Table Border -->
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

        <!-- Main Table -->
        <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3">
          <!-- Field # 14: Arrival Date -->
          <tr>
            <td width="30%" class="header-left">Arrival Date</td>
			<?php
			// check if this field is still editable 
			if ($viewrow['test_arrive'] >= $date_today)
			{ ?>
            <td width="70%" class="alt1"><span style="width:49%"><?=$viewrow[$column[14]]?></span><span style="width:49%;text-align:right"><input type="button" name="btnDates" value="Change..." class="button" style="vertical-align:middle;" onClick="top.Top.GoToURL('2', 'Edit Booking Dates[Ref=<?=$viewrow['booking_reference']?>]', 'edit.php?view=dates&key=booking_reference&value=<?=$viewrow['booking_reference']?>&');" /></span></td>
			<?php
			}  else { ?>
            <td width="70%" class="alt1"><?=$viewrow[$column[14]]?></td>
			<?php
			} 
			if ($company_contacts)
            {
				?>
          </tr>
          <!-- Arrival Time for co lets -->
          <tr>
            <td width="30%" class="header-left">Arrival Notes</td>
            <td width="70%" class="alt1"><input type="text" name="arrival_notes" value="<?=$viewrow['arrival_notes']?>" size="32" maxlength="64" class="input" onFocus="ChangeMade();">
			</td>
				<?php
			} ?>
          </tr>
          <!-- Field # 15: Departure Date -->
          <tr>
            <td width="30%" class="header-left">Departure Date</td>
			<?php
			// check if this field is still editable 
			if ($viewrow['test_depart'] >= $date_today)
			{ ?>
			<td width="70%" class="alt2"><span style="width:49%"><?=$viewrow[$column[15]]?></span><span style="width:49%;text-align:right"><input type="button" name="btnDates" value="Change..." class="button" style="vertical-align:middle;" onClick="top.Top.GoToURL('2', 'Edit Booking Dates[Ref=<?=$viewrow['booking_reference']?>]', 'edit.php?view=dates&key=booking_reference&value=<?=$viewrow['booking_reference']?>&');" /></span></td>
			<?php
			}  else { ?>	
            <td width="70%" class="alt2"><?=$viewrow[$column[15]]?></td>
            <?php
			} ?>
          </tr>
          <!-- Field # 13: Number of Nights -->
          <tr>
            <td width="30%" class="header-left"><?=$label[13]?></td>
            <td width="70%" class="alt1"><?=$viewrow[$column[13]]?></td>
          </tr>
          <!-- Field # 9: Property -->
          <tr>
            <td width="30%" class="header-left"><?=$label[9]?></td>
			<?php
			// check if this field is editable 
			if ($change_property)
			{ ?>
			<td width="70%" class="alt2"><span style="width:49%"><?=$viewrow[$column[9]]?></span><span style="width:49%;text-align:right"><input type="button" name="btnProperty" value="Change..." class="button" style="vertical-align:middle;" onClick="top.Top.GoToURL('2', 'Change Property[Ref=<?=$viewrow['booking_reference']?>]', 'edit.php?view=changeproperty&key=booking_reference&value=<?=$viewrow['booking_reference']?>&');" /></span></td>
			<?php
			}  else { ?>	
            <td width="70%" class="alt2"><?=$viewrow[$column[9]]?></td>
            <?php
			} ?>
          </tr>
        </table>
      </table>

    </td>
    <td width="50%" height="100%">
	
      <!-- Black Table Border -->
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

        <!-- Main Table -->
        <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3">
          <!-- Field # 10: Number of Adults -->
          <tr>
            <td width="30%" class="header-left"><?=$label[10]?></td>
            <td width="70%" class="alt2">
              <input type="text" name="<?=$column[10]?>" value="<?=$viewrow[$column[10]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();"></td>
          </tr>
			<?php
			if (!$company_contacts)
            {	?>
          <!-- Field # 11: Number of Children -->
          <tr>
            <td width="30%" class="header-left"><?=$label[11]?></td>
            <td width="70%" class="alt2">
              <input type="text" name="<?=$column[11]?>" value="<?=$viewrow[$column[11]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();"></td>
          </tr>
			<?php
			}	?>
          <!-- Field # 12: Number of Infants -->
          <tr>
            <td width="30%" class="header-left"><?=$label[12]?></td>
            <td width="70%" class="alt2">
              <input type="text" name="<?=$column[12]?>" value="<?=$viewrow[$column[12]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();"></td>
          </tr>
          <!-- Field # 23: Tariff -->
          <tr>
              <?php
              if ($company_contacts)
              { ?>
            <td width="30%" class="header-left">Rate</td>
            <td width="70%" class="alt1">
              <input type="text" name="tariff_field1" value="<?=$viewrow['tariff_field1']?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">
              <SELECT NAME="tariff_field2" style="font-size: 8pt" onFocus="ChangeMade();">
              <?php
              $match_found = false; 
              for ($j=1; $j<4; $j++) {
                if ($typearray[$j] == $viewrow['tariff_field2']) {
                    $match_found = true; ?>
              <OPTION VALUE="<?=$typearray[$j]?>" SELECTED><?=$typearray[$j]?></OPTION><?php
                } else { ?>
              <OPTION VALUE="<?=$typearray[$j]?>"><?=$typearray[$j]?></OPTION><?php
                }
              } ?>
              </SELECT></td>
            </td>
			  <?php
			  } else
			  {
			  	?>
            <td width="30%" class="header-left"><?=$label[23]?></td>
            <td width="70%" class="alt1"><?=$tariffarray[$viewrow[$column[23]]]?></td>
			  <?php
			  }
			  ?>
          </tr>
          <!-- Field # 16: Booking Status -->
          <tr>
            <td width="30%" class="header-left"><?=$label[16]?></td>
            <td width="70%" class="alt2">
              <SELECT NAME="booking_status" style="font-size: 8pt" onFocus="ChangeMade();">
              <?php
              $match_found = false; 
              for ($j=0; $j<count($statusarray); $j++) {
                if ($statusarray[$j] == $viewrow[$column[16]]) {
                    $match_found = true; ?>
              <OPTION VALUE="<?=$statusarray[$j]?>" SELECTED><?=$statusarray[$j]?></OPTION><?php
                } else { ?>
              <OPTION VALUE="<?=$statusarray[$j]?>"><?=$statusarray[$j]?></OPTION><?php
                }
              } ?>
              </SELECT></td>
          </tr>
			<?php
			if ($company_contacts)
            {	
            	?>
          <!-- Field # xx: Events -->
          <tr>
            <td width="30%" class="header-left">Reminders</td>
            <td width="70%" class="alt2" style"vertical-align:middle;"><?php
            	if ($i_rem_selected == 'CHECKED') {
            		// set up link to event manager
					?>
              <span style="width:49%;"><input type="checkbox" name="invoice_reminder" value="1" <?=$i_rem_selected?> onFocus="ChangeMade();"/>Invoices<?=$i_rem_link?>&nbsp;(<?=count($invoicearray)?>)&nbsp;</span><span style="width:49%;text-align:right;"><input type="button" name="btnInvoices" value="Manage..." class="button" style="vertical-align:middle;" onClick="top.Top.GoToURL('2', 'List Invoice Reminders', 'list.php?view=event_view&srch1=t2.booking_reference&op1=EQ&val1=<?=$viewrow['booking_reference']?>&srch2=t1.event_type&op2=EQ&val2=I&');" /></span></td>
              <?php
				} else {
					?>
              <span style="width:49%;"><input type="checkbox" name="invoice_reminder" value="1" <?=$i_rem_selected?> onFocus="ChangeMade();"/>Invoices<?=$i_rem_link?></span></td>
              <?php
				}
					?>
          </tr>
			<?php
			}	?>
        </table>
      </table>
    </td>
  </tr>
  <tr>
    <td width="50%" height="100%">
	
	<!-- Black Table Border -->
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3">
              <?php
              $class = 'alt1';
              if ($company_contacts)
              {
				?>
          <tr>
            <td width="30%" class="header-left">Company</td>
            <td width="70%" class="alt2"><?=$company?></td>
		  </tr>
          <tr>
            <td width="100%" colspan="2" class="alt1">Booking Contact Details:</td>
          </tr>
          <tr>
            <td width="30%" class="header-left">Name</td>
            <td width="70%" class="alt2">
              <input type="text" name="title" value="<?=$viewrow[$column[2]]?>" size="4" maxlength="4" class="input" onFocus="ChangeMade();">&nbsp;<input type="text" name="first_name" value="<?=$viewrow[$column[3]]?>" size="8" maxlength="20" class="input" onFocus="ChangeMade();">&nbsp;<input type="text" name="last_name" value="<?=$viewrow[$column[4]]?>" size="12" maxlength="25" class="input" onFocus="ChangeMade();"></td>
          </tr>
          <tr>
            <td width="30%" class="header-left">Address</td>
            <td width="70%" class="alt1">
                           <textarea name="post_address" cols="30" rows="3" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[5]]?></textarea>
            </td>
		  </tr>                            
          <tr>
            <td width="30%" class="header-left" nowrap="nowrap">Postcode,&nbsp;Email</td>
            <td width="70%" class="alt2">
                           <input type="text" name="post_code" value="<?=$viewrow[$column[6]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">&nbsp;&nbsp;<input type="text" name="email" value="<?=$viewrow[$column[8]]?>" size="28" maxlength="50" class="input" onFocus="ChangeMade();">
            </td>
		  </tr>                            
          <tr>
            <td width="30%" class="header-left">Phone1,&nbsp;Phone2</td>
            <td width="70%" class="alt1">
              <input type="text" name="telephone" value="<?=$viewrow[$column[7]]?>" size="18" maxlength="50" class="input" onFocus="ChangeMade();">&nbsp;&nbsp;<input type="text" name="telephone_alt" value="<?=$viewrow['telephone_alt']?>" size="18" maxlength="50" class="input" onFocus="ChangeMade();"></td>
          </tr>
          <tr>
            <td width="100%" colspan="2" class="alt1">Tenant Details (if different from above):</td>
          </tr>
          <tr>
            <td width="30%" class="header-left">Name</td>
            <td width="70%" class="alt2">
              <input type="text" name="title_t" value="<?=$tenantrow['title']?>" size="4" maxlength="4" class="input" onFocus="ChangeMade();">&nbsp;<input type="text" name="first_name_t" value="<?=$tenantrow['first_name']?>" size="8" maxlength="20" class="input" onFocus="ChangeMade();">&nbsp;<input type="text" name="last_name_t" value="<?=$tenantrow['last_name']?>" size="12" maxlength="25" class="input" onFocus="ChangeMade();"></td>
          </tr>
          <tr>
            <td width="30%" class="header-left">Address</td>
            <td width="70%" class="alt1">
                           <textarea name="post_address_t" cols="30" rows="3" class="input" onKeyDown="ChangeMade();"><?=$tenantrow['post_address']?></textarea>
            </td>
		  </tr>                            
          <tr>
            <td width="30%" class="header-left">Postcode, Email</td>
            <td width="70%" class="alt2">
                           <input type="text" name="post_code_t" value="<?=$tenantrow['post_code']?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">&nbsp;&nbsp;<input type="text" name="email_t" value="<?=$tenantrow['email']?>" size="28" maxlength="50" class="input" onFocus="ChangeMade();">
            </td>
		  </tr>                            
          <tr>
            <td width="30%" class="header-left">Phone1, Phone2</td>
            <td width="70%" class="alt1">
              <input type="text" name="telephone_t" value="<?=$tenantrow['telephone']?>" size="18" maxlength="50" class="input" onFocus="ChangeMade();">&nbsp;&nbsp;<input type="text" name="telephone_alt_t" value="<?=$tenantrow['telephone_alt']?>" size="18" maxlength="50" class="input" onFocus="ChangeMade();"></td>
          </tr>
				
				<?php                 	
              } else
              {
                  for ($i = 1; $i < 9; $i++) {
                        if (($unique[$i] == 'Y') | ($update[$i] == 'N')) { //part of key or not updateable - display as readonly text
                            ?>
                <tr>
                  <td width="30%" class="header-left"><?=$label[$i]?></td>
                  <td width="70%" class="<?=$class?>"><?=$viewrow[$column[$i]]?>
                            <?php
                        } elseif ($update[$i] == 'Y') { // field is updateable by user
                            ?> 
                <tr>
                  <td width="30%" class="header-left"><?=$label[$i]?></td>
                  <td width="70%" class="<?=$class?>">
                            <?php 
                            if ($column[$i] == 'booking_status') { // booking status is a select dropdown ?> 
                           <SELECT NAME="booking_status" style="font-size: 8pt" onFocus="ChangeMade();">
                            <?php
                            $match_found = false; 
                            for ($j=0; $j<count($statusarray); $j++) {
                              if ($statusarray[$j] == $viewrow[$column[$i]]) {
                                  $match_found = true; ?>
                           <OPTION VALUE="<?=$statusarray[$j]?>" SELECTED><?=$statusarray[$j]?></OPTION><?php
                              } else { ?>
                           <OPTION VALUE="<?=$statusarray[$j]?>"><?=$statusarray[$j]?></OPTION><?php
                              }
                            } ?>
                           </SELECT>
                            <?php 
                            } elseif ($type[$i] == 'T') { // input text field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="30" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'I') { // input integer field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'D') { // input date field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == '4') { // input datetime field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="19" maxlength="19" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'E') { // input email field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="30" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'A') { // textarea field ?> 
                           <textarea name="<?=$column[$i]?>" cols="30" rows="8" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[$i]]?></textarea> 
                            <?php 
                            } else { // checkbox
                                if ($viewrow[$column[$i]] == 'Y') {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" CHECKED onFocus="ChangeMade();">'; 
                                } else {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" onFocus="ChangeMade();">'; 
                                } 
                            } 
                        } ?>
                        </td>
                      </tr>
                      <?php
                      if ($class == 'alt1') {
                          $class = 'alt2';
                      }
                      else {
                          $class = 'alt1';
                      }
                  }
				} ?>
		</table>
	</td></tr></table>

            </td>
		<td width="50%" height="100%">
	
	<!-- Black Table Border -->
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3">
                  <?php
                  $class = 'alt1';
                  for ($i = 17; $i < 23; $i++) {
                        if (($unique[$i] == 'Y') | ($update[$i] == 'N')) { //part of key or not updateable - display as readonly text
                            ?>
                <tr>
                  <td width="30%" class="header-left"><?=$label[$i]?></td>
                  <td width="70%" class="<?=$class?>"><?=$viewrow[$column[$i]]?>
                            <?php
                        } elseif ($update[$i] == 'Y') { // field is updateable by user
                            ?> 
                <tr>
                  <td width="30%" class="header-left"><?=$label[$i]?></td>
                  <td width="70%" class="<?=$class?>">
                            <?php 
                            if ($column[$i] == 'payment_method') { // payment method is a select dropdown ?>
                           <SELECT NAME="payment_method" style="font-size: 8pt" onFocus="ChangeMade();">
                            <?php
                            $match_found = false; 
                            for ($j=1; $j<count($cardarray); $j++) {
                              if ($j == $viewrow[$column[$i]]) {
                                  $match_found = true; ?>
                           <OPTION VALUE="<?=$j?>" SELECTED><?=$cardarray[$j]?></OPTION><?php
                              } else { ?>
                           <OPTION VALUE="<?=$j?>"><?=$cardarray[$j]?></OPTION><?php
                              }
                            } ?>
                           </SELECT>
                            <?php 
                            } elseif ($type[$i] == 'T') { // input text field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="30" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'I') { // input integer field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'D') { // input date field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == '4') { // input datetime field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="19" maxlength="19" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'E') { // input email field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="30" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'A') { // textarea field ?> 
                           <textarea name="<?=$column[$i]?>" cols="40" rows="8" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[$i]]?></textarea> 
                            <?php 
                            } else { // checkbox
                                if ($viewrow[$column[$i]] == 'Y') {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" CHECKED onFocus="ChangeMade();">'; 
                                } else {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" onFocus="ChangeMade();">'; 
                                } 
                            } 
                        } ?>
                        </td>
                      </tr>
                      <?php
                      if ($class == 'alt1') {
                          $class = 'alt2';
                      }
                      else {
                          $class = 'alt1';
                      }
                  } ?>
          <!-- Field # 26: Notes -->
          <tr>
            <td width="30%" class="header-left"><?=$label[26]?></td>
            <td width="70%" class="<?=$class?>"><textarea name="<?=$column[26]?>" cols="30" rows="6" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[26]]?></textarea></td>
			<?php
			if ($company_contacts)
            {
                if ($class == 'alt1') {
                    $class = 'alt2';
                }
                else {
                    $class = 'alt1';
                }
            	?>
          </tr>
          <!-- Cleaning rota for co lets -->
          <tr>
            <td width="30%" class="header-left">Cleaning</td>
            <td width="70%" class="<?=$class?>">
                          <SELECT NAME="cleaning_option" style="font-size: 8pt" onFocus="ChangeMade();">
                            <?php
                            $match_found = false; 
                            for ($j=1; $j<count($cleaningarray); $j++) {
                              if ($cleaningarray[$j] == $viewrow['cleaning_option']) {
                                  $match_found = true; ?>
                           <OPTION VALUE="<?=$cleaningarray[$j]?>" SELECTED><?=$cleaningarray[$j]?></OPTION><?php
                              } else { ?>
                           <OPTION VALUE="<?=$cleaningarray[$j]?>"><?=$cleaningarray[$j]?></OPTION><?php
                              }
                            } ?>
                           </SELECT>&nbsp;on&nbsp;
                          <SELECT NAME="cleaning_day" style="font-size: 8pt" onFocus="ChangeMade();">
                            <?php
                            $match_found = false; 
                            for ($j=0; $j<count($cleandayarray); $j++) {
                              if ($j == $viewrow['cleaning_day']) {
                                  $match_found = true; ?>
                           <OPTION VALUE="<?=$j?>" SELECTED><?=$cleandayarray[$j]?></OPTION><?php
                              } else { ?>
                           <OPTION VALUE="<?=$j?>"><?=$cleandayarray[$j]?></OPTION><?php
                              }
                            } ?>
                           </SELECT>
			</td>
				<?php
			} ?>
          </tr>
		</table>

	</td></tr>
      </table>
	</td></tr>
      <tr>
		<td colspan="2" width="100%" height="100%">
	
	<!-- Black Table Border -->
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="14%" class="header-left">Emails</td>
                  <td width="86%" class="alt1"><?php
                   foreach ($emailarray as $emailrow) {
                   	   if (substr($emailrow['email_type'],0,10) == 'Booking No') $emailrow['email_type'] = 'Booking Notification';
                       if ($emailrow['sent_flag'] == 'Y') {
                           $sentstr = '&nbsp;(Sent)';
                       } else {
                           $sentstr = '&nbsp;(Unsent)';
                       } ?>
                       <a href="#" onClick="top.Top.GoToURL('2', 'Edit Email[Type=<?=$emailrow['email_type']?>, Id=<?=$emailrow['email_sequence']?>]', 'edit.php?view=email&key=booking_reference,email_sequence&value=<?=$emailrow['booking_reference']?>,<?=$emailrow['email_sequence']?>&');"><?=$emailrow['email_sequence'].':'.$emailrow['email_type'].$sentstr?></a>&nbsp;&nbsp;<?php
                   } ?></td>
                </tr>
		</table>

	</td></tr>
      </table>
	</td></tr>
	</td></tr>
      </table>
		
	
	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.BackToURL('');">
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnUpdate" value="Update" class="button" onClick="CheckSubmit()"><?php
				$last_email = array_pop($emailarray);
				?>
                <input type="button" name="btnEmail" value="Create Email" class="button" onClick="top.Top.GoToURL('2', 'Create Email[Type=General, Id=<?=$last_email['email_sequence']+1?>]', 'edit.php?view=newemail&key=booking_reference,email_sequence&value=<?=$viewrow['booking_reference']?>,<?=$last_email['email_sequence']+1?>&');" />
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="srch1" value="<?=$srch1?>">
      <input type="hidden" name="op1" value="<?=$op1?>">
      <input type="hidden" name="val1" value="<?=$val1?>">
      <input type="hidden" name="key" value="<?=$key?>">
      <input type="hidden" name="value" value="<?=$value?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
</div>

</body>
</html>