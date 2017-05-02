<?php
// +----------------------------------------------------------------------+
// | STATUS  - Esekey Admin Console Page Statistics                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/pagestats.php,v 1.01 2006/01/30
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');

$pagearray = $db_object->getAll("SELECT t1.page_id, 
                                        t1.page_title,
                                        t1.page_name,
                                        count(*) AS hits
                                   FROM page AS t1,
                                        activity_log".$_SESSION[$ss]['_test']." AS t2
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                    AND t1.company_id = t2.company_id
                                    AND t1.page_id = t2.page_id
                                    AND t2.time_accessed > DATE_SUB(now(), INTERVAL 1 MONTH)
                                    AND t1.active_flag = 'Y'
                               GROUP BY t1.page_id
                               ORDER BY hits DESC");
$oldpagearray = $db_object->getAll("SELECT t1.page_id, 
                                        t1.page_title,
                                        t1.page_name,
                                        count(*) AS hits
                                   FROM page AS t1,
                                        activity_log".$_SESSION[$ss]['_test']." AS t2
                                  WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                    AND t1.company_id = t2.company_id
                                    AND t1.page_id = t2.page_id
                                    AND t2.time_accessed > DATE_SUB(now(), INTERVAL 2 MONTH)
                                    AND t2.time_accessed <= DATE_SUB(now(), INTERVAL 1 MONTH)
                                    AND t1.active_flag = 'Y'
                               GROUP BY t1.page_id
                               ORDER BY hits DESC");

?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title>Esekey Administration Console</title>
<link rel="stylesheet" href="theme/esekey.css" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//-->
</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15">
<p class = "text"><br>
<p class = "text"><b>Site Statistics:</b><br><br>
<table>
  <tr>
    <td class="text" valign="top" width="50%">Page hits on the site during the past month:<br><br>
      <table>
        <tr><td class="text"><b>Page Name</b></td><td class="text" style="text-align: right"><b>Hits</b></td>
        <?php
        foreach ($pagearray as $pagerow) { ?>
        <tr><td class="text"><a href="#" title="Page Title: <?=$pagerow[page_title]?>"><?=$pagerow[page_id]?>&nbsp;<?=$pagerow[page_name]?></a></td>
            <td class="text" style="text-align: right"><?=$pagerow[hits]?></td>
        </tr><?php
        }
        if (count($oldpagearray) > 0) {
        ?>
      </table>
    </td>
    <td class="text" valign="top" width="50%">Page hits on the site during the previous month:<br><br>
      <table>
        <tr><td class="text"><b>Page Name</b></td><td class="text" style="text-align: right"><b>Hits</b></td>
        <?php
            foreach ($oldpagearray as $pagerow) { ?>
        <tr><td class="text"><a href="#" title="Page Title: <?=$pagerow[page_title]?>"><?=$pagerow[page_id]?>&nbsp;<?=$pagerow[page_name]?></a></td>
            <td class="text" style="text-align: right"><?=$pagerow[hits]?></td>
        </tr><?php
            }
        } ?>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
