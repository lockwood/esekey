<?php 
// +----------------------------------------------------------------------+
// | VIEW_BB  - Calculate and Layout B&B Availability                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/view_bb.php,v 1.00 2008/06/07
//

//read from table where date > start date and date < start date + 92 days (~3 months) 
//if records not found, insert new ones up to end date for selected period using mysql date_add (interval) function. 

$bbdatearray = $db_object->getAll("SELECT t1.resource_id,
                                        t1.day_of_week, 
										t1.booking_date,
                                        DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                        DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                        DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                        t1.booking_reference, 
                                        t2.display_status, 
                                        t2.expiry,
                                        t3.sleeps
                                   FROM calendar_booking AS t1, 
                                        booking AS t2,
                                        property As t3
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                    AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                    AND t1.company_id = t2.company_id
                                    AND t3.company_id = t2.company_id
                                    AND t3.active_bb = 'Y'
                                    AND t3.property_id = t1.resource_id
                                    AND t1.booking_reference = t2.booking_reference
                                    ".$select_property."
                               ORDER BY t3.sleeps,
										t1.booking_date,
                                        t2.display_status,
                                        t1.resource_id");

// echo 'Date Count: '.count($bbdatearray).'<br><br>';
// echo 'Prop Count: '.count($resourcearray).'<br><br>';

if ($select_property == '') {
    $property_count = count($bbarray);
} else {
    $property_count = 1;
} 

if (count($bbdatearray) < ($property_count*92)) { // need to add some dates
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
    foreach ($bbarray as $propertyrow) {
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
    // echo $insert;
    $bbdatearray = $db_object->getAll("SELECT t1.resource_id,
                                            t1.day_of_week,
											t1.booking_date,
                                            DATE_FORMAT(t1.booking_date, '%d')AS booking_day,
                                            DATE_FORMAT(t1.booking_date, '%m')AS booking_month, 
                                            DATE_FORMAT(t1.booking_date, '%Y')AS booking_year, 
                                            t1.booking_reference, 
                                            t2.display_status, 
                                            t2.expiry,
	                                        t3.sleeps
                                       FROM calendar_booking AS t1, 
                                            booking AS t2,
                                            property AS t3
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.booking_date >= '".$_SESSION[$ss]['selecteddate']."'
                                        AND t1.booking_date < date_add('".$_SESSION[$ss]['selecteddate']."', interval 92 day)
                                        AND t1.company_id = t2.company_id
                                        AND t3.company_id = t2.company_id
	                                    AND t3.active_bb = 'Y'
                                        AND t3.property_id = t1.resource_id
                                        AND t1.booking_reference = t2.booking_reference
                                        ".$select_property."
                               ORDER BY t3.sleeps,
										t1.booking_date,
                                        t2.display_status,
                                        t1.resource_id");

    // echo 'New Date Count: '.count($bbdatearray).'<br><br>';
 
}


$start_date = $_SESSION[$ss]['selecteddate'];
$n = 92;
include ($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/validate_bb.php');

echo '<p>&nbsp;<b>B&amp;B</b></p>';

$rows = 2;

if ($rows > 0)
{
	// set div height to correct value
	$height = $rows*25 + 20;
	echo '<table width="100%"><tr><td style="vertical-align:top;"><table border="0" cellspacing="1" cellpadding="0"><tr><td class="fill">&nbsp;</td></tr>';
	for($i=0;$i<$rows;$i++)
	{
		echo '<tr><td nowrap class="year" style="border:solid silver 1px;">&nbsp;Sleeps&nbsp;'.($i+1).'</td></tr>';
	}
	echo '</table></td>';
	if ($ss == 'Admin')
	{
		echo '<td><div style="position:absolute;top:77px;left:70px;width:3200%;overflow-x:auto;height:'.$height.'px;"><table border="0" cellspacing="1" cellpadding="0">';
	} else
	{
		echo '<td><div style="overflow-x:auto;width:680px; height:'.$height.'px;"><table border="0" cellspacing="1" cellpadding="0">';
	}
	//*

	echo '<tr>';
	foreach ($price1 as $date=>$price)
	{
		echo '<td class="year" nowrap>'.$dispdate[$date].'</td>';
	}
	echo '</tr>';
	echo '<tr>';
	foreach ($price1 as $date=>$price)
	{
		if ($s1_avail[$date] > 0)
		{
			if ($ss == 'Admin')
			{
				echo '<td class="E">&pound;'.$price.' ('.$s1_avail[$date].')</td>';
			} else
			{
				echo '<td class="E">&pound;'.$price.' </td>';
			}
		} else
		{
			echo '<td class="C">N/A</td>';
		}
	}
	echo '</tr>';
	echo '<tr>';
	foreach ($price2 as $date=>$price)
	{
		if ($s2_avail[$date] > 0)
		{
			if ($ss == 'Admin')
			{
				echo '<td class="E">&pound;'.$price.' ('.$s2_avail[$date].')</td>';
			} else
			{
				echo '<td class="E">&pound;'.$price.' </td>';
			}
		} else
		{
			echo '<td class="C">N/A</td>';
		}
	}
	echo '</tr>';
	echo '</table></div></td></tr></table><br><br><br>';
	// print_r($s1_avail);
	//*/
}



