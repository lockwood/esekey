<?php
// +----------------------------------------------------------------------+
// | GETVIEWDATA  - Esekey Admin Console generic get view row             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getviewdata.php,v 1.06 2005/01/21 (renamed from gettabledata.php)
//
if ($view_name != $_SESSION[$ss]['view_name']) { // user has switched to new view - need to reset page & search criteria 
	$_SESSION[$ss]['view_name'] = $view_name;
    $_SESSION[$ss]['pagenav'] = 1;
    $_SESSION[$ss]['searchstring1'] = '';
}
if (isset($_GET['pagenav'])) {
    $_SESSION[$ss]['pagenav'] = $_GET['pagenav'];
}
$searchstring1 = '';
if (isset($_GET['srch1'])) { // set up searchstring1 for parameter 1 in WHERE clause
    $srch1 = $_GET['srch1'];
    $op1 = $_GET['op1'];
    $val1 = $_GET['val1'];
    if ($op1 == 'GTEQ') { 
        $searchstring1 = ' AND '.$srch1.' >= '.$val1;
    } elseif ($op1 == 'GT') {
        $searchstring1 = ' AND '.$srch1.' > '.$val1;
    } elseif ($op1 == 'LT') {
        $searchstring1 = ' AND '.$srch1.' < '.$val1;
    } elseif ($op1 == 'EQ') {
        $searchstring1 = ' AND '.$srch1.' = "'.$val1.'"';
    } elseif ($op1 == 'LTEQ') {
        $searchstring1 = ' AND '.$srch1.' <= '.$val1;
    } elseif ($op1 == 'NE') {
        $searchstring1 = ' AND '.$srch1.' <> '.$val1;
    }
}
if ($_SESSION[$ss]['searchstring1'] != $searchstring1) { // search string has changed
	if ($searchstring1 != '') { // new search string built - update sub session and go to page 1
        $_SESSION[$ss]['searchstring1'] = $searchstring1;
        $_SESSION[$ss]['pagenav'] = 1;
    } else { // no search string was provided - use string from sub session
        $searchstring1 = $_SESSION[$ss]['searchstring1'];
    }
}

if ($view_name == 'image') { // build composite view for images
    // echo 'include getimagedata<br>';
    include ('getimagedata.php');
    return;
}

if ($view_name == 'element') { // build composite view for elements
    // echo 'include getelementdata<br>';
    include ('getelementdata.php');
    return;
}

if ($view_name == 'page') { // build composite view for elements
    // echo 'include getpagedata<br>';
    include ('getpagedata.php');
    return;
}

if ($view_name == 'event_view') { // build composite view for events
    // echo 'include geteventdata<br>';
    include ('geteventdata.php');
    return;
}

if ($view_name == 'cleaning') { // build composite view for cleaning rota
    // echo 'include getcleaningdata<br>';
    include ('getcleaningdata.php');
    return;
}

if ($view_name == 'bbmanage') { // build composite view for b&b options
    // echo 'include getbbpricedata<br>';
	if (isset($_GET[start_date]))
	{
		$start_date = $_GET[start_date];
	} else
	{
		$start_date = date('Y-m-d');
	}
	$n = 7;
    include ($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/getbbpricedata.php');
    return;
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
                                        WHERE t1.view_name = '".$view_name."'
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

if ($view_name == 'gallery') { // build composite view for bookings
    // echo 'include getgallerydata<br>';
    include ('getgallerydata.php');
    return;
}

if ($view_name == 'booking_view') { // build composite view for bookings
    // echo 'include getbookingdata<br>';
	if ($searchstring1 == ' AND t1.booking_status = "Cancelled"')
	{
		include ('getcancelledbookingdata.php');
		return;
	}
    include ('getbookingdata.php');
    return;
}

if ($view_name == 'enquiry_view') { // build composite view for enquiries
    // echo 'include getenquirydata<br>';
    include ('getenquirydata.php');
    return;
}

if ($view_name == 'customer') { 
    // customer subsystem is not keyed on company_id
    // uses its own sql queries 
    include ('getcustomerdata.php');
    return;
}

$stmts = false;
if ($view_name == 'commission_stmts') {
    // get data from commission table
    $view_name = 'commission';
    $stmts = true;
}

if (($view_name == 'company') or ($view_name == 'email') or ($view_name == 'commission')) { 
    // view has test and prod modes 
    $table_name = $view_name.$_SESSION[$ss]['_test']; 
} else {
    $table_name = $view_name; 
}
if (!isset($property_order))
{
	$property_order = "property_name, property_number";
}

if ($view_name == 'property') {
	$order_by = ' ORDER BY active_flag DESC, '.$property_order;
}
//ORDER BY price_code, start_date, max_nights 
if ($view_name == 'price') {
	$order_by = ' ORDER BY price_code, start_date DESC, max_nights';
}

// get view data and initialise array
// echo "SELECT ".$select." FROM ".$table_name." WHERE company_id = '".$_SESSION[$ss]['company_id']."'".$searchstring1.$order_by;
$viewarray = $db_object->getAll("SELECT ".$select." FROM ".$table_name." WHERE company_id = '".$_SESSION[$ss]['company_id']."'".$searchstring1.$order_by);
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
if ($stmts == true) {
    // reset view name
    $view_name = 'commission_stmts';
}

?>