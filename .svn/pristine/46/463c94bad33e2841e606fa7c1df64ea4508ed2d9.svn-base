<?php

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

$locations = $db_object->getAll("SELECT * 
                                 FROM location 
                                WHERE active_flag = 'Y'");

for ($i=49;$i<62;$i++)
{
	for ($j=-8;$j<3;$j++)
	{
		$grid[$i][$j] = array();
	}
}

foreach ($locations as $location)
{
	$i = floor($location['latitude']);
	$j = floor($location['longitude']);
	$grid[$i][$j][]= $location;
}

$mapstring = '
	<script type="text/javascript">
	//<![CDATA[
    
	var map = new GMap(document.getElementById("map"));
	map.addControl(new GLargeMapControl());';
$mapstring .= "
	GEvent.addListener(map, 'moveend', function() {
		var reMap = false;
		var currentZoom = map.getZoomLevel();
		var center = map.getCenterLatLng();
		var yMove = document.getElementById('center_y').innerHTML - center.y;
		var xMove = document.getElementById('center_x').innerHTML - center.x;
		if (yMove > 1 || yMove < -1 || xMove > 1 || xMove < -1) {
			reMap = true;
		}
		if (map.getZoomLevel() < 7 && reMap) {
			map.clearOverlays();
			var latLngStr = '(' + center.y + ', ' + center.x + ')';";
$mapstring .= '
			document.getElementById("center_y").innerHTML = center.y;
			document.getElementById("center_x").innerHTML = center.x;
			if (center.y == "") {
				alert("No Y Coordinate provided");
				return false;
			}';	
for ($i=49;$i<62;$i++)
{
	$mapstring .= '
			else if (center.y < '.($i + 1).') {
				if (center.x == "") {
					alert("No X Coordinate provided");
					return false;
				}';
	for ($j=-8;$j<3;$j++)
	{
		$mapstring .= '
				else if (center.x < '.($j + 1).') {';
		foreach ($grid[$i][$j] as $location)
		{
			$mapstring .= '
					var point'.$location['location_id'].' = new GPoint('.$location['longitude'].', '.$location['latitude'].');
					var marker'.$location['location_id'].' = new GMarker(point'.$location['location_id'].');
					GEvent.addListener(marker'.$location['location_id'].', "click", function() {
						marker'.$location['location_id'].'.openInfoWindowHtml("'.$location['name'].'");
					});
					map.addOverlay(marker'.$location['location_id'].');';
		}
		$mapstring .= '
				}';
	}
	$mapstring .= '
			}';
}
$mapstring .= '
		}
	});
	map.centerAndZoom(new GPoint(-1,54), 11);

	//]]>
    </script>';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="Self Catering Map : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Cottages, Availability, Accommodation, Self-catering, quality, discerning, comfort, luxury, Self catering accommodation, Bed & Breakfast, holiday cottages, short stays, efficiency studio apartment with full kitchenette"/>
<meta name="abstract" content="Self Catering Map."/>
<meta name="description" content="Find self catering accommodation anywhere in the UK with the Self Catering Map."/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
    <script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAOjtbVBxRShWXYwSkG3r8qhRsMb0-zksZz0MDPWUlRy7pCvN83RRRHWfLhS7LShYDRGfO9YRumi8FCA" type="text/javascript"></script>
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title>Self Catering Map</title>
  </head>
<body bgcolor="#FFFFFF" text="#000000" background="background2.jpg">
<table width="950" cellspacing="0" align="center" bordercolor="#006600" border="1" cellpadding="0">
  <tr> 
    <td> 
      <table width="950" cellspacing="0" bordercolor="#000000" align="center" cellpadding="0">
        <tr>
          <td nowrap class="headtext"><font size="14"><i><b>
            &nbsp;Self&nbsp;Catering&nbsp;Map</i></b></font>
            </td>
        </tr>
      </table>
      <table width="950" cellspacing="0" align="center" cellpadding="0">
          <tr>
          <td width="140" bordercolor="1" valign="top" class="contact">
            <br />
            <b>Find Self Catering accommodation anywhere in the UK! </b><br />
Use the controls at the top left of the map to zoom and scroll to the area you wish to search.<div id="center_x"></div>,<div id="center_y"></div> 
          </td>
            <td rowspan="2">
             <br />
             <table border="1" align="center" bordercolor="#006600">
                <tr><td>
                   <div id="map" style="width: 700px; height: 460px; text-align: center"></div>
                 </td></tr></table>
             <p class=maintext>&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td width="140" nowrap class="contact"><br/><b>Owners:</b><br/>Put yourself on the<br/>Self Catering Map!<br/>6 months free<br/><b>Tel 07860 832741<br/><a href="#"><font color=black size=1pt>Register Online</font></a></b></td>
        </tr>
      </table>

      <table width="950" cellspacing="0" align="center" bgcolor="#006600" cellpadding="4">
        <tr> 
          <td width="358"><font color="#FFFFFF">&nbsp;&copy; Copyright 2006 Esekey Limited, UK<img src="counter.php?p=5"></td>
          <td width="386"> 
            <div align="right"><font color="#FFFFFF"><a style="color: white; font-weight: normal" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></font></div>
          </td>
        </tr>
      </table>
    </td></tr></table>
	<?=$mapstring?>

</body>
</html>