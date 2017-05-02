<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 5                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 5/page.php,v 1.00 2005/01/11
//

$custom_page = true; // set flag to true - tells standard page formatter not to run
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title.' - '.$page_name?></title>
</head>
<BODY marginwidth="0" marginheight="0"><!-- OUTER TABLE TO HOLD FOOTER AND CREDITS AT THE BOTTOM -->
<DIV align=center>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="96%" border=0>
  <TR vAlign=top>
    <TD vAlign=top align=middle><!-- INNER TABLE TO HOLD PAGE CONTENT -->
      <DIV align=center>
      <TABLE cellSpacing=0 cellPadding=0 border=0><!-- HEIGHT SPACE TO BUTTONS AND LOGO -->
        <TBODY>
        <TR>
          <TD colSpan=3><IMG height=8 alt="" 
            src="1x1trans.gif" 
            width=1 border=0></TD></TR><!-- BUTTONS AND LOGO ROW -->
        <TR>
          <TD vAlign=top align=left colSpan=3>
            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD width=14><IMG height=1 alt="" 
                  src="1x1trans.gif" 
                  width=14 border=0></TD>
                <TD vAlign=top align=left>
                        <P class="topmenu"><A 
                        href="p<?=$intro_page[1]?>.php"><?=$descr[1]?></a>&nbsp;|&nbsp;<A 
                        href="p<?=$intro_page[2]?>.php"><?=$descr[2]?></a>&nbsp;|&nbsp;<A 
                        href="p<?=$intro_page[3]?>.php"><?=$descr[3]?></a>&nbsp;|&nbsp;<A 
                        href="p<?=$intro_page[4]?>.php"><?=$descr[4]?></a>&nbsp;|&nbsp;<A
                        href="p<?=$intro_page[5]?>.php"><?=$descr[5]?></a></P></TD>
                <TD width="100%"><IMG height=1 alt="" 
                  src="1x1trans.gif" 
                  width=1 border=0></TD>
                <TD vAlign=top align=right><A 
                  href="index.html"><IMG height=29 
                  alt="Home Page" 
                  src="vivatlogo_small.gif" 
                  width=177 border=0></A></TD></TR></TBODY></TABLE></TD></TR><!-- BUTTONS AND LOGO ROW --><!-- HEIGHT SPACE TO BUTTONS AND LOGO -->
        <TR>
          <TD colSpan=3><IMG height=2 alt="" 
            src="1x1trans.gif" width=1 
            border=0></TD></TR><!-- CONTENT ROW -->
        <TR>
          <TD vAlign=top align=left colSpan=3><!-- TABLE HOLDS THE THREE CONTENT COLUMNS -->
            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR><!-- LEFTHAND COLUMN -->
                <TD vAlign=top align=left>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><!-- WIDTH SPACERS -->
                    <TBODY>
                    <TR>
                      <TD width=14><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=14 border=0></TD>
                      <TD width="100%"><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD>
                      <TD width=14><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=14 border=0></TD></TR><!-- HEADLINES ROW -->
                    <TR class="s<?=$section_id?>gencolor"><!-- COLORED ROW HEIGHT SPACER -->
                      <TD><IMG height=110 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD><!-- ON PAIN OF DEATH, NO MORE THAN ONE LINE PLUS FOUR LINES IN THESE CELLS!!! -->
                      <TD vAlign=top align=left>
                        <TABLE height=110 cellSpacing=0 cellPadding=0 
                        width="100%" border=0>
                          <TBODY>
                          <TR>
                            <TD vAlign=top align=left>
                              <P class="s<?=$section_id?>head"><?=$title?></P></TD></TR>
                          <TR>
                            <TD vAlign=bottom align=left>
                              <P class="s<?=$section_id?>pagehead"><?=html_entity_decode($elementarray[3][text], ENT_QUOTES)?></P></TD></TR>
                          <TR>
                            <TD><IMG height=4 alt="" 
                              src="1x1trans.gif" 
                              width=1 border=0></TD></TR></TBODY></TABLE></TD>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD></TR><!-- SPACE TO TEXT -->
                    <TR>
                      <TD colSpan=3><IMG height=16 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD></TR>
                    <TR>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD>
                      <TD vAlign=top align=left>
                        <P class="basictext">
                        <P class="basictext">
                      <?php
                      // include the main content of the page
                      include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');  
                      ?>
                        <P></P></TD>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD></TR><!-- STRETCHY TEXT -->
                    <TR>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD>
                      <TD>
                        <P class="basictext"><FONT size=+3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</FONT></P></TD>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD></TR></TBODY></TABLE></TD><!-- END LEFTHAND COLUMN --><!-- MIDDLE COLUMN -->
                <TD vAlign=top align=right width=180>
                  <TABLE cellSpacing=0 cellPadding=0 border=0><!-- WIDTH SPACERS -->
                    <TBODY>
                    <TR>
                      <TD><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=180 border=0></TD></TR><!-- PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1  PIC 1 -->
                    <TR>
                      <TD><A 
                        onclick="MyWindow2=window.open('../pix/photos/trust/picaa.jpg','Vivat','toolbar=no,location=no,directories=no,height=380,width=500,status=no,menubar=no,scrollbars=yes,resizable=yes');" 
                        href="http://www.vivat.org.uk/trust/trust.cfm?chunkID=intro&amp;ArtNoID=non&amp;rowc=non#"><IMG 
                        height=110 alt="Click for larger image" 
                        src="<?=$elementarray[0]['image_name']?>" 
                        width=180 border=0></A></TD></TR><!-- SPACE TO LINKS -->
                    <TR>
                      <TD><IMG height=16 alt="" 
                        src="1x1trans.gif" 
                        width=1 border=0></TD></TR><!-- LINKS PANEL -->
                    <TR>
                      <TD><!-- TABLE HOLDING LINKS PANEL -->
                        <TABLE cellSpacing=0 cellPadding=3 width=180 border=0><!-- PANEL HEADLINE 1 -->
                          <TBODY>
                          <TR class="s<?=$section_id?>gencolor">
                            <TD vAlign=center align=left>
                              <?php
                              if ($section_id == 3) { // properties section - different layout/headings
                                  if ($menu_sequence == 1) { // properties introduction page ?> 
                              <P class="s<?=$section_id?>tablehead">KEY</P></TD></TR><!-- PANEL 1 CONTENT -->
                          <TR>
                            <TD vAlign=center align=left>
                              <P class="tablecontent"><ol class="key"> 
                              <?php
                                      $showprop = 0;
                                      foreach ($propertyarray as $propertyrow) { 
                                          if ($propertyrow['property_id'] != $showprop) {
                                              $showprop = $propertyrow['property_id']; ?>
                              <li><a href="p<?=$propertyrow[page_id]?>.php"><?=$propertyrow['property_name']?></a></li>
                              <?php
                                          }
                                      } ?>
                              </ol></P>
                              <?php
                                  } else { // property detail page ?>
                              <P class="s<?=$section_id?>tablehead">Property Information</P></TD></TR><!-- PANEL 1 CONTENT -->
                          <TR>
                            <TD vAlign=center align=left>
                              <P class="tablecontent"> 
                              <?php
                                      $currprop = $elementarray[0][resource_id];
                                      foreach ($propertyarray as $propertyrow) { 
                                          if ($propertyrow[property_id] == $currprop) { ?>
                              <a href="p<?=$propertyrow['page_id']?>.php"><img height=14 alt="" src="bullet_pink.gif" 
                              width=14 border=0><?=$propertyrow['page_name']?></a><br>
                              <?php
                                          }
                                      } ?>
				</p>
				</td>
				</tr>

				<!-- SPACE -->
				<tr><td><img src="../pix/general/1x1trans.gif" width="1" height="2" border="0" alt=""></td></tr>

				<!-- PANEL HEADLINE 2 -->
				<tr class="s<?=$section_id?>gencolor">
				<td align="left" valign="center">
                          <p class="s<?=$section_id?>tablehead">SELECT ANOTHER PROPERTY</p></td>
				</tr>

				<!-- PANEL 2 CONTENT -->
			
				<tr>
				<td align="left" valign="center">
				<form name="frm" action="index.php" method="get">
				<select name="p" onChange="submit();">
				<option value="0">Please Select...</option>
				
                              <?php
                                      $showprop = 0;
                                      foreach ($propertyarray as $propertyrow) { 
                                          if ($propertyrow['property_id'] != $showprop) {
                                              $showprop = $propertyrow['property_id']; ?>
                        <option value="<?=$propertyrow['page_id']?>"><?=$propertyrow['property_name']?></option>
                              <?php
                                          }
                                      } ?>
				</select>
				</form>
                              <?php
                                  }
                              } else { // not a property page ?>
                              <P class="s<?=$section_id?>tablehead">Further Information</P></TD></TR><!-- PANEL 1 CONTENT -->
                          <TR>
                            <TD vAlign=center align=left>
                              <P class="tablecontent"> 
                              <?php
                                  foreach ($menuarray as $menurow) { ?>
                              <a href="p<?=$menurow['page_id']?>.php"><img height=14 alt="" src="bullet_blue.gif" 
                              width=14 border=0><?=$menurow['page_name']?></a><br>
                              <?php
                                  } ?>
                              </P><?php
                              } ?>
                              </TD></TR></TBODY></TABLE><!-- END TABLE HOLDING LINKS PANEL --></TD></TR></TABLE></TD><!-- END MIDDLE COLUMN --><!-- RIGHTHAND COLUMN -->
                <TD vAlign=top align=right width=180>
                  <TABLE cellSpacing=0 cellPadding=0 border=0><!-- WIDTH SPACERS -->
                    <TBODY>
                    <TR>
                      <TD width=180><IMG height=1 alt="" 
                        src="1x1trans.gif" 
                        width=180 border=0></TD></TR><!-- PICS 2 and 3 PICS 2 and 3PICS 2 and 3PICS 2 and 3PICS 2 and 3PICS 2 and 3PICS 2 and 3-->
                    <TR>
                      <TD><A 
                        onclick="MyWindow2=window.open('../pix/photos/trust/picbb.jpg','Vivat','toolbar=no,location=no,directories=no,height=380,width=500,status=no,menubar=no,scrollbars=yes,resizable=yes');" 
                        href="http://www.vivat.org.uk/trust/trust.cfm?chunkID=intro&amp;ArtNoID=non&amp;rowc=non#"><IMG 
                        height=302 alt="Click for larger image" 
                        src="<?=$elementarray[1]['image_name']?>" 
                        width=180 border=0></A><BR><A 
                        onclick="MyWindow2=window.open('../pix/photos/trust/piccc.jpg','Vivat','toolbar=no,location=no,directories=no,height=380,width=500,status=no,menubar=no,scrollbars=yes,resizable=yes');" 
                        href="http://www.vivat.org.uk/trust/trust.cfm?chunkID=intro&amp;ArtNoID=non&amp;rowc=non#"><IMG 
                        height=133 alt="Click for larger image" 
                        src="<?=$elementarray[2]['image_name']?>" 
                        width=180 border=0></A></TD></TR></TABLE></TD><!-- END RIGHTHAND COLUMN --></TR></TABLE><!-- END TABLE HOLDING THE THREE CONTENT COLUMNS --></TD></TR><!-- END CONTENT ROW --></TABLE></DIV><!-- END INNER TABLE TO HOLD PAGE CONTENT --></TD></TR><!-- CREDITS -->
  <TR>
    <TD vAlign=bottom align=left>
      <TABLE cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=14><IMG height=1 alt="" 
            src="1x1trans.gif" width=14 
            border=0></TD>
          <TD vAlign=bottom align=left>
            <P class="credits">Copyright Vivat Trust MMV. Website powered by <A 
            href="http://www.esekey.com/" target=_blank>Esekey Limited</A>. 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A 
            href="p34.php">Vivat 
            privacy policy</A> </P></TD></TR></TBODY></TABLE></TD></TR><!-- SPACE -->
  <TR>
    <TD><IMG height=4 alt="" 
      src="1x1trans.gif" width=1 
    border=0><img src="counter.php?p=<?=$page_id?>"></TD></TR></TBODY></TABLE></DIV><!-- END OUTER TABLE TO HOLD FOOTER AND CREDITS AT THE BOTTOM -->

</body>
</html>
