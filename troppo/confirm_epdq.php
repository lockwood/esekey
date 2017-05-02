<?php
// +----------------------------------------------------------------------+
// | CONFIRM  - lays out confirmation of booking to user                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/confirm.php,v 1.03 2005/01/21
//
$snippet1 = '';
if ($ss == 'User') {
	if (isset($_GET['res'])) { // return from Barclaycard payment gateway.....
		if ($_GET['res'] == '1') {
    		echo '<br><br>Thank you very much for booking online with '.
         	$_SESSION[$ss]['company_name'].$_test.', '.$_SESSION[$ss]['title'].' '.$_SESSION[$ss]['last_name'].
'. Your booking reference, to be used in all future correspondence, is shown along with the booking details below.<br><br>';
			$snippet1 = 'success';
			echo 'Your payment details have been processed and the requested amount will be taken from your card.<br><br>';
		} else {
			echo '<br><br>Sorry, your booking has not been accepted as your payment details were not processed successfully. Please try again or, alternatively, contact us on '.$_SESSION[$ss]['company_telephone'].' to make the booking by telephone and arrange payment. 
<br><br>';
			return;
		}
	}
         
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
    <td><b>Apartment(s)</b></td>
    <td align="right"><b><?=$_SESSION[$ss]['apartment']?></b></td>
  </tr>
  <tr>
  <?php 
  if ($_SESSION[$ss]['deposit_rate'] < 1) { // deposit due now, balance 4 weeks before arrival.
    $snippet2 = 'to be charged now';
	if ($snippet1 == 'success') {
		$snippet2 = 'already taken';
	} elseif ($snippet1 == 'fail') {
		$snippet2 = 'to be paid within 48 hours';
	}
  	?>
    <td><b>Amount (<?=$_SESSION[$ss]['deposit_rate'] * 100?>% Deposit <?=$snippet2?>):</b></td>
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
    $snippet2 = 'Due Now';
	if ($snippet1 == 'success') {
		$snippet2 = 'Already taken';
	}
  	?>
    <td><b>Total Amount <?=$snippet2?>:</b></td>
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
    Another email containing further information will be sent when your payment has been authorised.
    If you have not received both of these emails in the next 48 hours, or if you have any other queries, please call us on
    <?=$_SESSION[$ss]['company_telephone']?>.
    <?php 
} else { ?>
	<p><input type="button" class="button-cust" name="btnAddNew" value="Start Another Booking" onClick="GoAdd();"></p>
<?php
}
?>