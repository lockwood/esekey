<?php
// +----------------------------------------------------------------------+
// | GETPAGEDATA  - Esekey Admin Console get page view                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getpagedata.php,v 1.00 2008/08/12
//

// get view data and initialise array
$viewarray = $db_object->getAll("SELECT  t2.section_id,
                                         t1.page_id,
                                         t1.page_title,
                                         t1.page_name,
                                         t1.content_source,
                                         t1.active_flag,
                                         t1.created_date,
                                         t1.last_modified_on,
                                         t1.last_modified_by
                                    FROM page AS t1,
										 section_page as t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.page_id = t2.page_id
                                     ORDER BY t2.section_id, t1.page_id");

$descriptorarray = $db_object->getAll("SELECT t1.field_name, 
                                              t1.unique_key,
                                              t1.list,
                                              t1.user_edit,
                                              t1.foreign_key, 
                                              t2.field_label, 
                                              t2.type,
                                              t2.justify
                                         FROM view_descriptor AS t1,
                                              descriptor AS t2
                                        WHERE t1.view_name = '".$view_name."'
                                          AND t1.company_id = 0
                                          AND t2.company_id = 0
                                          AND t1.field_name = t2.field_name 
                                     ORDER BY t1.field_sequence");

$select = null;
foreach ($descriptorarray as $descriptorrow) {
    if ($descriptorrow['field_name'] == $view_name) {
        $title = $descriptorrow['field_label'];
    } else {
        if ($select == null) {
            $select = $descriptorrow['field_name'];
        } else {
            $select .= ', '.$descriptorrow['field_name'];
        } 
        $name[] = $descriptorrow['field_name'];
        $unique[] = $descriptorrow['unique_key'];
        $list[] = $descriptorrow['list'];
        $type[] = $descriptorrow['type'];
        $update[] = $descriptorrow['user_edit'];
        $foreign_key[] = $descriptorrow['foreign_key'];
        $label[] = $descriptorrow['field_label'];
        if ($descriptorrow['justify'] == 'L') {
            $justify[] = 'left';
        } elseif ($descriptorrow['justify'] == 'C') {
            $justify[] = 'center';
        } else {
            $justify[] = 'right';
        }
    }
    if ($descriptorrow['unique_key'] == 'Y') {
        if ($order_by == null) {
            $order_by = ' ORDER BY '.$descriptorrow['field_name'];
        } else {
            $order_by .= ', '.$descriptorrow['field_name'];
        } 
    }
}
$columns = $viewarray[0];
if (count($columns) > 0) {
  foreach ($columns as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
}
?>