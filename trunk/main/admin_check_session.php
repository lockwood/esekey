<?php
// +----------------------------------------------------------------------+
// | ADMIN_CHECK_SESSION  - Esekey Admin Console validate session         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/admin_check_session.php,v 1.00 2006/07/21
//
if ($sid = $_GET['sid']) {
//	echo "Get ";
} elseif ($sid = $_POST['sid']){
//	echo "Post ";
} else {
	die ("No sid ");
}
if (isset($_SESSION[$ss]['username'])) { // check if session info is already there
	if ($_SESSION[$ss]['username'] != 'Administrator') {
		return;
	}
}
$info = null;
$check = $db_object->query("SELECT DISTINCT
                                     t1.user_id, 
                                     t1.user_name, 
                                     t1.permissions, 
                                     t1.company_id, 
                                     t2.userlog_timestamp, 
                                     t2.reason 
                                FROM user as t1, 
                                     userlog as t2 
                               WHERE t2.data = '".$sid."'
                                 AND t1.user_id = t2.user_id
                                 AND t1.active_flag = 'Y'
                            ORDER BY t2.userlog_timestamp");
while ($row = $check->fetchRow()) {
	$info = $row;
}
if ($info == null) {
	echo " Session Id is ".$_GET['sid'];
	die(' User not logged in');
//	header("Location: https://".$servername."/admin/goto_login.php");
}
$check2 = $db_object->query("SELECT DISTINCT
                                     t1.user_id, 
                                     t1.user_name, 
                                     t1.permissions, 
                                     t1.company_id, 
                                     t2.userlog_timestamp, 
                                     t2.reason 
                                FROM user as t1, 
                                     userlog as t2 
                               WHERE t1.user_name = '".$info['user_name']."'
                                 AND t1.user_id = t2.user_id
                                 AND t1.active_flag = 'Y'
								 AND t2.userlog_timestamp > '".$info['userlog_timestamp']."'
                            ORDER BY t2.userlog_timestamp");
if ($row = $check2->fetchRow()) {
	echo " Session Id is ".$_GET['sid'];
	die(' User login expired');
}
$check3 = $db_object->getOne("SELECT date_sub(now(), INTERVAL 1 DAY)");
if ($check3 > $info['userlog_timestamp']) {
	echo " Session login ".$info['userlog_timestamp'];
	die(' User login expired - please <a href="p8.php">login again</a>');
}
if (isset($_SESSION['User']['company_id']) 
	&& $_SESSION['User']['company_id'] != $info['company_id']
	&& $_SESSION['User']['company_id'] != $info['reason']) {
	echo " Session/Company mismatch: ".$_SESSION['User']['company_id'].":".$info['company_id'].":".$info['reason'];
	die(' User session expired');
}

//	echo " Session recovered for ".$info['user_name'];
if (!isset($_SESSION[$ss]['username'])) {
	$_SESSION[$ss] = array();
}
  $_SESSION[$ss]['username'] = $info['user_name'];
  $_SESSION[$ss]['permissions'] = $info['permissions'];
  if ($info['user_id'] > 1) {
  	$_SESSION[$ss]['company_id'] = $info['company_id'];
  	// mark previous session as expired and create a new record
      $update_table = $db_object->query(
                   "UPDATE userlog 
                       SET result = 'expired', 
                           userlog_timestamp = '".$info['userlog_timestamp']."' 
                     WHERE user_id = '".$info['user_id']."' 
                       AND userlog_timestamp = '".$info['userlog_timestamp']."' 
                       AND data = '".$sid."'"); 
      if (DB::isError($update_table)) {
          die($update_table->getMessage());
      }
   $insert_userlog = $db_object->query("INSERT INTO userlog
                                                VALUES('".$info['user_id']."',
                                                       now(),
                                                       'success',
                                                       'recovered', 
                                                       '".$sid."')");

      if (DB::isError($insert_userlog)) {
    $second_attempt = $db_object->query("INSERT INTO userlog
                                                VALUES('".$info['user_id']."',
                                                       DATE_ADD(now(), INTERVAL 1 SECOND),
                                                       'success',
                                                       'recovered', 
                                                       '".$sid."')");
       if (DB::isError($second_attempt)) {
  	        die($second_attempt->getMessage());
       }
      }
  } else {
  	// administrator - use company stored in reason field if present
  	if ($info['reason'] != '') {
   	$_SESSION[$ss]['company_id'] = $info['reason'];
  	} else {
   	$_SESSION[$ss]['company_id'] = $info['company_id'];
  	}
  }
  if ($_SESSION[$ss]['company_id'] > 0) { // find company details in DB
        $row = $db_object->getRow("SELECT company_name,
                                          company_telephone,
                                          company_fax,
                                          company_email,
                                          company_code 
                                     FROM company 
                                    WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                      AND active_flag = 'Y'");

  $_SESSION[$ss]['company_code'] = $row['company_code']; 
  $_SESSION[$ss]['company_name'] = $row['company_name']; 
  $_SESSION[$ss]['company_telephone'] = $row['company_telephone'];
  $_SESSION[$ss]['company_fax'] = $row['company_fax'];
  $_SESSION[$ss]['company_email'] = $row['company_email'];
  } else { //company 0 details
        $_SESSION[$ss]['company_code'] = '00000'; 
        $_SESSION[$ss]['company_name'] = 'Esekey Limited'; 
        $_SESSION[$ss]['company_telephone'] = '07860 832741';
        $_SESSION[$ss]['company_fax'] = 'None';
        $_SESSION[$ss]['company_email'] = 'info@esekey.com';
  }

?>