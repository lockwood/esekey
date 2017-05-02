<?php  
// +----------------------------------------------------------------------+
// | AVAILABILITY_WEEKLY  - Calculate Start Date for Weekly Availability  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/availability_weekly.php,v 1.00 2003/10/01
//
$viewweeks = 13;
$today = mktime(); // get today's date as timestamp //
$day = date("d",$today); // get today's day including leading zero
$month = date("m",$today); // get today's month including leading zero
$year = date("Y",$today); // et today's 4 digit year
if ($_SESSION[$ss]['date'] > $year.'-'.$month.'-'.$day) {// future date has been supplied - validate before use
    $dy = substr($_SESSION[$ss]['date'],8,2);
    if ($dy > 0 && $dy < 32) { // day valid
        $mnth = (int) substr($_SESSION[$ss]['date'],5,2);
        if ($mnth > 0 && $mnth < 13) { // month valid
            $yr = (int) substr($_SESSION[$ss]['date'],0,4);
            if ($yr >= $year && $yr <= ($year + 2)) { // year valid
                $day = $dy;
                $month = $mnth;
                $year = $yr; 
                $today = mktime(0, 0, 0, $month, $day, $year); // replaces today with valid future date //
            }
        }
    }
}
$year = date("Y",$today);
$month = date("m",$today);
$wday = date("w",$today);
$mday = date("d",$today);
$mday = $mday + 6 - $wday; //Set day of month to next Saturday //

//test month endings //
//$mday = $mday - 7;
//comment above out after test //

$nextsat = mktime(0, 0, 0, $month, $mday, $year);
$startyear = date("Y",$nextsat);
$startmonth = date("m",$nextsat);
$startday = date("d",$nextsat);

include 'view_weekly.php';
//include 'availability.php';
?>
