<?php
// +----------------------------------------------------------------------+
// | BOOKING_LOCK  - Wait for and Lock Online Booking Flag                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking_lock.php,v 1.01 2005/01/21
//
// Check and Lock booking flag at company level to prevent update conflicts
$booking_flag = $db_object->getOne("SELECT booking_flag 
                                      FROM company".$_test." 
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND active_flag = 'Y'");
if ($booking_flag == 'N') { // booking is not available to public
    if ($ss == 'Admin') { // administrator can work with bookings while closed to public
        echo '<p style="color: red">Note: Online Booking is currently only available to the administrator.</p>';
        return;
    } else { // shouldn't be here
        die('Sorry - The Online Booking System is not available - please try again later');
    }
}
if ($booking_flag == 'L') { // flag is locked - another user is currently updating a booking
    sleep(2); // wait for 2 seconds then read it again (attempt 2)
    $booking_flag = $db_object->getOne("SELECT booking_flag 
                                      FROM company".$_test." 
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND active_flag = 'Y'");
}
if ($booking_flag == 'L') { // flag is locked - another user is currently updating a booking
    sleep(2); // wait for 2 seconds then read it again (attempt 3)
    $booking_flag = $db_object->getOne("SELECT booking_flag 
                                      FROM company".$_test." 
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND active_flag = 'Y'");
}
if ($booking_flag == 'L') { // flag is locked - another user is currently updating a booking
    sleep(2); // wait for 2 seconds then read it again (attempt 4)
    $booking_flag = $db_object->getOne("SELECT booking_flag 
                                      FROM company".$_test." 
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND active_flag = 'Y'");
}
if ($booking_flag == 'Y') { // booking is enabled but flag is not locked - set it to 'L' to lock it
    $update_booking_flag = $db_object->query("UPDATE company".$_test." 
                                                 SET booking_flag = 'L'
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'");
    if (DB::isError($update_booking_flag)) {
        die($update_booking_flag->getMessage());
    }
} else { // flag is still not unlocked after 4 attempts - inform user that online booking is temporarily unavailable.
    include ('booking_unlock.php');
    die('Sorry - The Online Booking System is temporarily unavailable - please try again later');
}
?>