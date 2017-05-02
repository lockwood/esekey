<?php
// +----------------------------------------------------------------------+
// | ADMIN_NEW_BOOKING  - Admin Console - Make a Booking                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_new_booking.php,v 1.02 2005/01/21
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

// set mode (test or prod) 
$_test = $_SESSION[$ss]['_test'];
include('getdata.php');
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_validation.php');

?>
<html>
<head>
<title>Availability</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

function GoAdd() {

	window.location = 'admin_new_booking.php?conditions=Accept&sid=<?=$sid?>';

}

function RefreshAvailability() {

	top.Workarea.Workarea1.document.execCommand("Refresh");

}

//JavaScript Edit Validation Code

//-->
</script>

</head>
<?php
if (isset($_SESSION[$ss]['booking_reference'])) {     // booking made - refresh availability
    ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="RefreshAvailability()">
    <?php
} else { 
    ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
    <?php
} 
?>
<!-- Set Workarea -->
<div class="workarea">
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="midcol" height="100%"><p class=maintext>
    <?php
    // include the main content of the page	//if ($_SESSION[$ss]['company_code'] == 'troppo') {	//	$_GET['pgt'] = 1;	//}
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
    ?>
    </td>
  </tr>
</table>
</div>

</body>
</html>