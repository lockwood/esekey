<?php
// +----------------------------------------------------------------------+
// | STATUS  - Esekey Admin Console Status Page                           |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/status.php,v 1.20 2008/06/17
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

$message = false;

$_SESSION[$ss]['view_name'] = '';

if ($_SESSION[$ss]['username'] == 'Administrator') { // allow Admin only to switch companies
    if (isset($_GET['co'])) {
        $_SESSION[$ss]['company_id'] = $_GET['co'];
        $_SESSION[$ss]['_test']= '';
        $message = true;
        $msgtext = 'Switching session to company '.$_SESSION[$ss]['company_id'];
    }
    if (isset($_GET['co_t'])) {
        $_SESSION[$ss]['company_id'] = $_GET['co_t'];
        $_SESSION[$ss]['_test'] = '_test';
        $message = true;
        $msgtext = 'Switching session to TEST company '.$_SESSION[$ss]['company_id'];
    }
	if ($message) {
        $update_table = $db_object->query(
                     "UPDATE userlog 
                         SET reason = '".$_SESSION[$ss]['company_id']."' 
                       WHERE user_id = '".$info['user_id']."' 
                         AND userlog_timestamp = '".$info['userlog_timestamp']."' 
                         AND data = '".$sid."'"); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
	}
    if ($_SESSION[$ss]['company_id'] == 0) {
        $_SESSION[$ss]['company_code'] = '00000'; 
        $_SESSION[$ss]['company_name'] = 'Esekey Limited'; 
        $_SESSION[$ss]['company_telephone'] = '07860 832741';
        $_SESSION[$ss]['company_fax'] = 'None';
        $_SESSION[$ss]['company_email'] = 'info@esekey.com';
    } else {
        $companyrow = $db_object->getRow("SELECT *
                                          FROM company
                                         WHERE company_id = '".$_SESSION[$ss]['company_id']."'");
        $_SESSION[$ss]['company_code'] = $companyrow['company_code']; 
        $_SESSION[$ss]['company_name'] = $companyrow['company_name']; 
        $_SESSION[$ss]['company_telephone'] = $companyrow['company_telephone'];
        $_SESSION[$ss]['company_fax'] = $companyrow['company_fax'];
        $_SESSION[$ss]['company_email'] = $companyrow['company_email'];
        //$msgtext .= ' '.$_SESSION[$ss]['company_name'];
    }
}

$today = $db_object->getOne("SELECT DATE_FORMAT(now(), '%W %D %M %Y')");
$date_today = $db_object->getOne("SELECT CURDATE()");
$date_yesterday = $db_object->getOne("SELECT DATE_SUB('".$date_today."', interval 1 day)");
$autouser = $_SESSION[$ss]['username'].'-auto';
// Update booking status to 'Balance Due' if arrival date is four weeks or less
// Look up deposit rate record if present to get advance_days
$deposits = array();
$deposits = $db_object->getAll("SELECT t2.charge_from,
							   		t2.charge_amount, 		
							   		t2.charge_parameter as advance_days 		
							  FROM 	charge as t1,		
								   	charge_rate as t2
                            WHERE 	t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND 	t1.company_id = t2.company_id
                              AND 	t1.charge_code = t2.charge_code
                              AND 	t1.charge_type = 5
                              AND 	t2.charge_from <= CURDATE()
                         ORDER BY 	t2.charge_from
							");

// Find most recent deposit rate (last row in array)
$advance_days = 28; // default in case none provided in DB
if (count($deposits) > 0)
{
	$selected_row = count($deposits) - 1;
	$advance_days = $deposits[$selected_row]['advance_days'];
}
$res = $db_object->query("
                    UPDATE booking 
                      SET booking_status = 'Balance Due',
                          last_modified_on = now(),
                          last_modified_by = '".$autouser."'
                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                       AND booking_status = 'Deposit Paid'
                       AND arrival_date < DATE_ADD(now(), INTERVAL ".$advance_days." DAY) ");
if (DB::isError($res)) {
    die('booking status update failed....');
}
$res = $db_object->query("
                    SELECT booking_reference 
                      FROM booking
                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                       AND departure_date >= now()
                       AND booking_type <> 2
					   AND booking_status = 'Deposit Due' ");
$deposits_due = $res->numrows();
$res = $db_object->query("
                    SELECT booking_reference 
                      FROM booking
                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                       AND departure_date >= now()
                       AND booking_type <> 2
                       AND booking_status = 'Balance Due' ");
$balances_due = $res->numrows();

$occupancyarray = $db_object->getAll("
                    SELECT DISTINCT
                           t1.booking_reference,
                           t1.booking_status, 
                           t2.last_name,
                           t1.number_adults,
                           t1.number_children,
                           t1.number_infants,
                           t1.arrival_date,
                           t1.departure_date, 
                           DATE_FORMAT(t1.arrival_date, '%D %b') AS arrival_disp,
                           DATE_FORMAT(t1.departure_date, '%D %b') AS departure_disp,
                           t4.property_id 
                      FROM booking AS t1,
                           customer AS t2,
                           calendar_booking AS t3,
                           property AS t4
                     WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                       AND t1.company_id = t2.company_id
                       AND t1.company_id = t3.company_id
                       AND t1.company_id = t4.company_id
                       AND t1.contact_id = t2.customer_id
                       AND t1.booking_reference = t3.booking_reference
                       AND t3.resource_id = t4.property_id
                       AND t4.active_flag = 'Y'
                       AND t1.departure_date >= now()
                  ORDER BY t1.arrival_date");

if (!isset($property_order))
{
	$property_order = "property_name, property_number";
}
$propertyarray = $db_object->getAll("
                    SELECT property_id,
                           property_number,
                           property_name
                      FROM property
                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                       AND active_flag = 'Y'
                  ORDER BY ".$property_order); 
//*/
// archive all activity over 2 months old
$activityarray = $db_object->getAll("SELECT *
                                       FROM activity_log
                                      WHERE time_accessed < DATE_SUB(now(), INTERVAL 2 MONTH)");


foreach ($activityarray as $activityrow) {
  $insert = "INSERT INTO activity_backlog
            VALUES ('".$activityrow['company_id']."',
                    0,
                    '".$activityrow['page_id']."',
                    '".$activityrow['time_accessed']."',
                    '".$activityrow['accessor_address']."', 
                    '".$activityrow['browser_type']."', 
                    '".$activityrow['referred_from']."')";
  $add_member = $db_object->query($insert);
  if (DB::isError($add_member)) {
      echo $add_member->getMessage().' for key '.$activityrow['company_id'].', '.$activityrow['activity_id'];
  } else {
  	  $delete = "DELETE from activity_log
                                   WHERE company_id = '".$activityrow['company_id']."'
                                     AND activity_id = '".$activityrow['activity_id']."'";
      $result = $db_object->query($delete);
  }
}

?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title>Esekey Administration Console</title>
<link rel="stylesheet" href="theme/esekey.css" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//-->
</script>

</head>
<?php
if ($message) { // display msg, then reload page without "co" parameter to update Top and Menu frames without looping //
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="alert('<?=$msgtext?>'); top.Top.GoToURL('EseCompany', 'Administration Home', 'status.php?'); top.Menu.document.location.reload(true); top.Top.document.location.reload(true);">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15">
<?php
} ?>
<p class = "text"><br>
<p class = "text"><b>Welcome to the Esekey&trade; Administration Console V1.20 (17.06.2008).</b> 
<?php
if ($_SESSION[$ss]['username'] == 'Administrator') { // allow Admin only to switch companies
    ?>
<br><br>
  <table width="100%">
   <tr>
    <td valign="top" class="text" nowrap>
      <form action="<?=$_SERVER['PHP_SELF']?>" name="frmCoSelect" id="frmCoSelect" method="get"> 
      <SELECT class="text" NAME="co" onChange="submit();">
      <OPTION VALUE="">Select a company...</OPTION>
      <OPTION VALUE="00000">Esekey Limited</OPTION>    <?php 
    $companyarray = $db_object->getAll("SELECT *
                                          FROM company
                                      ORDER BY company_id");
    foreach ($companyarray as $companyrow) { ?>
      <OPTION VALUE="<?=$companyrow['company_id']?>"><?=$companyrow['company_name']?></OPTION><?php
    } ?>
      </SELECT><br>
	  <input type="hidden" name="sid" value="<?=$sid?>"/>
    </form>
   </td>
  </tr>
   <tr>
    <td valign="top" class="text" nowrap>
      <form action="<?=$_SERVER['PHP_SELF']?>" name="frmTCoSelect" id="frmTCoSelect" method="get"> 
      <SELECT class="text" NAME="co_t" onChange="submit();">
      <OPTION VALUE="00000">Or TEST a company...</OPTION>    <?php 
    $companyarray = $db_object->getAll("SELECT *
                                          FROM company_test
                                      ORDER BY company_id");
    foreach ($companyarray as $companyrow) { ?>
      <OPTION VALUE="<?=$companyrow['company_id']?>"><?=$companyrow['company_name']?></OPTION><?php
    } ?>
      </SELECT><br>
	  <input type="hidden" name="sid" value="<?=$sid?>"/>
    </form>
   </td>
  </tr>
 </table>
<?php
echo count($activityarray)." activity records archived. ";
echo " Session Id is ".$_GET['sid'];
} ?>
<p class = "text"><b>Reminders for <?=$today?></b><br><br> 
<b>1. Payments Due:&nbsp;</b>
<?php
if ($deposits_due > 1) { ?>
<a href="#" onClick="top.Top.GoToURL('EseBooking', 'Deposits Due', 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Deposit+Due&');"><?=$deposits_due?> Deposits Due</a>&nbsp;&nbsp;
<?php
} elseif ($deposits_due == 1) { ?>
<a href="#" onClick="top.Top.GoToURL('EseBooking', 'Deposits Due', 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Deposit+Due&');">1 Deposit Due</a>&nbsp;&nbsp;
<?php
} else { ?>No Deposits Due&nbsp;&nbsp;
<?php
}
if ($balances_due > 1) { ?>
<a href="#" onClick="top.Top.GoToURL('EseBooking', 'Balances Due', 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Balance+Due&');"><?=$balances_due?> Balances Due</a><br><br>
<?php
} elseif ($balances_due == 1) { ?>
<a href="#" onClick="top.Top.GoToURL('EseBooking', 'Balances Due', 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Balance+Due&');">1 Balance Due</a><br><br>
<?php
} else { ?>
No Balances Due<br><br>
<?php
}
$print_recommended = false;
 ?>
<b>2. Occupancy:&nbsp;</b><br><br>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table-border" colspan="3">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <th class="H" width="15%" align="left">Property</th>
          <th class="H" width="12%" align="left">Current Occupant</th>
          <th class="H" width="5%" align="left">Guests</th>
          <th class="H" width="8%" align="left">Departs</th>
          <th class="H" width="12%" align="left">Next Occupant</th>
          <th class="H" width="5%" align="left">Guests</th>
          <th class="H" width="8%" align="left">Arrives</th>
          <th class="H" width="8%" align="left">Departs</th>
        </tr>
        <?php
        foreach ($propertyarray as $propertyrow) {
          if ($show_property_number) {
          	$full_name = ltrim($propertyrow['property_number'].' '.$propertyrow['property_name']);
          } else
          {
          	$full_name = $propertyrow['property_name'];
          }
          $j = 0;
          echo '<tr>';
          echo '<td class="E"><b>'.$full_name.'</b></td>';
          for ($i = 0; $i < count($occupancyarray); $i++) {
            if (($occupancyarray[$i]['property_id'] == $propertyrow['property_id'])
            &&  ($occupancyarray[$i]['booking_status'] != 'Cancelled')) {
                if ($occupancyarray[$i]['arrival_date'] < $date_today) { // current occupant
                	if ($occupancyarray[$i]['arrival_date'] == $date_yesterday) {
                		// occupancy change - set print flag
                		$print_recommended = true;
                	}
                    echo '<td class="E"><a href="#" onClick="top.Top.GoToURL(&quot;';
                    echo 'EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view';
                    echo '&srch1=t1.booking_reference&op1=EQ&val1='.$occupancyarray[$i]['booking_reference'].'&&quot;);">';
                    echo $occupancyarray[$i]['booking_reference'].' ';
                    echo $occupancyarray[$i]['last_name'].'</a></td><td class="E">';
                    echo ($occupancyarray[$i]['number_adults'] + $occupancyarray[$i]['number_children'] + $occupancyarray[$i]['number_infants']).'</td><td class="E">';
                    echo $occupancyarray[$i]['departure_disp'].'</td>';
                    $j++;
                } else { // next arrival
                    if ($j == 0) {
                        echo '<td class="E">--None--</td><td class="E">--</td><td class="E">--</td>';
                        $j++; 
                    }
                    echo '<td class="E"><a href="#" onClick="top.Top.GoToURL(&quot;';
                    echo 'EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view';
                    echo '&srch1=t1.booking_reference&op1=EQ&val1='.$occupancyarray[$i]['booking_reference'].'&&quot;);">';
                    echo $occupancyarray[$i]['booking_reference'].' ';
                    echo $occupancyarray[$i]['last_name'].'</a></td><td class="E">';
                    echo ($occupancyarray[$i]['number_adults'] + $occupancyarray[$i]['number_children'] + $occupancyarray[$i]['number_infants']).'</td><td class="E">';
                    echo $occupancyarray[$i]['arrival_disp'].'</td>';
                    echo '<td class="E">'.$occupancyarray[$i]['departure_disp'].'</td>';
                    $j++;
                    break;
                }
            }
          }
          if ($j == 0) { // no occupant or future arrival found for this property
              echo '<td class="E">--None--</td><td class="E">--</td><td class="E">--</td><td colspan="4" class="E">No bookings</td>';
          }
          if ($j == 1) { // no future arrival found for this property
              echo '<td colspan="4" class="E">No bookings</td>';
          }
          echo '</tr>';  
        } 
        if ($print_recommended) {
        	$change_string = '<b><a title="A gentle reminder that the content of the Occupancy chart has changed - you may wish to print the new details">Note: The occupancy chart has changed today!</a></b>';
        } else {
        	$change_string = '&nbsp;';
        }
        ?>
      </table>
    </td>
  </tr>
  <tr>
	<td height="33" align="right" valign="bottom" colspan="3" class="text" nowrap>
		<?=$change_string?>&nbsp;<input type="button" name="btnPrint" value="Print" class="button" onClick="window.print();">				
	</td>
  </tr>
</table>
</body>
</html>
