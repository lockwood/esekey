<?php
// +----------------------------------------------------------------------+
// | RESERVE  - EseSite booking reservation - Company 5                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 5/reserve.php,v 1.01 2005/07/20
//

$cottagearray = $db_object->getAll("SELECT name
                                      FROM property
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_flag = 'Y'
                                   ORDER BY property_id");


$row = $db_object->getRow("SELECT customer_id
                             FROM customer 
                            WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                              AND title = '".$titlearray[$t]."'
                              AND first_name = '".$f."'
                              AND last_name = '".$l."'
                              AND post_address = '".$a."'
                              AND post_code = '".$q."'
                              AND telephone = '".$u."'
                              AND email = '".$e."'
                              AND active_flag = 'Y'");
if ($row['customer_id'] == null) { // does not already exist as a customer
    $insert = "INSERT INTO customer 
               VALUES ('".$_SESSION[$ss]['company_id']."',
                       0,
                       0,
                       '".$titlearray[$t]."', 
                       '".$f."', 
                       '".$l."', 
                       '".$a."', 
                       '".$q."', 
                       '".$u."',
	                       null,
                       '".$e."', 
                       'Y',
                       now(),
                       '".$_SESSION[$ss]['username']."', 
                       null)";
//  echo $insert; //
    $add_member = $db_object->query($insert);
    if (DB::isError($add_member)) {
        die($add_member->getMessage());
    }
    // return customer_id  //
    $customer_id = mysql_insert_id();  
} else {
    $customer_id = $row['customer_id'];
}
$booking_notes = '';

if ($sr != htmlentities('e.g. cot or other items required for baby; pets to be brought, etc....', ENT_QUOTES)) { // special requirements
    $booking_notes .= $sr;
}
$insert = "INSERT INTO booking 
           VALUES ('".$_SESSION[$ss]['company_id']."',
                   0, 
                   1, 
                   '".$start_date."', 
                   date_add('".$start_date."', interval '".$n."' day), 
                   '".$g."', 
                   '".$c."', 
                   '".$inf."', 
                   '".$customer_id."', 
                   0, 
                   now(),
                   date_add('".$start_date."', interval '".$n."' day), 
                   'P', 
                   'Deposit Due',
                   '".$booking_notes."', 
				   '',
                   '".$_SESSION[$ss]['username']."', 
                   null,
				   null)";
//      echo $insert; //
$add_member = $db_object->query($insert);
if (DB::isError($add_member)) {
    die($add_member->getMessage());
}
// return booking_reference  //
$booking_reference = mysql_insert_id();  
// put booking_reference and confirmation data on session  //
for ($i = 1; $i <= count($propertyarray); $i++) {
  if (isset($r[$i])) {
    $update_calendar_booking = 
    "UPDATE calendar_booking 
        SET booking_reference = '".$booking_reference."',
            last_modified_on = now(),
            last_modified_by = '".$_SESSION[$ss]['username']."'
      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
        AND booking_date >= '".$start_date."'
        AND booking_date < date_add('".$start_date."', interval '".$n."' day)
        AND resource_id = '".$i."'";
//  echo $update_calendar_booking; //
    $update_member = $db_object->query($update_calendar_booking);
    if (DB::isError($update_member)) {
        die($update_member->getMessage());
    }
  }
}
if ($v != '') {
    $issue = 'Issue '.$v;
} else {
    $issue = '';
}
$cc = substr($z, 0, 4).' '.substr($z, 4, 4).' '.substr($z, 8, 4).' '.substr($z, 12, 4).' '.substr($z, 16, 4);
$insert = "INSERT INTO payment 
           VALUES ('".$_SESSION[$ss]['company_id']."',
                   '".$booking_reference."', 
                   '".$w."', 
                   '".$deposit."', 
                   '".$cc."', 
                   '".$xm."/".$xy." ".$issue."',
                   '".$tariff."', 
                   '".$balance."', 
                   '".$discount."', 
                   '".$negotiated."',
                   '".$_SESSION[$ss]['username']."', 
                   null)";
//      echo $insert; //
$add_member = $db_object->query($insert);
if (DB::isError($add_member)) {
    die($add_member->getMessage());
}
$insert = "INSERT INTO booking_audit 
           VALUES ('".$_SESSION[$ss]['company_id']."',
                   '".$booking_reference."', 
                   0, 
                   '".$start_date."', 
                   date_add('".$start_date."', interval '".$n."' day), 
                   '".$g."', 
                   '".$c."', 
                   '".$inf."', 
                   '".$customer_id."', 
                   0, 
                   'P', 
                   'Deposit Due',
                   '".$deposit."', 
                   '".$balance."', 
                   '".$_SESSION[$ss]['username']."', 
                   null)";
//      echo $insert; //
$add_member = $db_object->query($insert);
if (DB::isError($add_member)) {
    die($add_member->getMessage());
}
$_SESSION[$ss]['booking_reference'] = $booking_reference;  
$apartment = '';
for ($i=0; $i<count($cottagearray);$i++) { 
  if (isset($r[$i + 1])) {
    $apartment .= $cottagearray[$i][name].'<br/>';
  }
}
$_SESSION[$ss]['apartment'] = $apartment;
$_SESSION[$ss]['arrival_date'] = $db_object->getOne("SELECT DATE_FORMAT('".$start_date."', '%D %b %y')");  
$_SESSION[$ss]['departure_date'] = $db_object->getOne("SELECT DATE_FORMAT(date_add('".$start_date."', interval '".$n."' day), '%D %b %y')");
$_SESSION[$ss]['number_of_guests'] = $g + $c + $inf;
$_SESSION[$ss]['title'] = $titlearray[$t];
$_SESSION[$ss]['last_name'] = $l;
$_SESSION[$ss]['deposit_rate'] = $deposit_rate;
$_SESSION[$ss]['deposit'] = $deposit;
$_SESSION[$ss]['balance'] = $balance;
$_SESSION[$ss]['price'] = $price;
$_SESSION[$ss]['number_of_nights'] = $n;
$_SESSION[$ss]['additional_info'] = $additional_info;

?>