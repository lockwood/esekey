<?php 
// +----------------------------------------------------------------------+
// | CUSTOMER_DETAILS_SETUP  - shared with bookings and enquiries co 9    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 9/customer_details_setup.php,v 1.00 2007/08/24
//

if (isset($enquiry['contact_id']) && $enquiry['contact_id'] > 0)
{
	// load details from specified enquiry
	$cust_id = $enquiry['contact_id'];
	$customer = $db_object->getRow("SELECT *
                                       FROM customer
                                      WHERE customer_id = ".$enquiry['contact_id']."
                                        AND company_id = '".$_SESSION[$ss]['company_id']."'");
} else
{
	$customer = array();
	$customer['customer_company_id'] = 0;
	$customer['title'] = '';
	$customer['first_name'] = '';
	$customer['last_name'] = '';
	$customer['telephone'] = '';
	$customer['telephone_alt'] = '';
	$customer['email'] = '';
}
if (!isset($enquiry['enquiry_notes'])) $enquiry['enquiry_notes'] = '';
$titlearray = array('','Mr','Mrs','Miss','Ms');
if (isset($_GET['co'])) { // customer company name - if applicable
    $co = htmlentities($_GET['co'], ENT_QUOTES);
} else {
	if ($customer['customer_company_id'] > 0) 
	{
		// print_r($customer);
		$co = $db_object->getOne("SELECT customer_company_name
                                       FROM customer_company
                                      WHERE customer_company_id = ".$customer['customer_company_id']."
                                        AND company_id = '".$_SESSION[$ss]['company_id']."'");
		$co_id = $customer['customer_company_id'];
	} else {
		$co = '';
	}
}
if (isset($_GET['t'])) { // title
    $t = $_GET['t'];
} else {
    $t = $customer['title'];
}
if (isset($_GET['f'])) { // first name
    $f = htmlentities($_GET['f'], ENT_QUOTES);
} else {
    $f = $customer['first_name'];
}
if (isset($_GET['l'])) { // last name
    $l = htmlentities($_GET['l'], ENT_QUOTES);
} else {
    $l = $customer['last_name'];
}
if (isset($_GET['a'])) { // post address
    $a = htmlentities($_GET['a'], ENT_QUOTES);
} else {
    $a = '';
}
if (isset($_GET['q'])) { // post code
    $q = $_GET['q'];
} else {
    $q = '';
}
if (isset($_GET['ouk'])) { // outside UK checkbox
    $ouk = 'CHECKED';
}
if (isset($_GET['u'])) { // telephone number
    $u = htmlentities($_GET['u'], ENT_QUOTES);
} else {
    $u = $customer['telephone'];
}
if (isset($_GET['u1'])) { // alt telephone number
    $u1 = htmlentities($_GET['u1'], ENT_QUOTES);
} else {
    $u1 = $customer['telephone_alt'];
}
if (isset($_GET['e'])) { // email address
    $e = $_GET['e'];
} else {
    $e = $customer['email'];
}

if (isset($_GET['add_tenant'])) { // add tenant now flag
    $add_tenant = $_GET['add_tenant'];
} else {
    $add_tenant = 'no';
}


if (isset($_GET['f_t']) && $add_tenant == 'yes') { // first name tenant
    $f_t = htmlentities($_GET['f_t'], ENT_QUOTES);
} else {
    $f_t = '';
}
if (isset($_GET['l_t']) && $add_tenant == 'yes') { // last name tenant
    $l_t = htmlentities($_GET['l_t'], ENT_QUOTES);
} else {
    $l_t = '';
}
if (isset($_GET['a_t']) && $add_tenant == 'yes') { // post address tenant
    $a_t = htmlentities($_GET['a_t'], ENT_QUOTES);
} else {
    $a_t = '';
}
if (isset($_GET['q_t']) && $add_tenant == 'yes') { // post code tenant
    $q_t = $_GET['q_t'];
} else {
    $q_t = '';
}
if (isset($_GET['ouk_t']) && $add_tenant == 'yes') { // outside UK checkbox tenant
    $ouk_t = 'CHECKED';
}
if (isset($_GET['u_t']) && $add_tenant == 'yes') { // telephone number tenant
    $u_t = htmlentities($_GET['u_t'], ENT_QUOTES);
} else {
    $u_t = '';
}
if (isset($_GET['u1_t']) && $add_tenant == 'yes') { // alt telephone number tenant
    $u1_t = htmlentities($_GET['u1_t'], ENT_QUOTES);
} else {
    $u1_t = '';
}
if (isset($_GET['e_t']) && $add_tenant == 'yes') { // email address tenant
    $e_t = $_GET['e_t'];
} else {
    $e_t = '';
}
if (isset($_GET['notes'])) { // enquiry notes
    $notes = htmlentities($_GET['notes'], ENT_QUOTES);
} else {
    $notes = $enquiry['enquiry_notes'];
}
unset($error2); //clear previous step 2 error messages, if any 
if ($ss == 'Admin') { // get customer and company lists for Admin Console dropdown
    include('dropdown_validate.php');
}

?>