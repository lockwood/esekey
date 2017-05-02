<?php
// +----------------------------------------------------------------------+
// | Parameter   initialisation of EseSite runtime driver                 |
// | Provides static navigation wrapper, passing param 'p' to index.php   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: p.php,v 1.00 2003/10/01
//

// array will contain the document name (e.g. "p1")
$URLarray = split ('[/.\]', $_SERVER[PHP_SELF]);
// select the penultimate entry in the array: count() - 2;
// strip off the first character to get the actual page number
// and set it up as an HTTP GET parameter "p"
$_GET['p'] = substr($URLarray[(count($URLarray)-2)], 1);
require('index.php');
?>