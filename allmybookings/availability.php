<?php
// +----------------------------------------------------------------------+
// | Availability  - the EseBooking availability driver - any Company     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2012 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/availability.php,v 1.00 2012/05/30
//

// Set environment variables
if ($_SERVER['SERVER_NAME'] == 'dlockwood') { // test environment variables
    // Environment - test
    $env = 'test';
    // $_test = '_test';

    // Database User - test
    $db_user = 'root';
    $db_name = 'eseData';

    // Document root - test
    $DOCUMENT_ROOT .= '/esekey';

    // Server Name - test
    $servername = 'dlockwood/esekey';

} else { // production environment variables
    // Environment - production

    $env = 'prod';

        // Database User - production
        $db_user = 'esekey9_dlockwoo';
        $db_name = 'esekey9_eseData';

        // Document root - production
        $DOCUMENT_ROOT = '/home/esekey9/public_html';

        // Server Name - production
          $servername = 'phi.securesslhost.net/~esekey9';
}
// Sub Session User type for this directory
$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin

// Username for database identification
$_SESSION[$ss]['username'] = 'guest';

// company id for this request
if (isset($_GET['cid']) && $_GET['cid'] > 0) {
	$_SESSION[$ss]['company_id'] = str_pad($_GET['cid'], 5, "0", STR_PAD_LEFT);
} else {
	echo 'Invalid Request Rejected - Code 1';
	exit;
}
// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

// get data and populate arrays
if ($_SESSION[$ss]['company_id'] != '00000') { //Look for company details in database
    $row = $db_object->getRow("SELECT company_name, 
                                      company_code,
                                      company_telephone,
                                      company_fax,
                                      company_email,
                                      availability_flag,
                                      booking_flag 
                                 FROM company 
                                WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                  AND active_flag = 'Y'");

    $_SESSION[$ss]['company_name'] = $row['company_name']; 
    $_SESSION[$ss]['company_code'] = $row['company_code']; 
    $_SESSION[$ss]['company_telephone'] = $row['company_telephone'];
    $_SESSION[$ss]['company_fax'] = $row['company_fax'];
    $_SESSION[$ss]['company_email'] = $row['company_email'];
    $_SESSION[$ss]['availability_flag'] = $row['availability_flag'];
    $_SESSION[$ss]['booking_flag'] = $row['booking_flag'];
} 
if (!isset($_SESSION[$ss]['company_name'])) {
	print_r($_GET); 
	echo 'Invalid Request Rejected - Code 2';
	exit;
}
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

$propertyarray = $db_object->getAll("SELECT DISTINCT t1.page_id,
                                            t3.property_id,
                                            t3.property_number,
                                            t3.property_name,
                                            t3.price_code,
                                            t4.page_name
                                       FROM page_element as t1,
                                            element as t2,
                                            property as t3,
                                            page as t4
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t3.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t4.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t2.resource_id = t3.property_id
                                        AND t1.element_id = t2.element_id
                                        AND t3.active_flag = 'Y'
                                        AND t4.page_id = t1.page_id
                                   ORDER BY t1.page_id");

if (!isset($property_order))
{
	$property_order = "property_name, property_number";
}

$resourcearray = $db_object->getAll("SELECT *
                                       FROM property
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_flag = 'Y'
                                   ORDER BY ".$property_order); 
if (isset($_GET['grp']) && $_GET['grp'] ==  'p') {	include('availability_prop.php');	return;}$property_selected = false;
$selected_id = 0;
if (isset($_GET['property'])) {
	$selected_id = $_GET['property'];
	$property_selected = true;
}$title = 'Availability';
$page_name = 'Availability';
if ($property_selected) {
	foreach ($resourcearray as $propertyrow) {
		if ($propertyrow['property_id'] == $selected_id) {
			$title .= ' for '.$propertyrow['property_name'];
			$page_name .= ' for '.$propertyrow['property_name'];
		}
	}
}

// Differences from generic popup.php: 
// Based on old page.php without lefthand menu column
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="All My Bookings : Secure Booking "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Booking, Availability, Self Catering, Web, On Line, Real Time, Accommodation, Self-catering, quality, discerning, comfort, luxury"/>
<meta name="abstract" content="Secure Booking."/>
<meta name="description" content="Book on line with security and peace of mind"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="booking.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="midcol" colspan="2" height="100%">
    <?php
    // include the main content of the page
    include('availability_daily.php');
    ?>
    </td>
  </tr>
</table>
</body>
</html>

