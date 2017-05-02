<?php
// +----------------------------------------------------------------------+
// | POPUP  - layout of EseSite secure popup Company 4                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/popup.php,v 1.01 2006/01/30
//

$custom_popup = 1; // set flag to 1 - this custom page formatter is used for Company 4 - Sheephouse Manor.
// Differences from generic popup.php:  metatags
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="Sheephouse Manor : Secure Booking "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Windsor, Maidenhead, Legoland, Cottages, Availability, Accommodation, Self-catering, Cookham, Eton, Bray, quality, discerning, comfort, luxury, Self catering accommodation, Bed & Breakfast, holiday cottages, short stays, efficiency studio apartment with full kitchenette, Berkshire, London, Thames Path, Fat Duck"/>
<meta name="abstract" content="Sheephouse Manor."/>
<meta name="description" content="Make a secure reservation for luxury self-catering cottages at Sheephouse Manor"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body bgcolor="#FFFFFF" text="#000000" background="background2.jpg">
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="midhead">&nbsp;<?=$page_name?> 
    </td>
    <td class="righthead" nowrap>
    <a href="javascript:window.opener=self; window.close();"><b>Close this window</b></a>&nbsp;</td>
  </tr>
  <tr>
    <td class="midcol" colspan="2" height="100%"><p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');
    ?><img src="counter.php?p=<?=$page_id?>">
    </td>
  </tr>
</table>
</body>
</html>

