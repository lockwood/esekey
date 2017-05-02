<?php
// +----------------------------------------------------------------------+
// | INDEX  - the EseSite runtime driver - Company 4                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/index.php,v 1.00 2005/03/04
//

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
if (!isset($_GET['p'])) {
    $page_id = 1;
} else {
    $page_id = $_GET['p'];
}
// get data and populate arrays
require('getdata.php');

require('page.php');	// page format script.
?>