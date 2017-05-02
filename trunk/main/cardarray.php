<?php
// +----------------------------------------------------------------------+
// | CARDARRAY  - populate payment type dropdown for default Company      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/cardarray.php,v 1.00 2006/07/05
//

$custom_cards = null; // set flag to null - if custom cardarray is found it will set this flag
if (file_exists($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/cardarray.php'))
{
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/cardarray.php'); // call custom cardarray
}
if ($custom_cards != null) { //don't use this dropdown, a custom one has been found and used
    return;
}
$cardarray = array('','Visa','Mastercard','Switch','Maestro','Delta');
?>