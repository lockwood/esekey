<?php
// +----------------------------------------------------------------------+
// | GETGALLERYDATA  - Esekey Admin Console get gallery view              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getbookingdata.php,v 1.00 2004/11/15
//
if ($_SESSION[$ss]['company_id'] == '00004') {
	$gallery_view = true;
    include ('getimagedata.php');
    return;
}
// get view data and initialise array
$viewarray = $db_object->getAll("SELECT    t2.page_id,
                                           t2.sequence,
                                           t1.element_id,
                                           t1.image_name,
                                           t1.text AS gallery_title,
                                           t1.active_flag,
                                           t1.created_date,
                                           t1.last_modified_on,
                                           t1.last_modified_by
                                      FROM element as t1,
                                           page_element as t2,
                                           page AS t3
                                     WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND t1.company_id = t2.company_id
                                       AND t1.company_id = t3.company_id
                                       AND t1.element_id = t2.element_id
                                       AND t2.page_id = t3.page_id
                                       AND t3.content_source = '10'
								  ORDER BY t2.page_id, t2.sequence");

$columns = $viewarray[0];
if (count($columns) > 0) {
  foreach ($columns as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
} else
{
    foreach ($descriptorarray as $descriptorrow) {
        if ($descriptorrow['type'] != 'P') {// exclude passwords
            $column[] = $descriptorrow['field_name'];
        }
    }
}
?>