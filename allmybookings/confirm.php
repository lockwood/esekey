<?php
// +----------------------------------------------------------------------+
// | CONFIRM  - lays out confirmation of booking to user                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/confirm.php,v 1.03 2006/01/27
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
    <td><b>Property</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['apartment']?></b></td>
  </tr>
  <tr>
  <?php 
  if ($_SESSION[$ss]['deposit_rate'] < 1) { // deposit due now, balance 4 weeks before arrival.
		if ($_SESSION[$ss]['advance_days'] > 10 )
		{
			$balance_due = $_SESSION[$ss]['advance_days']." days before ";
		} else
		{
			$balance_due = "on ";
		}
  ?>
    <td><b>Amount (<?=$_SESSION[$ss]['deposit_rate'] * 100?>% Deposit to be charged now):</b></td>
    <td align="right"><b><?='£'.number_format($_SESSION[$ss]['deposit'],2)?></b></td>
  </tr>
  <tr>
    <td><b>Balance (due <?=$balance_due?>arrival):</b></td>
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
  ?>
  </tr>
</table>
<p><?=$_SESSION[$ss]['additional_info']?></p>
<?php
if ($ss == 'User') { ?>
    <p>An email confirming these details has been sent to the email address that you provided.
    Another email containing further information will be sent when your payment has been processed.
    If you have not received both of these emails in the next 48 hours, or if you have any other queries, please call us on
    <?=$_SESSION[$ss]['company_telephone']?>
    <?php 
}
?>