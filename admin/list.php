<?php
// +----------------------------------------------------------------------+
// | LIST  - Esekey Admin Console Generic List Page                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/list.php,v 1.06 2005/03/21
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

$view_name = $_GET['view'];
$message = false;
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');
if ($view_name == 'page' && $_GET['cre'] == 1) {
	include ('add_page.php');
    $message = true;
}
if ($view_name == 'gallery' && $_GET['cre'] == 1) {
	include ('add_gallery.php');
    $message = true;
}
include('getviewdata.php');

if (isset($_GET['gen'])) { //request to regenerate all static pages
    // echo 'Request to generate - starting<br>';
    include ('generate_all.php');
    // echo 'Request to generate - ending<br>';
    $message = true;
    $msgtext = 'Generate All - Results:'.$msgtext.'\nStatic Page Generation Complete';
}    
$actionwidth = "80";
if ($_SESSION[$ss]['company_id'] == '00009') $actionwidth = "40";
if ($view_name == 'user') {
	foreach ($viewarray as $viewrow) {
		if ($viewrow['user_name'] == $_SESSION[$ss]['username']) {
			// My User Profile
			$actionwidth = "140";
		}
	}
}
$pagerows= 20;
if ($view_name == 'price' && $_SESSION[$ss]['company_id'] == '00009') {
	$pagerows = 60; 
}
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
<head><?php
if (!isset($_GET['btnUpdate']) && !isset($_POST['btnUpdate']))
{
	?>
<meta http-equiv="REFRESH" content="600">
<?php	
}
	?>
<title><?=$view_label?> List</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

function GoAdd() {

	window.location = 'add.php?view=<?=$view_name?>&sid=<?=$sid?>';

}

//-->
</script>

</head>
<?php
if ($message) { // display message, then reload list without "gen" parameter so auto refresh doesn't regenerate pages //
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="alert('<?=$msgtext?>'); top.Top.BackToURL('list.php?view=<?=$view_name?>&sid=<?=$sid?>')">
<?php
} elseif (isset($uploadmsg)) { // display upload result message 
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="alert('<?=$msgtext?>');">
<?php
} elseif (isset($alert)) { // display alert message 
?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="alert('<?=$alert?>');">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15" onload="top.Top.SetChangedFlag(false);">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">

            <?php
            if ($view_name == 'event_view') { 
                $level = 2;
            } else {
                $level = 1;
            }
            if ($view_name == 'event_view') { 
                // build composite editor for events - filters with no page number links required 
                include ('listevent.php');
                return;
            }
            if ($view_name == 'cleaning') { 
                // build composite editor for cleaning rota - filters with no page number links required 
                include ('cleaningrota.php');
                return;
            }
            if ($view_name == 'bbmanage') { 
                // build composite editor for b&b options - filters with no page number links required 
                include ('bbmanage.php');
                return;
            } ?>
    <!-- Page Number Links -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pagelinks"><?=$firstpage?> &nbsp;<?=$prevpage?> &nbsp; 
        <?php
        $pageno = 1;
        if ($pageno == $_SESSION[$ss]['pagenav']) {
            echo '<b>'.$_SESSION[$ss]['pagenav'].'</b>&nbsp;';
        } else {
            ?>
            <a href="list.php?view=<?=$view_name?>&pagenav=<?=$pageno?>&sid=<?=$sid?>"><?=$pageno?></a>&nbsp;
            <?php
        }
        for ($totrows = count($viewarray)- $pagerows; $totrows > 0; $totrows = $totrows - $pagerows) {
          $pageno++;
          if ($pageno == $_SESSION[$ss]['pagenav']) {
              echo '<b>'.$_SESSION[$ss]['pagenav'].'</b>&nbsp;';
          } else {
              ?>
              <a href="list.php?view=<?=$view_name?>&pagenav=<?=$pageno?>&sid=<?=$sid?>"><?=$pageno?></a>&nbsp;
              <?php
          }
        } ?> 
<?=$nextpage?> &nbsp;<?=$lastpage?></td>
			<td align="right" class="pagelinks">Page <?=$_SESSION[$ss]['pagenav']?> / <?=$pageno?></td>
		</tr>
	</table>

	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
            <?php
            if ($view_name == 'gallery') { 
                // build composite editor for gallery
                if ($_SESSION[$ss]['company_id'] == '00004') {
	                include ($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/listgallery.php');
                } else {
                	include ('listgallery.php');
                }
                return;
            }
            if ($view_name == 'booking_view') { 
                // build composite editor for bookings
                include ('listbooking.php');
                return;
            }
            if ($view_name == 'email') { 
                // build composite editor for emails
                include ('listemail.php');
                return;
            }
            if ($view_name == 'image') { 
                // build composite editor for images
                if ($_SESSION[$ss]['company_id'] == '00004') {
	                include ($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/listimage.php');
                } else {
                	include ('listimage.php');
                }
                return;
            }
            if ($view_name == 'price' && $_SESSION[$ss]['company_id'] == '00009') { 
                // build composite editor for accommodation windsor prices
                include ('listprices.php');
                return;
            } ?>

		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                  <?php
                      $colcount = 1;
                      for ($i = 0; $i < count($label); $i++) {
                          if ($list[$i] == 'Y') { ?>
				      <td class="header-center"><?=$label[$i]?></td>
                              <?php
                              $colcount++;
                          } 
                      } ?>
                      <td width="<?=$actionwidth?>" class="header-center" nowrap>Action</td>
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
                  if ($view_name == 'page')
                  {
						// generate unique name for popup window target 
						$unique_name = time();
                  }
                  for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey++) {
                    $viewrow = $viewarray[$viewkey]; ?>
                    <tr>
                    <?php
                        unset($key);
                        $edit_title = '';
                        for ($i = 0; $i < count($column); $i++) {
                            if ($unique[$i] == 'Y') { // unique key field - needed for Edit link
                                if (!isset($key)) {
                                    $key = $name[$i];
                                    $value = $viewrow[$column[$i]];
                                } else {
                                    $key .= ','.$name[$i];
                                    $value .= ','.$viewrow[$column[$i]];
                                } 
                                // build titlebar string
                                if ($edit_title == '') { // first keyfield
                                    $edit_title .= '['.$label[$i].'='.$viewrow[$column[$i]];
                                } else {
                                    $edit_title .= ' '.$label[$i].'='.$viewrow[$column[$i]];
                                }
                            }
                            if ($list[$i] == 'Y') { 
                            	$listval = $viewrow[$column[$i]];
                            	if ($type[$i] == 'D') {
                            		//convert date format
									$listval = date('d M Y', strtotime($viewrow[$column[$i]]));
                            	}
                            	?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=$listval?></td>
                                <?php
                            } 
                        } 
                        $edit_title .= ']'; 
                        $property_name = '['; 
                        if (isset($viewrow['property_number'])) {
							$property_name .= $viewrow['property_number'].' ';
                        }
                        if (isset($viewrow['property_name'])) {                        	$property_name .= $viewrow['property_name'].']';                        	                        }?>
                        <td width="<?=$actionwidth?>" class="<?=$class?>-center" nowrap>
						<?php
						if (isset($viewrow['user_name']) && ($viewrow['user_name'] == $_SESSION[$ss]['username'])) {
							// My User Profile
						?>
						<a href="#" onClick="top.Top.GoToURL('<?=$level?>', 'Change Password <?=$edit_title?>', 'password.php?');">Change&nbsp;Password</a> |<?php
						} elseif ($view_name == 'property') { ?>
						<a href="#" onClick="top.Top.GoToURL('<?=$level?>', 'List Bookings <?=$property_name?>', 'list.php?view=booking_view&back=2&srch1=t4.property_id&op1=EQ&val1=<?=$value?>&');">List&nbsp;Bookings</a>&nbsp;|<?php
						} elseif ($view_name == 'enquiry_view') { ?>
						<a href="#" onClick="top.Top.GoToURL('<?=$level?>', '&nbsp;Edit <?=$edit_title?>', 'admin_search.php?enquiry_reference=<?=$value?>&');">Edit</a><?php
						} elseif ($view_name == 'page') { ?>
						<a href="../<?=$_SESSION[$ss]['company_code']?>/index.php?p=<?=$viewrow['page_id']?>&sid=<?=$sid?>" target="_<?=$unique_name++;?>">Page</a> |<?php
						} else { ?>
                        <a href="view.php?view=<?=$view_name?>&row=<?=$viewkey?>&sid=<?=$sid?>">View</a> |<?php
						}
						if ($view_name != 'enquiry_view') { ?><a href="#" onClick="top.Top.GoToURL('<?=$level?>', '&nbsp;Edit <?=$edit_title?>', 'edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&');">Edit</a><?php
						} ?>
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
			<td height="33" valign="bottom" nowrap><?php
                    if ($view_name == 'page') { // option to generate static pages
                    	$sectionarray = $db_object->getAll("SELECT section_id, 
                                       description
                                  FROM section
                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                   AND section_id <> 5
                                   AND active_flag = 'Y'");
                    	$btnstring = '';
						foreach ($sectionarray as $sectionrow) {
						    $btnstring .= '<input type="button" value="Section '.$sectionrow['section_id'].' Add Page" class="button-cust"';
						    $btnstring .= ' onClick="if (confirm(\'This will create a new blank page in section '.$sectionrow['section_id'].' ('.$sectionrow['description'].') of the site. \n\nAre you sure you wish to continue?\')){top.Top.GoToURL(\'1\', \'Page List\', \'list.php?view=page&cre=1&section='.$sectionrow['section_id'].'&\')};">';
						}
                    	?>
                        <form action="list.php" name="frmList" id="frmList" method="get">
                        <input type="hidden" name="view" value="<?=$view_name?>">
                        <input type="hidden" name="gen" value="1">
	                    <input type="hidden" name="sid" value="<?=$sid?>">
				<input type="button" name="btnGen" value="Generate All Static Pages" class="button-cust" 
                         onClick="doConfirmSubmit('This option will regenerate all static pages on the site.\n\nAre you sure you wish to continue?');"><?=$btnstring?></form><?php
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