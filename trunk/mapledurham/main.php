<?php
// +----------------------------------------------------------------------+
// | MAIN  - determines overall layout of page for co 6                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 6/main.php,v 1.01 2005/01/24
//
if ($content_source == 10) { //display gallery
    include('gallery.php');
    return;
} 
if ($content_source == 9) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/booking_intro.php');
}
foreach ($elementarray as $elementrow) { 
    if ($elementrow[element_type] == 'left') {
        if ($elementrow[image_name] !=null) {?>
           <table align="center">
             <tr>
               <td valign="top" width="20%"><a href="<?=$elementrow[link]?>">
                 <IMG src="<?=$elementrow[image_name]?>" alt="<?=$elementrow[image_alt]?>"></a>&nbsp;
               </td>
               <td width="80%"><?=html_entity_decode($elementrow[text], ENT_QUOTES)?>
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
                 <IMG src="<?=$elementrow[image_name]?>">&nbsp;
               </td>
             </tr>
           </table>
           <?php 
        }
    } elseif ($elementrow[element_type] == 'flow') {
        if ($elementrow[image_name] !=null) {?>
                                                   
                           
           <IMG src="<?=$elementrow[image_name]?>" border=0 alt="">     
                                                                  
                                                                   
           <?php 
        }
    } elseif ($elementrow[element_type] != 'headpic') { // heading pictures are displayed in page.php
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
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
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
    $select_property = " AND t1.resource_id IN ('".$elementarray[0][resource_id]."') ";
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
} 
if ($content_source == 9) {
    include('booking.php');
} 
?>