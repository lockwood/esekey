<?php
// +----------------------------------------------------------------------+
// | COMBINED_BOOKING_VALIDATION  - validates daily booking/payment data  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 5/combined_booking_validation.php,v 1.04 2005/07/20
//
if (isset($_GET['conditions'])) { // booking conditions accepted - this is a new booking - ensure booking reference null
    unset($_SESSION[$ss]['booking_reference']);
}
if (isset($_SESSION[$ss]['booking_reference'])) { // booking already made - don't validate
    return;
}
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$xmntharray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');
$titlearray = array('','Mr','Mrs','Miss','Ms');
$cardarray = array('','Visa','Mastercard','Switch','Maestro','Delta');
$today = mktime(); // get today's date as timestamp //
$todayday = date("d",$today); // get today's day including leading zero
$todaymonth = date("m",$today); // get today's month including leading zero
$todaydayx = 0 + $todayday; // get today's day excluding leading zero
$todaymonthx = 0 + $todaymonth; // get today's month excluding leading zero
$todayyear = date("Y",$today); // get today's 4 digit year
unset($error1); //clear previous step 1 error messages, if any 
unset($error2); //clear previous step 2 error messages, if any 
$additional_info = ''; // clear additional info, if any
// get any form values already entered  
foreach ($propertyarray as $propertyrow) { 
  if (isset($_GET['r'.$propertyrow['property_id']])) { // property id
      $r[$propertyrow['property_id']] = 'CHECKED';
  }
}
if (isset($_GET['pr'])) { //property 
    $pr = $_GET['pr'];
    $r[$pr] = 'CHECKED';
} else {
    $pr = 0;
}
if (isset($_GET['d'])) { //start date dd 
    $d = $_GET['d'];
} else {
    $d = $todayday;
}
if (isset($_GET['m'])) { //start date mm
    $m = $_GET['m'];
} else {
    $m = $todaymonth;
}
if (isset($_GET['y'])) { // start date ccyy
    $y = $_GET['y'];
} else {
    $y = $todayyear;
}
if (isset($_GET['n'])) { // number of nights
    $n = $_GET['n'];
} else {
    $n = 1;
}
if (isset($_GET['g'])) { // number of paying guests
    $g = $_GET['g'];
} else {
    $g = 1;
}
if (isset($_GET['c'])) { // number of children under 5
    $c = $_GET['c'];
} else {
    $c = 0;
}
if (isset($_GET['i'])) { // number of children under 5
    $inf = $_GET['i'];
} else {
    $inf = 0;
}
if (isset($_GET['sr'])) { // special requirements
    $sr = htmlentities($_GET['sr'], ENT_QUOTES);
} else {
    $sr = htmlentities('e.g. cot or other items required for baby; pets to be brought, etc....', ENT_QUOTES);
}
for ($i = 1; $i <= 2; $i++) {  
  if (isset($_GET['o'.$i])) { // offers - waive minimum charge & rowing group
      $o[$i] = 'CHECKED';
  }
}
if (isset($_GET['f'])) { // first name
    $f = htmlentities($_GET['f'], ENT_QUOTES);
} else {
    $f = '';
}
if (isset($_GET['l'])) { // last name
    $l = htmlentities($_GET['l'], ENT_QUOTES);
} else {
    $l = '';
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
if (isset($_GET['u'])) { // telephone number
    $u = htmlentities($_GET['u'], ENT_QUOTES);
} else {
    $u = '';
}
if (isset($_GET['e'])) { // email address
    $e = $_GET['e'];
} else {
    $e = '';
}
if (isset($_GET['v'])) { // card issue number (Switch) 
    $v = $_GET['v'];
} else {
    $v = '';
}
if (isset($_GET['z'])) { // card number
    $z = $_GET['z'];
} else {
    $z = '';
}
if (isset($_GET['w'])) { // card type 
    $w = $_GET['w'];
} else {
    $w = 1;
}
if (isset($_GET['xm'])) { // card expiry month
    $xm = $_GET['xm'];
} else {
    $xm = $todaymonth;
}
if (isset($_GET['xy'])) { // card expiry year
    $xy = $_GET['xy'];
} else {
    $xy = $todayyear;
}
if ($ss == 'Admin') { // get customer list for Admin Console dropdown
    include('dropdown_validate.php');
}
// lock booking flag to prevent update conflicts with other users
include('booking_lock.php');
// validate form fields
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/validate.php');
if (!isset($error1)) { // if all details are valid, calculate price
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/price.php');
}
if ((isset($_GET['requestBooking'])) && (!isset($error1)) && (!isset($error2))) { // user has confirmed valid booking request
    if (!isset($_SESSION[$ss]['booking_reference'])) { // check this booking has not already been made
        include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/reserve.php');
        include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/email.php');
    }
    if (!isset($_SESSION[$ss]['booking_reference'])) { // booking has not been made successfully
        die('Sorry - an error has occurred and the booking has not been recorded. '.
        'Please contact '.$_SESSION[$ss]['company_name'].'.');
        return;
    }
}
// unlock booking flag after preventing update conflicts with other users
include('booking_unlock.php');
?>
