<?php
// +----------------------------------------------------------------------+
// | VIEW  - Esekey Admin Console generic view table row                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/view.php,v 1.03 2004/12/08
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
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

$view_name = $_GET['view'];
$row = $_GET['row'];

include('getviewdata.php');
$viewrow = $viewarray[$row];
// build titlebar string and replace linebreaks with html breaks in textarea fields
$view_title = '';
for ($i = 0; $i < count($column); $i++) {
    if ($unique[$i] == 'Y') {
        if ($view_title == '') { // first keyfield
            $view_title .= '['.$label[$i].'='.$viewrow[$column[$i]];
        } else {
            $view_title .= ' '.$label[$i].'='.$viewrow[$column[$i]];
        }
    }
    if ($type[$i] == 'A') { // textarea field
        $viewrow[$column[$i]] = nl2br($viewrow[$column[$i]]);
    }
}
$view_title .= ']';

?>
<html>
<head>
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="SetTopText(' &gt; View <?=$view_title?>')">

<!-- Set Workarea -->
<div class="workarea">
<form action="view.php" name="frmView" id="frmView" method="POST">
	
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <?php
                  $class = 'alt1';
                  for ($i = 0; $i < count($column); $i++) { ?>
                      <tr>
                        <td width="20%" class="header-left"><?=$label[$i]?></td>
                        <td width="80%" class="<?=$class?>"><?=$viewrow[$column[$i]]?> 
                        </td>
                      </tr>
                      <?php
                      if ($class == 'alt1') {
                          $class = 'alt2';
                      }
                      else {
                          $class = 'alt1';
                      }
                  } ?>
		</table>

	</td></tr></table>		
	
	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.BackToURL('list.php?view=<?=$view_name?>&srch1=<?=$srch1?>&op1=<?=$op1?>&val1=<?=$val1?>&sid=<?=$sid?>');">				
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="srch1" value="<?=$srch1?>">
      <input type="hidden" name="op1" value="<?=$op1?>">
      <input type="hidden" name="val1" value="<?=$val1?>">
      <input type="hidden" name="row" value="<?=$row?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
</div>

</body>
</html>