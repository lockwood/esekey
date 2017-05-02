<?php
// +----------------------------------------------------------------------+
// | EMAIL  - EseSite booking confirmation email formatter - Company 8    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id:allmybookings/email.php,v 1.05 2006/01/27
//

if ($ss == 'User') { // confirm this was an online booking
    $online = ' online';
} else { // this was an admin booking
    $online = '';
}
/* recipients */
$to  = $e;

/* type */
$type = "Booking Notification";
/* subject */
$subject = "Booking Notification: ".str_replace("<br>", "", $_SESSION[$ss]['apartment'])." from ".$_SESSION[$ss]['arrival_date']." for ".$_SESSION[$ss]['number_of_nights']." nights";

// message is made up of the following components:
// $email_top - the style sheet data and html header tags
// $email_top_text - a string that is updatable via the Admin Console for personalised messages
// $email_body - the generated body of the email containing the booking data
// $email_tail_text - a string that is updatable via the Admin Console for personalised messages
// $email_tail - the closing html tags

$email_top = '
<html>
<head>
<title>Booking Notification</title>
<style type="text/css">

code {color: #333333; font-family: verdana, courier, monospace; font-size: 10pt}
pre {color: #333333; font-family: verdana, courier, monospace; font-size: 10pt}
body, div, span {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
td, th {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
tr {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
table {font-family: arial, helvetica, sans-serif; font-size: 10pt}
p {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
li {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
br {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
div {color: #666699; font-family: arial, helvetica, sans-serif; font-size: 10pt}
sup {font-family: arial, helvetica, sans-serif; font-size: 5pt}
h3 {color: #666699; font-family: arial, helvetica, sans-serif; font-size: 11pt}
h4, b {color: #666699; font-family: arial, helvetica, sans-serif; font-size: 10pt}
blockquote, input, select {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
ul, ol {color: #333333; font-family: arial, helvetica, sans-serif; font-size: 10pt}
a:link {font-size: 10pt; font-family: arial, helvetica, sans-serif; color:#666699 }
span.purple {font-weight: bold; color: #666699; font-family: arial, helvetica, sans-serif; font-size: 10pt}
span.small {font-size: 8pt; font-family: arial, helvetica, sans-serif; color:#333333 }
span.link {font-size: 8pt; font-family: arial, helvetica, sans-serif; color:#666699 }
table.dkgrey {background:#666}
table.white {background:#FFF}
td.dkgrey1 {background:#BBB}
input.buttonblue {background: #594FBF;font-family: lucida, arial, sans-serif; color:#FFF; height: 1.4em; font-weight: bold; font-size: 11px; padding: 0px; margin: 0px; border: 0px none #000}
</style>
</head>
<body>
<p>';
$email_top_text = 'Dear '.$titlearray[$t].' '.stripslashes($l).'

Thank you for booking'.$online.' with '
.$_SESSION[$ss]['company_name'].$_test.'. Your booking reference, to be used in all future correspondence, is shown below along with a summary of your booking.';
$email_body = '</p>
<table align="center" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td><b>Booking Reference</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['booking_reference'].'</b></td>
  </tr>
  <tr>
    <td><b>Arrival Date</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['arrival_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Departure Date</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['departure_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Nights</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['number_of_nights'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Guests</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['number_of_guests'].'</b></td>
  </tr>
  <tr>
    <td><b>Property</b></td>
    <td align="right"><b>'.$_SESSION[$ss]['apartment'].'</b></td>
  </tr>
  <tr>';
if ($_SESSION[$ss]['deposit_rate'] < 1) { // deposit due now, balance 4 weeks before arrival.
    $deposit_percent = $_SESSION[$ss]['deposit_rate'] * 100;
    $email_body .= '
    <td><b>Amount ('.$deposit_percent.'% Deposit to be charged now):</b></td>
    <td align="right"><b>£'.number_format($_SESSION[$ss]['deposit'],2).'</b></td>
  </tr>
  <tr>
    <td><b>Balance (to be charged 4 weeks before arrival):</b></td>
    <td align="right"><b>£'.number_format($_SESSION[$ss]['balance'],2).'</b></td>
  </tr>
  <tr>
    <td><b>Total Price:</b></td>
    <td align="right"><b>£'.number_format($_SESSION[$ss]['price'],2).'</b></td>';
} else { // Full amount is due
    $email_body .= '
    <td><b>Total Amount (To be charged now):</b></td>
    <td align="right"><b>£'.number_format($_SESSION[$ss]['price'],2).'</b></td>';
}
$email_body .= '
  </tr>
</table>
<p>';
$textarray = split ('<br>', $_SESSION[$ss]['additional_info']);
$email_tail_text = '';
foreach($textarray as $textrow) {
  $email_tail_text .= $textrow.'
';
}
$email_tail = '</p>
</body>
</html>
';

$complete_message = $email_top.nl2br($email_top_text).$email_body.nl2br($email_tail_text).$email_tail;


/* To send HTML mail, set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* additional headers */
$headers .= "From: All My Bookings <bookings@allmybookings.co.uk>\r\n";
$headers .= "Bcc: ".$_SESSION[$ss]['company_email'].", dave@esekey.com, 07860832741@text.sms2email.com\r\n";

/* and now mail it */
if (($ss == 'Admin') && ($em == 'CHECKED')) {
    $mail_now = true;
} else {
    if ($ss == 'User') {
        $mail_now = true;
    } else {
        $mail_now = false;
    }
}
if ($mail_now) {
    if (@mail($to, $subject, $complete_message, $headers)) { // email sent
        $insert = "INSERT INTO email".$_test." 
                   VALUES ('".$_SESSION[$ss]['company_id']."',
                           '".$_SESSION[$ss]['booking_reference']."',
                           0, 
                           '".$type."', 
                           '".$subject."', 
                           '".$email_top."', 
                           '".$email_top_text."', 
                           '".$email_body."', 
                           '".$email_tail_text."', 
                           '".$email_tail."', 
                           '".$to."',
                           '".$headers."', 
                           'Y',
                           now(),
                           '".$_SESSION[$ss]['username']."', 
                           null)";
    //  echo $insert; //
        $add_member = $db_object->query($insert);
        if (DB::isError($add_member)) {
            die($add_member->getMessage());
        }
    } else { // failed to send
        $mail_now = false;
    }
}
if (!$mail_now) {
    $insert = "INSERT INTO email".$_test." 
               VALUES ('".$_SESSION[$ss]['company_id']."',
                       '".$_SESSION[$ss]['booking_reference']."',
                       0, 
                       '".$type."', 
                       '".$subject."', 
                       '".$email_top."', 
                       '".$email_top_text."', 
                       '".$email_body."', 
                       '".$email_tail_text."', 
                       '".$email_tail."', 
                       '".$to."',
                       '".$headers."', 
                       'N',
                       now(),
                       '".$_SESSION[$ss]['username']."', 
                       null)";
//  echo $insert; //
    $add_member = $db_object->query($insert);
    if (DB::isError($add_member)) {
        die($add_member->getMessage());
    }
    $trackhdr  = "MIME-Version: 1.0\r\n";
    $trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $trackhdr .= "From: All My Bookings Admin <admin@allmybookings.co.uk>\r\n";
    @mail('dave@esekey.com', $subject, $complete_message, $trackhdr);
}
?>

