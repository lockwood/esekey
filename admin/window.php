<?php
// +----------------------------------------------------------------------+
// | WINDOW  - Esekey Admin Console resize Login Page                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/window.php,v 1.00 2004/10/15
//

//get active session
session_start();

// Set environment variables
require('properties.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Esekey Administration Console</title>

<link href="theme/menu.css" rel="stylesheet" type="text/css">

<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

var objAdmin;

function OpenWindow(serverName) {

            var targetUrl = serverName + '/admin/login_frame.php';

		objAdmin = window.open(targetUrl, 'Admin', 'resizable=yes,scrollbars=yes,status=yes,toolbar=no');

		if ((screen.width <= 1024) && (screen.height <= 768)) {
			objAdmin.moveTo(0,0);
			objAdmin.resizeTo(screen.availWidth,screen.availHeight);
			objAdmin.focus();
		} else {
			objAdmin.resizeTo(1024,740);			
			objAdmin.moveTo( (screen.availWidth - 1024) / 2 , (screen.availHeight - 740) / 2 );
			objAdmin.focus();
	}

}	

//-->
</script>


</head>

<body onLoad=OpenWindow('<?=$servername?>');>

</body>
</html>

