<?php
// +----------------------------------------------------------------------+
// | IDXS  - the secure EseSite runtime driver - Company 6                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 6/idxs.php,v 1.00 2005/01/12
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

// initialise all variables
if (!isset($_GET['s'])) {
    $section_id = 1;
} else {
    $section_id = $_GET['s'];
}
$window_type = 'p';

$page_id = $_GET['p'];
// get data and populate arrays
require('getdata.php');

if ($page_id != 5) { 
    // secure booking  page 5 only - otherwise redirect to home
    header("Location: http://".$_SERVER['SERVER_NAME']."/".$_SESSION[$ss]['company_code']);
    return;
}

if (!isset($_GET['conditions'])) { 
    // not first time thru, so may be personal details attached to referring url
    // remove these parameter values from http referer field for security 
    // as this field gets logged to activity table
    $_SERVER['HTTP_REFERER'] = '';
}

if ($_SESSION[$ss]['booking_flag'] == 'N') { // Online booking is disabled
    header("Location: http://".$_SERVER['SERVER_NAME']."/".$_SESSION[$ss]['company_code']);
    return;
}

if (!isset($_SERVER['HTTPS'])) { // session not using secure sockets - must have got here in error - redirect
    header("Location: http://".$_SERVER['SERVER_NAME']."/".$_SESSION[$ss]['company_code']);
    return;
}

if ((!isset($_GET['conditions'])) && (!isset($_GET['d']))) { // booking conditions not accepted or form not submitted with valid date - redirect
    header("Location: http://".$_SERVER['SERVER_NAME']."/".$_SESSION[$ss]['company_code']);
    return;
}

require('validator.php');    // validation script.
require('popup.php');    // page format script.
?>