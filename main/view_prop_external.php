<?php 
// +----------------------------------------------------------------------+
// | VIEW_DAILY  - Calculate and Layout Daily Availability for external use|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2012 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/view_daily_external.php,v 1.07 2005/07/20
//
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

//read from table where date > start date and date < start date + 92 days (~3 months) 
//if records not found, insert new ones up to end date for selected period using mysql date_add (interval) function. 
for ($x = 0; $x <= 6; $x++) {$selected_id = $resourcearray[$x]['property_id'];$select_property = " AND t1.resource_id = '".$selected_id."' ";
$datearray = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week, 
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.property_number AS property_number,
                                        t3.property_name AS property_name
                                   FROM calendar_booking".$_test." AS t1, 
                                        booking".$_test." AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.active_flag = 'Y'
                                    AND t3.property_id = t1.resource_id
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        ".$property_order.",
                                        booking_day");

// echo 'Date Count: '.count($datearray).'<br><br>';
// echo 'Prop Count: '.count($resourcearray).'<br><br>';

if ($select_property == '') {
    $property_count = count($resourcearray);
} else {
    $property_count = 1;
} 

if (count($datearray) < ($property_count*92)) { // need to add some dates
    $number_inserted = 0;
    $insert = "INSERT INTO booking 
                VALUES ('".$_SESSION[$ss]['company_id']."',
                        0, 
	                    1, 
                        '".$_SESSION[$ss]['prevsatdate']."', 
                        date_add('".$_SESSION[$ss]['prevsatdate']."', interval 98 day), 
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
    foreach ($resourcearray as $propertyrow) {
        $dow = 6; // set day of week to Saturday
        for ($i = 0; $i <= 99; $i++) {
            $insert = "INSERT INTO calendar_booking 
                        VALUES ('".$_SESSION[$ss]['company_id']."',
                                '".$propertyrow['property_id']."', 
                                date_add('".$_SESSION[$ss]['prevsatdate']."', interval '".$i."' day), 
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
	                                        t3.property_number AS property_number,
    	                                    t3.property_name AS property_name
                                       FROM calendar_booking".$_test." AS t1, 
                                            booking".$_test." AS t2,
                                            property AS t3 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
                                        AND t3.property_id = t1.resource_id
                                        AND t3.active_flag = 'Y'
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY booking_year,
                                        booking_month,
                                        ".$property_order.",
                                        booking_day");

    // echo 'New Date Count: '.count($datearray).'<br><br>';
 
}
// compatibility issue MYSQL 4.0 and 4.1 - add 0 to timestamp to return number rather than string
$last_updated = $db_object->getOne("SELECT MAX(last_modified_on + 0)
                                      FROM booking".$_test."
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'");


$c_year = $datearray[0]['booking_year'];
$disp_year = $datearray[0]['booking_year'];
$c_month = $datearray[0]['booking_month'];
$month_count = 1;
if ($show_property_number)
{
    $c_name = ltrim($datearray[0]['property_number'].' '.$datearray[0]['property_name']);
} else
{
    $c_name = $datearray[0]['property_name'];
}$cal_link = '<a href="'.$resourcearray[$x]['web_page'].'">'.strtoupper($c_name).'</a>';
$c_day = 1; // start at beginning of row
$i = 0;
?>
<div><table>  <tr><td colspan="8" class="apartment"><?=$cal_link?></td></tr><?php
while ($month_count <= 3) {
  while ($datearray[$i]['booking_month'] == $c_month) { ?>
        <tr>
          <td class="mnth-center" style="width:16%;"><?=strtoupper($montharray[(0 + $c_month)])?></td>
          <td class="day-center" style="width:12%;">Sa</td>          <td class="day-center" style="width:12%;">Su</td>
          <td class="day-center" style="width:12%;">Mo</td>
          <td class="day-center" style="width:12%;">Tu</td>
          <td class="day-center" style="width:12%;">We</td>
          <td class="day-center" style="width:12%;">Th</td>
          <td class="day-center" style="width:12%;">Fr</td>
        </tr>
        <tr>        <td class="year-center"><?=$disp_year?></td>
        <?php 
        if ($datearray[$i]['day_of_week'] < 6) { // 1st week of month does not start on Saturday 
            for ($j = 0; $j <= $datearray[$i]['day_of_week']; $j++) {
                ?>
                <td class="fill">&nbsp;</td><?php
                $c_day++;
            }
        }
		if ($show_property_number)
		{
	        $fullname = ltrim($datearray[$i]['property_number'].' '.$datearray[$i]['property_name']);
		} else
		{
	        $fullname = $datearray[$i]['property_name'];
		}
        while (($fullname == $c_name) && ($datearray[$i]['booking_month'] == $c_month)) {
            if ($c_day > 7) { // new row needed
                $c_day = 1;  ?>
        </tr>
        <tr>
			<td class="year-center">&nbsp;</td>			<?php             } ?>
            <td class="<?=$datearray[$i]['display_status']?>">
            <?php
            echo $datearray[$i]['booking_day'].'</td>';
            $i++;
			if ($show_property_number)
			{
		        $fullname = ltrim($datearray[$i]['property_number'].' '.$datearray[$i]['property_name']);
			} else
			{
		        $fullname = $datearray[$i]['property_name'];
			}
            $c_day++;
        }
        $c_day = 1; //ready for next block of dates
        ?>
        </tr>
  <?php 
  }
  $month_count++;
  $c_month = $datearray[$i]['booking_month'];
  $c_year = $datearray[$i]['booking_year'];
  $disp_year = $datearray[$i]['booking_year'];
} 
?>
</table> </div><?php }?>