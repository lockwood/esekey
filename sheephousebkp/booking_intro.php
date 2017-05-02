<?php
// +----------------------------------------------------------------------+
// | BOOKING_INTRO  - Company 4 - Advise user of Online Booking status    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/booking_intro.php,v 1.02 2006/01/30
//

if ($_SESSION[$ss]['booking_flag'] == 'Y') { // Online booking is enabled
    ?>
<p>On line booking is currently available for B&amp;B, and for self catering cottages for bookings of 7 days or more made at least 3 days in advance.
 For shorter self catering bookings, please contact us via phone or email as indicated above.</p>
<p>If you wish to book online, please read the conditions of booking shown on this page, then choose the appropriate 
button to proceed. Submission of the booking form confirms your acceptance of these conditions. 
Your booking will remain unconfirmed until you receive an email confirming availability and indicating our acceptance of 
the booking.</p>  
<?php
} ?>
<h1 style="text-align:center">Terms and conditions of booking</h1>
<ul>
<li>Bookings for the cottages are subject to a 50% non refundable deposit at the time of booking.</li>
<li>The balance in full is payable 28 days before arrival.</li>
<li>Cancellations made within 28 days of the start date of the booking are not entitled to any refund. If you are in any doubt as to whether you may need to cancel, please consider taking out your own cancellation insurance.</li>
<li>Rates include VAT, heating, lighting, linen and towels, weekly cleaning and service.</li>
<li>Check-in is after 4:00pm on day of arrival unless otherwise arranged.</li>
<li>Check-out is 10:30am on day of departure unless otherwise arranged.</li>
<li>If known, expected check-in and check-out times should be notified on the Secure Booking as Additional Information.</li>
<li>For B&B, a non refundable deposit equal to the cost of the first night will be made at the time of booking.</li>
<li>For B&B cancellations made less than 48 hours prior to check in, the amount in full may also be payable. This is at the owner's discretion.</li>
<li>Breakages and damage will be charged for.</li>
<li>Cottages are to be left in a similar condition to that in which found on arrival, or an extra cleaning charge may be made.</li>
<li>In the event of us cancelling a booking due to circumstances beyond our control, we will refund monies paid to us. We strongly advise you to take out your own travel insurance to cover other costs.</li>
<li>Owners will have weekly access to all accommodation for cleaning and maintenance.</li>
</ul>
