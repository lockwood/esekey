<?php
// +----------------------------------------------------------------------+
// | REDIRECT_BOOKING  - Direct user to first booking page (Company 1)    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/redirect_booking.php,v 1.00 2003/10/01
//
 
$url_parms = '?id='.$_SESSION[$ss]['company_id'].'&s=5&p=1&r=0&t=p&d='.$_SESSION[$ss]['date'];

header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$url_parms);

?>
