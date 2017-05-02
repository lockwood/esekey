<?php

// +----------------------------------------------------------------------+

// | Properties - initialisation of EseSite runtime driver - Company 4    |

// +----------------------------------------------------------------------+

// | Copyright (c) 2003-2005 Esekey Limited                               |

// +----------------------------------------------------------------------+

// | Author:  Dave Lockwood <dave@esekey.com>                             |

// +----------------------------------------------------------------------+

//

// $Id: 4/properties.php,v 1.02 2005/05/06

//



// $_test = '_test';



if ($_SERVER['SERVER_NAME'] == 'www.sheephousedave.co.uk') { // test environment variables

    // Environment - test

    $env = 'test';

    // $_test = '_test';



    // Database User - test

    $db_user = 'root';

    $db_name = 'eseData';



    // Document root - test

    $DOCUMENT_ROOT = 'c:/wamp64/www/esekey';



    // Server Name - test

    $servername = 'http://'.$_SERVER['SERVER_NAME'];



} else { // production environment variables

    // Environment - production



    $env = 'prod';




    // Database User - production

    $db_user = 'esekey9_dlockwoo';

    $db_name = 'esekey9_eseData';



    // Document root - production

    $DOCUMENT_ROOT = '/home/esekey9/public_html';



    // Server Name - production

    $servername = 'phi.securesslhost.net/~esekey9';

}

// Sub Session User type for this directory

$ss = 'User'; // sub-session type is User - avoid session data conflict with type Admin



// Username for database identification

$_SESSION[$ss]['username'] = 'guest';



// company id for this directory

$_SESSION[$ss]['company_id'] = '00004';



?>