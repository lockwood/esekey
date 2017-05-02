<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 7 RJS Lettings   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 7/page.php,v 1.01 2006/01/17
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
if ($section_id > 1 && (!isset($sid)))
{
	$prefix = '../';
} else
{
	$prefix = '';
}
if (isset($sid))
{
	$href = 'id';
	$title_id = $page_id." ";
} else
{
	$href = 'href';
	$title_id = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Language" content="en-gb"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<meta name="title" content="RJS Lettings : Introduction "/>
<meta name="status" content="final"/>
<meta name="keywords" content="Maidenhead, Windsor, Holyport, Fowey, Cornwall, West Country, Legoland, Professional, Lettings, Availability, Accommodation, Accomodation, acommodation, Self, Catering, Self-catering, quality, discerning, comfort, luxury, long, short, term, let, pet, dog, friendly, pet-friendly, dog-friendly"/>
<meta name="abstract" content="RJS Lettings."/>
<meta name="description" content="High quality comfortable self catering accommodation in pet-friendly houses in Holyport near Maidenhead, Berkshire, and Fowey in Cornwall; short or long term"/>
<meta name="security" content="Public"/>
<meta name="charset" content="ISO-8859-1"/>
<meta name="robots" content="index,follow"/>
<link rel="stylesheet" href="<?=$prefix?>esestyles.css" type="text/css"/>
<script language="JavaScript" src="<?=$prefix?>eseSite.js" type="text/javascript"></script>
<?php
if (!isset($sid) && $content_source == 20)
{ ?> 
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false
    &amp;key=ABQIAAAAOjtbVBxRShWXYwSkG3r8qhQuzW19AnAr4m2KyGZxPtI1kNpgkBQna0vvIqN2ptd1el8NAzMAePIH-A"
    type="text/javascript">
  </script>
  <script type="text/javascript">
    function initialize() { 
    	if (GBrowserIsCompatible()) {
		    var map = new GMap2(document.getElementById("map_canvas"));
		    var point = new GLatLng(50.3376, -4.6492);
		    map.setCenter(point, 9);
		    map.setUIToDefault();
		
		    var marker = new GMarker(point);
		
		    var html = "We are here";
		    GEvent.addListener(marker, 'click', function() {
			marker.showMapBlowup(2);
		    });
		
		    map.addOverlay(marker);
		}
	}
    </script>
<?php
}
?> 
<title><?=$title_id?><?=html_entity_decode($title, ENT_QUOTES)?> - RJS Lettings </title>
</head>
<?php
if (!isset($sid) && $content_source == 20)
{ ?> 
<body bgcolor="#FFFFFF" text="#000000" background="<?=$prefix?>maidenh1.jpg" onload="initialize()" onunload="GUnload()">
<?php
} else
{ ?>
<body bgcolor="#FFFFFF" text="#000000" background="<?=$prefix?>maidenh1.jpg">
<?php
} 
if ($section_id == 2)
{
?>
<div class="leftcol" style="z-index: 1; position: absolute; left: 10px; top: 0px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>garden_detail.jpg" width="155" height="115" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 10px; top: 120px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>sofa_detail_small.jpg" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 58px; top: 120px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>frontview.jpg"  width="57" height="75" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 120px; top: 120px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>reception_detail.jpg"  width="45" height="35" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 10px; top: 166px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>conservatory_detail.jpg" width="43" height="130" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 58px; top: 200px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>kitchen_detail.jpg" width="57" height="76" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 120px; top: 160px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>sofa_picture.jpg" width="45" height="116" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 10px; top: 301px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>garden_detail_med.jpg" width="43" height="40" border="1" alt="RJS Lettings"/>
</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 58px; top: 281px; margin-top: <?=($mainheight + 40)?>px;">
<img src="<?=$prefix?>frontview_detail.jpg" width="107" height="60" border="1" alt="RJS Lettings"/>
</div><?php
} ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
  <tr>
    <td colspan="4" nowrap="nowrap" class="headtext" align="center"><a <?=$href?>="<?=$prefix?>index.html">&nbsp;Self Catering Accommodation</a></td>
    <td nowrap="nowrap" class="contact"><b>Tel <?=$_SESSION[$ss]['company_telephone']?><br/>Fax <?=$_SESSION[$ss]['company_fax']?><br/>email:</b><br/><a href="mailto:rolandstreet@maidenheadwine.co.uk">rolandstreet@maidenheadwine.co.uk</a></td>
  </tr>
  <tr>
    <td class="righthead"></td>
    <td colspan="5"></td>
  </tr>
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
  <tr><?php
If ($section_id == 2)
{ ?>
    <td><img src="<?=$prefix?>maidenh1.jpg" width="165" height="350" border="0" alt=""/></td><?php
} else
{ ?>  
    <td>&nbsp;</td><?php
} ?>
    <td class="midhead"><table border="0" cellspacing="0" cellpadding="3">
    <?php 
    if ($section_id > 1 )
    {
    	?>
          <tr><td class="leftcol" height="24" nowrap="nowrap">
          <a <?=$href?>="<?=$prefix?>index.html">&nbsp;RJS Lettings Home</a>&nbsp;</td></tr><?php
    }
 	foreach ($menuarray as $menurow) {
      if ($menurow['page_id'] == $page_id) { ?>
          <tr><td class="lefthead" nowrap="nowrap"><?=$menurow['page_name']?>&nbsp;</td></tr><?php
      } else { 
      	if ($menurow['content_source'] == 1) {
      	  $url = str_replace(' ', '_', $menurow['page_name']).'.html';
      	} else {
      		$url = str_replace(' ', '_', $menurow['page_name']).'_page.php';
      	}
      	$link = '<a '.$href.'="'.$url.'">'.$menurow[page_name].'</a>';
      	?>
          <tr><td class="leftcol" height="24" nowrap="nowrap">
          <?=$link?>&nbsp;</td></tr><?php
      }
    } ?>
    <tr><td class="leftcol" height="100%">&nbsp;</td></tr></table></td>
    <td class="midhead" colspan="3" height="100%"><table border="0" width="100%" cellspacing="0" cellpadding="5">
    <tr><td class="midcol" height="100%"> 
    <?php
    // include the main content of the page
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/main.php');
    ?>
    </td></tr></table></td>
  </tr>
</table>
<div id="footer">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="midline" colspan="5"></td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="4">&nbsp;&copy; <?=$copyright_year?> R J Street Lettings, UK<img src="<?=$prefix?>counter.php?p=<?=$page_id?>" alt=""/></td>
	<?php
	if ($ss == 'Admin') { ?>
	<td class="rightfoot" style="text-align: right"><a style="color: #333366" href="#" onclick="AddElement('<?=$servername?>','<?=$page_id?>','<?=$sid?>')">Add a new element to this page...</a></td>
	<?php
	} else { ?>
	<td class="rightfoot" style="text-align: right"><a style="color: #333366" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
	<?php
	} ?>
  </tr>
</table>
</div>
</body>
</html>
