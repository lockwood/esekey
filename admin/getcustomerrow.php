<?php
// +----------------------------------------------------------------------+
// | GETCUSTOMERROW  - Esekey Admin Console get customer row              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getcustomerrow.php,v 1.01 2005/01/21
//


$viewrow = $db_object->getRow("SELECT DISTINCT
                                         t1.customer_id,
                                         t1.title,
                                         t1.first_name,
                                         t1.last_name,
                                         t1.post_address,
                                         t1.post_code,
                                         t1.email,
                                         t1.telephone,
                                         t1.active_flag
                                    FROM customer AS t1,
                                         booking".$_SESSION[$ss]['_test']." AS t2
                                   WHERE t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.customer_id = '".$value."' 
                                     AND t2.customer_id = t1.customer_id 
                                ORDER BY ".$_SESSION[$ss]['order']);

if (count($viewrow) > 0) {
  foreach ($viewrow as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
}

?>