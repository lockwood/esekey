<?php
// +----------------------------------------------------------------------+
// | ADMIN_BOOKING_FRAME  - Admin Console - Availability/New Booking      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_booking_frame.php,v 1.00 2003/10/01
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');
$property_parm = '';
if (isset($_GET['from']))
{
//	echo "Came here from ".$_GET['from'];
	$property_parm = '&property='.$_GET['pid']."&d=".$_GET['d']."&m=".$_GET['m']."&y=".$_GET['y']."&n=".$_GET['n'];
}
?>
<html>
<head>
	<title>Esekey Administration Console</title>
</head>

<frameset rows="230,*" framespacing="2" frameborder="1">
    <frame src="admin_availability.php?sid=<?=$sid?><?=$property_parm?>" name="Workarea1" id="Workarea1" scrolling="Yes" marginwidth="10" marginheight="15">
    <frame src="admin_new_booking.php?conditions=Accept&sid=<?=$sid?><?=$property_parm?>" name="Workarea2" id="Workarea2" scrolling="Yes" marginwidth="10" marginheight="15">
</frameset>

</html>
