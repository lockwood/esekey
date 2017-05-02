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
$prevsatday = date("d",$prevsat);$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');$monthnumarray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');$daynamearray = array('','Sa','Su','Mo','Tu','We','Th','Fr','Sa');$_SESSION[$ss]['selecteddate'] = $year.'-'.$month.'-'.$day; // set current date in session$_SESSION[$ss]['prevsatdate'] = $prevsatyear.'-'.$prevsatmonth.'-'.$prevsatday; // set previous Saturday date in session// Format start dates for display //$j = 0 + $todaymonth; // $j is integer index for montharray - cannot have leading zero$display_nav[] = $montharray[$j].' '.$todayyear;$nav[] = $_SESSION[$ss]['todaydate'];for ($k = 1; $k <= 11; $k++) {    $j++;    if ($j > 12) {        $todayyear++;        $j = 1;    }    $display_nav[$k] = $montharray[$j].' '.$todayyear;    $nav[$k] = $todayyear.'-'.$monthnumarray[$j].'-01';}?><form action="<?=$_SERVER[PHP_SELF]?>" name="frmAvail" id="frmAvail" method="get">	<input type="hidden" name="cid" value="<?=$_GET['cid']?>" />	<input type="hidden" name="grp" value="<?=$_GET['grp']?>" />  <table width="100%" style="margin-bottom:20px;">   <tr>   <td>    <table style="width:158px;">     <tr><td colspan="2"><b>Key:<b></td></tr>     <tr><td width="22" class="E" nowrap>10</td><td class="fill" nowrap>Available</td></tr>     <tr><td class="P" nowrap>11</td><td class="fill" nowrap>Provisionally&nbsp;Booked</td></tr>     <tr><td class="C" nowrap>12</td><td class="fill" nowrap>Booked</td></tr>    </table>   </td>    <td valign="top" align="right" style="font-size: 12;vertical-align:top;"><b>From:</b>    <SELECT NAME="sd" onChange="submit();"><?php for ($k = 0; $k <= 11; $k++) {  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>      <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php  } else { ?>      <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php  }} ?>    </SELECT>   </td>   <td width="60%" align="right">&nbsp;</td>  </tr> </table></form><div class="parent-div"><?php include 'view_prop_external.php';?></div>
<table><tr><td colspan="5" class="fill" style="text-align:center;"><i><br/>The information in this table is current and is updated online.&nbsp;  <?='Last real time update '.substr($last_updated,6,2).'/'.substr($last_updated,4,2).'/'.substr($last_updated,0,4).' '.substr($last_updated,8,2).':'.substr($last_updated,10,2).':'.substr($last_updated,12)?></i>  </td></tr></table> 