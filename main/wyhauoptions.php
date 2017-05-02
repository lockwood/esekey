<?php
// +----------------------------------------------------------------------+
// | WYHAUOPTIONS  - populate "where you heard about us" options for dflt co |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/wyhauoptions.php,v 1.01 2007/08/15
//

$wyhau_options = null; // set flag to null - if custom wyhau options is found it will set this flag
if (file_exists($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/wyhauoptions.php'))
{
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/wyhauoptions.php'); // call custom cardarray
}
if ($wyhau_options != null) { //don't use this dropdown, a custom one has been found and used
    return;
}
$wyhau_options = array( 'Please Select', 
						'Returning visitor', 
						'Trip Advisor', 
						'Windsor Information', 
						'Stay in Britain',
						'Around About Britain',
						'Country Cottages',
						'Pet Friendly Rentals/Pet Holiday Finder',
						'We Accept Pets',
						'Click Holiday Cottages',
						'Lodgings International',
						'Royal Borough of Windsor &amp; Maidenhead',
						'Love to Escape',
						'Visit Britain',
						'Visit England',
						'Other (please comment in box above)');
?>