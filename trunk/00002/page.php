<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 2                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 2/page.php,v 1.01 2006/01/17
//

$custom_page = true; // set flag to true - tells standard page formatter not to run
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="National Lodges : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Holiday, Lodges, Online, Booking, Availability, Accommodation, Self-catering, beach, farm, family, quality, discerning, comfort, luxury, tourist, board, "/>
<meta name="abstract" content="National Lodges."/>
<meta name="description" content="National Lodges provide quality accommodation for the discerning holidaymaker"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="<?=$sect[0]?>" colspan="2"><a style="color: black" 
    href="index.php?s=1&p=<?=$intropage[0]?>"><?=$descr[0]?></a></td>

    <td class="<?=$sect[1]?>"><a style="color: black" 
    href="index.php?s=2&p=<?=$intropage[1]?>"><?=$descr[1]?></a></td>

    <td class="<?=$sect[2]?>"><a style="color: black" 
    href="index.php?s=3&p=<?=$intropage[2]?>"><?=$descr[2]?></a></td>

    <td class="<?=$sect[3]?>" colspan="2"><a style="color: black" 
    href="index.php?s=4&p=<?=$intropage[3]?>"><?=$descr[3]?></a></td>
  </tr>
  <tr>
    <td colspan="6" height="45" nowrap class=headtext align="left"><B><I><?=$_SESSION['company_name']?></I></B></td>
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
    <?php foreach ($menuarray as $menurow) { ?>
        <hr width="80%"><?php
        if ($menurow[page_id] == $page_id) { ?>
            <b style="color: white"><?=$menurow[page_name]?></b><br><?php
        } else { ?>
            <a 
            href="index.php?s=<?=$section_id.'&p='.$menurow[page_id].'">'.$menurow[page_name]?>
          </a><br><?php
        }
    } ?>
    <hr width="80%">
    <img border="0" src="tourismbadge.jpg" alt="English Tourism Council">
    </td>
    <td class="midcol" colspan="4"><br><p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');  
    ?>
    </td>
    <td class="rightcol"><br>
    <?php
    if (count($propertyarray) > 0) { ?>
        <b>Our lodges...</b><br>
        <br>
        <?php
        foreach ($propertyarray as $propertyrow) { ?>
            <a href="index.php?s=2&p=<?=$propertyrow[page_id]?>"> 
            <img border="0" alt="<?=$propertyrow[name]?>" 
            src="<?='thumbnail'.$propertyrow[property_id]?>.jpg"
            height="50" width="75"> </a><br><br>
        <?php
        }
    } ?>
  </tr>
  <tr>
    <td class="leftcol"/>
    <td class="midcol" colspan="4"/>
    <td class="rightcol" valign="bottom"><a href="http://<?=$_SERVER['SERVER_NAME']?>">About Esekey Limited</a></td>
  </tr>

  <tr>
    <td class="rightfoot" colspan="6">&nbsp;&copy; Copyright <?=$copyright_year?> Esekey Limited, UK.</td>
  </tr>
</table>
</body>
</html>
