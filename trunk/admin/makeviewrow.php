<?php
// +----------------------------------------------------------------------+
// | MAKEVIEWROW  - Esekey Admin Console generic create an empty view row |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2009 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/makeviewrow.php,v 1.00 2009/03/31
//

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
}

$viewrow = array();
foreach ($descriptorarray as $descriptorrow) {
	$viewrow[$descriptorrow['field_name']] = '';
    if ($descriptorrow['type'] != 'P') {// exclude passwords
        $column[] = $descriptorrow['field_name'];
    }
}
$table_name = $view_name;

?>