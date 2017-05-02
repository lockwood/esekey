<?php
// +----------------------------------------------------------------------+
// | CONTROLLER  - secure session management for popups Company 1         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/controller.php,v 1.00 2003/10/01
//
include('check_session.php');

    // initialise all variables

    if (isset ($_GET['r'])) { //property_id specified on url
        $property_id = $_GET['r']; 
    }
    if (!isset ($property_id)) {
        $property_id = 0;
    }
    if (isset ($_GET['d'])) { //date specified on url
        $_SESSION[$ss]['date'] = $_GET['d']; // store availability start date on session
    }
    if (!isset($_SESSION[$ss]['date'])) {
        $_SESSION[$ss]['date'] = '0';
    }
    if (isset ($_GET['b'])) { //date specified on url
        $_SESSION[$ss]['booking_date'] = $_GET['b']; // store booking date on session
    }
    if (!isset($_SESSION[$ss]['booking_date'])) {
        $_SESSION[$ss]['booking_date'] = '0';
    }
    if ($_SESSION[$ss]['booking_date'] == '0') {
        unset($_SESSION[$ss]['booking_property_id']);
        unset($_SESSION[$ss]['booking_property_name']);
        unset($_SESSION[$ss]['booking_duration']);
        unset($_SESSION[$ss]['payment_method']);
        unset($_SESSION[$ss]['display_date']);
    }
    if (isset ($_GET['l'])) { //duration specified on url
        $_SESSION[$ss]['booking_duration'] = $_GET['l']; // store booking duration on session
    }
    if (isset ($_GET['m'])) { //payment method specified on url
        $_SESSION[$ss]['payment_method'] = $_GET['m']; // store payment method on session
    }

    //debugging code //
    $debugstring = 's='.$section_id.'&p='.$page_id.'&r='.$property_id.'&t='.$window_type.'&d='.$_SESSION[$ss]['date'];
    //end debugging code

    // get data and populate arrays
    require('getdata.php');

    // perform any validation of input
    if ($content_source == 1) { // reset error message as this page has no validation
        unset($_SESSION[$ss]['error_message']);
    } 
    if ($content_source == 4) { // validate requested booking before building page - may need to redirect
        include('validate_booking.php');
    } 
    if ($content_source == 5) { // validate requested booking before building page - may need to redirect
        include('validate_booking.php');
    } 
    if ($content_source == 6) { // validate requested booking before building page - may need to redirect
        include('validate_booking.php');
    } 
    require('popup.php');
//}
?>