<?php
// +----------------------------------------------------------------------+
// | CHECK_SESSION  - Validate secure session in popup (Company 1)        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/check_session.php,v 1.01 2005/01/21
//

/* check session script, included in index.php -->> controller.php after db_connect.php. */

session_start();

$logged_in = 1; //assume logged in as guest

if (!isset($_SESSION[$ss]['username'])) { 
      // control has passed from root path index.php with no previous session info
      // start session as guest user
      $_SESSION[$ss]['username'] = 'guest';
      $_SESSION[$ss]['company_id'] = '00000';
}
//company should be specified as id on url
$company_url = str_pad($_GET['id'], 5, '0', STR_PAD_LEFT); // allow company on url to omit leading zeroes
if ($_SESSION[$ss]['company_id'] != $company_url) { // company has changed
    $_SESSION[$ss]['username'] = 'guest';
    $_SESSION[$ss]['company_id'] = $company_url; 
      unset($_SESSION[$ss]['company_name']);
      unset($_SESSION[$ss]['password']);
}
if ($_SESSION[$ss]['username'] == 'guest') {
      if ($_SESSION[$ss]['company_id'] != '00000') { //Look for company details in database
          $row = $db_object->getRow("SELECT company_name, company_telephone 
                                       FROM company".$_test." 
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                        AND active_flag = 'Y'");

          $_SESSION[$ss]['company_name'] = $row['company_name']; 
          $_SESSION[$ss]['company_telephone'] = $row['company_telephone'];
      } 
      if ($_SESSION[$ss]['company_name'] == '') { //company not found - assume company 0
          $_SESSION[$ss]['company_id'] = '00000';
          $_SESSION[$ss]['company_name'] = 'Esekey'; 
          $_SESSION[$ss]['company_telephone'] = '07860 832741'; 
      }

} else { //validate password 

	// remember, $_SESSION[$ss]['password'] will be encrypted.

	if(!get_magic_quotes_gpc()) {
		$_SESSION[$ss]['username'] = addslashes($_SESSION[$ss]['username']);
	}


	// addslashes to session username before using in a query.
	$pass = $db_object->query("SELECT password FROM user WHERE user_name = '".$_SESSION[$ss]['username']."'");

	if(DB::isError($pass)) {
		$logged_in = 0;
		unset($_SESSION[$ss]['username']);
		unset($_SESSION[$ss]['password']);
		// kill incorrect session variables.
	}

	$db_pass = $pass->fetchRow();

	// now we have encrypted pass from DB in 
	//$db_pass['password'], stripslashes() just incase:

	$db_pass['password'] = stripslashes($db_pass['password']);
	$_SESSION[$ss]['password'] = stripslashes($_SESSION[$ss]['password']);



	//compare:



	if($_SESSION[$ss]['password'] == $db_pass['password']) { 
		// valid password for username
		$logged_in = 1; // they have correct info
					// in session variables.
	} else {
		$logged_in = 0;
		unset($_SESSION[$ss]['username']);
		unset($_SESSION[$ss]['password']);
		// kill incorrect session variables.
	}
      // clean up
      unset($db_pass['password']);

      $_SESSION[$ss]['username'] = stripslashes($_SESSION[$ss]['username']);

}

?>