<?php
// +----------------------------------------------------------------------+
// | Properties - initialisation of EseSite runtime driver - Company 8    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/properties.php,v 1.00 2005/07/15
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

    list($p1, $p2, $p3, $p4) = explode("/", $DOCUMENT_ROOT);

    if ($p3 == 'sites') { // esekey.com domain
        // Database User - production
        $db_user = 'dlockwood';
        $db_name = 'eseData';


        // Document root - production
        $DOCUMENT_ROOT = '/home/sites/site296/web';

        // Server Name - production
        $servername = 'www.secureserver3.co.uk/ssl/www.esekey.com';
    } else { // esekey.co.uk domain
        // Database User - production
        $db_user = 'esekey9_dlockwoo';
        $db_name = 'esekey9_eseData';

        // Document root - production
        $DOCUMENT_ROOT = '/home/esekey9/public_html';

        // Server Name - production
          $servername = 'securesslhost.net/~esekey9';
    }
}
// Sub Session User type for this directory
$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin

// Username for database identification
$_SESSION[$ss]['username'] = 'guest';

// company id for this directory
$_SESSION[$ss]['company_id'] = '00008';

?>