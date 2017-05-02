<?php
// +----------------------------------------------------------------------+
// | MAIN  - determines overall layout of page for company 7              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 7/main.php,v 1.00 2005/07/18
//
if ($content_source == 10) { //display gallery
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/gallery.php');
    return;
} 
if ($content_source == 9) {
    include('booking_intro.php');
}
foreach ($elementarray as $elementrow) {
	$has_content = false; 
	if ($ss == 'Admin') {
		echo '<div style="background-color:transparent;" id="'.$elementrow['element_id'].'" 
				onmouseover="ShowReady(this);" 
				onmouseout="HideReady(this);"
				onclick="EditElement('."'".$servername."','".$elementrow['element_id']."','".$sid."'".')">';
	}
	if ($elementrow[element_type] == 'left') {
        if ($elementrow[image_name] !=null) {
        	$has_content = true;
        	?>
           <table align="center">
             <tr>
               <td valign="top">
                 <img src="<?=$prefix.$elementrow[image_name]?>" border="1"/>&nbsp;
               </td>
               <td><?php 
               if ($elementrow[link] !=null) {?>
                   <a href="<?=$elementrow[link]?>"><?=html_entity_decode($elementrow[text], ENT_QUOTES)?></a><?php
               }
               elseif ($elementrow[text] !=null) {?>
                   <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
               } ?>
               </td>
             </tr>
           </table>
           <?php 
        }
    } elseif ($elementrow[element_type] == 'right') {
        if ($elementrow[image_name] !=null) {
        	$has_content = true;
        	?>
           <table align="center">
             <tr>
               <td><?php 
               if ($elementrow[link] !=null) {?>
                   <a href="<?=$elementrow[link]?>"><?=html_entity_decode($elementrow[text], ENT_QUOTES)?></a><?php
               }
               elseif ($elementrow[text] !=null) {?>
                   <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
               } ?>
               </td>
               <td>
                 <img src="<?=$prefix.$elementrow[image_name]?>" border="1"/>&nbsp;
               </td>
             </tr>
           </table>
           <?php 
        }
    } else {
        if ($elementrow[image_name] !=null) {
        	$has_content = true;
        	?>
           <p style="text-align: center">
           <img src="<?=$prefix.$elementrow[image_name]?>"/>
           </p><?php 
        }
        if ($elementrow[link] !=null) {
        	$has_content = true;
        	?>
           <a href="<?=$elementrow[link]?>"><?=html_entity_decode($elementrow[text], ENT_QUOTES)?></a><?php
        }
        elseif ($elementrow[text] !=null) {
        	$has_content = true;
        	?>
            <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
        }
    }
	if ($ss == 'Admin') {
		if ($has_content === false) echo "[Empty Element]";
		echo '</div>';
	}
	// limit availability display to show only the selected property id....
	if ($content_source == 7 && $elementrow['resource_id'] > 0) $selected_id = $elementrow['resource_id'];
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
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
} 
if ($content_source == 9) {
    include('booking.php');
} 
?>