<?php
// +----------------------------------------------------------------------+
// | ENQUIRY  - EseSite booking enquiry - Company 9                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 9/enquiry.php,v 1.00 2007/08/25
//

$customer_company_id = 0;
if ($co != '')
{
	$row = $db_object->getRow("SELECT customer_company_id
	                             FROM customer_company 
	                            WHERE company_id = '".$_SESSION[$ss]['company_id']."'
	                              AND customer_company_name = '".$co."'");
	if ($row['customer_company_id'] == null) { // does not already exist as a company
	    $insert = "INSERT INTO customer_company 
	               VALUES ('".$_SESSION[$ss]['company_id']."',
	                       0,
	                       '".$co."', 
	                       now(),
	                       '".$_SESSION[$ss]['username']."', 
	                       null)";
	//  echo $insert; //
	    $add_member = $db_object->query($insert);
	    if (DB::isError($add_member)) {
	        die($add_member->getMessage());
	    }
	    // return customer_id  //
	    $customer_company_id = mysql_insert_id();  
	} else {
	    $customer_company_id = $row['customer_company_id'];
	}
}

$row = $db_object->getRow("SELECT customer_id
                             FROM customer 
                            WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                              AND customer_company_id = '".$customer_company_id."'
                              AND title = '".$titlearray[$t]."'
                              AND first_name = '".$f."'
                              AND last_name = '".$l."'
                              AND telephone = '".$u."'
                              AND email = '".$e."'
                              AND active_flag = 'Y'");
if ($row['customer_id'] == null) { // does not already exist as a customer
    $insert = "INSERT INTO customer 
               VALUES ('".$_SESSION[$ss]['company_id']."',
                       0,
                       '".$customer_company_id."', 
                       '".$titlearray[$t]."', 
                       '".$f."', 
                       '".$l."', 
                       '".$a."', 
                       '".$q."', 
                       '".$u."',
                       '".$u1."',
                       '".$e."', 
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
    $contact_id = mysql_insert_id();  
} else {
    $contact_id = $row['customer_id'];
}
if ($_SESSION[$ss]['enquiry_reference'] > 0)
{
	// existing enquiry - update if necessary
	$enquiry_reference = $_SESSION[$ss]['enquiry_reference'];
	$update = "UPDATE enquiry 
				  SET property_id = '".$_SESSION[$ss]['property_id']."',
					  area = '".$_SESSION[$ss]['location']."',
					  beds = '".$_SESSION[$ss]['bedrooms']."',
					  sleeps = '".$_SESSION[$ss]['sleeps']."',
					  parking = '".($_SESSION[$ss]['parking'] == 'CHECKED' ? '1' : '')."',
					  start_date = '".$_SESSION[$ss]['sql_start_date']."',
					  nights = '".$_SESSION[$ss]['nights']."',
					  sort = '".$_SESSION[$ss]['sort']."',
					  contact_id = '".$contact_id."',
					  expiry = date_add(now(), interval 1 month),
					  enquiry_notes = '".$notes."',
					  last_modified_by = '".$_SESSION[$ss]['username']."'
				WHERE enquiry_reference = ".$_SESSION[$ss]['enquiry_reference']."
				  AND company_id = '".$_SESSION[$ss]['company_id']."'";
	$update_member = $db_object->query($update);
	$enquiry['last_modified_on'] = date('Y-m-d H:i:s');
	if (DB::isError($update_member)) {
    	die($update_member->getMessage());
	}
} else
{
	// new enquiry 
	$insert = "INSERT INTO enquiry 
           VALUES ('".$_SESSION[$ss]['company_id']."',
                   0, 
                   '".$_SESSION[$ss]['property_id']."', 
                   '".$_SESSION[$ss]['location']."', 
                   '".$_SESSION[$ss]['bedrooms']."', 
                   '".$_SESSION[$ss]['sleeps']."', 
                   '".($_SESSION[$ss]['parking'] == 'CHECKED' ? '1' : '')."', 
                   '".$_SESSION[$ss]['sql_start_date']."', 
                   '".$_SESSION[$ss]['nights']."', 
                   '".$_SESSION[$ss]['sort']."', 
                   '".$contact_id."', 
                   now(),
                   date_add(now(), interval 1 month), 
                   '".$notes."',
                   '".$_SESSION[$ss]['username']."', 
				   null)";
	//      echo $insert; //
	$add_member = $db_object->query($insert);
	if (DB::isError($add_member)) {
    	die($add_member->getMessage());
	}
	// return enquiry_reference  //
	$_SESSION[$ss]['enquiry_reference'] = mysql_insert_id();  
	$enquiry['created_date'] = date('Y-m-d');
	$enquiry['last_modified_on'] = date('Y-m-d H:i:s');
}
?>