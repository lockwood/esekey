<?php
// +----------------------------------------------------------------------+
// | INDEX  - the EseSite runtime driver - Company 2                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 2/index.php,v 1.00 2003/10/01
//

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

// initialise all variables
if (!isset($_GET['p'])) {
    $page_id = 1;
} else {
    $page_id = $_GET['p'];
}

// get data and populate arrays
require('getdata.php');

// this is a full navigation window
require('page.php');    // page format script.

?>