<?php
// +----------------------------------------------------------------------+
// | COMBINED_BOOKING_VALIDATION  - validates daily booking/payment data  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/combined_booking_validation.php,v 1.07 2006/02/06
//
if (isset($_GET['conditions'])) { // booking conditions accepted - this is a new booking - ensure booking reference null
    unset($_SESSION[$ss]['booking_reference']);
}
if (isset($_SESSION[$ss]['booking_reference'])) { // booking already made - don't validate
    return;
}
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$xmntharray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');
$cardarray = array();
include ('cardarray.php');
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
$property_selected = false;
if (isset($_GET['property'])) {
	$selected_id = $_GET['property'];
	$_GET['r'.$selected_id] = 1;
}
foreach ($resourcearray as $propertyrow) { 
  if (isset($_GET['r'.$propertyrow['property_id']])) { // property id
      $r[$propertyrow['property_id']] = 'CHECKED';
      $property_selected = true;
  }
}
if (isset($_GET['d'])) { //start date dd 
    $d = $_GET['d'];
} else {
    $d = $todaydayx;
}
if (isset($_GET['m'])) { //start date mm
    $m = $_GET['m'];
} else {
    $m = $todaymonthx;
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
if (isset($_GET['g'])) { // number of adult guests over 16
    $g = $_GET['g'];
} else {
    $g = 1;
}
if (isset($_GET['c'])) { // number of children aged 5 - 16
    $c = $_GET['c'];
} else {
    $c = 0;
}
if (isset($_GET['i'])) { // number of infants under 5
    $inf = $_GET['i'];
} else {
    $inf = 0;
}
if (isset($_GET['sr'])) { // special requirements
    $sr = htmlentities($_GET['sr'], ENT_QUOTES);
} else {
    $sr = htmlentities('e.g. cot or other items required for baby; pets to be brought, etc....', ENT_QUOTES);
}
for ($i = 1; $i <= 5; $i++) {  
  if (isset($_GET['o'.$i])) { // optional extras
      $o[$i] = 'CHECKED';
  }
}
include('customer_details_setup.php');

if (isset($_GET['v'])) { // card issue number (Switch) 
    $v = $_GET['v'];
} else {
    $v = '';
}
if (isset($_GET['cv2'])) { // card security code (cv2) 
    $cv2 = $_GET['cv2'];
} else {
    $cv2 = '';
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
if (isset($_GET['fm'])) { // card from month
    $fm = $_GET['fm'];
} else {
    $fm = $todaymonth;
}
if (isset($_GET['fy'])) { // card from year
    $fy = $_GET['fy'];
} else {
    $fy = $todayyear;
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
if (isset($_GET['em'])) { // email flag
    $em = 'CHECKED';
}
if (isset($_GET['ap'])) { // agreed price
    $ap = $_GET['ap'];
} else {
    $ap = null;
}
if (isset($_GET['fpc'])) { // from property calendar
    $fpc = $_GET['fpc'];
} else {
    $fpc = false;
}
// lock booking flag to prevent update conflicts with other users
include('booking_lock.php');

// date has been supplied - validate before use
$start_date = $y.'-'.$m.'-'.$d; // set start date variable
$start_date_day = "";
$departure_date_day = "";
if (($d > 0 && $d < 32) && ($m > 0 && $m < 13) && ($y >= $todayyear && $y <= ($todayyear + 1))) { // date format valid
    $day = $d;
    $month = $m;
    $year = $y; 
    $vdate = mktime(0, 0, 0, $month, $day, $year); // creates valid date from supplied dd mm yyyy values  //
    $vy = date("Y",$vdate);
    $vm = date("m",$vdate);
    $vmx = 0 + $vm; // month excluding leading zero
    $wday = date("w",$vdate);
    $vd = date("d",$vdate);
    $vdx = 0 + $vd; // day excluding leading zero
    // echo $start_date.'<br>'.$vy.'-'.$vm.'-'.$vd.'<br>'.$todayyear.'-'.$todaymonth.'-'.$todayday; 
    if ($start_date != $vy.'-'.$vmx.'-'.$vdx) { // selected date is not valid e.g. 30th Feb
        $error1.='Please enter a valid date.<br>';
    } else {
        $start_date = $vy.'-'.$vm.'-'.$vd; // update date variable with leading zeros
        if ($start_date < $todayyear.'-'.$todaymonth.'-'.$todayday) { // selected date is in the past
            $error1.='Requested date is in the past.<br>';
        } else { // start date is valid - calculate departure date and set day strings
			$start_date_day = $db_object->getOne("SELECT DATE_FORMAT('".$start_date."', '%a')");
            $departure_date = $db_object->getOne("SELECT DATE_FORMAT(date_add('".$start_date."', interval '".$n."' day), '%D %b %y')");
			$departure_date_day = $db_object->getOne("SELECT DATE_FORMAT(date_add('".$start_date."', interval '".$n."' day), '%a')");
        }
    }
} else { // shouldn't get this as date comes from dropdown selections
    $error1.='Please enter a valid date from the list provided.<br>';
}
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
        echo 'Sorry - an error has occurred and the booking has not been recorded. '.
        'Please contact '.$_SESSION[$ss]['company_name'].'.';
        return;
    }
}
// unlock booking flag after preventing update conflicts with other users
include('booking_unlock.php');
?>
