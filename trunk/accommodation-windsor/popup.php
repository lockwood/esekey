<?php
// +----------------------------------------------------------------------+
// | POPUP  - layout of EseSite secure popup Company 8                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/popup.php,v 1.02 2004/11/15
//

$custom_popup = 1; // set flag to 1 - this custom page formatter is used for Company 3 - Troppo.
$property_selected = false;
$selected_id = 0;
if (isset($_GET['property'])) {
	$selected_id = $_GET['property'];
	$property_selected = true;
}

if (isset($_GET['fpc'])) {
	$property_selected = true;
}

if (isset($_GET['conditions']) && $_GET['conditions'] == 'Acptcl') {
	$property_selected = true;
}

if ($property_selected) {
	foreach ($resourcearray as $propertyrow) {
		if (isset($_GET['r'.$propertyrow['property_id']])) {
			$selected_id = $propertyrow['property_id'];
		}
		if ($propertyrow['property_id'] == $selected_id) {
			$title .= ' for '.$propertyrow['property_name'];
			$page_name .= ' for '.$propertyrow['property_name'];
		}
	}
}

if (isset($_GET['bk']) && $_GET['bk'] == 1) {
	$start_booking = true;
}else {
	$start_booking = false;
}
// Differences from generic popup.php: 
// Based on old page.php without lefthand menu column
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="All My Bookings : Secure Booking "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Booking, Availability, Self Catering, Web, On Line, Real Time, Accommodation, Self-catering, quality, discerning, comfort, luxury"/>
<meta name="abstract" content="Secure Booking."/>
<meta name="description" content="Book on line with security and peace of mind"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="bkgstyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="midhead" nowrap>&nbsp;<?=$page_name?> 
    </td>
    <td class="righthead" nowrap>
    <a href="javascript:window.opener=self; window.close();"><b>Close this window</b></a>&nbsp;</td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="midcol" colspan="2" height="100%"><p class=maintext>
    <?php
    // include the main content of the page
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');
    ?><img src="counter.php?p=<?=$page_id?>">
    </td>
  </tr>
</table>
</body>
</html>

