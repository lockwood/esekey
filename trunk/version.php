<?php
// +----------------------------------------------------------------------+
// | VERSION  - Esekey Admin Console release new code from FTP to live    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: version.php,v 1.00 2004/11/18
//

$dir = $DOCUMENT_ROOT;

echo $dir;
echo '<br>'.$_SERVER['PHP_SELF'];


$dirtree = split ('[/.\]', $_SERVER['PHP_SELF']);
$verpos = count($dirtree) - 3;
$verdir = $dir.'/main1';
//$verdir = $dir.'/'.$dirtree[$verpos];
//$verdir = $dir;
echo '<br>'.$verdir;

mkdir('/temp/test/');

if (is_dir($verdir)) {
    echo '<br>'.$verdir.' is a directory';
    if ($dh = opendir($verdir)) {
        echo '<br>Opened directory '.$verdir;
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

