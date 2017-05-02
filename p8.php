<?php
// +----------------------------------------------------------------------+
// | Parameter   initialisation of EseSite runtime driver                 |
// | Provides static navigation wrapper, passing param 'p' to index.php   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2016 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: p.php,v 2.00 2016/03/07
//

// array will contain the document name (e.g. "p1")
$segarray = explode('/', $_SERVER["PHP_SELF"]);
$segs = count($segarray);
$URLarray = explode('.', $segarray[$segs-1]);
// strip off the first character to get the actual page number
// and set it up as an HTTP GET parameter "p"
$_GET['p'] = substr($URLarray[0], 1);
require('index.php');
?>