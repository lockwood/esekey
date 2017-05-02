<?php
// +----------------------------------------------------------------------+
// | POPUP  - layout of EseSite secure popup Company 2                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 2/popup.php,v 1.01 2004/10/19
//

$custom_popup = true; // set flag to true - tells standard popup formatter not to run
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
<LINK REL="stylesheet" HREF="<?=$_SESSION['company_id'].'\esestyles.css'?>" TYPE="text/css">
<?php
include 'javascript.php';
?> 

<title><?=$title?></title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="lefthead" nowrap><br>
    <?=strtolower($description)?>&nbsp;</td>
    <td class="midhead"><br>
    &nbsp;<?=strtolower($page_name)?> 
    </td>
    <td class="righthead" nowrap><br>
    <a href="javascript:window.opener=self; window.close();"><b>close this window</b></a>&nbsp;</td>
  </tr>
  <tr>
    <td class="midcol" colspan="3"><br><p class=maintext>
    <?php
    // debug code //
    // echo $debugstring;
    // end debug code 
    // include the main content of the page
    include('main.php');  
    ?>
    </td>
  </tr>
  <tr>
    <td class="midcol" colspan="3"><br><p class=maintext>
    Current Selection:&nbsp;
    <?php
    if (isset($_SESSION['booking_property_id'])) {
        echo $_SESSION['booking_property_name'].'.<br>';
    } else {
        echo 'None selected.<br>';
    }
    echo 'Start Date:&nbsp;';
    if (isset($_SESSION['display_date'])) {
        echo $_SESSION['display_date'].'.<br>';
    } else {
        echo 'Not specified.<br>';
    }
    echo 'Duration:&nbsp;';
    if (isset($_SESSION['booking_duration'])) {
        echo $_SESSION['booking_duration'].'.<br>';
    } else {
        echo 'Not specified.<br>';
    }
    foreach ($_SESSION as $key => $value) {
        echo 'Key: '.$key.', Value: '.$value.'.<br>';
    }
    ?>
    </td>
  </tr>
  <tr>
    <td class="midcol" colspan="3"><br><p class=maintext>
    <input type="button" name="availability" value="Check Availability"
    <?php 
    if (($section_id == 5) && ($page_id == 1)) { 
        // only enable button if not in availability screen //
        ?>
        >
    <?php
    } else {
        ?>
        onClick="DoPopup(5,1,0,'p','<?=$_SESSION['date']?>',500,'<?=$_SESSION['booking_date']?>');">
    <?php
    }  
    if (($section_id == 5) && ($page_id > 1)) { 
        // only enable button if a property is selected //
        ?>     
        <input type="button" name="property" value="View <?=$_SESSION['booking_property_name']?> Details" 
        onClick="DoPopup(2,1,<?=$_SESSION['booking_property_id']?>,'p','<?=$_SESSION['date']?>',500,'<?=$_SESSION['booking_date']?>');">
        <?php
    }
    if (isset($_SESSION['booking_date']) && ($_SESSION['booking_date'] > '0')) {
        // only allow navigation to booking details if a booking exists..
        ?>
        <input type="button" name="booking" value="Booking Details" 
        onClick="DoPopup(5,2,<?=$_SESSION['booking_property_id']?>,'p','<?=$_SESSION['date']?>',500,'<?=$_SESSION['booking_date']?>');">
        <?php
    }
    ?>
    </td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="4">&nbsp;&copy; Copyright 2003 Esekey Limited, UK.</td>
  </tr>
</table>
</body>
</html>
