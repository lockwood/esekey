<?php
// +----------------------------------------------------------------------+
// | GENERAL_EMAIL  - general email formatter for Sheephouse Manor (co 4) |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/general_email.php,v 1.00 2006/11/22
//

$viewrow['booking_reference'] = $bookingrow['booking_reference'];
$viewrow['email_sequence'] = $valuearray[1]; 
$viewrow['email_type'] = 'General'; 
$viewrow['email_subject'] = 'Booking Update'; 
$viewrow['email_top'] = '
<html>
<head>
<title>Booking Update</title>
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
$viewrow['email_top_text'] = 'Dear '.$bookingrow['title'].' '.mysql_real_escape_string($bookingrow['last_name']).'

Thank you for booking with '
.$_SESSION[$ss]['company_name'].$_SESSION[$ss]['_test'].'. Your updated booking details are shown below.';
	$viewrow['email_body'] = '</p>
<table align="center" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td><b>Booking Reference</b></td>
    <td align="right"><b>'.$bookingrow['booking_reference'].'</b></td>
  </tr>
  <tr>
    <td><b>Arrival Date</b></td>
    <td align="right"><b>'.$bookingrow['arrival_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Departure Date</b></td>
    <td align="right"><b>'.$bookingrow['departure_date'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Nights</b></td>
    <td align="right"><b>'.$bookingrow['number_nights'].'</b></td>
  </tr>
  <tr>
    <td><b>Number of Guests</b></td>
    <td align="right"><b>'.($bookingrow['number_adults'] + $bookingrow['number_children'] + $bookingrow['number_infants']).'</b></td>
  </tr>
  <tr>
    <td><b>Accommodation</b></td>
    <td align="right"><b>'.$bookingrow['property_name'].'</b></td>
  </tr>
</table>
<p>';


$viewrow['email_tail_text'] = '


Kind Regards
Caroline Street';
$viewrow['email_tail'] = '</p>
</body>
</html>
';

$viewrow['email_to'] = $bookingrow['email'];
$viewrow['email_headers']  = "MIME-Version: 1.0\r\n";
$viewrow['email_headers'] .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* additional headers */
$viewrow['email_headers'] .= "From: Sheephouse Manor <bookings@sheephousemanor.co.uk>\r\n";
$viewrow['email_headers'] .= "Bcc: ".$_SESSION[$ss]['company_email'].", dave@esekey.com\r\n";

// indicate that this is a create email request - sent flag = 0 rather than Y or N
$viewrow['sent_flag'] = '0';
$viewrow['created_date'] = '';
$viewrow['last_modified_on'] = '';
$viewrow['last_modified_by'] = '';

$column[] = 'booking_reference';
$column[] = 'email_sequence';
$column[] = 'email_type';
$column[] = 'email_subject';
$column[] = 'email_top_text';
$column[] = 'email_body';
$column[] = 'email_tail_text';
$column[] = 'email_to';
$column[] = 'sent_flag';
$column[] = 'created_date';
$column[] = 'last_modified_on';
$column[] = 'last_modified_by';

?>
