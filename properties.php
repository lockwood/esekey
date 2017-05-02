<?php
// +----------------------------------------------------------------------+
// | Properties - initialisation of EseSite runtime driver                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: properties.php,v 1.01 2005/05/06
//

if ($_SERVER['SERVER_NAME'] == 'www.esekeydave.com') { // test environment variables
    // Environment - test
    $env = 'test';

    // Database User - test
    $db_user = 'root';
    $db_name = 'eseData';

    // Document root - test
    //$DOCUMENT_ROOT .= '/esekey';
	$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
    // Server Name - test
    $servername = 'http://'.$_SERVER['SERVER_NAME'];	// $sec_protocol = 'http';
} else { // production environment variables
    // Environment - production

    $env = 'prod';
    // Database User - production
    $db_user = 'esekey9_dlockwoo';    $db_name = 'esekey9_eseData';
    // Document root - production
    $DOCUMENT_ROOT = '/home/esekey9/public_html';
    // Server Name - production
    $servername = 'https://phi.securesslhost.net/~esekey9';
	// $sec_protocol = 'https';}
// Sub Session User type for this directory
$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin

// Username for database identification
$_SESSION[$ss]['username'] = 'guest';

// company id for this directory
$_SESSION[$ss]['company_id'] = '00000';

?>