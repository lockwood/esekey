<?php
// +----------------------------------------------------------------------+
// | GET DATA  - initialisation of EseSite runtime driver                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: getdata.php,v 1.05 2006/01/17
//
// retrieve any individual settings

// get data and initialise arrays

if ($_SESSION[$ss]['company_id'] != '00000') { //Look for company details in database
    $row = $db_object->getRow("SELECT company_name, 
                                      company_code,
                                      company_telephone,
                                      company_fax,
                                      company_email,
                                      availability_flag,
                                      booking_flag 
                                 FROM company 
                                WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                  AND active_flag = 'Y'");

    $_SESSION[$ss]['company_name'] = $row['company_name']; 
    $_SESSION[$ss]['company_code'] = $row['company_code']; 
    $_SESSION[$ss]['company_telephone'] = $row['company_telephone'];
    $_SESSION[$ss]['company_fax'] = $row['company_fax'];
    $_SESSION[$ss]['company_email'] = $row['company_email'];
    $_SESSION[$ss]['availability_flag'] = $row['availability_flag'];
    $_SESSION[$ss]['booking_flag'] = $row['booking_flag'];
} 
if ($_SESSION[$ss]['company_name'] == '') { //company not found - assume company 0
    $_SESSION[$ss]['company_id'] = '00000';
    $_SESSION[$ss]['company_name'] = 'Esekey'; 
    $_SESSION[$ss]['company_code'] = '00000';
    $_SESSION[$ss]['company_telephone'] = '07860 832741'; 
    $_SESSION[$ss]['company_fax'] = '07860 832741'; 
    $_SESSION[$ss]['company_email'] = 'enquiries@esekey.com'; 
    $_SESSION[$ss]['availability_flag'] = 'N';
    $_SESSION[$ss]['booking_flag'] = 'N';
}

include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

$row = $db_object->getRow("SELECT t1.page_title,
                                  t1.page_name, 
                                  t1.content_source, 
                                  t2.section_id,
                                  t2.menu_sequence
                             FROM page as t1,
                                  section_page as t2
                            WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                              AND t1.company_id = t2.company_id
							  AND t2.active_flag = 'Y'
                              AND t1.page_id = t2.page_id
                              AND t1.page_id = '$page_id'");
if (($row['page_name'] == null) && ($ss != 'Admin')) { // site page not found 
    if ($page_id == 1) { // home page not found - probable database problem
        die('The site is temporarily unavailable - please try again later');
    } else { // try home page
        $page_id = 1;
        include('getdata.php');
        return;
    }
}
$section_id = $row['section_id'];
$section_name = '';
if ($section_id == 5 && $window_type != 'p') { // secure booking must be invoked in pop-up
    $page_id = 1;
    include('getdata.php');
    return;
}
$title = $row['page_title'];
$page_name = $row['page_name'];
$content_source = $row['content_source'];
$menu_sequence = $row['menu_sequence'];
$copyright_year = date('Y');
$sectionarray = $db_object->getAll("SELECT section_id, 
                                           description
                                      FROM section
                                     WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND section_id <> 5
                                       AND active_flag = 'Y'");
foreach ($sectionarray as $sectionrow) {
	if ($sectionrow['section_id'] == $section_id)
	{
		$section_name = $sectionrow['description'];
	}
    $intropage = $db_object->getRow("SELECT t1.page_id,
                                            t1.content_source 
                                       FROM page AS t1,
                                            section_page AS t2 
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t1.page_id = t2.page_id
                                        AND t2.section_id = '".$sectionrow[section_id]."'                                       
                                        AND t2.menu_sequence = 1");
    $intro_page[] = $intropage['page_id'];
    if ($intropage['content_source'] == 1) { // static page
        $intro_url[] = 'p'.$intropage['page_id'].'.html';
    } else { // dynamic page
        $intro_url[] = 'p'.$intropage['page_id'].'.php';
    }  
    $descr[] = $sectionrow[description];
    if ($sectionrow[section_id] == $section_id) {
        $sect[] = 'currentsection';
        $description = $sectionrow[description];
    } else {
        $sect[] = 'othersection';
    }
}

$menuarray = $db_object->getAll("SELECT t1.page_id,
                                        t1.menu_sequence, 
                                        t2.page_name,
                                        t2.page_title,
                                        t2.content_source,
                                        t1.active_flag,
                                        'dummystring' AS page_url 
                                   FROM section_page AS t1, 
                                                page AS t2 
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND t1.section_id = '$section_id'
                                    AND t1.menu_sequence > 0
                                    AND t1.active_flag = 'Y'
                                    AND t2.active_flag = 'Y'
                                    AND t1.company_id = t2.company_id
                                    AND t1.page_id = t2.page_id
                               ORDER BY t1.menu_sequence");
for ($i= 0; $i < count($menuarray); $i++) {
    if ($menuarray[$i]['content_source'] == 1) { // static page
        $menuarray[$i]['page_url'] = 'p'.$menuarray[$i]['page_id'].'.html';
    } else { // dynamic page
        $menuarray[$i]['page_url'] = 'p'.$menuarray[$i]['page_id'].'.php';
    }  
}

$propertyarray = $db_object->getAll("SELECT DISTINCT t1.page_id,
                                            t3.property_id,
                                            t3.property_number,
                                            t3.property_name,
                                            t3.price_code,
                                            t4.page_name
                                       FROM page_element as t1,
                                            element as t2,
                                            property as t3,
                                            page as t4
                                      WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t3.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t4.company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND t2.resource_id = t3.property_id
                                        AND t1.element_id = t2.element_id
                                        AND t3.active_flag = 'Y'
                                        AND t4.page_id = t1.page_id
                                   ORDER BY t1.page_id");

if (!isset($property_order))
{
	$property_order = "property_name, property_number";
}

$resourcearray = $db_object->getAll("SELECT *
                                       FROM property
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_flag = 'Y'
                                   ORDER BY ".$property_order); 

$bbarray = $db_object->getAll("      SELECT *
                                       FROM property
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_bb = 'Y'
                                   ORDER BY ".$property_order); 

$booking_patterns = $db_object->getAll("SELECT DISTINCT booking_pattern
                                       FROM property
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_flag = 'Y'"); 

$pricearray = $db_object->getAll("SELECT * FROM price WHERE company_id = '".$_SESSION[$ss]['company_id']."' ORDER BY price_code, start_date, max_nights");

$elementarray = $db_object->getAll("SELECT t1.image_name,
                                           t1.image_alt,
                                           t1.element_type,
                                           t1.text,
                                           t1.link,
                                           t1.resource_id,
										   t1.element_id
                                      FROM element as t1,
                                           page_element as t2
                                     WHERE t2.company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND t1.company_id = t2.company_id
                                       AND t1.element_id = t2.element_id
                                       AND t2.page_id = '$page_id'
                                       AND t2.active_flag = 'Y'");

?>