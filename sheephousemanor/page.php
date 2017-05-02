<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 4                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/page.php,v 1.02 2006/01/17
//
if ($content_source == 11 && isset($_POST) && count($_POST) > 0) {
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_review_validate.php');
	if (isset($_SESSION[$ss]['thanks'])) {
		// guest review successfully added - redirect to review page....
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
	}
}
$custom_page = 1; // set flag to 1 - this custom page formatter is used for Company 4 - Sheephouse Manor.
// Differences from generic page.php: 
//   Different meta tags for Company 3
// title_logo.jpg used as logo
// No section level menu as all pages are in section 1.
// Section id not passed in url as all pages are in section 1. 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="title" content="<?=$title?> - Sheephouse Manor, Maidenhead">
<meta name="status" content="final">
<meta name="keywords" content="b and b in Maidenhead, b&amp;b in Maidenhead, b&amp;b Maidenhead, bandb in Maidenhead, bandbs in Maidenhead, bb Maidenhead, bbs Maidenhead, bed and breakfast in Maidenhead, bed and breakfast Maidenhead, bed and breakfasts in Maidenhead, holidays in Maidenhead, motel in Maidenhead, motels in Maidenhead, Maidenhead b&amp;b, Maidenhead b&amp;bs, Maidenhead bbs, Maidenhead bed and breakfasts, vacations in Maidenhead, Windsor, Maidenhead, Legoland, Cottages, Availability, Accommodation, Self-catering, B&amp;B, Cookham, Eton, Bray, quality, discerning, comfort, luxury, Self catering accommodation, Bed &amp; Breakfast, holiday cottages, short stays, efficiency studio apartment with full kitchenette, Berkshire, London, Thames Path, Fat Duck, Bed and Breakfast, Bed&amp;Breakfast, Accommodation in Maidenhead, Accommodation in Berkshire, Accommodation near Legoland, Hotels in Maidenhead, Thames path, Guesthouse accommodation, Short let stays, Holidays in Maidenhead, Holiday rentals, Holidays near Legoland, Henley, Ascot, Slough, Basingstoke, Reading, Holyport, Cycling the Thames Path, Walking the Thames Path, Boulters Lock, Fat Duck Restaurant, Waterside Restaurant, Sheephouse Manor, Where to stay Maidenhead, Sheephouse Trout Fishery">
<meta name="abstract" content="Sheephouse Manor.">
<meta name="description" content="High quality bed and breakfast accommodation &amp; self catering cottages, rural guest house in Maidenhead, Berkshire, convenient for M4, M40, Windsor, Legoland and Ascot.">
<meta name="security" content="Public">
<meta name="charset" content="ISO-8859-1">
<meta name="robots" content="index,follow">
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<?php
$body_class = '';
if ($content_source == 11) {
	// fix for th datepicker issue
	$body_class = ' class="review"'; 
?>
<link href='scroll.css' type='text/css' rel='stylesheet' />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type='text/javascript' src='jquery.scrollTo-min.js'></script>
<script type='text/javascript' src='jquery.serialScroll-min.js'></script>
<script type='text/javascript' src='init.js'></script>
<script>
$(function() {
$( "#arrival_date" ).datepicker( { dateFormat: "dd/mm/yy" } );
});
</script>
<style type="text/css">
.review th {
font-size:1em;
}
</style>
<?php
}
?>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-511266032a133f44"></script>
<script src="http://www.jscache.com/wejs?wtype=linkingWidgetRedesign&amp;uniq=775&amp;locationId=564303&amp;lang=en_UK&amp;border=true"></script>
<style type="text/css">
#talink.widLNKSml {
    font-size: 6pt !important;
    line-height: 8pt;
}
#talink.widLNKSml a {
    font-size: 6pt !important;
    line-height: 8pt;
}
</style>
<title><?=$title.$_test?> - Sheephouse Manor, Maidenhead</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" background="background2.jpg" <?=$body_class?> >
 <table width="900" align="center" border="0" cellspacing="0" cellpadding="2"><tr><td style="background-color:#006600">
  <table width="900" align="center" border="0" cellspacing="0" cellpadding="0" style="background-image: url(background2.jpg);">
  <tr> 
    <td> 
      <table width="900" cellspacing="0" align="center" cellpadding="0">
        <tr>
          <td class="headtext">
            <table><tr><td colspan="6"><a href="index.html"><img border="0" alt="Sheephouse Manor" src="drawing3.jpg" align="left"></a></td></tr>
            <tr><td><a href="p15.html"><img border="0" alt="En français" title="En français" src="France.png" align="left"></a></td><td><a href="p16.html"><img border="0" alt="Auf Deutsch" title="Auf Deutsch" src="Germany.png" align="left"></a></td><td><a href="p17.html"><img border="0" alt="En español" title="En español" src="Spain.png" align="left"></a></td><td><a href="p18.html"><img border="0" alt="In italiano" title="In italiano" src="Italy.png" align="left"></a></td><td width="60%"><img border="0" alt="Wifi available" title="Wifi available" src="30px-Wireless-icon.png" align="right"></td></tr></table>
            </td>
          <td align="center"><img border="0" alt="Sheephouse Manor" src="heading1.jpg" align="left"><?=$_test?></td>
          <td nowrap class="contact"><br/><b>Sheephouse Manor<br/>Sheephouse Road<br/>Maidenhead<br/>Berks SL6 8HJ<br/>U.K.</b><br/><br/>
<div id="TA_linkingWidgetRedesign775" class="TA_linkingWidgetRedesign">
<ul id="UxXQ5IL" class="TA_links xChlMu">
<li id="4I2mjg" class="1lq0DZhS">Read reviews of<br/> <a style="color:black;" target="_blank" href="http://www.tripadvisor.co.uk/Hotel_Review-g186418-d564303-Reviews-Sheephouse_Manor-Maidenhead_Windsor_and_Maidenhead_Berkshire_England.html">Sheephouse Manor</a></li>
</ul>
</div>
          </td>
		  <td class="contact"><br/><b>Tel <?=$_SESSION[$ss]['company_telephone']?><br>Fax <?=$_SESSION[$ss]['company_fax']?><br>email:</b><br><a href="mailto:info@sheephousemanor.co.uk"><font color=black size=1pt>info@sheephousemanor.co.uk</font></a><br/><br/><b>Find us on Facebook:</b>
<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fsheephousemanor.co.uk&amp;width=220&amp;height=80&amp;colorscheme=light&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:210px; height:80px;" allowTransparency="true"></iframe>
		  </td>
        </tr>
      </table>
      <table width="900" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td bgcolor="#006600" height="20"> 
            <div align="center"><font color="#FFFFFF">&nbsp;
            <?php
            $i = 0; 
            foreach ($menuarray as $menurow) {
              $i++;
              if ($i < 12)
              {
              	if ($i > 1) { ?>
              		|
              	<?php	
              	}
              	if ($menurow['page_id'] == $page_id) { ?>
                  <span class="lefthead"><font color="yellow"><b><?=$menurow['page_name']?>&nbsp;</b></font></span><?php
              	} else { ?>
                  <span>
          <?='<a title="'.$menurow['page_title'].'"
             href="'.$menurow['page_url'].'">'.$menurow['page_name'].'</a>&nbsp;</span>'?><?php
              	}
			  }
            } ?>
          </font></div>
          </td>
        </tr>
      </table>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style " style="float:right;margin-top:10px;"> 
<a class="addthis_button_facebook_like" fb:like:action="recommend"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<!-- AddThis Button END -->
      <table width="900" cellspacing="0" align="center" cellpadding="0">
        <tr><?php
        if ($content_source == 7) { ?>
          <td colspan="4" margin="1"><?php
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
        } elseif ($content_source == 9) { ?>
          <td colspan="4" margin="1">
            <table width= "100%" cellpadding="3">
              <tr><td><?php
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/booking_intro.php');
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/booking.php'); ?>
              </td></tr>
            </table><?php
        } elseif ($content_source == 3) { ?>
          <td colspan="4" margin="1"><?php
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/tariff.php');
        } elseif ($content_source == 10) { ?>
          <td colspan="4" margin="1"><?php
            include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/gallery.php');
		} else {
			$image_disp = false;
			foreach ($elementarray as $elementrow)
			{
				if ($elementrow['image_name'] != '') {
					$image_disp = true;
				} else {
					if (strpos($elementrow['text'],'<iframe')) {
						$image_disp = true;
					}
					if (strpos($elementrow['text'],'maps.google.com')) {
						$image_disp = true;
					}
				}
			}
		    if ($content_source == 11) {
		  	    $image_disp = true;
		    }
			if (!$image_disp) { ?>
          <td colspan="4" style="padding:20px">
            <p>&nbsp;</p>
            <?=$elementarray[0]['text']?><?php 
			} else {
			?>
          <td width="183" height="5" valign="top">&nbsp;</td>
          <td width="9" height="5" valign="top">&nbsp;</td>
          <td height="5" valign="top" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td width="183" valign="top"><?php
          if ($content_source != 11) {
            echo '<p>&nbsp;</p>';
          }
            ?>
            <?=$elementarray[0]['text']?> 
          </td>
          <td width="9" valign="top">&nbsp;</td>
          <td width="310" valign="top"> 
            <p align="center"><b><font size="3"><?=$elementarray[0]['image_alt']?></font></b>
            </p><?php
		  if ($content_source == 11) {
		  	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_reviews.php');
		  }
            for ($i=2;$i<count($elementarray);$i++) {
            	if ($elementarray[$i]['image_name'] != '') { ?>
            <div align="center"><img src="<?=$elementarray[$i]['image_name']?>" border="1" alt="<?=$elementarray[$i]['image_alt']?>" title="<?=$elementarray[$i]['image_alt']?>"><br /><i><?=$elementarray[$i]['image_alt']?></i></div>
            <br><?php 
				} else { ?>
            <p>&nbsp;</p><?php
				}?>
            <div align="center"><?=$elementarray[$i]['text']?></div><?php
			} 
			?>
          </td>
          <td width="246" valign="top"> 
            <p class=maintext>
            <?=$elementarray[1]['text']?>
            <?php
			  if ($content_source == 11) {
				include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/guest_review_form.php');
			  }
			}
        } ?> 
          </td>
        </tr>
      </table>
      <table width="900" cellspacing="0" align="center" bgcolor="#006600" cellpadding="4">
        <tr> 
          <td width="358"><font color="#FFFFFF">&nbsp;&copy; Copyright <?=$copyright_year?> Sheephouse Manor, UK<img src="counter.php?p=<?=$page_id?>" alt="counter"></font></td>
          <td width="236"><a href="http://www.icondrawer.com" target="id"><img border="0" alt="Flags by IconDrawer" src="UK.png" align="right"></a></td> 
          <td width="150">&nbsp;<font color="#FFFFFF"><a style="color: white; font-weight: normal" href="http://www.esekey.com/" target="z">Powered by Esekey&trade;</a></font>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</td></tr></table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-789136-1";
urchinTracker();
</script>
</body>
</html>
