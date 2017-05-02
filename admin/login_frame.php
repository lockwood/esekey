<?php
// +----------------------------------------------------------------------+
// | LOGIN_FRAME  - Esekey Admin Console Login Frameset                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/login_frame.php,v 1.00 2003/10/01
//
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<title>Esekey Administration Console</title>
</head>

<frameset rows="75,*" framespacing="1" frameborder="1">
	<frame src="top_login.html" name="Top" id="Top" scrolling="No" noresize marginwidth="0" marginheight="0">
	<frameset cols="212,*" framespacing="1" frameborder="1">
    <frame src="login.php" name="Menu" id="Menu" scrolling="No" marginwidth="0" marginheight="0">
    <frame src="info.html" name="Workarea" id="Workarea" scrolling="Auto" marginwidth="10" marginheight="15">
	</frameset>
</frameset>

</html>
