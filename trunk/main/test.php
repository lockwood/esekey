<?PHP
// +----------------------------------------------------------------------+
// | TEST  - Display php info etc..                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/test.php,v 1.00 2003/10/01
// 

session_start();
if (!isset($HTTP_SERVER_VARS['HTTP_REFERER'])) {
    $HTTP_SERVER_VARS['HTTP_REFERER'] = "dave"; 
}
list($p1, $p2, $p3, $p4) = explode("/", $DOCUMENT_ROOT);
echo '<br><br><a href="test1.php">Return to referring page</a><br><br>';
echo $p3.'<br/>';
/* Display php information*/ 
echo 'HTTP_SERVER_VARS<br>';
echo '<table>';
foreach ($HTTP_SERVER_VARS as $key => $value) {
    echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
}
echo '</table>';
phpinfo();

?> 
