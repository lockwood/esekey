<?php
// +----------------------------------------------------------------------+
// | EDIT  - Esekey Admin Console generic edit view row                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/edit.php,v 1.09 2006/11/23
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

if (isset($_GET['view'])) {
    $view_name = $_GET['view'];
    $key = $_GET['key'];
    $value = $_GET['value'];
} else { // use POST when updating due to size of data
    $view_name = $_POST['view'];
    $key = $_POST['key'];
    $value = $_POST['value'];
    $posted = true;
}
$keyarray = split('[,]', $key);
$valuearray = split('[,]', $value);
$view_namearray = split('[?]', $view_name);

if (isset($_GET['send'])) { // send email request
    include('sendemail.php');
} 


// echo 'include getviewrow<br>';
if ($view_name == 'dates' || $view_name == 'changeproperty')
{
	$saved_view_name = $view_name;
	$view_name = 'booking_view';
	// get booking view data before processing dates...
	include('getviewrow.php');
	$view_name = $saved_view_name;
} else 
{
	include('getviewrow.php');
}

$success = false;
$field_changed = false;
$nothing_changed = true; // to reset javascript changed flag to false on loading if nothing changed
$extraJS = '';

// build titlebar string and populate any foreign key dropdowns
$edit_title = '';
for ($i = 0; $i < count($column); $i++) {
    if ($unique[$i] == 'Y') {
        if ($edit_title == '') { // first keyfield
            $edit_title .= '['.$label[$i].'='.$viewrow[$column[$i]];
        } else {
            $edit_title .= ' '.$label[$i].'='.$viewrow[$column[$i]];
        }
    }
    if ($foreign_key[$i] != '') { // get list of keys from view
        include('getlistdata.php');
    }
}
$edit_title .= ']';

if ($view_name == 'promotions') {
	$extraJS = '
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(function() {
$( "#start_date" ).datepicker( { dateFormat: "dd/mm/yy" } );
$( "#end_date" ).datepicker( { dateFormat: "dd/mm/yy" } );
});
</script>
';
}

if ($view_name == 'element') { 
    // build element editor for sheephouse
    // echo 'include editelement<br>';
    include ('editshelement.php');
    return;
} 

if ($view_name == 'gallery') { 
    // build composite editor for gallery
    // echo 'include editgallery<br>';
    include ('editgallery.php');
    return;
} 

if ($view_name == 'price' && $_SESSION[$ss]['company_id'] == '00009') { 
    // build composite editor for accommodation windsor price
    // echo 'include editprice<br>';
    include ('editprice.php');
    return;
} 

if ($view_name == 'booking_view') { 
    // build composite editor for bookings
    // echo 'include editbooking<br>';
    include ('editbooking.php');
    return;
} 

if ($view_name == 'email' || $view_name == 'newemail') { 
    // build composite editor for email
    // echo 'include editemail<br>';
    include ('editemail.php');
    return;
} 

if ($view_name == 'dates') { 
    // build composite editor for editing booking dates
    // echo 'include editbookingdates<br>';
    include ('editbookingdates.php');
    return;
} 

if ($view_name == 'changeproperty') { 
    // build composite editor for changing property on a booking
    // echo 'include editbookingproperty<br>';
    include ('editbookingproperty.php');
    return;
} 

// check for updated fields
if ($posted) { // if form has been submitted
  for ($i = 0; $i < count($column); $i++) {
    if (isset($_POST[$column[$i]])) {
        $formfield[$i] = trim(stripslashes($_POST[$column[$i]]));
        if ($type[$i] == 'D') {
        	$curval = date('d/m/Y', strtotime($viewrow[$column[$i]]));
        } else {
        	$curval = $viewrow[$column[$i]];
        }
        if ($formfield[$i] != $curval) { // column is updated;
        	if ($type[$i] == 'D') { // date format
	        	$bits = explode('/',$formfield[$i]);
        		if ($field_changed == false) { // first field
	                $field_changed = true;
	                $setparms = " SET ".$column[$i]." = '".$bits[2]."-".$bits[1]."-".$bits[0]."'"; 
	            } else {
	                $setparms .= ", ".$column[$i]." = '".$bits[2]."-".$bits[1]."-".$bits[0]."'"; 
	            }
	            $viewrow[$column[$i]] = $bits[2]."-".$bits[1]."-".$bits[0];
	            // echo $viewrow[$column[$i]];
        	} else {
	        	if ($field_changed == false) { // first field
	                $field_changed = true;
	                $setparms = " SET ".$column[$i]." = '".mysql_real_escape_String($formfield[$i])."'"; 
	            } else {
	                $setparms .= ", ".$column[$i]." = '".mysql_real_escape_String($formfield[$i])."'"; 
	            }
	            $viewrow[$column[$i]] = $formfield[$i];
        	}
        }
    } else {
        if (($type[$i] == 'C') && ($viewrow[$column[$i]] == 'Y')) { // checkbox has been unset
            $formfield[$i] = 'N';
            $viewrow[$column[$i]] = 'N';
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " SET ".$column[$i]." = '".$formfield[$i]."'"; 
            } else {
                $setparms .= ", ".$column[$i]." = '".$formfield[$i]."'"; 
            }
        } else { // field unchanged; set formfield value to database value
            $formfield[$i] = $viewrow[$column[$i]];
        }
    }
  }
  if ($field_changed == true) {
        $nothing_changed = false;
        $setparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'";
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."'"; 
        for ($i = 0; $i < count($column); $i++) {
            if ($unique[$i] == 'Y') { // this is a key field
                $whereparms .= " AND ".$column[$i]." = '".$viewrow[$column[$i]]."'";
            }
        }
        if ($view_name == 'company') { 
            // company view has test and prod modes 
            $table_name = $view_name.$_SESSION[$ss]['_test']; 
        } else {
            $table_name = $view_name; 
        }
		if (!isset($_SESSION[$ss]['username'])) { // check if this is a logged in user - if not, redirect.
		    header("Location: https://".$servername."/admin/goto_login.php");
		}
		if (($_SESSION[$ss]['username'] != '') && ($_SESSION[$ss]['company_id'] != '')) { // check if this is a logged in user - if not, redirect.
	        // echo "UPDATE  ".$table_name.$setparms.$whereparms;
	        $update_table = $db_object->query(
	                     "UPDATE  ".$table_name.$setparms.$whereparms); 
	        if (DB::isError($update_table)) {
	            die($update_table->getMessage());
	        }
	        if ($view_name == 'property') {
	        	// check there is a location entry for the postcode - insert one if not
				$postcode_exists = false;
				$locations = $db_object->getAll("SELECT * FROM location where company_id = '".$_SESSION[$ss]['company_id']."' AND postcode like '".substr($viewrow['postcode'],0,3)."%'");
				if (count($locations) > 0) {
					foreach ($locations as $location) {
						if ($location['postcode'] == $viewrow['postcode']) {
							$postcode_exists = true;
						}
					}
					if (!$postcode_exists) {
						$insert = "INSERT INTO location VALUES( 0,
																'".$locations[0]['company_id']."',
																'".$locations[0]['name']."',
																'".$locations[0]['area']."',
																'".$locations[0]['description']."',
																'".$viewrow['postcode']."',
																'".$locations[0]['latitude']."',
																'".$locations[0]['longitude']."',
																'Y',
																'9999-01-01',
																now(),
																'".$_SESSION[$ss]['username']."',
																now())";
						$result = $db_object->query($insert);
						//print_r($result);
	        			if (DB::isError($result)) {
	            			die($result->getMessage());
	        			}
	        			$postcode_exists = true;
					}
				}
				if (!$postcode_exists) {
					$insert = "INSERT INTO location VALUES( 0,
															'".$_SESSION[$ss]['company_id']."',
															'".$_SESSION[$ss]['company_name']."',
															'Not known',
															'To be defined',
															'".$viewrow['postcode']."',
															'0',
															'0',
															'Y',
															'9999-01-01',
															now(),
															'".$_SESSION[$ss]['username']."',
															now())";
					$result = $db_object->query($insert);
        			if (DB::isError($result)) {
            			die($result->getMessage());
        			}
				}
	        }
	        $success = true;
		} else {
		    header("Location: https://".$servername."/admin/goto_login.php");
		}
        
		$trackhdr  = "MIME-Version: 1.0\r\n";
		$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
		@mail('dave@esekey.com', 'Table Updated', $table_name.$setparms.$whereparms, $trackhdr);
        /*
		for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
		// */
        $viewrow['last_modified_on'] = $db_object->getOne("SELECT now() + 0");
        $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
        // call generation script to publish static page(s) if relevant 
        include ('generate_changed.php');
  }

}


?>
<html>
<head>
<title><?=$title?></title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<script type="text/javascript" src="../main/fckeditor/fckeditor.js"></script>
<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

function LoadEditor() {
  if (document.getElementById('text')) {
	var oFCKeditor = new FCKeditor( 'text' ) ;
	oFCKeditor.ToolbarSet = 'Default' ;
	oFCKeditor.BasePath = "../main/fckeditor/" ;
	oFCKeditor.ReplaceTextarea() ;
  }
}


//JavaScript Edit Validation Code

//-->
</script>
<?=$extraJS?>
</head>
<?php
if ($success) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="LoadEditor();top.Top.SetChangedFlag(false); alert('Record Successfully Updated<?=$msgtext?>')">
<?php
} elseif ($nothing_changed) { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="LoadEditor();top.Top.SetChangedFlag(false);">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="LoadEditor();">
<?php
} ?>

<!-- Set Workarea -->
<div class="workarea">
<form action="edit.php" name="frmEdit" id="frmEdit" method="post">
	
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
                            if ($view_name == 'reviews') {
                            	// don't show id as part of the dropdown display
	                            for ($j = 0; $j < count($listarray[$i]); $j++) {
	                              if ($listarray[$i][$j] == $viewrow[$column[$i]]) { ?>
	                           <OPTION VALUE="<?=$listarray[$i][$j]?>" SELECTED><?=$list_desc_array[$i][$j]?></OPTION><?php
	                              } else { ?>
	                           <OPTION VALUE="<?=$listarray[$i][$j]?>"><?=$list_desc_array[$i][$j]?></OPTION><?php
	                              }
	                            }
							} else {
	                            for ($j = 0; $j < count($listarray[$i]); $j++) {
	                              if ($listarray[$i][$j] == $viewrow[$column[$i]]) { ?>
	                           <OPTION VALUE="<?=$listarray[$i][$j]?>" SELECTED><?=$listarray[$i][$j].$list_desc_array[$i][$j]?></OPTION><?php
	                              } else { ?>
	                           <OPTION VALUE="<?=$listarray[$i][$j]?>"><?=$listarray[$i][$j].$list_desc_array[$i][$j]?></OPTION><?php
	                              }
	                            }
							}  ?>
                           </SELECT>
                           <?php
                            } elseif ($type[$i] == 'T') { // input text field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="50" maxlength="80" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'I') { // input integer field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="8" maxlength="8" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'D') { // input date field 
								if ($viewrow[$column[$i]] != '') {
									// echo $viewrow[$column[$i]];
	                            	$date =  date('d/m/Y', strtotime($viewrow[$column[$i]]));
	                            	// echo $date;
								} else {
									$date = '';
								}
                            	?> 
                           <input type="text" name="<?=$column[$i]?>" id="<?=$column[$i]?>" value="<?=$date?>" size="10" maxlength="10" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == '4') { // input datetime field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="19" maxlength="19" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'E') { // input email field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'A') { // textarea field ?> 
                           <textarea name="<?=$column[$i]?>" id="<?=$column[$i]?>" cols="75" rows="15" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[$i]]?></textarea> 
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
                         onClick="top.Top.BackToURL('');">				
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="submit" name="btnUpdate" value="Update" class="button">
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
// $Log: edit.php,v $
?>