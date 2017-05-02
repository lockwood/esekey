<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 3                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 3/page.php,v 1.03 2006/01/17
//

$custom_page = 1; // set flag to 1 - this custom page formatter is used for Company 3 - Troppo.
// Differences from generic page.php: 
//   Different meta tags for Company 3
// title_logo.jpg used as logo
// No section level menu as all pages are in section 1.
// Section id not passed in url as all pages are in section 1. 

if ($section_id == 2)
{
	// new layout
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
<LINK REL="stylesheet" HREF="esestyles1.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<?php
if ($page_id == 14)
{
	// load in all gallery items for page 23 - the new gallery, to create a fading gallery effect on home page.
	$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];
    $galleryarray = $db_object->getAll("SELECT t1.image_name,
                                           t1.element_type,
                                           t1.text,
                                           t1.link
                                      FROM element as t1,
                                           page_element as t2,
                                           page AS t3
                                     WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND t1.company_id = t2.company_id
                                       AND t1.company_id = t3.company_id
                                       AND t1.element_id = t2.element_id
                                       AND t2.page_id = '23'
                                       AND t2.page_id = t3.page_id
                                       AND t1.active_flag = 'Y'
                                       AND t2.active_flag = 'Y'
                                       AND t3.content_source = '10'
									ORDER BY t2.sequence");
	$image_array = array();
	foreach ($galleryarray as $galleryrow)
	{
		$imagesize = getimagesize($dir.'/'.$galleryrow['image_name']);
		if (is_array($imagesize) && ($imagesize[0] > $imagesize[1]))
		{
			// only include landscape images 
			$image_array[] = '"'.$galleryrow['image_name'].'"';
		} 
	}
	$slide_images = implode(',', $image_array);
	echo '
<script language="JavaScript1.1">
<!--

//*****************************************
// Blending Image Slide Show Script- 
// © Dynamic Drive (www.dynamicdrive.com)
// For full source code, visit http://www.dynamicdrive.com/
//*****************************************

//specify interval between slide (in mili seconds)
var slidespeed=3000

//specify images
var slideimages=new Array('.$slide_images.')

//specify corresponding links
var slidelinks=new Array("http://www.dynamicdrive.com","http://javascriptkit.com","http://www.geocities.com")

var newwindow=1 //open links in new window? 1=yes, 0=no

var imageholder=new Array()
var ie=document.all
for (i=0;i<slideimages.length;i++){
imageholder[i]=new Image()
imageholder[i].src=slideimages[i]
}

function gotoshow(){
if (newwindow)
window.open(slidelinks[whichlink])
else
window.location=slidelinks[whichlink]
}

//-->
</script>
'; 
}
?>
<title><?=html_entity_decode($title, ENT_QUOTES)?></title>
</head>
<body style="background-image: url(graduation2.jpg);">
<table bordercolor="green" style="border-left: solid black 2px; border-right: solid black 2px; border-top: solid black 1px;" width="760" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td class="head" colspan="9"><img src="banner.jpg" alt="Dorney Self Catering Apartments"></td>
  </tr>
  <tr>
    <td colspan="9" align="center" nowrap style="vertical-align:top;background-color: #948A54;">
    <?php
    $i=0; 
    foreach ($menuarray as $menurow) {
     $menurow['page_name'] = str_replace(' ','&nbsp;',$menurow['page_name']);
     if ($i<10)
     {
      if ($menurow[page_id] == $page_id) { ?>
<span class="lefthead" style="padding-left:11px;padding-right:10px;" nowrap><?=$menurow[page_name]?></span><?php
      } else { ?>
<span class="leftcol" style="vertical-align:middle;padding-left:11px;padding-right:10px;"><a href="<?=$menurow[page_url].'">'.$menurow[page_name]?></a></span><?php
      }
	 }
	 $i++;
    }
	$large_size = " width=450 height=300";
	$small_size = " width=160 height=120";
	if ($page_id == 14)
	{
		$img1 = '
<img src="'.$galleryarray[0]['image_name'].'" name="slide" border=0 style="filter:blendTrans(duration=3)" width=450 height=300>
<script language="JavaScript1.1">
<!--

var whichlink=0
var whichimage=0
var blenddelay=(ie)? document.images.slide.filters[0].duration*1000 : 0
function slideit(){
if (!document.images) return
if (ie) document.images.slide.filters[0].apply()
document.images.slide.src=imageholder[whichimage].src
if (ie) document.images.slide.filters[0].play()
whichimage=(whichimage<slideimages.length-1)? whichimage+1 : 0
setTimeout("slideit()",slidespeed+blenddelay)
}
slideit()

//-->
</script>
';
	} elseif (isset($elementarray[0]['image_name']) && $elementarray[0]['image_name'] != '')
	{
		$img1 = '<img src="'.$elementarray[0]['image_name'].'" alt="'.$elementarray[0]['image_alt'].'"'.$large_size.'>';
	}
	if (isset($elementarray[1]['image_name']) && $elementarray[1]['image_name'] != '')
	{
		$img2 = '<img src="'.$elementarray[1]['image_name'].'" alt="'.$elementarray[1]['image_alt'].'"'.$small_size.'>';
	}
	if (isset($elementarray[2]['image_name']) && $elementarray[2]['image_name'] != '')
	{
		$img3 = '<img src="'.$elementarray[2]['image_name'].'" alt="'.$elementarray[2]['image_alt'].'"'.$small_size.'>';
	}
	if (isset($elementarray[3]['image_name']) && $elementarray[3]['image_name'] != '')
	{
		$img4 = '<img src="'.$elementarray[3]['image_name'].'" alt="'.$elementarray[3]['image_alt'].'"'.$small_size.'>';
	}
	if (isset($elementarray[4]['image_name']) && $elementarray[4]['image_name'] != '')
	{
		$img5 = '<img src="'.$elementarray[4]['image_name'].'" alt="'.$elementarray[4]['image_alt'].'"'.$small_size.'>';
	}
	if (isset($elementarray[0]['text']) && $elementarray[0]['text'] != '')
	{
		$txt1 = html_entity_decode($elementarray[0]['text'], ENT_QUOTES);
		if ($page_id == 14) {
			$txt1 = str_replace('<b>Welcome</b> to ', '
<a href="http://www.troppo.uk.com/lakelets/?module=search&action=Index" target="_goLakelets"><img src="Lakelets-banner-ad.jpg" width="600" border="0"></a></p><p>
<b>Welcome</b> to ', $txt1);
		}
	}
	if (isset($elementarray[1]['text']) && $elementarray[1]['text'] != '')
	{
		$txt2 = html_entity_decode($elementarray[1]['text'], ENT_QUOTES);
	}
	if (isset($elementarray[2]['text']) && $elementarray[2]['text'] != '')
	{
		$txt3 = html_entity_decode($elementarray[2]['text'], ENT_QUOTES);
	}
	if (isset($elementarray[3]['text']) && $elementarray[3]['text'] != '')
	{
		$txt4 = html_entity_decode($elementarray[3]['text'], ENT_QUOTES);
	}
	if (isset($elementarray[4]['text']) && $elementarray[4]['text'] != '')
	{
		$txt5 = html_entity_decode($elementarray[4]['text'], ENT_QUOTES);
	}
	if (isset($elementarray[5]['text']) && $elementarray[5]['text'] != '')
	{
		$txt6 = html_entity_decode($elementarray[5]['text'], ENT_QUOTES);
	}
    ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="9" style="border-top: solid black 1px;">
    <?php
if ($content_source == 10) { //display gallery
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/gallery.php');
} else { 
	if ($content_source == 9) {
		echo '<div style="padding:10px;">';
	    include('booking_intro.php');
    	echo '<div style="padding-right:25px;">'.$txt1.'</div></div>';
	}
} 
if ($content_source == 1)
{
 ?><br>
	<?=$img1?></td>
  </tr>
  <tr>
    <td colspan="9" style="padding-top:10px;padding-left:80px;padding-right:80px;" align="left"><span style="font-size: 11pt; font-family: Calibri"><?=$txt1?><br><br></span></td>
  </tr>
  <tr align="center">
    <td style="width:20px">&nbsp;</td>
    <td style="vertical-align:bottom"><?=$img2?></td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"><?=$img3?></td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"><?=$img4?></td>
    <td>&nbsp;</td>
    <td align="right" style="vertical-align:bottom"><?=$img5?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="width:20px">&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri"><?=$txt2?></span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri"><?=$txt3?></span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri"><?=$txt4?></span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri"><?=$txt5?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="midcol" colspan="9">
<?php
} else
{
 ?><br> </td>
  </tr>
  <tr>
    <td style="width:20px">&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri">&nbsp;</span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri">&nbsp;</span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri">&nbsp;</span></td>
    <td>&nbsp;</td>
    <td align="center" style="vertical-align:top"><span style="font-size: 9pt; font-family: Calibri">&nbsp;</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="midcol" colspan="9">
	<?php
}
if ($content_source == 0) {
    include('admin_popup.php');
} 
if ($content_source == 2) {
    include('availability_weekly.php');
} 
if ($content_source == 3) {
    include('booking_wizard.php');
} 
if ($content_source == 4) {
    include('booking_form.php');
} 
if ($content_source == 5) {
    include('payment_form.php');
} 
if ($content_source == 6) {
    include('personal_form.php');
} 
if ($content_source == 7) {
    include('availability_daily.php');
    echo "<br>";
} 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
} 
if ($content_source == 9) {
	echo '<div style="padding:10px;">';
	include('booking.php');
	echo '</div>';
} 
        ?>
    </td>
  </tr>
  <tr>
    <td class="leftfoot" colspan="5" style="border-top: solid black 1px;">&nbsp;&copy;&nbsp;<?=$copyright_year?>&nbsp;Troppo&nbsp;Property&nbsp;Limited,&nbsp;UK<img src="counter.php?p=<?=$page_id?>"></td>
    <td class="rightfoot" align="right" colspan="4" style="border-top: solid black 1px;" nowrap><a style="color: white" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
  </tr>
</table>
</body>
</html><?php
} else
{
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
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=html_entity_decode($title, ENT_QUOTES).$_test?></title>
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
    <td colspan="3" nowrap class="headtext" align="center">&nbsp;Self Catering Apartments<?=$_test?></td>
    <td nowrap class="contact"><b>Tel <?=$_SESSION[$ss]['company_telephone']?><br>Fax <?=$_SESSION[$ss]['company_fax']?><br>email:</b><br><a href="mailto:enquiries@troppo.uk.com">enquiries@troppo.uk.com</a></td>
  </tr>
  <tr>
    <td class="righthead" nowrap>&nbsp;</td>
    <td class="midhead" colspan="4">&nbsp;<?=$page_name?> 
    </td>
  </tr>
  <tr>
    <td class="leftcol"><table border="0" width="100%" cellspacing="0" cellpadding="3" height="100%">
    <?php 
    foreach ($menuarray as $menurow) {
      if ($menurow[page_id] == $page_id) {
          if ($page_id == 1) { ?>
              <tr><td class="leftcol" height="24">&nbsp;</td></tr><?php
          } else { ?>
              <tr><td class="lefthead" nowrap><?=$menurow[page_name]?>&nbsp;</td></tr><?php
          }
      } else { ?>
          <tr><td class="leftcol" height="24" nowrap>
          <a href="<?=$menurow[page_url].'">'.$menurow[page_name]?></a>&nbsp;</td></tr><?php
      }
    } ?>
    <tr><td class="rightcol" height="100%">&nbsp;</td></tr></table></td>
    <td class="midcol" colspan="4" height="100%"><p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');
    ?>
    </td>
  </tr>
  <tr>
    <td class="rightfoot" colspan="4">&nbsp;&copy; <?=$copyright_year?> Troppo Property Limited, UK<img src="counter.php?p=<?=$page_id?>"></td>
    <td class="rightfoot" align="right"><a style="color: white" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></td>
  </tr>
</table>
</body>
</html><?php
}
?>
