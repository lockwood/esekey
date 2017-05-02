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

<frameset rows="80,*" framespacing="1" frameborder="1">
	<frame src="top_nav.php" name="Top" id="Top" scrolling="No" noresize marginwidth="0" marginheight="0">
	<frameset cols="212,*" framespacing="1" frameborder="1">
    <frame src="menu.php" name="Menu" id="Menu" scrolling="Yes" marginwidth="0" marginheight="0">
    <frame src="status.php?sid=<?=$_REQUEST['PHPSESSID']?>" name="Workarea" id="Workarea" scrolling="Yes" marginwidth="10" marginheight="15">
	</frameset>
</frameset>

</html>
