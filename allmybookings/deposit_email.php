<?php
// +----------------------------------------------------------------------+
// | DEPOSIT_EMAIL  - deposit paid email formatter for All My Bookings (co 8)|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/deposit_email.php,v 1.01 2006/02/06
//

/* recipients */
$to  = $viewrow['email'];

/* subject */
$subject = "Deposit Notification";

// message is made up of the following components:
// $email_top - the style sheet data and html header tags
// $email_top_text - a string that is updatable via the Admin Console for personalised messages
// $email_body - the generated body of the email containing the booking data
// $email_tail_text - a string that is updatable via the Admin Console for personalised messages
// $email_tail - the closing html tags

$email_top = '
<html>
<head>
<title>Deposit Notification</title>
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
$email_top_text = 'Dear '.$viewrow['title'].' '.mysql_real_escape_string($viewrow['last_name']).'

Thank you for booking with '.$_SESSION[$ss]['company_name'].'. We can now confirm that your deposit payment of £'
.$viewrow['deposit_amount'].' has been processed.';
$email_body = '</p>
<table align="center" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td><b>Booking Reference</b></td>
    <td align="right"><b>'.$viewrow['booking_reference'].'</b></td>
  </tr>
  <tr>
    <td><b>Arrival Date</b></td>
    <td align="right"><b>'.$viewrow['arrival_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Departure Date</b></td>
    <td align="right"><b>'.$viewrow['departure_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Nights</b></td>
    <td align="right"><b>'.$viewrow['number_nights'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Guests</b></td>
    <td align="right"><b>'.($viewrow['number_adults'] + $viewrow['number_children'] + $viewrow['number_infants']).'</b></td>
  </tr>
  <tr>
    <td><b>Property</b></td>
    <td align="right"><b>'.$viewrow['property_name'].'</b></td>
  </tr>
  <tr>
    <td><b>Amount Due 4 weeks before arrival</b></td>
    <td align="right"><b>£'.$viewrow['balance_amount'].'</b></td>
  </tr>
</table>
<p>';
$email_tail_text = 'A further email, including directions to the property, will be sent when the balance payment is processed. 
This should arrive approximately 4 weeks before your arrival is due. In the meantime, if you have any queries, please do not hesitate to contact me.


Kind Regards
All My Bookings
';
$email_tail = '</p>
</body>
</html>
';

$complete_message = $email_top.$email_top_text.$email_body.$email_tail_text.$email_tail;

/* Set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* additional headers */
$headers .= "From: All My Bookings <bookings@allmybookings.co.uk>\r\n";
$headers .= "Bcc: ".$_SESSION[$ss]['company_email'].", dave@esekey.com\r\n";

/* and now save it in the database */
$insert = "INSERT INTO email".$_SESSION[$ss]['_test']." 
               VALUES ('".$_SESSION[$ss]['company_id']."',
                       '".$viewrow['booking_reference']."',
                       0, 
                       '".$subject."', 
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
} else {
    $msgtext .= '\nand Deposit Notification email created for review';
}
?>
