<?php
// +----------------------------------------------------------------------+
// | ADD_PAGE  - Esekey Admin Console add page to site                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/add_page.php,v 1.00 2008/02/03
//

  $insert_string = "INSERT INTO page
                                            VALUES ('".$_SESSION[$ss]['company_id']."',
                                                    0,
                                                    'New Page Title',
                                                    'New Page Name',
                                                    1,
                                                    'Y',
                                                    now(),
                                                    '".$_SESSION[$ss]['username']."',
                                                    now())";
  //echo $insert_string;
  //*
  $insert_page = $db_object->query($insert_string);
  if (DB::isError($insert_page)) {
      die($insert_page->getMessage());
  }
  // */
  
  // return page_id  //
  $page_id = mysql_insert_id(); 
  $update_page = "UPDATE page SET page_title = 'New Page ".$page_id." Title', page_name = 'New Page ".$page_id." Name'
             WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND page_id = ".$page_id;
  $db_object->query($update_page);
  // echo $update_page; 
  if (isset($_GET['section']))
  {
  	$section_id = $_GET['section'];
  } else
  {
  	$section_id = 1;
  }

  $select = $db_object->getRow("SELECT section_id,
                                   MAX(menu_sequence) AS menu_sequence
                                  FROM section_page
                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                   AND section_id = '".$section_id."'
							  GROUP BY section_id");
  $sequence = $select['menu_sequence'] + 1;
  $insert_section_string = "INSERT into section_page
                                      VALUES('".$_SESSION[$ss]['company_id']."',
                                             '".$section_id."',
                                             '".$sequence."',
                                             '".$page_id."',
                                             'Y',
                                             now(),
                                             '".$_SESSION[$ss]['username']."',
                                             now())";
  // echo $insert_section_string;
  $insert_section_page = $db_object->query($insert_section_string);
  if (DB::isError($insert_section_page)) {
      die($insert_section_page->getMessage());
  }
  
  $text = "Page ".$page_id." element ";
  for ($i=1;$i<7;$i++)
  {
  	$insert_string = "INSERT INTO element
                                            VALUES ('".$_SESSION[$ss]['company_id']."',
                                                    0,
                                                    0,
                                                    '',
                                                    NULL,
                                                    'top',
                                                    '".$text.$i."',
                                                    '',
                                                    'Y',
                                                    now(),
                                                    '".$_SESSION[$ss]['username']."',
                                                    now())";
  	$insert_element = $db_object->query($insert_string);
  	if (DB::isError($insert_element)) {
    	  die($insert_element->getMessage());
  	}
  	// return element_id  //
  	$element_id[$i] = mysql_insert_id();
  }
    
  for ($i=1;$i<7;$i++)
  {
  	$insert_page_string = "INSERT into page_element
                                      VALUES('".$_SESSION[$ss]['company_id']."',
                                             '".$page_id."',
                                             '".$i."',
                                             '".$element_id[$i]."',
                                             'Y',
                                             now(),
                                             '".$_SESSION[$ss]['username']."',
                                             now())";
  	$insert_page_element = $db_object->query($insert_page_string);
  	if (DB::isError($insert_page_element)) {
    	  die($insert_page_element->getMessage());
  	}
  }
  $msgtext = 'New Page '.$page_id.' successfully added to section '.$section_id;
  $trackhdr  = "MIME-Version: 1.0\r\n";
  $trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
  @mail('dave@esekey.com', $msgtext, $msgtext, $trackhdr);

