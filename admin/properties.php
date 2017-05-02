<?php
// +----------------------------------------------------------------------+
// | Properties - initialisation of EseSite runtime driver - Admin Console|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/properties.php,v 1.01 2005/05/06
//

if ($_SERVER['SERVER_NAME'] == 'www.esekeydave.com') { // test environment variables
    // Environment - test
    $env = 'test';

    // Database User - test
    $db_user = 'root';
    $db_name = 'eseData';

    // Document root - test
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

    // Server Name - test
    $servername = 'http://'.$_SERVER['SERVER_NAME'];
	// $sec_protocol = 'http';
} else { // production environment variables
    // Environment - production

    $env = 'prod';

    // Database User - production
    $db_user = 'esekey9_dlockwoo';
    $db_name = 'esekey9_eseData';

    // Document root - production
    $DOCUMENT_ROOT = '/home/esekey9/public_html';

    // Server Name - production
	// secure url 'https://' + serverName + '/admin/login_frame.php';
    $servername = 'https://phi.securesslhost.net/~esekey9';
	// $sec_protocol = 'https';}
// Sub Session User type for this directory
$ss = 'Admin'; // sub-session type is Admin - avoid session data conflict with type User
$posted = false; // initialise variable to prevent warnings
// Username for database identification - provided when user logs in
// company id for this directory - provided when user logs in
?>