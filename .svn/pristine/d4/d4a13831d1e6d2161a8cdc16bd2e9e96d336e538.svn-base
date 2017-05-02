<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 11 Pebble Villa  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 11/page.php,v 1.01 2008/03/18
//

$custom_page = 1; // set flag to 1 - this custom page formatter is used for Company 7 - RJS Lettings.
// Differences from generic page.php: 
//   Different meta tags for Company 7
// No logo
// No section level menu as all pages are in section 1.
// Section id not passed in url as all pages are in section 1. 
if (!isset($mainheight)) {
    $mainheight = 42;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML lang=en><HEAD><TITLE>Pebble Villa: Weymouth b&b for business and leisure Bed and Breakfast</TITLE>
<META content="Select peaceful b&amp;b in Weymouth for discerning adults overlooking the bay. Ideal for motorists joining the Condor Ferry. Online booking" name=description>
<META http-equiv=Content-Type content="text/html; charset=us-ascii">
<META content="b&amp;b Weymouth Dorset, Weymouth bed and breakfast, b&amp;b in Weymouth, bed breakfast in Weymouth, Preston Dorset, luxury weekend breaks" name=keywords>
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title>Pebble Villa</title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="0" height="10%">
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
  <tr>
    <td colspan="4" nowrap class="headtext" align="center"><img src="beach.gif"/><img src="logo.jpg" />
    <?php 
    foreach ($menuarray as $menurow) {
      if ($menurow[page_id] == $page_id) { ?>
          <?=$menurow[page_name]?><?php
      }
    } ?>
    </td>
    <td nowrap class="contact"><br><br><b>Tel: <?=$_SESSION[$ss]['company_telephone']?><br>email:</b>&nbsp;<a href="mailto:<?=$_SESSION[$ss]['company_email']?>"><?=$_SESSION[$ss]['company_email']?></a></td>
  </tr>
  <tr>
    <td class="righthead"></td>
    <td colspan="5"></td>
  </tr>
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="top"></td>  
    <td class="midhead"><table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
    <tr><td class="leftcol" height="100%">&nbsp;</td></tr></table></td>
    <td class="midhead" colspan="3" height="100%"><table border="0" width="100%" cellspacing="0" cellpadding="5" height="100%">
    <tr><td class="midcol" height="100%"> 
    <p class=maintext>
    <?php
    // include the main content of the page
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');
    ?>
    </td></tr></table></td>
  </tr>
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="4" nowrap>&nbsp;&copy; <?=$copyright_year?> Pebble Villa, Weymouth, UK<img src="counter.php?p=<?=$page_id?>"></td>
    <td class="rightfoot" style="text-align: right"><a style="color: #333366" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
  </tr>
</table>
</body>
</html>
