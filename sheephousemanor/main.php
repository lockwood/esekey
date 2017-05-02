<?php
// +----------------------------------------------------------------------+
// | MAIN  - determines overall layout of page for co 4                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/main.php,v 1.01 2005/01/24
//
if ($content_source == 10) { //display gallery
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/gallery.php');
    return;
} 
if ($content_source == 9) {
    include('booking_intro.php');
}
foreach ($elementarray as $elementrow) { ?>
    <?=html_entity_decode($elementrow[text], ENT_QUOTES)?><?php
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
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/availability_daily.php');
} 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_form.php');
} 
if ($content_source == 9) {
    include('booking.php');
} 
?>