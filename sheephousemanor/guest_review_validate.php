<?php
// +----------------------------------------------------------------------+
// |GUEST_REVIEW_VALIDATE  - Company 4 - Validate guest review form       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2013 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/guest_review_validate.php,v 1.00 2013/03/03
//
$form_errors = '';
if ($_POST['name'] == '' || $_POST['property'] == 0 || $_POST['arrival_date'] == '') {
	$form_errors .= '<p style="color:red; font-weight:bold;margin-left:12px;margin-bottom:0;">Please enter a reviewer name, select the date of your arrival and select the accommodation you are reviewing</p>';
} else {
	$today = date('Y-m-d');
	$bits = explode('/',$_POST['arrival_date']);
	if (count($bits) != 3) {
		$form_errors .= '<p style="color:red; font-weight:bold;margin-left:12px;margin-bottom:0;">Please select a valid Arrival Date (dd/mm/YYYY).</p>';
	} else {
		$arrival = $bits[2].'-'.$bits[1].'-'.$bits[0];
		if ($arrival > $today) {
			$form_errors .= '<p style="color:red; font-weight:bold;margin-left:12px;margin-bottom:0;">Your arrival date cannot be in the future</p>';
		}
		$earliest = date('Y-m-d', strtotime($today.' - 1 year'));
		if ($arrival < $earliest) {
			$form_errors .= '<p style="color:red; font-weight:bold;margin-left:12px;margin-bottom:0;">Sorry, we cannot accept reviews for visits more than one year ago.</p>';
		}
	}
}
if ($form_errors == '') {
	// all information is valid. Insert the review and post the thank you message
	$name = $_POST['name'];
	$property = $_POST['property'];
	$comments = $_POST['comments'];
	$q1 = 0;
	$q2 = 0;
	$q3 = 0;
	$q4 = 0;
	$q5 = 0;
	$useable = false;
	if (strlen($comments) > 1) $useable = true;
	foreach($_POST as $k=>$v) {
		if (in_array($k,array('q1','q2','q3','q4','q5'))) {
			$$k = $v;
		}
	}
	if ($q1 == 0 || $q2 == 0 || $q5 == 0) $useable = false;
	if ($useable) {
		$insert = "INSERT INTO reviews 
    	           VALUES ('".$_SESSION[$ss]['company_id']."',
        	               0,
            	           '".$name."', 
                	       '', 
                    	   '".$arrival."', 
	                       ".$property.", 
    	                   ".$q1.", 
        	               ".$q2.", 
            	           ".$q3.", 
                	       ".$q4.", 
                    	   ".$q5.", 
						   '".$comments."',
    	                   'N',
         	               now(),
    	                   '".$_SESSION[$ss]['username']."', 
       		               null)";
		//echo $insert; //
		//die;
    	$add_member = $db_object->query($insert);
    	if (DB::isError($add_member)) {
        	die($add_member->getMessage());
    	}
    	// return review_id  //
    	$review_id = mysql_insert_id();  
		$_SESSION[$ss]['thanks'] = '<p style="color:green; font-weight:bold;margin-left:12px;margin-bottom:0;">Thank you for taking the time to give us your feedback. We value all comments made by our guests, and welcome your comments so we can continue to improve your stay.</p>';
	} else {
		$form_errors .= '<p style="color:red; font-weight:bold;margin-left:12px;margin-bottom:0;">Please select the required ratings and enter some comments.</p>';
	}
}

