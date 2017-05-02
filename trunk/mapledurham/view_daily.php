<?php 
// +----------------------------------------------------------------------+
// | VIEW_DAILY  - Calculate and Layout Daily Availability              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/view_daily.php,v 1.07 2005/07/20
//
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
$monthnumarray = array('','01','02','03','04','05','06','07','08','09','10','11','12','01');
$daynamearray = array('','Sa','Su','Mo','Tu','We','Th','Fr','Sa');
$_SESSION[$ss]['selecteddate'] = $year.'-'.$month.'-'.$day; // set current date in session
$_SESSION[$ss]['nextfridate'] = $nextfriyear.'-'.$nextfrimonth.'-'.$nextfriday; // set next Friday date in session
// set display status on recently expired bookings to show available dates
$update_expired_bookings = $db_object->query("UPDATE booking".$_test." 
                                                 SET display_status = 'E',
                                                     last_modified_on = now()
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                                 AND display_status != 'E'
                                                 AND expiry < now()");
if (DB::isError($update_expired_bookings)) {
    die($update_expired_bookings->getMessage());
}

//read from table where date > start date and date < start date + 184 days (~6 months) 
//if records not found, insert new ones up to end date for selected period using mysql date_add (interval) function. 

$datearray = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.property_name
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['nextfridate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['nextfridate']."', interval 184 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.property_id = t1.resource_id
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t1.resource_id,
                                        booking_day");

// echo 'Date Count: '.count($datearray).'<br><br>';
// echo 'Prop Count: '.count($propertyarray).'<br><br>';

if ($select_property == '') {
    $property_count = count($propertyarray);
} else {
    $property_count = 1;
} 

if (count($datearray) < ($property_count*184)) { // need to add some dates
    $number_inserted = 0;
    $insert = "INSERT INTO booking 
                VALUES ('".$_SESSION[$ss]['company_id']."',
                        0, 
	                    1, 
                        '".$_SESSION[$ss]['nextfridate']."', 
                        date_add('".$_SESSION[$ss]['nextfridate']."', interval 196 day), 
                        0, 
                        0, 
                        0, 
                        0, 
                        0, 
                       now(),
                        now(),
                        'E', 
                        'D',
                        '', 
					    '',
                        '".$_SESSION[$ss]['username']."', 
                        null,
						null)";
    $add_member = $db_object->query($insert);

    if (DB::isError($add_member)) {
        die($add_member->getMessage());
    }
    // return booking_reference  //
    $booking_reference = mysql_insert_id();  
    // echo 'Booking Ref: '.$booking_reference.'<br><br>';
    foreach ($propertyarray as $propertyrow) {
        $dow = 5; // set day of week to Friday
        for ($i = 0; $i <= 198; $i++) {
            $insert = "INSERT INTO calendar_booking 
                        VALUES ('".$_SESSION[$ss]['company_id']."',
                                '".$propertyrow['property_id']."', 
                                date_add('".$_SESSION[$ss]['nextfridate']."', interval '".$i."' day), 
                                '".$dow."', 
                                '".$booking_reference."', 
                                '".$_SESSION[$ss]['username']."', 
                                null)";
            $add_member = $db_object->query($insert);
            if (!DB::isError($add_member)) {
                $number_inserted++;
            }
            $dow++;
            if ($dow > 6) { // day of week starts at Sunday = 0 thru Saturday = 6
                $dow = 0;
            }
        }
    }
    // echo 'Rows Inserted: '.$number_inserted.'<br><br>';
    $datearray = $db_object->getAll("SELECT t1.resource_id,
                                            t1.day_of_week,
                                            DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                            DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                            DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                            t1.booking_reference, 
                                            t2.display_status, 
                                            t2.expiry,
                                            t3.property_name 
                                       FROM calendar_booking".$_test." AS t1, 
                                            booking".$_test." AS t2,
                                            property AS t3 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['nextfridate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['nextfridate']."', interval 184 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
                                        AND t3.property_id = t1.resource_id
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        t1.resource_id,
                                        booking_day");

    // echo 'New Date Count: '.count($datearray).'<br><br>';
 
}

$last_updated = $db_object->getOne("SELECT MAX(last_modified_on)
                                      FROM booking".$_test."
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'");

// Format start dates for display //
$j = 0 + $todaymonth; // $j is integer index for montharray - cannot have leading zero
$display_nav[] = $montharray[$j].' '.$todayyear;
$nav[] = $_SESSION[$ss]['todaydate'];
for ($k = 1; $k <= 11; $k++) {
    $j++;
    if ($j > 12) {
        $todayyear++;
        $j = 1;
    }
    $display_nav[$k] = $montharray[$j].' '.$todayyear;
    $nav[$k] = $todayyear.'-'.$monthnumarray[$j].'-01';
}
$c_year = $datearray[0]['booking_year'];
$disp_year = $datearray[0]['booking_year'];
$c_month = $datearray[0]['booking_month'];
$month_count = 1;
$c_name = $datearray[0]['property_name'];
$c_day = 1; // start at beginning of row
$i = 0;
if ($ss == 'User') {
?>
<form action="<?=$_SERVER[PHP_SELF]?>" name="frmAvail" id="frmAvail" method="get">
  <table width="100%">
   <tr>
    <td valign="top" nowrap><b>For 6 month period beginning 
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 11; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
              <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php
  }
} ?>
    </SELECT><br>(Select from list)</b>
   </td>
   <td valign="top" width="10%" align="right"><b>Key:<b></td>
   <td>
    <table>
     <tr><td width="22" class="E" nowrap>&nbsp;</td><td class="fill" nowrap>Available</td></tr>
     <tr><td class="P" nowrap>&nbsp;</td><td class="fill" nowrap>Provisionally Booked</td></tr>
     <tr><td class="C" nowrap>&nbsp;</td><td class="fill" nowrap>Booked</td></tr>
    </table>
   </td>
   <td>&nbsp;</td>
  </tr>
 </table>
</form>
<?php
} else {
?>
<form action="admin_availability.php" name="frmAdAvail" id="frmAdAvail" method="get">
For 6 month period beginning (Select from list) &nbsp;
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 11; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
              <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php
  }
} ?>
    </SELECT>
</form>
<br>
<?php
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0"><?php
while ($month_count <= 6) { ?>
  <tr>
    <td height="100%">
      <table height="100%" width="100%" border="0"><?php
       if ($month_count == 1) { ?> 
        <tr><td class="fill">&nbsp;</td></tr><?php
       }
       if ($disp_year > 0) { ?>
        <tr><td class="year"><?=$disp_year?></td></tr><?php
       } ?>
        <tr><td height="100%" valign="top" class="year"><?=$montharray[(0 + $c_month)]?></td></tr>
      </table>
    </td> 
  <?php
  while ($datearray[$i]['booking_month'] == $c_month) { ?>
    <td>
      <table width="100%" border="0"><?php
      if ($disp_year > 0) { 
          if ($month_count == 1) { ?> 
        <tr><td class="year-center" colspan="7"><?=$c_name?></td></tr><?php
          } ?>
        <tr>
          <td class="year-center">Fr</td>
          <td class="year-center">Sa</td>
          <td class="year-center">Su</td>
          <td class="year-center">Mo</td>
          <td class="year-center">Tu</td>
          <td class="year-center">We</td>
          <td class="year-center">Th</td>
        </tr>
      <?php
      } ?>
        <tr>
        <?php 
        if ($datearray[$i]['day_of_week'] < 5) { // 1st week of month does not start on Friday 
            for ($j = -2; $j < $datearray[$i]['day_of_week']; $j++) {
                ?>
                <td class="fill">&nbsp;</td><?php
                $c_day++;
            }
        } elseif ($datearray[$i]['day_of_week'] > 5) { // 1st week of month starts on Saturday 
            ?>
                <td class="fill">&nbsp;</td><?php
                $c_day++;
        }
        while (($datearray[$i]['property_name'] == $c_name) && ($datearray[$i]['booking_month'] == $c_month)) {
            if ($c_day > 7) { // new row needed
                $c_day = 1;  ?>
        </tr>
        <tr>
            <?php 
            } ?>
            <td class="<?=$datearray[$i]['display_status']?>">
            <?php
            if (($datearray[$i]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
                echo '<a href="#"
                onClick="top.Top.GoToURL(&quot;EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view&srch1=t1.booking_reference&op1=EQ&val1='.$datearray[$i]['booking_reference'].'&quot;);"
                onMouseOver="return window.status=&quot;EseBooking&trade; &gt; Selected Booking&quot;;"
                onMouseOut="return window.status=&quot;&quot;;">'.$datearray[$i]['booking_day'].'</a></td>';
            } else {
                echo $datearray[$i]['booking_day'].'</td>';
            }
            $i++;
            $c_day++;
        }
        $c_name = $datearray[$i]['property_name'];
        $c_day = 1; //ready for next block of dates
        ?>
        </tr>
      </table>
    </td>
  <?php 
  } ?>  
  </tr><?php
  $month_count++;
  $c_month = $datearray[$i]['booking_month'];
  if ($c_year == $datearray[$i]['booking_year']) {// year hasn't changed, don't show it
      $disp_year = 0;
  } else {
      $c_year = $datearray[$i]['booking_year'];
      $disp_year = $datearray[$i]['booking_year'];
  }
} 
?>
<tr><td colspan="4" class="fill"><i>The information in this table is current and is updated online.&nbsp;
  <?='Last real time update '.substr($last_updated,6,2).'/'.substr($last_updated,4,2).'/'.substr($last_updated,0,4).' '.substr($last_updated,8,2).':'.substr($last_updated,10,2).':'.substr($last_updated,12)?></i>  
</td></tr>
</table> 
