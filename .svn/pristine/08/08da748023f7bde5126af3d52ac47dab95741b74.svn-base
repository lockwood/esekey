<?php
// +----------------------------------------------------------------------+
// | POPUP  - layout of EseSite secure popup default Company              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/popup.php,v 1.01 2004/10/19
//

$custom_popup = null; // set flag to null - if custom popup formatter is found it will set this flag
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/popup.php'); // call custom popup formatter
if ($custom_popup != null) { //don't use this popup formatter, a custom one has been found and used
    return;
}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="REFRESH" content="65">
<meta name="title" content="Fictional Farm Holiday Cottages : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Holiday, Cottages, Online, Booking, Availability, Accommodation, Self-catering, beach, farm, family, quality, discerning, comfort, luxury, tourist, board, "/>
<meta name="abstract" content="Fictional Farm Holiday Cottages."/>
<meta name="description" content="Fictional Farm Holiday Cottages provide quality accommodation for the discerning holidaymaker"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>

<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="lefthead" nowrap><br>
    <?=strtolower($description)?>&nbsp;</td>
    <td class="midhead" nowrap><br>
    &nbsp;<?=strtolower($page_name)?> 
    </td>
    <td class="righthead" nowrap><br>
    <a href="javascript:window.opener=self; window.close();"><b>close this window</b></a>&nbsp;</td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="midcol" colspan="14"><br><p class=maintext>
    Current Selection:&nbsp;
    <?php
    if (isset($_SESSION[$ss]['booking_property_id'])) {
        echo $_SESSION[$ss]['booking_property_name'].'.<br>';
    } else {
        echo 'None selected.<br>';
    }
    echo 'Start Date:&nbsp;';
    if (isset($_SESSION[$ss]['display_date'])) {
        echo $_SESSION[$ss]['display_date'].'.<br>';
    } else {
        echo 'Not specified.<br>';
    }
    echo 'Duration:&nbsp;';
    if (isset($_SESSION[$ss]['booking_duration'])) {
        echo $_SESSION[$ss]['booking_duration'].' nights.<br>';
    } else {
        echo 'Not specified.<br>';
    }
    // uncomment to display session variables
    //foreach ($_SESSION as $key => $value) {
    //    echo 'Key: '.$key.', Value: '.$value.'.<br>';
    //}
    ?>
    <br>
    </td>
  </tr>
  <tr>
    <td></td>
    <td class="fill">&nbsp;</td>
  <?php foreach ($menuarray as $menurow) {
      if ($menurow[page_id] == $page_id) { ?>
          <td class="currstep" width="200"><?=$menurow[page_name]?><?php
      } elseif ($menurow[menu_sequence] == 1) { ?>
          <td class="compstep" width="200">
          <a 
          href="javascript:DoPopup('<?=$servername?>',5,<?=$menurow[page_id]?>,0,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
          <?=$menurow[page_name]?></a><?php
      } elseif ($menurow[menu_sequence] == 2)  {
          if (isset($_SESSION[$ss]['booking_date']) && ($_SESSION[$ss]['booking_date'] > '0')) {
              // only allow navigation to duration page if a booking exists..
              ?>
              <td class="compstep" width="200">
              <a 
              href="javascript:DoPopup('<?=$servername?>',5,<?=$menurow[page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');"><?=$menurow[page_name]?></a><?php
          } else { ?>
              <td class="otherstep" width="200"><?=$menurow[page_name]?><?php
          }
      } elseif ($menurow[menu_sequence] == 3)  {
          if (isset($_SESSION[$ss]['payment_method'])) {
              ?>
              <td class="compstep" width="200"><?php
          } else {
              ?>
              <td class="otherstep" width="200"><?php
          }
          if (isset($_SESSION[$ss]['booking_duration'])) {
              // only allow navigation to payment method page if a duration exists..
              ?>
              <a href="javascript:DoPopup('<?=$servername?>',5,<?=$menurow[page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');"><?=$menurow[page_name]?></a><?php
          } else { ?>
              <?=$menurow[page_name]?><?php
          }
      } elseif ($menurow[menu_sequence] == 4)  {
          if (isset($_SESSION[$ss]['payment_method']) && ($_SESSION[$ss]['payment_method'] > "0")) {
              // only allow navigation to personal details page if a payment method exists..
              ?>
              <td class="compstep" width="200">
              <a 
              href="javascript:DoPopup('<?=$servername?>',5,<?=$menurow[page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');"><?=$menurow[page_name]?></a><?php
          } else { ?>
              <td class="otherstep" width="200"><?=$menurow[page_name]?><?php
          }
      } ?>
    </td>
    <td class="fill">&nbsp;</td>
    <?php
    } ?>
    <td class="fill" width="55%">&nbsp;</td>
    <td class="fill">&nbsp;</td>
  </tr>
  <tr>
    <td class="currstep" colspan=14><img src="border.gif" alt="" width="100%" height="2" border="0"></td>
  </tr>
  <tr>
    <td class="midcol" rowspan="2"><img src="border.gif" alt="" width="2" height="400" border="0"></td>
    <td class="fill" rowspan="2">&nbsp;</td>
    <td class="midcol" colspan="10"><p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');  
    ?>
    </td>
    <td class="fill" rowspan="2">&nbsp;</td>
    <td class="midcol" rowspan="2"><img src="border.gif" alt="" width="2" height="400" border="0"></td>
  </tr>
  <tr>
    <td class="midcol" colspan="6"><br><p class=maintext>
    <?php
    if (($section_id == 5) && ($page_id > 1)) { 
        // only enable button if a property is selected //
        ?>     
        <input type="button" name="property" value="View Accommodation" 
        onClick="DoPopup('<?=$servername?>',2,1,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
        <?php
    }
    ?>
    </td>
  </tr>
  <tr>
    <td class="currstep" colspan=14><img src="border.gif" alt="" width="100%" height="2" border="0"></td>
  </tr>
  <tr>
    <td class="fill" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="14">&nbsp;&copy; Copyright 2003 Esekey Limited, UK.</td>
  </tr>
</table>
</body>
</html>
