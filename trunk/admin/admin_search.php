<?php
// +----------------------------------------------------------------------+
// | ADMIN_SEARCH  - Admin Console - Search Availability                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_search.php,v 1.00 2006/12/17
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

?>
<html>
<head>
<title>Availability</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;

//-->
</script>
	<!-- calendar stylesheet -->
        <link rel="stylesheet" type="text/css" media="all" href="theme/calendar-win2k-1.css" title="win2k-1" />

	<!-- main calendar program -->
        <script type="text/javascript" src="js/calendar.js"></script>

        <!-- language for the calendar -->
        <script type="text/javascript" src="js/calendar-en.js"></script>
	       

        <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
        <script type="text/javascript" src="js/calendar-setup.js"></script>

</head>
<?php
if (isset($_GET['enquiry_reference']) || $_SESSION[$ss]['enquiry_reference'] > 0) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="SetTopHead2('')">
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
} else {
    if ($_SESSION[$ss]['company_id'] == 6) {
        include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
    } else {
        include('availability_search.php');
    }
}
?>

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
		

</div>

</body>
</html>