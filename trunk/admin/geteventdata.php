<?php
// +----------------------------------------------------------------------+
// | GETEVENTDATA  - Esekey Admin Console get event view                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/geteventdata.php,v 1.00 2007/05/07
//

if (isset($_GET['cre']) || isset($_GET['clr'])) {
	//TODO include ('createreminders.php');
	// first delete any existing reminders
	$delete = "DELETE FROM calendar_event
					 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
					   AND event_type = 'I'
					   AND resource_id IN (SELECT DISTINCT resource_id FROM calendar_booking
                                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
													   AND booking_reference = '".$val1."')
					   AND event_date IN (SELECT DISTINCT booking_date from calendar_booking
													   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
														 AND booking_reference = '".$val1."')";
    $result = $db_object->query($delete);
	//print_r($db_object);
}
if (isset($_GET['cre'])) {
	$select = "SELECT *, 
					  (TO_DAYS(departure_date) - TO_DAYS(arrival_date)) AS number_nights,
					  CURDATE() as today_date 
				 FROM booking 
				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
				  AND booking_reference = '".$val1."'";
	$bookingrow = $db_object->getRow($select);
	$select2 = "SELECT DISTINCT resource_id FROM calendar_booking
                          WHERE company_id = '".$_SESSION[$ss]['company_id']."'
							AND booking_reference = '".$val1."'";
	$bookingproperties = $db_object->getAll($select2);
	$reminders = 0;
	$reminder_date = $bookingrow['arrival_date'];
	// echo $bookingrow['departure_date'].'&nbsp;';
	while ($reminder_date < $bookingrow['departure_date']) {
		if ($reminder_date > $bookingrow['today_date'] ) {
			// set up invoice reminder for 1st day of stay and each month thereafter
			foreach ($bookingproperties as $bookingproperty) {
				$insert1 = "INSERT INTO calendar_event 
		               VALUES ('".$_SESSION[$ss]['company_id']."',
        		               	".$bookingproperty['resource_id'].",
                		       	'".$reminder_date."', 
                       			'I', 
		                       	'Inv_no', 
                		       	'".$_SESSION[$ss]['username']."', 
		                       	null)";
				// echo $insert1;
	    		$result1 = $db_object->query($insert1);
	    		// print_r($result1);
			}
		}
		$reminders++;
		if ($reminders > 20)
		{
			// break out of loop
			$reminder_date = '2999-99-99';
		}
		$reminder_date = $db_object->getOne("SELECT DATE_ADD('".$reminder_date."', INTERVAL 1 month)");
		// echo $reminder_date.'&nbsp;';
	}
	if ($reminders == 0) {
   		$alert = 'Unable to create Invoice reminders from current booking settings.';
	}
}

if (isset($_GET['invoice_number'])) {
	// form was submitted
	foreach ($_GET['invoice_number'] as $inv_date=>$inv_data)
	{
		$update_query = "UPDATE calendar_event 
                      SET event_data = '".$inv_data."'
				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
				  AND resource_id = '".$_GET['property_id'][$inv_date]."'
				  AND event_date = '".$inv_date."'
				  AND event_type = 'I'";
    	$result = $db_object->query($update_query);
	}
   	$alert = 'Invoice reminders were saved.';
}

// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(t4.property_number, ' ', t4.property_name)) AS property_name";
} else
{
	$name_select = "t4.property_name";
}
$searchstring2 = '';
if (isset($_GET['srch2'])) { // set up searchstring1 for parameter 1 in WHERE clause
    $srch2 = $_GET['srch2'];
    $op2 = $_GET['op2'];
    $val2 = $_GET['val2'];
    if ($op2 == 'GTEQ') { 
        $searchstring2 = ' AND '.$srch2.' >= '.$val2;
    } elseif ($op2 == 'GT') {
        $searchstring2 = ' AND '.$srch2.' > '.$val2;
    } elseif ($op2 == 'LT') {
        $searchstring2 = ' AND '.$srch2.' < '.$val2;
    } elseif ($op2 == 'EQ') {
        $searchstring2 = ' AND '.$srch2.' = "'.$val2.'"';
    } elseif ($op2 == 'LTEQ') {
        $searchstring2 = ' AND '.$srch2.' <= '.$val2;
    } elseif ($op2 == 'NE') {
        $searchstring2 = ' AND '.$srch2.' <> '.$val2;
    }
}
if ($_SESSION[$ss]['searchstring2'] != $searchstring2) { // search string has changed
	if ($searchstring2 != '') { // new search string built - update sub session and go to page 1
        $_SESSION[$ss]['searchstring2'] = $searchstring2;
        $_SESSION[$ss]['pagenav'] = 1;
    } else { // no search string was provided - use string from sub session
        $searchstring2 = $_SESSION[$ss]['searchstring2'];
    }
}



// get view data and initialise array
//TODO get name of event_data for this type (invoice_number) from view_descriptor table instead of hardcoding
$viewarray = $db_object->getAll("SELECT DISTINCT 
                                         t1.event_date,
                                         ".$name_select.",
                                         t1.resource_id,
                                         t1.event_type,
                                         t1.event_data AS invoice_number,
                                         t1.last_modified_on,
                                         t1.last_modified_by
                                    FROM calendar_event AS t1,
                                         calendar_booking AS t2,
                                         property AS t4
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t4.company_id
                                     AND t1.event_date = t2.booking_date
                                     AND t1.resource_id = t2.resource_id
                                     AND t1.resource_id = t4.property_id
                                     ".$searchstring1."
                                     ".$searchstring2."
                                     ORDER BY t4.property_name, t1.event_date");
//print_r($db_object);
$view_suffix = '';
if ($val2 == 'I') {
	$view_suffix = '_i';
}

$descriptorarray = $db_object->getAll("SELECT t1.field_name, 
                                              t1.unique_key,
                                              t1.list,
                                              t1.user_edit,
                                              t1.foreign_key, 
                                              t2.field_label, 
                                              t2.type,
                                              t2.justify
                                         FROM view_descriptor AS t1,
                                              descriptor AS t2
                                        WHERE t1.view_name = '".$view_name.$view_suffix."'
                                          AND t1.company_id = 0
                                          AND t2.company_id = 0
                                          AND t1.field_name = t2.field_name 
                                     ORDER BY t1.field_sequence");

$select = null;
foreach ($descriptorarray as $descriptorrow) {
	if ($descriptorrow['field_name'] == $view_name) {
        $title = $descriptorrow['field_label'];
    } else {
    	if ($select == null) {
            $select = $descriptorrow['field_name'];
        } else {
            $select .= ', '.$descriptorrow['field_name'];
        } 
        $name[] = $descriptorrow['field_name'];
        $unique[] = $descriptorrow['unique_key'];
        $list[] = $descriptorrow['list'];
        $type[] = $descriptorrow['type'];
        $update[] = $descriptorrow['user_edit'];
        $foreign_key[] = $descriptorrow['foreign_key'];
        $label[] = $descriptorrow['field_label'];
        if ($descriptorrow['justify'] == 'L') {
            $justify[] = 'left';
        } elseif ($descriptorrow['justify'] == 'C') {
            $justify[] = 'center';
        } else {
            $justify[] = 'right';
        }
    }
    if ($descriptorrow['unique_key'] == 'Y') {
        if ($order_by == null) {
            $order_by = ' ORDER BY '.$descriptorrow['field_name'];
        } else {
            $order_by .= ', '.$descriptorrow['field_name'];
        } 
    }
}

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
?>