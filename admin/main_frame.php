<?php
// +----------------------------------------------------------------------+
// | MAIN_FRAME  - Esekey Admin Console Main Frameset                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/main_frame.php,v 1.01 2005/02/03
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
?>
<html>
<head>
	<title>Esekey Administration Console</title>
</head>

<body>
	<iframe src="top_nav.php" name="Top" id="Top" width="100%" height="80px"></iframe>
    <iframe src="menu.php" name="Menu" id="Menu" scrolling="Yes" width="15%" height="550px"></iframe>
    <iframe src="status.php?sid=<?=$_COOKIE['PHPSESSID']?>" name="Workarea" id="Workarea" scrolling="Yes" width="80%" height="550px"></iframe>
</body>

</html>
