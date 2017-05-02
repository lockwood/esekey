<?php
// +----------------------------------------------------------------------+
// | ADMIN_GUEST_REVIEWS  - Admin Console - Guest Reviews                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2013 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_guest_reviews.php,v 1.00 2013/03/01
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
	$back = $_GET['back'] - 1;
}
if (isset($_POST) && count($_POST) > 0) {
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_review_validate.php');
	if (isset($_SESSION[$ss]['thanks'])) {
		// guest review successfully added - redirect to review page....
		header("Location: ".$_SERVER['PHP_SELF']."?sid=".$sid);
		exit;
	}
}

?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title>Availability</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<link href='scroll.css' type='text/css' rel='stylesheet' />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type='text/javascript' src='js/jquery.scrollTo-min.js'></script>
<script type='text/javascript' src='js/jquery.serialScroll-min.js'></script>
<script type='text/javascript' src='js/init.js'></script>
<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;
window.onresize = ScaleTable;
$(function() {
$( "#arrival_date" ).datepicker({ dateFormat: "dd/mm/yy" });
});
//-->
</script>

</head>
<?php
if ($_SESSION[$ss]['company_id'] == 9) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="setScrollSync();ScaleTable();">
<?php
} else { ?>
<body style="background-image: url(images/background2.jpg);" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<?php
} ?>	
<!-- Set Workarea -->
<div class="workarea">
<table style="background-image: url(images/background2.jpg);"><tr><td>
<?php
// set session mode (test or prod)
$_test = $_SESSION[$ss]['_test'];
include('getdata.php');
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_reviews.php');
?>
</td><td>
<?php
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_review_form.php');
?>
</td>
</tr></table>

</div>

</body>
</html>