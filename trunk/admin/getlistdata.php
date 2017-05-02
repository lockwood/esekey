<?php
// +----------------------------------------------------------------------+
// | GETLISTDATA  - Esekey Admin Console generic get dropdownlist data    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getlistdata.php,v 1.02 2005/07/20
//

if ($foreign_key[$i] == 'image') { // get image list from file system
    $dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    $filename = split ('[/.\]', $file);
                    if ((strtoupper(end($filename)) == 'JPG') or (strtoupper(end($filename)) == 'GIF')) {
                        $filearray[] = $file;
                    }
                }
            }
            closedir($dh);
        }
        asort($filearray);
        foreach($filearray as $filerow) {
            $listarray[$i][] = $filerow;
        }
    }
    return;
}

if ($foreign_key[$i] == 'customer') { // customer table - desc is Surname, Firstname
    $temparray = $db_object->getAll("SELECT *
                                    FROM customer
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'");
    foreach($temparray as $temprow) {
        $listarray[$i][] = $temprow[customer_id];
        $list_desc_array[$i][] = ' - '.$temprow[last_name].', '.$temprow[first_name];
        // echo $temprow[customer_id];
    }
    return;
}

if ($foreign_key[$i] == 'property') { // property table uses resource_id as property_Id
    $temparray = $db_object->getAll("SELECT property_id, property_name 
                                       FROM property
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."' ");
    foreach($temparray as $temprow) {
        $listarray[$i][] = $temprow['property_id'];
        $list_desc_array[$i][] = ' - '.$temprow['property_name'];
        // echo $temprow[property_id];
    }
    return;
}

if ($foreign_key[$i] == 'page') { // get page title as descriptive info
    $temparray = $db_object->getAll("SELECT page_id, page_name 
                                       FROM page
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."' ");
    foreach($temparray as $temprow) {
        $listarray[$i][] = $temprow[page_id];
        $list_desc_array[$i][] = ' - '.$temprow[page_name];
        // echo $temprow[page_id];
    }
    return;
}

if ($foreign_key[$i] == 'element') { // get beginning of element text as descriptive info
    $temparray = $db_object->getAll("SELECT element_id, text 
                                       FROM element
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."' ");
    foreach($temparray as $temprow) {
        $listarray[$i][] = $temprow[element_id];
        $list_desc_array[$i][] = ' - '.substr(htmlentities($temprow[text], ENT_QUOTES), 0, 90);
        // echo $temprow[element_id];
    }
    return;
}

if ($foreign_key[$i] == 'element_type') { // static array
    $listarray[$i][] = 'top';
    $listarray[$i][] = 'left';
    $listarray[$i][] = 'right';
    return;
}

if ($foreign_key[$i] == 'charge_type') { // not keyed on company_id
	$temparray = $db_object->getAll("SELECT * FROM charge_type");
    foreach($temparray as $temprow) {
        $listarray[$i][] = $temprow[charge_type];
        $list_desc_array[$i][] = ' - '.$temprow[charge_type_name].' '.$temprow[charge_type_applies];
    }
    return;
}

if ($foreign_key[$i] == 'accommodation') { // static array
    $listarray[$i][] = 6;
    $listarray[$i][] = 1;
    $listarray[$i][] = 2;
    $listarray[$i][] = 3;
    $listarray[$i][] = 4;
    $listarray[$i][] = 9;
    $listarray[$i][] = 5;
    $list_desc_array[$i][] = 'B &amp B';
    $list_desc_array[$i][] = 'Cottage One';
    $list_desc_array[$i][] = 'Cottage Two';
    $list_desc_array[$i][] = 'Cottage Three';
    $list_desc_array[$i][] = 'Cottage Four';
    $list_desc_array[$i][] = 'The West Wing';
    $list_desc_array[$i][] = 'Southlands Cottage';
    return;
}

if ($foreign_key[$i] == 'review_status') { // static array
    $listarray[$i][] = 'N';
    $listarray[$i][] = 'Y';
    $listarray[$i][] = 'D';
    $list_desc_array[$i][] = 'Unapproved';
    $list_desc_array[$i][] = 'Approved';
    $list_desc_array[$i][] = 'Deleted';
    return;
}


$temparray = $db_object->getAll("SELECT ".$name[$i]." FROM ".$foreign_key[$i]." WHERE company_id = '".$_SESSION[$ss]['company_id']."' ");

foreach($temparray as $temprow) {
    $listarray[$i][] = $temprow[$name[$i]];
    // echo $temprow[$name[$i]];
}

?>