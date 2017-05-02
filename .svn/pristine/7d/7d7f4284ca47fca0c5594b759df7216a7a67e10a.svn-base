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

$pagearray = $db_object->getAll("SELECT page_id
                                   FROM page 
                                  WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND active_flag = 'Y'
                               ORDER BY page_id");

foreach ($pagearray as $pagerow) {
    $page_id = $pagerow['page_id'];
    // echo 'Processing Page '.$page_id.'<br>'; 
    include ('generate.php');
}
?>