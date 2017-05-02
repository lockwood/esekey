<?php
// +----------------------------------------------------------------------+
// | GENERATE ALL  - call EseSite static page generator for all static pgs|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: generate_all.php,v 1.01 2003/10/11
//

$pagearray = $db_object->getAll("SELECT section_id, page_id
                                   FROM section_page 
                                  WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND active_flag = 'Y'
                               ORDER BY section_id, page_id");

foreach ($pagearray as $pagerow) {
	$section_id = $pagerow['section_id'];
    $page_id = $pagerow['page_id'];
    // echo 'Processing Page '.$page_id.'<br>'; 
    include ('generate.php');
}
?>