<?php
// +----------------------------------------------------------------------+
// | COMBINED_BOOKING_VALIDATION  - validates daily booking/payment data  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/combined_booking_validation.php,v 1.07 2006/09/03
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

$today = $db_object->getOne("SELECT CURDATE()");
$dow = $db_object->getOne("SELECT DATE_FORMAT('".$today."', '%w')");
$todayyear = $db_object->getOne("SELECT DATE_FORMAT('".$today."', '%Y')");
if ($dow == 6)
{ // today is Saturday - start taking bookings from next Saturday
    $diff = 7;
} else
{ // start taking bookings from next Saturday
    $diff = 6 - $dow;
}
$today_date = $db_object->getOne("SELECT DATE_FORMAT('".$today."', '%Y%m%d')");
$today_day = substr($today_date, 6, 2);
$today_dayx = 0 + $today_day;
$today_month = substr($today_date, 4, 2);
$today_monthx = 0 + $today_month;
$today_year = 0 + substr($today_date, 0, 4);

$saturday_date = $db_object->getOne("SELECT DATE_FORMAT(date_add('".$today."', interval '".$diff."' day), '%Y%m%d')");
$sat_day = substr($saturday_date, 6, 2);
$sat_dayx = 0 + $sat_day;
$sat_month = substr($saturday_date, 4, 2);
$sat_monthx = 0 + $sat_month;
$sat_year = 0 + substr($saturday_date, 0, 4);

unset($error1); //clear previous step 1 error messages, if any 
unset($error2); //clear previous step 2 error messages, if any 
$additional_info = ''; // clear additional info, if any
// get any form values already entered  
foreach ($resourcearray as $propertyrow) { 
  if (isset($_GET['r'.$propertyrow['property_id']])) { // property id
      $r[$propertyrow['property_id']] = 'CHECKED';
  }
}
if (isset($_GET['d'])) { //start date dd 
    $d = $_GET['d'];
    $bb_d = $_GET['d'];
} else {
    $d = $sat_dayx;
    $bb_d = $today_dayx;
}
if (isset($_GET['m'])) { //start date mm
    $m = $_GET['m'];
    $bb_m = $_GET['m'];
} else {
    $m = $sat_monthx;
    $bb_m = $today_monthx;
}
if (isset($_GET['y'])) { // start date ccyy
    $y = $_GET['y'];
    $bb_y = $_GET['y'];
} else {
    $y = $sat_year;
    $bb_y = $today_year;
}
if (isset($_GET['ymd'])) { // combined date ccyymmdd
    $combined_date = $_GET['ymd'];
    $d = 0 + substr($combined_date, 6, 2);
    $m = 0 + substr($combined_date, 4, 2);
    $y = 0 + substr($combined_date, 0, 4);
}
if (isset($_GET['book_bb'])) { // bed & breakfast?
    $book_bb = $_GET['book_bb'];
} else {
	$book_bb = $_GET['bb'];
}
if (isset($_GET['n'])) { // number of nights
    $n = $_GET['n'];
} else {
	if ($book_bb == 'yes')
	{
		$n = 1;
	} else
	{
		$n = 7;
	} 
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
if (isset($_GET['sgl'])) { // number of sleeps 1 rooms (b&b)
    $sgl = $_GET['sgl'];
} else {
    $sgl = 0;
}
if (isset($_GET['dbl'])) { // number of sleeps 2 double rooms (b&b)
    $dbl = $_GET['dbl'];
} else {
    $dbl = 0;
}
if (isset($_GET['twn'])) { // number of sleeps 2 twin rooms (b&b)
    $twn = $_GET['twn'];
} else {
    $twn = 0;
}
if (isset($_GET['sr'])) { // special requirements
    $sr = htmlentities($_GET['sr'], ENT_QUOTES);
} else {
    $sr = '';
}
for ($i = 1; $i <= 5; $i++) {  
  if (isset($_GET['o'.$i])) { // optional extras
      $o[$i] = 'CHECKED';
  }
}
if (isset($_GET['t'])) { // title
    $t = $_GET['t'];
} else {
    $t = '';
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
if (isset($_GET['ouk'])) { // outside UK checkbox
    $ouk = 'CHECKED';
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
    $fm = $sat_month;
}
if (isset($_GET['fy'])) { // card from year
    $fy = $_GET['fy'];
} else {
    $fy = $sat_year;
}
if (isset($_GET['xm'])) { // card expiry month
    $xm = $_GET['xm'];
} else {
    $xm = $sat_month;
}
if (isset($_GET['xy'])) { // card expiry year
    $xy = $_GET['xy'];
} else {
    $xy = $sat_year;
}
if (isset($_GET['em'])) { // email flag
    $em = 'CHECKED';
}
if (isset($_GET['ap'])) { // agreed price
    $ap = $_GET['ap'];
} else {
    $ap = null;
}
// lock booking flag to prevent update conflicts with other users
include('booking_lock.php');
if ($ss == 'Admin') { // get customer list for Admin Console dropdown
    include('dropdown_validate.php');
}
// date has been supplied - validate before use
$start_date = $y.'-'.$m.'-'.$d; // set start date variable
if (($d > 0 && $d < 32) && ($m > 0 && $m < 13) && ($y >= $sat_year && $y <= ($sat_year + 1))) { // date format valid
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
    // echo $start_date.'<br>'.$vy.'-'.$vm.'-'.$vd.'<br>'.$sat_year.'-'.$sat_month.'-'.$sat_day; 
    if ($start_date != $vy.'-'.$vmx.'-'.$vdx) { // selected date is not valid e.g. 30th Feb
        $error1.='Please enter a valid date.<br>';
    } else {
        $start_date = $vy.'-'.$vm.'-'.$vd; // update date variable with leading zeros
        if ($start_date < $today_year.'-'.$today_month.'-'.$today_day) { // selected date is in the past
            $error1.='Requested date is in the past.<br>';
        } else { // start date is valid - calculate departure date
            $departure_date = $db_object->getOne("SELECT DATE_FORMAT(date_add('".$start_date."', interval '".$n."' day), '%a %D %b %Y')");
        }
    }
} else { // shouldn't get this as date comes from dropdown selections
    $error1.='Please enter a valid date from the list provided.<br>';
}
$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");
$olympic_nights = 0;
if (isset($_GET['n'])) {
	// echo 'end_date='.$end_date.'; start_date='.$start_date;
	if ($end_date > '2012-07-21' && $start_date < '2012-08-13') {
		// Olympic rates and restrictions apply
		$day = $start_date;
		for ($i=0;$i<$n;$i++) {
			if ($day > '2012-07-25' && $day < '2012-08-13') {
				$olympic_nights++;
			}
			$day = date('Y-m-d', strtotime($day.' + 1 day'));
		}
	}
}
if ($olympic_nights > 0 && $n < 7) {
	$error1 = 'Olympics booking restrictions apply (26 Jul - 12 Aug 2012).<br>Any Olympics booking must include a minimum of 7 nights.<br>';
}
// validate form fields
if (!isset($error1)) { // if date details are valid, validate rest of form
	if ($book_bb == 'yes')
	{
		include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/validate_bb.php');
	} else
	{
		include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/validate.php');
	}
} else 
{
	$labels = array();
	$dailies = array();
	$percents = array();
}
if (!isset($error1)) { // if all details are valid, calculate price
	if ($book_bb == 'yes')
	{
		include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/price_bb.php');
	} else
	{
		include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/price.php');
	}	
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
