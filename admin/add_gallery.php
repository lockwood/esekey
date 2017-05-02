<?php
// +----------------------------------------------------------------------+
// | ADD_GALLERY  - Esekey Admin Console add gallery element to page      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2009 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/add_gallery.php,v 1.00 2009/01/15
//

  $insert_string = "INSERT INTO element
                                            VALUES ('".$_SESSION[$ss]['company_id']."',
                                                    0,
                                                    0,
                                                    '',
                                                    NULL,
                                                    'top',
                                                    '',
                                                    '',
                                                    'N',
                                                    now(),
                                                    '".$_SESSION[$ss]['username']."',
                                                    now())";
  $insert_element = $db_object->query($insert_string);
  if (DB::isError($insert_element)) {
      die($insert_element->getMessage());
  }
  
  // return element_id  //
  $element_id = mysql_insert_id(); 
  $update_element = "UPDATE element SET text = 'New Gallery Element ".$element_id." text'
             WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND element_id = ".$element_id;
  $db_object->query($update_element);
  // echo $update_page; 
  if (isset($_GET['page']))
  {
  	$page_id = $_GET['page'];
  } else
  {
  	$page_id = 5;
  }

  $select = $db_object->getRow("SELECT page_id,
                                   MAX(sequence) AS sequence
                                  FROM page_element
                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                   AND page_id = '".$page_id."'
							  GROUP BY page_id");
  $sequence = $select['sequence'] + 1;
  $insert_page_string = "INSERT into page_element
                                      VALUES('".$_SESSION[$ss]['company_id']."',
                                             '".$select['page_id']."',
                                             '".$sequence."',
                                             '".$element_id."',
                                             'Y',
                                             now(),
                                             '".$_SESSION[$ss]['username']."',
                                             now())";
  // echo $insert_page_string;
  $insert_page_element = $db_object->query($insert_page_string);
  if (DB::isError($insert_page_element)) {
      die($insert_page_element->getMessage());
  }
  $msgtext = 'New Gallery Element '.$element_id.' successfully added to page '.$page_id;
  $trackhdr  = "MIME-Version: 1.0\r\n";
  $trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
  @mail('dave@esekey.com', $msgtext, $msgtext, $trackhdr);

