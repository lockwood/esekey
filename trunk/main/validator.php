<?php
// +----------------------------------------------------------------------+
// | VALIDATOR  - include validation if required (called from idxs.php)   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/validator.php,v 1.00 2003/10/01
// 
if ($content_source == 8) {
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/combined_booking_validation.php');
} 
?>