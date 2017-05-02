<?php
// +----------------------------------------------------------------------+
// | ADD  - Esekey Admin Console generic add view row                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/add.php,v 1.01 2005/10/03
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

if (isset($_GET['view'])) {
    $view_name = $_GET['view'];
} else { // use POST when updating due to size of data
    $view_name = $_POST['view'];
    $posted = true;
}
// echo 'include getviewdata<br>';
include('getviewdata.php');

$lastrow = end($viewarray);

$success = false;
$field_changed = false;

// build titlebar string and populate any foreign key dropdowns
$add_title = '';
for ($i = 0; $i < count($column); $i++) {
    $viewrow[$column[$i]] = '';
    if ($unique[$i] == 'Y') {
        $viewrow[$column[$i]] = $lastrow[$column[$i]] + 1;
        if ($add_title == '') { // first keyfield
            $add_title .= '['.$label[$i].'='.$viewrow[$column[$i]];
        } else {
            $add_title .= ' '.$label[$i].'='.$viewrow[$column[$i]];
        }
    }
    if ($foreign_key[$i] != '') { // get list of keys from view
        include('getlistdata.php');
    }
}
$add_title .= ']';

if ($view_name == 'booking_view') { 
    // build composite editor for bookings
    // echo 'include editbooking<br>';
    include ('editbooking.php');
    return;
} 

// check for updated fields
if ($posted) { // if form has been submitted
  for ($i = 0; $i < count($column); $i++) {
    $formfield[$i] = $_POST[$column[$i]];
    if ($column[$i] == 'image_name') {
        $image_name = htmlentities($formfield[$i], ENT_QUOTES); 
    }
    if ($column[$i] == 'gallery_title') {
        $text = htmlentities($formfield[$i], ENT_QUOTES); 
    }
    if ($column[$i] == 'active_flag') {
        if ($formfield[$i] == 'Y') {
            $active_flag = 'Y';
        } else { 
            $active_flag = 'N';
        }
    }
  }
  $insert_string = "INSERT INTO element
                                            VALUES ('".$_SESSION[$ss]['company_id']."',
                                                    0,
                                                    0,
                                                    '".$image_name."',
                                                    NULL,
                                                    'top',
                                                    '".$text."',
                                                    '',
                                                    '".$active_flag."',
                                                    now(),
                                                    '".$_SESSION[$ss]['username']."',
                                                    now())";
  $insert_element = $db_object->query("INSERT INTO element
                                            VALUES ('".$_SESSION[$ss]['company_id']."',
                                                    0,
                                                    0,
                                                    '".$image_name."',
                                                    NULL,
                                                    'top',
                                                    '".$text."',
                                                    '',
                                                    '".$active_flag."',
                                                    now(),
                                                    '".$_SESSION[$ss]['username']."',
                                                    now())");
  if (DB::isError($insert_element)) {
      die($insert_element->getMessage());
  }
  
  // return element_id  //
  $element_id = mysql_insert_id();  
  $select = $db_object->getRow("SELECT t1.page_id,
                                   MAX(t1.sequence) AS sequence
                                  FROM page_element AS t1,
                                       page AS t2
                                 WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                   AND t1.page_id = t2.page_id
                                   AND t1.company_id = t2.company_id
                                   AND t2.content_source = 10
                              GROUP BY t1.page_id");
  $sequence = $select['sequence'] + 1;
  $insert_page_string = "INSERT into page_element
                                      VALUES('".$_SESSION[$ss]['company_id']."',
                                             '".$select['page_id']."',
                                             '".$sequence."',
                                             '".$element_id."',
                                             'Y',
                                             now(),
                                             '".$_SESSION[$ss]['username']."',
                                             now())";
  $insert_page_element = $db_object->query("INSERT into page_element
                                      VALUES('".$_SESSION[$ss]['company_id']."',
                                             '".$select['page_id']."',
                                             '".$sequence."',
                                             '".$element_id."',
                                             'Y',
                                             now(),
                                             '".$_SESSION[$ss]['username']."',
                                             now())");
  if (DB::isError($insert_page_element)) {
      die($insert_page_element->getMessage());
  }
  for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
    $viewrow[$column[$i]] = $formfield[$i];
  }
  $viewrow['element_id'] = $element_id;
  $viewrow['sequence'] = $sequence;
  $viewrow['last_modified_on'] = $db_object->getOne("SELECT now() + 0");
  $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
  $success = true;
  $msgtext = 'Gallery entry '.$sequence.' successfully added';
  $trackhdr  = "MIME-Version: 1.0\r\n";
  $trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@troppo.uk.com>\r\n";
  @mail('dave@esekey.com', $msgtext, $insert_string, $trackhdr);
}


?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//JavaScript Edit Validation Code

//-->
</script>

</head>
<?php
if ($success) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="Initialise('Add New <?=$add_title?>'); alert('<?=$msgtext?>'); top.Top.BackToURL('list.php?view=gallery')">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="Initialise('Add New <?=$add_title?>')">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">
<form action="add.php" name="frmAdd" id="frmAdd" method="post">
	
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
	
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <?php
                  $class = 'alt1';
                  for ($i = 0; $i < count($column); $i++) {
                        if (($unique[$i] == 'Y') | ($update[$i] == 'N')) { //part of key or not updateable - display as readonly text
                            ?>
                <tr>
                  <td width="40%" class="header-left"><?=$label[$i]?></td>
                  <td width="60%" class="<?=$class?>"><?=$viewrow[$column[$i]]?>
                            <?php
                        } elseif ($update[$i] == 'Y') { // field is updateable by user
                            ?> 
                <tr>
                  <td width="40%" class="header-left"><?=$label[$i]?></td>
                  <td width="60%" class="<?=$class?>">
                            <?php
                            if ($foreign_key[$i] != '') { // drop down list field ?>
                           <SELECT NAME="<?=$column[$i]?>" class="input" onChange="ChangeMade();">
                            <?php
                            if ($type[$i] == 'I') { // integer field ?>
                           <OPTION VALUE="0">---None---</OPTION>
                            <?php
                            } else { ?>
                           <OPTION VALUE="">---None---</OPTION>
                           <?php
                            } 
                            for ($j = 0; $j < count($listarray[$i]); $j++) {
                              if ($listarray[$i][$j] == $viewrow[$column[$i]]) { ?>
                           <OPTION VALUE="<?=$listarray[$i][$j]?>" SELECTED><?=$listarray[$i][$j].$list_desc_array[$i][$j]?></OPTION><?php
                              } else { ?>
                           <OPTION VALUE="<?=$listarray[$i][$j]?>"><?=$listarray[$i][$j].$list_desc_array[$i][$j]?></OPTION><?php
                              }
                            } ?>
                           </SELECT>
                           <?php
                            } elseif ($type[$i] == 'T') { // input text field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'I') { // input integer field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'D') { // input date field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == '4') { // input datetime field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="19" maxlength="19" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'E') { // input email field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'A') { // textarea field ?> 
                           <textarea name="<?=$column[$i]?>" cols="75" rows="15" class="input" onFocus="ChangeMade();"><?=$viewrow[$column[$i]]?></textarea> 
                            <?php 
                            } else { // checkbox
                                if ($viewrow[$column[$i]] == 'Y') {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" CHECKED onFocus="ChangeMade();">'; 
                                } else {
                                    echo '<input type="checkbox" name="'.$column[$i].'" value="Y" onFocus="ChangeMade();">'; 
                                } 
                            } 
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
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.BackToURL('list.php?view=<?=$view_name?>&srch1=<?=$srch1?>&op1=<?=$op1?>&val1=<?=$val1?>&sid=<?=$sid?>');">
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="submit" name="btnAdd" value="Add" class="button">
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="key" value="<?=$key?>">
      <input type="hidden" name="value" value="<?=$value?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>
</div>

</body>
</html>
<?php
// $Log: add.php,v $
?>