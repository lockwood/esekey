<?php
// +----------------------------------------------------------------------+
// | Properties - initialisation of EseSite runtime driver - Company 0    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 0/properties.php,v 1.01 2005/05/06
//

if ($_SERVER['SERVER_NAME'] == 'dlockwood') { // test environment variables
    // Environment - test
    $env = 'test';

    // Database User - test
    $db_user = 'root';
    $db_name = 'eseData';

    // Document root - test
    $DOCUMENT_ROOT .= '/esekey';

    // Server Name - test
    $servername = 'dlockwood/esekey';
//	ini_set('include_path', 'c:\apache2\php\pear');
} else { // production environment variables
    // Environment - production

    $env = 'prod';

    // Database User - production
    $db_user = 'esekey9_dlockwoo';
    $db_name = 'esekey9_eseData';

    // Document root - production
    $DOCUMENT_ROOT = '/home/esekey9/public_html';

    // Server Name - production
    $servername = 'www.secureserver3.co.uk/ssl/www.esekey.co.uk';
	ini_set('include_path', '/home/esekey9/public_html/service/PEAR');
}
// Sub Session User type for this directory
$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin

// Username for database identification
$_SESSION[$ss]['username'] = 'guest';

// company id for this directory
$_SESSION[$ss]['company_id'] = '00000';

?>