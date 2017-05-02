<?php
// +----------------------------------------------------------------------+
// | BOOKING_UNLOCK  - Unlock Online Booking Flag after use               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking_unlock.php,v 1.01 2005/01/21
//
// Check that flag is locked before unlocking
$booking_flag = $db_object->getOne("SELECT booking_flag 
                                      FROM company".$_test." 
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND active_flag = 'Y'");
if ($booking_flag == 'L') { // flag is locked - request to unlock can proceed

    // Unlock booking flag at company level after completing any updates
    $update_booking_flag = $db_object->query("UPDATE company".$_test." 
                                                 SET booking_flag = 'Y'
                                               WHERE company_id = '".$_SESSION[$ss]['company_id']."'");
    if (DB::isError($update_booking_flag)) {
        die($update_booking_flag->getMessage());
    }
}
// if flag is not locked - cannot unlock.
?>