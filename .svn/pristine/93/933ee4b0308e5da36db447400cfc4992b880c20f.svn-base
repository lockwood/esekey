<?php
// +----------------------------------------------------------------------+
// | EDITELEMENT  - Esekey Admin Console edit element in popup            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2009 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editelement.php,v 1.00 2009/03/31
//


// check for updated fields
if ($posted) { // if form has been submitted
	for ($i = 0; $i < count($column); $i++) {
    if (isset($_POST[$column[$i]])) {
        $formfield[$i] = trim(stripslashes($_POST[$column[$i]]));
        if ($formfield[$i] != $viewrow[$column[$i]]) { // column is updated;
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " ".$column[$i]." = '".mysql_real_escape_String($formfield[$i])."'"; 
            } else {
                $setparms .= ", ".$column[$i]." = '".mysql_real_escape_String($formfield[$i])."'"; 
            }
            $viewrow[$column[$i]] = $formfield[$i];
        }
    } else {
        if (($type[$i] == 'C') && ($viewrow[$column[$i]] == 'Y')) { // checkbox has been unset
            $formfield[$i] = 'N';
            $viewrow[$column[$i]] = 'N';
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " ".$column[$i]." = '".$formfield[$i]."'"; 
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
        $setparms .= ", last_modified_on = now(), 
						last_modified_by = '".$_SESSION[$ss]['username']."',
        				company_id = '".$_SESSION[$ss]['company_id']."'"; 
        for ($i = 0; $i < count($column); $i++) {
            if ($unique[$i] == 'Y') { // this is a key field
                $setparms .= ", ".$column[$i]." = '".$viewrow[$column[$i]]."'";
            }
        }
		if (!isset($_SESSION[$ss]['username'])) { // check if this is a logged in user - if not, redirect.
		    header("Location: https://".$servername."/admin/goto_login.php");
		}
		if (($_SESSION[$ss]['username'] != '') && ($_SESSION[$ss]['company_id'] != '')) { // check if this is a logged in user - if not, redirect.
	        // echo "INSERT INTO element SET".$setparms." ON DUPLICATE KEY UPDATE".$setparms;
	        $update_table = $db_object->query("INSERT INTO element SET".$setparms." ON DUPLICATE KEY UPDATE".$setparms); 
	        if (DB::isError($update_table)) {
	            die($update_table->getMessage());
	        }
	        if ($element_id == 0)
	        {
	        	// insert page_element relationship row here
				$element_id = mysql_insert_id();
				// echo "New element Id: ".$element_id;
				if (!$current_sequence = $db_object->getOne("SELECT MAX(sequence) FROM page_element
															  WHERE company_id = '".$_SESSION[$ss]['company_id']."'
																AND page_id = '".$_POST['page']."' ")) 
					$current_sequence = 0;
				$next_sequence = $current_sequence + 1;
			  	$insert_page_string = "INSERT into page_element
			                                      VALUES('".$_SESSION[$ss]['company_id']."',
			                                             '".$_POST['page']."',
			                                             '".$next_sequence."',
			                                             '".$element_id."',
			                                             'Y',
			                                             now(),
			                                             '".$_SESSION[$ss]['username']."',
			                                             now())";
			  	$insert_page_element = $db_object->query($insert_page_string);
			  	if (DB::isError($insert_page_element)) {
			    	  die($insert_page_element->getMessage());
			  	}
			  	// now that row is inserted, refresh to reflect edit mode rather than add mode
		        $name = array();
		        $unique = array();
		        $list = array();
		        $type = array();
		        $update = array();
		        $foreign_key = array();
		        $label = array();
		        $justify = array();
		        $column = array();
			  	$btnlabel = 'Update'; 
				$valuearray = array($element_id);
				include('getviewrow.php');
	        }
	        $success = true;
		} else {
		    header("Location: https://".$servername."/admin/goto_login.php");
		}
        
		$trackhdr  = "MIME-Version: 1.0\r\n";
		$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
		@mail('dave@esekey.com', 'Table Updated', $table_name.$setparms, $trackhdr);
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
        $viewrow['last_modified_on'] = $db_object->getOne("SELECT now() + 0");
        $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
        // call generation script to publish static page(s) if relevant 
        include ('generate_changed.php');
  }

}
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



?>
<html>
<head><?php
if ($element_id == 0) { ?>
<title>Add Element to Page <?=$page_id?> <?=$edit_title?></title><?php
} else { ?>
<title>Edit Element <?=$edit_title?></title><?php
} ?>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>
<script type="text/javascript" src="../main/fckeditor/fckeditor.js"></script>
<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

function LoadEditor() {
	var oFCKeditor = new FCKeditor( 'text' ) ;
	oFCKeditor.ToolbarSet = 'Default' ;
	oFCKeditor.Height = '400' ;
	oFCKeditor.BasePath = "../main/fckeditor/" ;
	oFCKeditor.ReplaceTextarea() ;
}


//JavaScript Edit Validation Code

//-->
</script>

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
                  <td width="15%" class="header-left"><?=$label[$i]?></td>
                  <td width="85%" class="<?=$class?>"><?=$viewrow[$column[$i]]?>
                            <?php
                        } elseif ($update[$i] == 'Y') { // field is updateable by user
                            ?> 
                <tr>
                  <td width="15%" class="header-left"><?=$label[$i]?></td>
                  <td width="85%" class="<?=$class?>">
                            <?php
                            if ($foreign_key[$i] != '') { // drop down list field ?>
                           <SELECT NAME="<?=$column[$i]?>" class="input">
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
                           <textarea name="<?=$column[$i]?>" id="<?=$column[$i]?>" cols="100" rows="200" class="input" onKeyDown="ChangeMade();"><?=$viewrow[$column[$i]]?></textarea> 
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