<?php  
// +----------------------------------------------------------------------+
// | BOOKING  - Link to Online Booking if enabled                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking.php,v 1.00 2003/10/01
//
if ($_SESSION[$ss]['booking_flag'] == 'N') { // Online booking is disabled
    echo '<p>We are temporarily unable to take online bookings here. If you wish to make a booking, please call us on '.$_SESSION[$ss]['company_telephone'].'.</p>';
    return;
} ?>
<input type="button" name="conditions" value="Accept " onclick="DoPopup('<?=$servername?>');"/>