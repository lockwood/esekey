<?php
// +----------------------------------------------------------------------+
// | GETEVENTDATA  - Esekey Admin Console get element view                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getelementdata.php,v 1.00 2008/08/11
//

// get view data and initialise array
$viewarray = $db_object->getAll("SELECT  t2.page_name,
                                         t1.element_id,
                                         t1.resource_id,
                                         SUBSTR(t1.image_name,1,12) AS image_name,
                                         t1.image_alt,
                                         t1.element_type,
                                         t1.text,
                                         t1.link,
                                         t1.active_flag,
                                         t1.created_date,
                                         t1.last_modified_by,
                                         t1.last_modified_on
                                    FROM element AS t1,
                                         page AS t2,
                                         section AS t3,
										 section_page as t4,
										 page_element as t5
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.company_id = t3.company_id
                                     AND t1.company_id = t4.company_id
                                     AND t1.company_id = t5.company_id
                                     AND t5.page_id = t2.page_id
                                     AND t5.element_id = t1.element_id
                                     AND t4.section_id = t3.section_id
                                     AND t4.page_id = t2.page_id
                                     ORDER BY t4.section_id, t5.page_id, t1.element_id");

foreach ($viewarray as $id=>$viewrow) {
	$viewarray[$id]['page_name'] = html_entity_decode($viewrow['page_name']);
	$viewarray[$id]['text'] = html_entity_decode($viewrow['text']);
}
$name = array('page_name','element_id','resource_id','image_name','image_alt',
			  'element_type','text','link','active_flag','created_date','last_modified_by', 'last_modified_on' );
$unique = array('N','Y','N','N','N',
			  'N','N','N','N','N','N', 'N' );
$list = array('Y','Y','N','Y','N',
			  'N','Y','N','Y','N','N', 'N' );
$type = array('T','I','I','T','T',
			  'T','T','T','C','D','U', 'D' );
$update = array('N','N','Y','Y','Y',
			  'Y','Y','Y','Y','N','N', 'N' );
$foreign_key = array('','','property','image','',
			  'element_type','','','','','', '' );
$label = array('Page','Id','Property Id','Image','Alt',
			  'Element Type','Text','Link','Active','Created','Mod By', 'Mod On' );
$justify = array('left','right','right','left','left',
			  'left','left','left','center','center','center', 'center' );
$column = $name;
?>