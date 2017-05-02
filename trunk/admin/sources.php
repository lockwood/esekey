<?php
// +----------------------------------------------------------------------+
// | SOURCES  - Esekey Admin Console Booking Sources (Troppo)             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/sources.php,v 1.00 2007/07/21
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
//print_r($_SESSION[$ss]);

include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

include ('wyhauoptions.php');
unset($wyhau_options[0]);
$view_name = 'sources';
$viewarray = array();
foreach ($wyhau_options as $source)
{
	$lastmonth =  $db_object->getOne("SELECT count(*) from booking where company_id = ".$_SESSION[$ss]['company_id']." and wyhau = '".$source."' and created_date > date_sub(now(), interval 1 month) ");
	$lastyear =  $db_object->getOne("SELECT count(*) from booking where company_id = ".$_SESSION[$ss]['company_id']." and wyhau = '".$source."' and created_date > date_sub(now(), interval 1 year) ");
	$viewarray[] = array('source'=>$source, 'lastmonth'=>$lastmonth, 'lastyear'=>$lastyear);
}
$today = $db_object->getOne("SELECT DATE_FORMAT(now(), '%W %D %M %Y')");

$pagerows= 20;
$firstrow = ($_SESSION[$ss]['pagenav'] - 1) * $pagerows;
$lastrow = $firstrow + $pagerows;
if ($lastrow > count($viewarray)) {
    $lastrow = count($viewarray);
}
if ($_SESSION[$ss]['pagenav'] == 1) {
    $firstpage = '[&lt;&lt;First]';
} else {
    $firstpage = '[<a href="list.php?view='.$view_name.'&pagenav=1&sid='.$sid.'">&lt;&lt;First</a>]';
}
if ($_SESSION[$ss]['pagenav'] > 1) {
    $prevpageno = $_SESSION[$ss]['pagenav'] -1;
    $prevpage = '[<a href="list.php?view='.$view_name.'&pagenav='.$prevpageno.'&sid='.$sid.'">&lt;Previous</a>]';
} else {
    $prevpage = '[&lt;Previous]';
}
$pages = ceil(count($viewarray)/$pagerows);
if ($_SESSION[$ss]['pagenav'] < $pages) {
    $nextpageno = $_SESSION[$ss]['pagenav'] + 1;
    $nextpage = '[<a href="list.php?view='.$view_name.'&pagenav='.$nextpageno.'&sid='.$sid.'">Next&gt;</a>]';
} else {
    $nextpage = '[Next&gt;]';
}
if ($_SESSION[$ss]['pagenav'] >= $pages) {
    $lastpage = '[Last&gt;&gt;]';
} else {
    $lastpage = '[<a href="list.php?view='.$view_name.'&pagenav='.$pages.'&sid='.$sid.'">Last&gt;&gt;</a>]';
}
?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title><?=$view_label?> List</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

function GoAdd() {

	window.location = 'add.php?view=<?=$view_name?>&sid=<?=$sid?>';

}

//-->
</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15">
<!-- Set Workarea -->
<div class="workarea">

    <!-- Page Number Links -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pagelinks">Booking Sources as at <?=$today?></td>
      </tr>
	</table>

	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
				      <td class="header-center">Booking Source</td>
                      <td width="<?=$actionwidth?>" class="header-center" nowrap>Last Month</td>
                      <td width="<?=$actionwidth?>" class="header-center" nowrap>Last Year</td>
			</tr>
                  <?php
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="<?=$colcount?>">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  }
                  foreach ($viewarray as $viewrow) { ?>
                    <tr>
                        <td class="<?=$class?>-left"><?=htmlentities($viewrow['source'])?></td>
                        <td width="<?=$actionwidth?>" class="<?=$class?>-center" nowrap><?=$viewrow['lastmonth']?></td>
                        <td width="<?=$actionwidth?>" class="<?=$class?>-center" nowrap><?=$viewrow['lastyear']?></td>
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
			<td height="33" valign="bottom" nowrap><?php
                    if ($view_name == 'page') { // option to generate static pages
                        ?>
                        <form action="list.php" name="frmList" id="frmList" method="get">
                        <input type="hidden" name="view" value="<?=$view_name?>">
                        <input type="hidden" name="gen" value="1">
	                    <input type="hidden" name="sid" value="<?=$sid?>">
				<input type="button" name="btnGen" value="Generate All Static Pages" class="button-cust" 
                         onClick="doConfirmSubmit('This option will regenerate all static pages on the site.\n\nAre you sure you wish to continue?');">
                    <?php
                    } else {
                        if ($level == 2) { ?>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.BackToURL('');"><?php
                        	if ($view_name == 'event_view' && $val2 == 'I') { ?>
				<input type="button" name="btnCre" value="Create from Booking" class="button-cust" 
                          onClick="if (confirm('This will clear all Invoice reminders for this booking and create new records based on the booking data. \n\nSelect Cancel if you do not wish to override existing reminders.')){top.Top.GoToURL('2', 'List Invoice Reminders', 'list.php?view=event_view&cre=1&srch1=t2.booking_reference&op1=EQ&val1=<?=$val1?>&srch2=t1.event_type&op2=EQ&val2=I&')};"><?php
                        	} 
                        } else { ?>				
                        &nbsp;				
                    <?php
                        }
                    } ?>
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
		<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
		
</div>

</body>
</html>