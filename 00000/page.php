<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 0                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 0/page.php,v 1.01 2006/01/17
//

$custom_page = 1; // set flag to 1 - this custom page formatter is used for Company 0.
// Differences from generic page.php: 
//   Different meta tags for Company 0 
//   Doesn't display any property links as Company 0 has no properties
//   Doesn't display ETC badge
//   Displays other logos
//   Only displays left column menu if there is more than one menu item
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="Esekey Limited : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Web, web-based, Development, Consulting, Online, Booking, Software, Service, Availability, quality, discerning"/>
<meta name="abstract" content="Online Holiday Property Management Service."/>
<meta name="description" content="Esekey Limited provide quality web-based management services for holiday property owners and agents"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="<?=$sect[0]?>" colspan="2"><a style="color: black" 
    href="<?=$intro_url[0]?>"><?=$descr[0]?></a></td>

    <td class="<?=$sect[1]?>"><a style="color: black" 
    href="<?=$intro_url[1]?>"><?=$descr[1]?></a></td>

    <td class="<?=$sect[2]?>"><a style="color: black" 
    href="<?=$intro_url[2]?>"><?=$descr[2]?></a></td>

    <td class="<?=$sect[3]?>" colspan="2"><a style="color: black" 
    href="<?=$intro_url[3]?>"><?=$descr[3]?></a></td>
  </tr>
  <tr>
    <td colspan="4" height="50" nowrap align="left" valign="middle">
      <a href="index.html">
      <img border="0" alt="Esekey Limited" src="esekey_logo.jpg" align="absmiddle">
      </a>
    </td>
    <td align="right">
      <img border="0" alt="Supporting UK Online for Business" src="ukonline.gif" align="absmiddle">
    </td>
    <td align="center">
      <img border="0" alt="Supporting Tourism In Britain" src="britain.gif" align="absmiddle">
    </td>
  </tr>
  <tr>
    <td class="lefthead" nowrap><br>
    <?=strtolower($description)?>&nbsp;</td>
    <td class="midhead" colspan="4"><br>
    &nbsp;<?=strtolower($page_name)?> 
    </td>
    <td class="righthead"><br>
    &nbsp;</td>
  </tr>
  <tr>
    <td class="leftcol" height="100%">
    <?php
      if (count($menuarray) > 1) {   
        foreach ($menuarray as $menurow) { ?>
        <hr width="80%"><?php
        if ($menurow[page_id] == $page_id) { ?>
            <b style="color: white"><?=$menurow[page_name]?></b><br><?php
        } else { ?>
            <a href="<?=$menurow[page_url].'">'.$menurow[page_name]?></a><br><?php
        }
      } ?>
    <hr width="80%"><?php
    } ?>
    </td>
    <td class="midcol" colspan="4">
    <p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');  
    //display session parameters //
    //foreach ($_SESSION as $key => $value) {
    //    echo 'Key: '.$key.' Value: '.$value.'<br>';
    //}
    ?>
    </td>
    <td class="rightcol"><br>
      <a href="http://www.instantssl.com" target="zz">
      <img src="horz_master_100pixels.gif" alt="SSL Certificate Authority" width="100" height="60" style="border: 0px;">
      </a>
      <br><br>
      <a href="http://www.php.net" target="zz">
      <img border="0" alt="Powered by PHP" src="pb_php.gif">
      </a>
    </td>
  </tr>
  <tr>
    <td class="leftcol"/>
    <td class="midcol" colspan="4"/>
    <td class="rightcol" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="6">&nbsp;&copy; Copyright <?=$copyright_year?> Esekey Limited, UK.</td>
  </tr>
</table>
</body>
</html>

