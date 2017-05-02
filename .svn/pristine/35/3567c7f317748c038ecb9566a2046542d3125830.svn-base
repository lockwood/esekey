<?php
// +----------------------------------------------------------------------+
// | GETVIEWROW  - Esekey Admin Console generic get view row              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getviewrow.php,v 1.04 2006/11/23
//

if ($view_name == 'newemail')
{
	$query_name = 'email';
} else
{
	$query_name = $view_name;
}

$descriptorarray = $db_object->getAll("SELECT t1.field_name, 
                                              t1.unique_key,
                                              t1.list,
                                              t1.user_edit,
                                              t1.foreign_key, 
                                              t2.field_label, 
                                              t2.type,
                                              t2.justify
                                         FROM view_descriptor AS t1,
                                              descriptor AS t2
                                        WHERE t1.view_name = '".$query_name."'
                                          AND t1.company_id = 0
                                          AND t2.company_id = 0
                                          AND t1.field_name = t2.field_name 
                                     ORDER BY t1.field_sequence");

$select = null;
foreach ($descriptorarray as $descriptorrow) {
    if ($descriptorrow['field_name'] == $view_name) {
        $title = $descriptorrow['field_label'];
    } else {
        if ($select == null) {
            $select = $descriptorrow['field_name'];
        } else {
            $select .= ', '.$descriptorrow['field_name'];
        } 
        $name[] = $descriptorrow['field_name'];
        $unique[] = $descriptorrow['unique_key'];
        $list[] = $descriptorrow['list'];
        $type[] = $descriptorrow['type'];
        $update[] = $descriptorrow['user_edit'];
        $foreign_key[] = $descriptorrow['foreign_key'];
        $label[] = $descriptorrow['field_label'];
        if ($descriptorrow['justify'] == 'L') {
            $justify[] = 'left';
        } elseif ($descriptorrow['justify'] == 'C') {
            $justify[] = 'center';
        } else {
            $justify[] = 'right';
        }
    }
}

if ($view_name == 'gallery') { // build composite view for bookings
    // echo 'include getgalleryrow<br>';
    include ('getgalleryrow.php');
    return;
}

if ($view_name == 'booking_view') { // build composite view for bookings
    // echo 'include getbookingrow<br>';
    include ('getbookingrow.php');
    return;
}

if (($view_name == 'company') or ($view_name == 'email')) { 
    // view has test and prod modes 
    $table_name = $view_name.$_SESSION[$ss]['_test']; 
} else {
    $table_name = $view_name; 
}

// get view row and initialise array

// echo "SELECT ".$select." FROM ".$table_name." WHERE company_id = '".$_SESSION[$ss]['company_id']."'".$searchstring1;
$query = "SELECT ".$select." 
            FROM ".$table_name."
           WHERE company_id = '".$_SESSION[$ss]['company_id']."'";
for ($i=0;$i<count($keyarray);$i++) { // add key parms
    $query .= "
             AND ".$keyarray[$i]." = '".$valuearray[$i]."'";
}
$viewrow = $db_object->getRow($query);
if ($view_name == 'page')
{
	include ('getpagedata.php');
	foreach ($viewarray as $view)
	{
		if ($view[$keyarray[0]] == $valuearray[0])
		{
			$viewrow = $view;
		}
	}
} elseif (count($viewrow) > 0) {
  foreach ($viewrow as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
}
if ($view_name == 'newemail')
{
    // this is a create new email request - get booking data as input to this
    include ('getbookingrow.php');
    return;
}

?>