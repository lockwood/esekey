<?php
// +----------------------------------------------------------------------+
// | DEPOSIT_EMAIL  - final confirmation email formatter for Troppo (co 3)|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/final_email.php,v 1.02 2006/01/17
//

/* recipients */
$to  = $viewrow['email'];

/* subject */
$subject = "Final Confirmation";

// message is made up of the following components:
// $email_top - the style sheet data and html header tags
// $email_top_text - a string that is updatable via the Admin Console for personalised messages
// $email_body - the generated body of the email containing the booking data
// $email_tail_text - a string that is updatable via the Admin Console for personalised messages
// $email_tail - the closing html tags

$email_top = '
<html>
<head>
<title>Final Confirmation</title>
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

$email_top_text = "Dear&nbsp;".$viewrow['title']." ".$viewrow['last_name']."<br/>
Thank you for booking with <span style='font-family:Arial;color:green;font-weight:bold'>".$_SESSION[$ss]['company_name'].$_test."</span> (Troppo Property Ltd).<br/><br/> 
We can now confirm that your total payment of&nbsp;<b>£"
.$viewrow['total_amount']."</b> has been processed. Your accommodation will be available from <span style='font-family:Arial;color:green;font-weight:
bold'>4pm</span> on the day of your arrival and we would ask you to please ensure that you leave by <span style='font-family:Arial;color:green;font-weight:
bold'>10:30 a.m.</span> on the day of your departure.<br/>
<br/>
<span style='font-family:Arial;color:red;font-weight:bold'>PLEASE SEE THE LINK BELOW FOR INFORMATION FOR ACCESS AND DIRECTIONS. IF YOU ARE IN A GROUP, PLEASE SEND THIS  LINK OR A COPY OF THIS EMAIL TO EACH MEMBER OF YOUR GROUP.</span><br/>
<br/>
Due to the number of vehicle movements in the driveway, please park on the lawn when you have finished unloading.

To reach the <span style='font-family:Arial;color:green;font-weight:bold'>parking area</span> please drive down past the apartments.

At the end, opposite the hens, please turn sharply right and park against the tall hedge.

There is a <span style='font-family:Arial;color:green;font-weight:bold'>pedestrian gate</span> at the end of the hedge close to the greenhouse, through which you can walk back, to save walking all the way around to your apartment. This request is greatly appreciated.<br/>
<span style='font-family:Arial;color:green;font-weight:bold'>Sainsbury&#039;s </span>supermarket is 2 miles away and you may have passed this on your way to The Old Place if you exited the M4 at Junction 7.<br/>
Your booking details are as follows:";

$email_body = '</p>
<div style="width:100%;">
<table align="left" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td><b>Booking Reference</b></td>
    <td align="right"><b>'.$viewrow['booking_reference'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Arrival Date</b></td>
    <td align="right"><b>'.$viewrow['arrival_date'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Departure Date</b></td>
    <td align="right"><b>'.$viewrow['departure_date'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Number of Nights</b></td>
    <td align="right"><b>'.$viewrow['number_nights'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Number of Guests</b></td>
    <td align="right"><b>'.($viewrow['number_adults'] + $viewrow['number_children'] + $viewrow['number_infants']).'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Apartment(s)</b></td>
    <td align="right"><b>'.$viewrow['property_name'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><b>Total Cost</b></td>
    <td align="right"><b>£'.$viewrow['total_amount'].'</b></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</div>
<br/>
<p>';
$email_tail_text = "
Should you require any <span style='font-family:Arial;color:green;font-weight:bold'>specific sleeping or bedding arrangements</span>, i.e. all separate beds/rooms, travel cot etc, please ensure that we are informed before your stay.<br/>";
if (strpos($viewrow['booking_notes'],'pet supplement')) {
	$email_tail_text .= "
<br/>
If you bring your dog(s)..............<br/>
We ask dog owners not to allow their  pets to create a nuisance to other guests.<br/>
If the dog is ever left alone in the apartment, please ensure that the dog is not regularly or continuously barking.<br/>
We welcome dogs, as we have three small dogs living at the premises and we recommend guests to 
introduce their dogs carefully to our dogs, so that they can get to know each other and avoid 
unnecessary barking or fighting. Please read our booking conditions regarding nuisance by dogs.<br/>
Our dogs are relatively sociable, but dogs are dogs!<br/><br/>";
}
$email_tail_text .= '
<span style="font-family:Arial;color:red;font-weight:bold">DIRECTIONS</span><br/>
<br/>
Please download the <A href="http://www.troppo.uk.com/directions.pdf">Directions and Access Instructions</A> and make sure that all members of your party that need it have a copy. <br/><br/>

Kind Regards 
Jan Wright 

Dorney Self Catering Apartments 
Troppo Property Partnership 
The Old Place 
Lock Path 
Dorney 
Windsor 
Berkshire 
SL4 6QQ 

Tel: 01753 827037 
Fax: 01753 855022 
Web: http://www.troppo.uk.com/dsca 

';
$email_tail = '</p>
</body>
</html>
';

$complete_message = $email_top.$email_top_text.$email_body.$email_tail_text.$email_tail;

/* To send HTML mail, set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* additional headers */
$headers .= "From: Dorney Self Catering Apartments <bookings@dorneyselfcatering.co.uk>\r\n";
$headers .= "Bcc: ".$_SESSION[$ss]['company_email'].", dave@esekey.com\r\n";

/* and now save it in the database */
$insert = "INSERT INTO email".$_SESSION[$ss]['_test']." 
               VALUES ('".$_SESSION[$ss]['company_id']."',
                       '".$viewrow['booking_reference']."',
                       0, 
                       '".$subject."', 
                       '".$subject."', 
                       '".$email_top."', 
                       '".mysql_real_escape_string($email_top_text)."', 
                       '".$email_body."', 
                       '".mysql_real_escape_string($email_tail_text)."', 
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
    $msgtext .= '\nand Final Confirmation email created for review';
}
?>
