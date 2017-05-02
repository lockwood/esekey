<?php

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

$locations = $db_object->getAll("SELECT * 
                                 FROM location 
                                WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                  AND active_flag = 'Y'");
$mapstring = '<script type="text/javascript">
    //<![CDATA[
    
    var map = new GMap(document.getElementById("map"));
    map.addControl(new GSmallMapControl());';

foreach ($locations as $location)
{
	$mapstring .= 'var point'.$location['location_id'].' = new GPoint('.$location['longitude'].', '.$location['latitude'].');';
    $mapstring .= 'map.centerAndZoom(point'.$location['location_id'].', 5);';

    $mapstring .= 'var marker'.$location['location_id'].' = new GMarker(point'.$location['location_id'].');

    GEvent.addListener(marker'.$location['location_id'].', "click", function() {
	marker'.$location['location_id'].'.showMapBlowup(2);
    });

    map.addOverlay(marker'.$location['location_id'].');';
}

$mapstring .= '   //]]>
    </script>';

?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="Dorney Self Catering Apartments : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Windsor, Dorney, Lake, Rowing, Eton, College, Legoland, Cottages, Availability, Accommodation, Self-catering, Wisteria, Gardener, Bothy, Smithy, quality, discerning, comfort, luxury"/>
<meta name="abstract" content="Dorney Self Catering Apartments."/>
<meta name="description" content="Dorney Self Catering Apartments provide quality accommodation conveniently located for Windsor and Dorney Lake"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
    <script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAOjtbVBxRShWXYwSkG3r8qhR2ayLnM5ZdecXsm4m5mjzKgtP_LRRE9sMR2luoLRaLxclpg4oBagLNlQ" type="text/javascript"></script>
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title>Dorney Self Catering Apartments - Where We Are</title>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
  <tr>
    <td class="headtext">
      <a href="index.html">
      <img border="0" alt="Dorney Self Catering Apartments" src="title_logo.jpg" align="right">
      </a></td>
    <td colspan="3" nowrap class="headtext" align="center">&nbsp;Self Catering Apartments</td>
    <td nowrap class="contact"><b>Tel 01753 827037<br>Fax 01753 855022<br>email:</b><br><a href="mailto:enquiries@troppo.uk.com">enquiries@troppo.uk.com</a></td>
  </tr>
  <tr>
    <td class="righthead" nowrap>&nbsp;</td>
    <td class="midhead" colspan="4">&nbsp;Where We Are 
    </td>
  </tr>
  <tr>
    <td class="leftcol"><table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
              <tr><td class="leftcol" height="24" nowrap>
          <a href="p1.html">Home</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p8.html">Gardener's Bothy</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p7.html">Wisteria</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p9.html">The Smithy</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p11.html">Prices</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p10.php">Availability</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p12.php">Booking</a>&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p4.html">Local Attractions</a>&nbsp;</td></tr>              <tr><td class="lefthead" nowrap>Where We Are&nbsp;</td></tr>          <tr><td class="leftcol" height="24" nowrap>
          <a href="p5.php">Gallery</a>&nbsp;</td></tr>    <tr><td class="rightcol" height="100%">&nbsp;</td></tr></table></td>
    <td class="midcol" colspan="4" height="100%"><p class=maintext>
                <br><p align=center>This map illustrates our M4 corridor&#047;Thames Valley location. We are only 10 minutes' drive from Junction 7 of the M4.</p>
             <table border="1" align="center" bordercolor="#006600">
                <tr><td>
                   <div id="map" style="width: 650px; height: 330px; text-align: center"></div>
                 </td></tr></table>
                <p align=center>Use the controls on the left of the map to zoom in or out and view other parts of the map. Click on the marker to see a magnified view of the immediate area, then select the Satellite view for an excellent aerial view of Dorney Lake.</p>
    </td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="4">&nbsp;&copy; 2008 Troppo Property Limited, UK<img src="counter.php?p=3"></td>
    <td class="rightfoot" align="right"><a style="color: white" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
  </tr>
</table>
<?=$mapstring?>
</body>
</html>