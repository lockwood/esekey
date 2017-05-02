<?php
// +----------------------------------------------------------------------+
// | INDEX  - the EseSite runtime driver - Company 8                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/index.php,v 1.00 2005/07/15
//

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
if (!isset($_GET['p'])) {
    $page_id = 1;
} else {
    $page_id = $_GET['p'];
}

if (!isset($_GET['popup'])) {
    $popup = 0;
} else {
    $popup = $_GET['popup'];
}

if (!isset($_GET['bk'])) {
    $bk = 0;
} else {
    $bk = $_GET['bk'];
}

// get data and populate arrays
require('getdata.php');

if ($popup == 1)
{
	require ('popup.php');
} else
{
	require('page.php');	// page format script.
}
?>