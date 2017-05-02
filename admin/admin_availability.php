<?php
// +----------------------------------------------------------------------+
// | ADMIN_AVAILABILITY  - Admin Console - View Availability              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_availability.php,v 1.02 2005/04/12
//
//ini_set('memory_limit', '-1');
//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');

if (isset($_GET['property'])) {
	$selected_id = $_GET['property'];
	$property_selected = true;
}
if (isset($_GET['from'])) {
	$back = -1;
} else
{
	$back = (isset($_GET['back']) ? $_GET['back'] : 0) - 1;
}

?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title>Availability</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;
window.onresize = ScaleTable;
//-->
</script>

</head>
<?php
if ($_SESSION[$ss]['company_id'] == 9) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="setScrollSync();ScaleTable();">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} ?>	
<!-- Set Workarea -->
<div class="workarea">
<?php
// set session mode (test or prod)
$_test = $_SESSION[$ss]['_test'];
include('getdata.php');
if ($_SESSION[$ss]['company_id'] == 4) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} elseif ($_SESSION[$ss]['company_id'] == 6) {
        include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} elseif ($_SESSION[$ss]['company_id'] == 9) {
        include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} else {
        include('availability_daily.php');
}

if ($_SESSION[$ss]['company_id'] != 9) { ?>

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>&nbsp;
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">
			</td>
		</tr>
	</table>
<?php
}
// echo memory_get_usage(true);
?>		

</div>

</body>
</html>