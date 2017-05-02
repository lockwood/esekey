<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 8 All My Bookings|
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 8/page.php,v 1.01 2006/01/17
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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="All My Bookings : Introduction ">
<meta name="status" content="final">
<meta name="keywords" content="Windsor, Dorney, Lake, Rowing, Eton, College, Legoland, Cottages, Availability, Accommodation, Self-catering, Wisteria, Gardener, Bothy, Smithy, quality, discerning, comfort, luxury">
<meta name="abstract" content="All My Bookings.">
<meta name="description" content="All My Bookings provide online availability and secure booking services for small self catering businesses">
<meta name="security" content="Public">
<meta name="charset" content="ISO-8859-1">
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=html_entity_decode($title, ENT_QUOTES).$_test?></title>
</head>
<body>
<div style="z-index: 1; position: absolute; left: 10px; top: 20px; height: 60px;">
<img src="collage.jpg" alt="All My Bookings&trade;">
</div>
<div class="headtext" style="z-index: 1; position: absolute; left: 260px; top: 55px;">
All&nbsp;My&nbsp;Bookings<?=$_test?>&trade;
</div>
<div class="headtext2" style="z-index: 1; position: absolute; left: 554px; top: 55px;">
.co.uk
</div>
<table border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="midline"></td>
    <td class="midline" width="100%"></td>
    <td class="midline"></td>
    <td class="midline"></td>
  </tr>
  <tr>
    <td class="midfill" colspan="4"></td>
  </tr>
  <tr>
    <td colspan="3" class="headimg" nowrap></td>
    <td nowrap class="contact"><b>Tel <?=$_SESSION[$ss]['company_telephone']?><br>email:</b>&nbsp;<a href="mailto:info@esekey.com">info@esekey.com</a></td>
  </tr>
  <tr>
    <td class="midline" colspan="4"></td>
  </tr>
  <tr>
    <td class="leftcol" style="vertical-align: top;" rowspan="2">
      <table border="0" cellspacing="0" cellpadding="0">
    <?php 
    foreach ($menuarray as $menurow) {
      if ($menurow[page_id] == $page_id) { ?>
          <tr><td class="currmenu" height="24" nowrap><?=$menurow[page_name]?>&nbsp;</td></tr><?php
      } else { ?>
          <tr><td class="leftcol" height="24" nowrap>
          <a href="<?=$menurow[page_url].'">'.$menurow[page_name]?></a>&nbsp;</td></tr><?php
      }
    } ?>
      </table>
    </td>
    <td class="midcol" colspan="3" height="100%"><table border="0" width="100%" cellspacing="0" cellpadding="3" style="height:100%">
    <tr><td class="midcol" height="100%"> 
    <p class=maintext>
    <?php
    // include the main content of the page
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');
    ?>
    </td></tr></table></td>
  </tr>
  <tr>
    <td class="midcol" colspan="3" height="50%"></td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="2" nowrap>&nbsp;&copy; <?=$copyright_year?> All My Bookings, UK<img src="counter.php?p=<?=$page_id?>" alt="Counter"></td>
    <td class="rightfoot" colspan="2" style="text-align: right"><a style="color: white" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
  </tr>
</table>
</body>
</html>
