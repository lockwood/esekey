<?php  
// +----------------------------------------------------------------------+
// | AVAILABILITY  - Calculate Start Date for Daily Availability          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/availability_daily.php,v 1.01 2004/11/18
//
if ($_SESSION[$ss]['availability_flag'] == 'N') { // View Availability is not available to public
    if ($ss == 'Admin') { // administrator can view availability while closed to public
        echo '<p style="color: red">Note: Availability is currently only available to the administrator.</p>';
    } else { 
        echo '<p>We are temporarily unable to show current availability here. Please call us on '.$_SESSION[$ss]['company_telephone'].' for latest availability information.</p>';
        return;
    }
}
$today = mktime(); // get today's date as timestamp //
$todayday = date("d",$today); // get today's day including leading zero
$todaymonth = date("m",$today); // get today's month including leading zero
$todayyear = date("Y",$today); // get today's 4 digit year
$_SESSION[$ss]['todaydate'] = $todayyear.'-'.$todaymonth.'-'.$todayday; // set today's date in session
if (isset($_GET['sd'])) {
    $_SESSION[$ss]['selecteddate'] = $_GET['sd'];
} else {
    $_SESSION[$ss]['selecteddate'] = $_SESSION[$ss]['todaydate'];
}
if ($_SESSION[$ss]['selecteddate'] > $_SESSION[$ss]['todaydate']) {// future date has been supplied - validate before use
    $dy = substr($_SESSION[$ss]['selecteddate'],8,2);
    if ($dy > 0 && $dy < 32) { // day valid
        $mnth = (int) substr($_SESSION[$ss]['selecteddate'],5,2);
        if ($mnth > 0 && $mnth < 13) { // month valid
            $yr = (int) substr($_SESSION[$ss]['selecteddate'],0,4);
            if ($yr >= $todayyear && $yr < ($todayyear + 2)) { // year valid
                if ($yr > $todayyear && $mnth < $todaymonth) { // year valid
                    $today = mktime(0, 0, 0, $mnth, $dy, $yr); // replaces today with valid future date //
                }
                if ($yr == $todayyear && $mnth >= $todaymonth) { // year valid
                    $today = mktime(0, 0, 0, $mnth, $dy, $yr); // replaces today with valid future date //
                }
            }
        }
    }
}
$year = date("Y",$today);
$month = date("m",$today);
$wday = date("w",$today);
$day = date("d",$today);
if ($wday < 6) { // if today is not Saturday
    // set date to last Saturday
    $mday = $day - $wday - 1;
} else {
    $mday = $day;
}
//test month endings //
//$mday = $mday - 7;
//comment above out after test //

$prevsat = mktime(0, 0, 0, $month, $mday, $year);
$prevsatyear = date("Y",$prevsat);
$prevsatmonth = date("m",$prevsat);
$prevsatday = date("d",$prevsat);

if (isset($selected_id)) {
	if ($selected_id == 0) {
	    $select_property = '';
	} else {
		$select_property = " AND t1.resource_id = '".$selected_id."' ";
	}
}
if (!isset($select_property)) {
    $select_property = '';
}

include $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/view_daily.php';
//include 'view_weekly.php';
?>
