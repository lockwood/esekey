<?php  
// +----------------------------------------------------------------------+
// | BOOKING  - Link to Online Booking if enabled                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking.php,v 1.01 2009/05/03
//
if ($_SESSION[$ss]['booking_flag'] == 'N') { // Online booking is disabled
    echo '<p>We are temporarily unable to take online bookings here. If you wish to make a booking, please call us on '.$_SESSION[$ss]['company_telephone'].'.</p>';
    return;
} 
if (isset($single_property_bookings_only) && $single_property_bookings_only)
{
	?>
<input type="button" name="conditions" value="Accept " onclick="DoPopup('<?=$servername?>','<?=$selected_id?>');"/>	
	<?php
} else
{
	?>
<input type="button" name="conditions" value="Accept " onclick="DoPopup('<?=$servername?>');"/>	
	<?php
}
