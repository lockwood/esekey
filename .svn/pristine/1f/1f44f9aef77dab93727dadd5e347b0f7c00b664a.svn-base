<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 6                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 6/page.php,v 1.00 2005/01/20
//

$custom_page = true; // set flag to true - tells standard page formatter not to run
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title>Mapledurham Estate - <?=$title?> <?=$page_name?></title>
</head>
<BODY vLink=#ffff66 aLink=#ffff66 link=#ffff66 bgColor=#ffffff leftMargin=0 
topMargin=0>
<DIV align=center>
<CENTER>
<TABLE cellSpacing=0 cellPadding=0 width=90% border=0>
  <TBODY>
  <TR>
    <TD bgColor=#003300 align=right colspan="3">
      <P align=right><FONT face=Tahoma color=#ffff66 size=2>[&nbsp;<A 
      href="p<?=$intro_page[0]?>.php"><?=$descr[0]?></a>&nbsp;|&nbsp;<A 
      href="p<?=$intro_page[1]?>.php"><?=$descr[1]?></a>&nbsp;|&nbsp;<A 
      href="p<?=$intro_page[2]?>.php"><?=$descr[2]?></a>&nbsp;|&nbsp;<A 
      href="p<?=$intro_page[3]?>.php"><?=$descr[3]?></a>&nbsp;|&nbsp;<A 
      href="p<?=$intro_page[4]?>.php"><?=$descr[4]?></a>&nbsp;|&nbsp;<A
      href="p<?=$intro_page[5]?>.php"><?=$descr[5]?></a>&nbsp;]</FONT></P></TD></TR>
  <TR>
    <TD vAlign=middle width="100%" bgColor=#003300 colSpan=2 height=55>
      <P align=center><IMG height=40 src="maple.gif" width=492 border=0></P></TD></TR>
  <TR cellpadding=5>
    <TD vAlign=top width="280" style="width: 280px;" bgColor=#003300>
      <TABLE cellSpacing=10 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD width="100%">
            <?php
            if ($elementarray[0]['resource_id'] > 0) { // Show list of cottages as heading ?>
                <form action="index.php" name="frmAvail" id="frmAvail" method="get">
                <SELECT NAME="p" onChange="submit();">
                  <OPTION VALUE="8" SELECTED>Yew Tree Cottage</OPTION> 
                  <OPTION VALUE="10">Thatch Cottage</OPTION> 
                </SELECT>
                </form><?php
            }
            foreach($elementarray as $elementrow) {
                if ($elementrow[element_type] == 'headpic') { ?>
            <P align=center><?php
                    if ($elementrow[image_name] !=null) {?>
            <IMG src="<?=$elementrow[image_name]?>"></p>
            <?php 
                    }
                    if ($elementrow[text] !=null) {
                        if ($elementrow[text] != '#cottages#') { ?>
            <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
                        } else { // list cottages ?>
            <div align="center">
              <center>
              <table border="0" width="95%" cellpadding="0">
                <tr>
                  <td width="70%" align="center"><b><font face="Tahoma" size="1" color="#FFFF66"><u>Cottage Name</u></font></b></td>
                  <td width="30%" align="center"><b><font face="Tahoma" size="1" color="#FFFF66"><u>Sleeps</u></font></b></td>
                </tr>
                <tr>
                  <td width="70%" align="center"><font face="Tahoma" size="1" color="#FFFF66">&nbsp;&nbsp;&nbsp;</font></td>
                  <td width="30%" align="center"><font face="Tahoma" size="1" color="#FFFF66">&nbsp;&nbsp;&nbsp;</font></td>
                </tr><?php
                            $showprop = 0;
                            foreach ($propertyarray as $propertyrow) { 
                                if ($propertyrow['property_id'] != $showprop) {
                                    $showprop = $propertyrow['property_id']; ?>
                <tr>
                  <td width="70%" align="center"><font face="Tahoma" color="#FFFF66" size="2"><a href="p<?=$propertyrow[page_id]?>.php"><?=$propertyrow[name]?></a></font></td>
                  <td width="30%" align="center"><font face="Tahoma" color="#FFFF66" size="2"><?=$propertyrow[price_code]?></font></td>
                </tr>
                  <?php
                                }
                            } ?>
              </table>
              </center>
            </div><?php
                        }
                    }?>
            </P><?php
                }
            } ?> 
    </TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top width="70%">
      <TABLE cellSpacing=10 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD width="100%">
            <P align=justify>
            <?php
            // include the main content of the page
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');
            ?>
            </P><img src="counter.php?p=<?=$page_id?>"></TD></TR></TBODY></TABLE></TD></TR>
  <TR height=50>
    <TD width=263 bgColor=#003300>
      <P align=center><IMG height=13 
      src="footer1.gif" 
      width=196 border=0></P></TD>
    <TD width=333 bgColor=#003300>
      <P align=center><A href="http://www.esekey.com/"><FONT face=Tahoma color=#ffff66 size=2>Powered by Esekey&trade;</FONT></A></P></TD></TR></TBODY></TABLE></CENTER></DIV></BODY></HTML>
