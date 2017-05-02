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
$ss = 'Admin'; // sub-session type is Admin - avoid session data conflict with type User

// Username for database identification - provided when user logs in
// company id for this directory - provided when user logs in
?>