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
						'Windsor Information', 
						'Stay in Britain',
						'Information Britain',
						'A1 Tourist Guide UK',
						'Paws for a Walk', 
						'Self Catering Holiday Direct',
						'UK Holiday Accommodation',
						'Cottage Holidays',
						'Holiday Rentals',
						'Country Cottages Online',
						'Pet Friendly Rentals',
						'Pet Holiday Finder',
						'The Holiday Cottages',
						'Self Catering Directory',
						'Self Catering Holidays',
						'Lodgings International',
						'RBWM',
						'Love to Escape',
						'Tourist Net UK',
						'Visit Britain',
						'Direct from Internet search',
						'Other');
?>