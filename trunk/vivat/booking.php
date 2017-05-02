<?php  
// +----------------------------------------------------------------------+
// | BOOKING  - Link to Online Booking if enabled                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking.php,v 1.00 2005/02/09
//
if ($_SESSION[$ss]['booking_flag'] == 'N') { // Online booking is disabled
    return;
} ?>
<br><br><input type="button" name="conditions" value="Accept " onClick="DoPopup('<?=$servername?>');">