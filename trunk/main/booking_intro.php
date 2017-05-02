<?php
// +----------------------------------------------------------------------+
// | BOOKING_INTRO  - Advise user of Online Booking status                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking_intro.php,v 1.00 2003/10/01
//
if ($_SESSION[$ss]['booking_flag'] == 'N') { // Online booking is disabled
    echo '<br>We are temporarily unable to take online bookings here. If you wish to make a booking, please call us on '.$_SESSION[$ss]['company_telephone'].'.';
    return;
} ?>
<p>If you wish to book online, please read the conditions of booking shown on this page, then click the &#039;Accept&#039; button to proceed to the Secure Booking form. Submission of the booking form confirms your acceptance of these conditions. Your booking will remain unconfirmed until you receive an email confirming availability and indicating our acceptance of the booking.</p>  
