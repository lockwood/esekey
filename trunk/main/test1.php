<?php 
// +----------------------------------------------------------------------+
// | TEST1  - Displays php info and referral data                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/test1.php,v 1.00 2003/10/01
// 
session_start();
?>
<html>
<head>
<LINK REL="stylesheet" HREF="esestyles.css" TYPE="text/css">
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title>Test1</title>
</head>
<body>
Quick Test<br><br>

<a href="http://richardathome.no-ip.com/index.php?article_id=64">Click Here to test referral</a><br><br>
<?php 
echo 'GLOBALS<br>';
echo '<table>';
foreach ($GLOBALS as $key => $value) {
    echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
}
echo '</table>';
?>
</body>
</html>
