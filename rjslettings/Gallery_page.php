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
// : p.php,v 1.00 2003/10/01
//

$_GET['p'] = 8;
require('index.php');
?>