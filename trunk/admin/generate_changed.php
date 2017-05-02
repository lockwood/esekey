<?php
// +----------------------------------------------------------------------+
// | GENERATE CHANGED  - call EseSite static page generator for changes   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: generate_changed.php,v 1.01 2004/10/27
//

// initialise all variables

if ($keyarray[0] == 'page_id') { // generate page that has been changed
    $page_id = $valuearray[0];
    include ('generate.php');
    return;
} elseif ($keyarray[0] == 'element_id') { // list pages that this element appears in and generate each one
                                  // only generate pages in section 1
    $pagearray = $db_object->getAll("SELECT t1.page_id
                                       FROM page_element AS t1,
                                            section_page AS t2
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t1.company_id = t2.company_id
                                        AND t1.page_id = t2.page_id
                                        AND t1.active_flag = 'Y'
                                        AND t2.active_flag = 'Y'
                                        AND element_id = '".$valuearray[0]."'"); 

    foreach ($pagearray as $pagerow) {
        $page_id = $pagerow['page_id'];
        // echo 'Processing Page '.$page_id.'<br>'; 
        include ('generate.php');
    }
} elseif ($keyarray[0] == 'section_id') { // list pages in the changed section and generate each one
    $pagearray = $db_object->getAll("SELECT page_id
                                       FROM section_page 
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND active_flag = 'Y'
                                        AND section_id = '".$valuearray[0]."'"); 

    foreach ($pagearray as $pagerow) {
        $page_id = $pagerow['page_id'];
        // echo 'Processing Page '.$page_id.'<br>'; 
        include ('generate.php');
    }
} else {
    return;
}
?>