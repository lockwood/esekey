<?php
// +----------------------------------------------------------------------+
// | COUNTER  - the EseSite page counter - Company 3                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/counter.php,v 1.01 2005/01/21
//
// This file updates the database activity log with an entry for the page  

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

// Initialize working values 
$rfr=getenv ("HTTP_REFERER");  

$activity_log = 'activity_log'.$_test;
// update activity log
$insert = "INSERT INTO ".$activity_log." 
            VALUES ('".$_SESSION[$ss]['company_id']."',
                    0,
                    '".$_GET['p']."',
                    now(),
                    '".$_SERVER['REMOTE_ADDR']."', 
                    '".$_SERVER['HTTP_USER_AGENT']."', 
                    '".$rfr."')";
$add_member = $db_object->query($insert);
if (DB::isError($add_member)) {
    die($add_member->getMessage());
}
$new = ImageCreate(1,2); // make tiny image 
$bgc = ImageColorAllocate($new,255,255,255); // background color 
$tc = ImageColorAllocate($new,0,0,0); // text color 
ImageFilledRectangle($new,0,0,150,30,$bgc); // add background 

// Send image with expired header so that it will not be cached, then quit 
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
Header("Content-type: image/jpg"); 
ImageJPEG($new); 
ImageDestroy($new); 
die; // make sure nothing else is sent 
 
?>
