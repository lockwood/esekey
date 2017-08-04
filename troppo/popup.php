<?php
// +----------------------------------------------------------------------+
// | POPUP  - layout of EseSite secure popup Company 3                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/popup.php,v 1.02 2004/11/15
//

$custom_popup = 1; // set flag to 1 - this custom page formatter is used for Company 3 - Troppo.
// Differences from generic popup.php: 
// Based on oldplace page.php without lefthand menu column
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="The Old Place : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Windsor, Dorney, Lake, Rowing, Eton, College, Legoland, Cottages, Availability, Accommodation, Self-catering, Wisteria, Gardener, Bothy, Smithy, quality, discerning, comfort, luxury"/>
<meta name="abstract" content="The Old Place."/>
<meta name="description" content="The Old Place provides quality accommodation conveniently located for Windsor and Dorney Lake"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
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

