<?php
// +----------------------------------------------------------------------+
// | STATUS  - Esekey Company 6 Calculate and store commission            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 6/commission.php,v 1.00 2005/02/08
//

$commission_rate = 0.02;

$bookingarray = $db_object->getAll("
                    SELECT booking_reference
                      FROM booking".$_SESSION[$ss]['_test']."
                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                  ORDER BY booking_reference");

foreach ($bookingarray as $bookingrow) {
  $insert = "INSERT into commission".$_SESSION[$ss]['_test']." SELECT 
                                         company_id,
                                         CONCAT(YEAR(last_modified_on), 'Q', QUARTER(last_modified_on)),
                                         booking_reference,
                                         last_modified_on,
                                         last_modified_by,
                                         deposit_amount+balance_amount AS initial_amount,
                                         (deposit_amount+balance_amount) * ".$commission_rate." AS commission_amount,
                                         'Draft',
                                         '',
                                         '',
                                         '".$_SESSION[$ss]['username']."',
                                         now()
                                    FROM booking_audit".$_SESSION[$ss]['_test']."
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND booking_reference = '".$bookingrow['booking_reference']."'
                                     AND booking_sequence = 1";
  $add_member = $db_object->query($insert);
}

