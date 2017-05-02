<?php
// +----------------------------------------------------------------------+
// | CONFIRM  - lays out confirmation of booking for Company 4            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/confirm.php,v 1.00 2005/04/11
//
if ($ss == 'User') {
    echo '<br><br>Thank you very much for booking online with '.
         $_SESSION[$ss]['company_name'].$_test.', '.$_SESSION[$ss]['title'].' '.$_SESSION[$ss]['last_name'].
         '. Your booking reference, to be used in all future correspondence,'.
         ' is shown along with the booking details below.<br><br>';
} else { 
    echo 'Booking Added Successfully:<br><br>'; 
} ?>
<table align="center" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td><b>Booking Reference</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['booking_reference']?></b></td>
  </tr>
  <tr>
    <td><b>Arrival Date</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['arrival_date']?></b></td>
  </tr>
  <tr>
    <td><b>Departure Date</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['departure_date']?></b></td>
  </tr>
  <tr>
    <td><b>Number of Nights</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['number_of_nights']?></b></td>
  </tr>
  <tr>
    <td><b>Number of Guests</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['number_of_guests']?></b></td>
  </tr>
  <tr>
    <td><b>Accommodation</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['accommodation']?></b></td>
  </tr>
  <tr>
  <?php 
if ($book_bb == 'yes')
{
	if ($_SESSION[$ss]['deposit'] == $_SESSION[$ss]['price'])
	{
  ?>
    <td><b>Total Amount Due Now:</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['price'],2)?></b></td>
  <?php
	} else {
  ?>
    <td><b>Deposit (Cost of first night, to be charged now):</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['deposit'],2)?></b></td>
  </tr>
  <tr>
    <td><b>Balance (to be charged 4 weeks before arrival):</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['balance'],2)?></b></td>
  </tr>
  <tr>
    <td><b>Total Price:</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['price'],2)?></b></td>
  <?php
    }
} else {
	if ($_SESSION[$ss]['deposit_rate'] < 1) { // deposit due now, balance 4 weeks before arrival.
  ?>
    <td><b>Amount (<?=$_SESSION[$ss]['deposit_rate'] * 100?>% Deposit to be charged now):</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['deposit'],2)?></b></td>
  </tr>
  <tr>
    <td><b>Balance (to be charged 4 weeks before arrival):</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['balance'],2)?></b></td>
  </tr>
  <tr>
    <td><b>Total Price:</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['price'],2)?></b></td>
  <?php
  } else { // Full amount is due
  ?>
    <td><b>Total Amount Due Now:</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['price'],2)?></b></td>
  <?php
  }
}
  ?>
  </tr>
</table>
<p><?=$_SESSION[$ss]['additional_info']?></p>
<?php
if ($ss == 'User') { ?>
    <p>An email confirming these details has been sent to the email address that you provided.
    Another email containing further information will be sent when your payment has been processed.
    If you have not received both of these emails in the next 48 hours, or if you have any other queries, please call us on
    <?=$_SESSION[$ss]['company_telephone']?>.
<!-- Google Code for PURCHASE Conversion Page -->
<script language="JavaScript" type="text/javascript">
<!--
var google_conversion_id = 1067802999;
var google_conversion_language = "en_GB";
var google_conversion_format = "1";
var google_conversion_color = "666666";
if (1.0) {
  var google_conversion_value = 1.0;
}
var google_conversion_label = "PURCHASE";
//-->
</script>
<script language="JavaScript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<img height=1 width=1 border=0 src="https://www.googleadservices.com/pagead/conversion/1067802999/?value=1.0&label=PURCHASE&script=0">
</noscript>
    <?php 
}
?>