<?php
// +----------------------------------------------------------------------+
// | DB_CONNECT  - database connection                                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/db_connect.php,v 1.01 2005/05/06
//

if (!file_exists($DOCUMENT_ROOT.'/main/admin_check_session.php')) {
	die ("Polite message from Esekey Limited: <br/><br/>We apologise for any inconvenience. The Availability and Booking Service is currently undergoing maintenance which may take several minutes.<br/><br/>Please try again in approximately 10 minutes.<br/><br/>Thank you for your patience.");
}


//require the PEAR::DB classes.

require_once 'DB.php';


$db_engine = 'mysql';
//$db_user specified in properties file - varies with environment.
$db_pass = 'real1ty2';
$db_host = 'localhost';
//$db_name specified in properties file - varies with environment.

$datasource = $db_engine.'://'.
			  $db_user.':'.
			  $db_pass.'@'.
		 	  $db_host.'/'.
	  		  $db_name;


$db_object = DB::connect($datasource, TRUE);

/* assign database object in $db_object, 

if the connection fails $db_object will contain

the error message. */

// If $db_object contains an error:

// error and exit.

if(DB::isError($db_object)) {
	die($db_object->getMessage());
}

$db_object->setFetchMode(DB_FETCHMODE_ASSOC);

?>