<?php
// +----------------------------------------------------------------------+
// | INDEX  - the EseSite runtime driver - Company 7                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 7/index.php,v 1.00 2005/07/15
//


// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

if ($sid = $_GET['sid']) {
	// web page is accessed via Admin Console for editing
	$ss = 'Admin';
	require ('admin_check_session.php');
}

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
if (isset($_GET['property'])) {
	$selected_id = $_GET['property'];
}

// get data and populate arrays
require('getdata.php');

require('page.php');	// page format script.
?>