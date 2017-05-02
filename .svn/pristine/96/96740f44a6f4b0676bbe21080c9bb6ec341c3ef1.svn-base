<?php  
// +----------------------------------------------------------------------+
// | AVAILABILITY  - Calculate Start Date for Daily Availability          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 6/availability_daily.php,v 1.01 2004/11/18
//
if ($_SESSION[$ss]['availability_flag'] == 'N') { // View Availability is not available to public
    if ($ss == 'Admin') { // administrator can view availability while closed to public
        echo '<p style="color: red">Note: Availability is currently only available to the administrator.</p>';
    } else { 
        echo '<br>We are temporarily unable to show current availability here. Please call us on '.$_SESSION[$ss]['company_telephone'].' for latest availability information.';
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
if ($wday < 5) { // if today is not Friday
    // set date to next Friday
    $mday = $day + 5 - $wday;
} elseif ($wday > 5) { // today is Saturday
    // set date to next Friday
    $mday = $day + 12 - $wday;
} else { // today is Friday
    // set date to next Friday
    $mday = $day + 7;
}
//test month endings //
//$mday = $mday - 7;
//comment above out after test //

$nextfri = mktime(0, 0, 0, $month, $mday, $year);
$nextfriyear = date("Y",$nextfri);
$nextfrimonth = date("m",$nextfri);
$nextfriday = date("d",$nextfri);

if (!isset($select_property)) {
    $select_property = '';
}

//include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/view_daily.php');
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/view_weekly.php');
?>
