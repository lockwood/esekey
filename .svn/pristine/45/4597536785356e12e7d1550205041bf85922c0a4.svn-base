<?php
// +----------------------------------------------------------------------+
// | Properties - initialisation of EseSite runtime driver - Company 9    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 9/properties.php,v 1.00 2007/02/01
//

// $_test = '_test';

if ($_SERVER['SERVER_NAME'] == 'dlockwood') { // test environment variables
    // Environment - test
    $env = 'test';
    // $_test = '_test';

    // Database User - test
    $db_user = 'root';
    $db_name = 'eseData';

    // Document root - test
    $DOCUMENT_ROOT .= '/esekey';

    // Server Name - test
    $servername = 'dlockwood/esekey';

} else { // production environment variables
    // Environment - production

    $env = 'prod';

    // Database User - production
    $db_user = 'esekey9_dlockwoo';
    $db_name = 'esekey9_eseData';

    // Document root - production
    $DOCUMENT_ROOT = '/home/esekey9/public_html';

    // Server Name - production
    $servername = 'securesslhost.net/~esekey9';
}
// Sub Session User type for this directory
$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin

// Username for database identification
$_SESSION[$ss]['username'] = 'guest';

// company id for this directory
$_SESSION[$ss]['company_id'] = '00009';

?>