<?php
// +----------------------------------------------------------------------+
// | RELEASE  - Esekey Admin Console release new code from FTP to live    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: release.php,v 1.00 2004/11/18
//

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

require ('db_connect.php');
// require our database connection

$dir = $DOCUMENT_ROOT;

echo $dir;
echo '<br>'.$_SERVER['PHP_SELF'];

if (!isset($_GET['p'])) { // no version directory specified - list available versions
    echo 'No password specified';
    return;
} else {
    if (!get_magic_quotes_gpc()) {
	    $_GET['u'] = addslashes($_GET['u']);
    }

    $check = $db_object->query("SELECT user_id,
                                       user_name, 
                                       password,
                                       permissions, 
                                       company_id 
                                  FROM user 
                                 WHERE user_name = '".$_GET['u']."'");
    $info = $check->fetchRow();
    if ($info == null) {
         echo 'Incorrect username or password, please try again.';
         $insert_userlog = $db_object->query("INSERT INTO userlog
                                              VALUES(0,
                                                     now(),
                                                     'fail',
                                                     'bad username', 
                                                      '".$_GET['u']."')");
         return;
    } else {
        // check passwords match
        $password = stripslashes($_GET['p']);
        $info['password'] = stripslashes($info['password']);
        $md5password = md5($password); 

        if ($md5password != $info['password']) {
	      echo 'Incorrect username or password, please try again.';
            $insert_userlog = $db_object->query("INSERT INTO userlog
                                                 VALUES($info[user_id],
                                                        now(),
                                                        'fail',
                                                        'bad password', 
                                                        '".$password."')");
            return;
        }
    }
}

$dirtree = split ('[/.\]', $_SERVER['PHP_SELF']);
$verpos = count($dirtree) - 3;
$verdir = $dir.'/'.$dirtree[$verpos];
echo '<br>'.$verdir;

// change our directory to the document root
chdir($DOCUMENT_ROOT);

if (is_dir($verdir)) {
    if ($dh = opendir($verdir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                echo '<br>'.$file;
                $filename = split ('[/.\]', $file);
                if (count($filename) == 1) { //directory
                    if (is_dir($verdir.'/'.$file)) {
                        echo ' (directory)';
                        if ($dh2 = opendir($verdir.'/'.$file)) {
                            while (($file2 = readdir($dh2)) !== false) {
                                if ($file2 != '.' && $file2 != '..') {
                                    echo '<br> >>'.$file2;
                                    if (($file == 'test') && ($file2 == 'template.php')) {
                                        echo '<br>>>>>>>>>>>>>>><br>>> Test Copy<br>>>>>>>>>>>>>>>';
                                        if (copy('/'.$dirtree[$verpos].'/'.$file.'/'.$file2, 
                                                 '/'.$dirtree[$verpos].'/'.$file.'/new'.$file2)) { // success
                                            echo '<br>'.$file2.' Copied';
                                        } else { 
                                            echo '<br>'.$file2.' Copy failed';
                                        }
                                    }
                                }
                            }
                            closedir($dh2);
                        }
                    }
                } 
            }
        }
        closedir($dh);
    }
}
?>

