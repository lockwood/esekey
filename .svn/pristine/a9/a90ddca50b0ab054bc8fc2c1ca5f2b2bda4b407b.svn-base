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
	echo '<table><tr><td>';
    include('availability_daily.php');
    echo '</td><td>&nbsp;&nbsp;&nbsp;</td><td>';
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/booking_intro.php');
	include('booking.php');
    echo '</td></tr></table>';
}
foreach ($elementarray as $elementrow) { 
    if ($elementrow[element_type] == 'left') {
        if ($elementrow[image_name] !=null) {?>
           <table align="center">
             <tr>
               <td valign="top">
                 <IMG src="<?=$elementrow[image_name]?>" border="1">&nbsp;
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
        if ($elementrow[image_name] !=null) {?>
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
                 <IMG src="<?=$elementrow[image_name]?>" border="1">&nbsp;
               </td>
             </tr>
           </table>
           <?php 
        }
    } else {
        if ($elementrow[image_name] !=null) {?>
           <p style="text-align: center">
           <IMG src="<?=$elementrow[image_name]?>">
           </p><?php 
        }
        if ($elementrow[link] !=null) {?>
           <a href="<?=$elementrow[link]?>"><?=html_entity_decode($elementrow[text], ENT_QUOTES)?></a><?php
        }
        elseif ($elementrow[text] !=null) {?>
            <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
        }
    }
} ?></p>
<?php
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
} 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
} 
?>