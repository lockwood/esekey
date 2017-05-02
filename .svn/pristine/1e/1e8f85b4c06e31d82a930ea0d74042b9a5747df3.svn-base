<?php
// +----------------------------------------------------------------------+
// | GETCUSTOMERDATA  - Esekey Admin Console get customer                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getcustomerdata.php,v 1.04 2005/07/20
//


if (isset($_GET['order'])) { // order by selected field
    $_SESSION[$ss]['order'] = $_GET['order'];
} else {
    if (!isset($_SESSION[$ss]['order'])) { 
        $_SESSION[$ss]['order'] = 'last_name, first_name';
    }
}

// get table data and initialise array
//$viewarray = $db_object->getAll("SELECT ".$select." FROM ".$view_name."
//                                   ORDER BY ".$_SESSION[$ss]['order']);

$viewarray = $db_object->getAll("SELECT  ".$select."
                                    FROM customer
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                ORDER BY ".$_SESSION[$ss]['order']);

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