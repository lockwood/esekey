<?php
// +----------------------------------------------------------------------+
// | EDITGALLERY  - Esekey Admin Console edit gallery image element row   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/editgallery.php,v 1.02 2005/10/03
//

// check for updated fields
if ($posted) { // if form has been submitted
    $replaced_chars = array("$", "__", "_", ".jpg");
	$replace_chars = array("'", ", ", " ", "");

	$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

	for ($i = 0; $i < count($column); $i++) {
	    if (isset($_POST[$column[$i]])) {
	        $formfield[$i] = stripslashes($_POST[$column[$i]]);
	        if (htmlentities($formfield[$i], ENT_QUOTES) != $viewrow[$column[$i]]) { // column is updated;
	            if ($column[$i] == 'gallery_title') {
	            	$field_changed = true;
	                $new_name = str_replace($replace_chars, $replaced_chars, $formfield[$i]);
	            }
	            if ($column[$i] == 'sequence') {
	            	$field_changed = true;
	                if (strlen($formfield[$i] < 3)) $formfield[$i] = str_pad($formfield[$i], 3, '0', STR_PAD_LEFT);
	                if (strlen($formfield[$i]) > 3) $formfield[$i] = substr($formfield[$i],0,3);
	                $new_seq = $formfield[$i];
	            }
	            if ($column[$i] == 'active_flag') {
	            	$field_changed = true;
	                $new_flag = 'G';
	            }
	        }
	    } else {
	        if (($type[$i] == 'C') && ($viewrow[$column[$i]] == 'Y')) { // checkbox has been unset
	            $formfield[$i] = 'N';
	            $field_changed = true;
	            $new_flag = 'N';
	        } else { // field unchanged; set formfield value to database value
	            $formfield[$i] = $viewrow[$column[$i]];
	        }
	    }
  }
  if ($field_changed == true) {
		$cur_filename = $viewrow['image_name'];
		$new_filename = 'GG';
		if (isset($new_flag)) {
			$new_filename .= $new_flag;
		} else {
			$new_filename .= $viewrow['active_flag'] == 'Y' ? 'G' : 'N';
		}
		if (isset($new_seq)) {
			$new_filename .= $new_seq;
		} else {
			$new_filename .= $viewrow['sequence'];
		}
		if (isset($new_name)) {
			$new_filename .= $new_name;
		} else {
			$new_filename .= str_replace($replace_chars, $replaced_chars, $viewrow['gallery_title']);
		}
        $bits = split ('[/.\]', $viewrow['image_name']);
        $new_filename .= '.'.end($bits);
		
		if (rename($dir.'/'.$cur_filename,$dir.'/'.$new_filename)) {
	  		$success = true;
			$trackhdr  = "MIME-Version: 1.0\r\n";
			$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@troppo.uk.com>\r\n";
			@mail('dave@esekey.com', 'Gallery Updated', $cur_filename.' renamed '.$new_filename, $trackhdr);
		}
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
        $viewrow['image_name'] = $new_filename;
        $viewrow['last_modified_on'] = $db_object->getOne("SELECT now() + 0");
        $viewrow['last_modified_by'] = $_SESSION[$ss]['username'];
  }

}


?>
<html>
<head>
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
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="Initialise('Edit <?=$edit_title?>'); alert('Record Successfully Updated<?=$msgtext?>')">
<?php
} else { ?>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" onload="Initialise('Edit <?=$edit_title?>')">
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
                  		if ($label[$i] == 'Exhibit') $label[$i] = 'Title';
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
                        if ($foreign_key[$i] != '') { // drop down list field -must be image 
                            $imagedivs = '';
                            $image_selected = false; 
			                $dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];
		                    $imagesize = getimagesize($dir.'/'.$viewrow['image_name']);
		                    //$img_string = 'W: '.$imagesize[0].', H: '.$imagesize[1];
		                    if ($imagesize[0] > $imagesize[1])
		                    {
		                    	if ($imagesize[0] > 480)
		                    	{
		                    		$thumb_width = 480;
		                    		$thumb_height = round(480*$imagesize[1]/$imagesize[0]);
		                    	} else
		                    	{
		                    		$thumb_width = $imagesize[0];
		                    		$thumb_height = $imagesize[1];
		                    	} 
		                    } else
		                    {
		                    	if ($imagesize[1] > 480)
		                    	{
		                    		$thumb_width = round(480*$imagesize[0]/$imagesize[1]);
		                    		$thumb_height = 480;
		                    	} else
		                    	{
		                    		$thumb_width = $imagesize[0];
		                    		$thumb_height = $imagesize[1];
		                    	} 
		                    }
                       		$imagedivs .= '<div id="'.$viewrow['image_name'].'"><img src="../'.$_SESSION[$ss]['company_code'].'/'.$viewrow['image_name'].'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div>';
							$imagedivs .= '<div id="noimg" style="display:none;">&nbsp;</div>';
                            ?>
                           <?=$imagedivs?>
                           <?php
                            } elseif ($type[$i] == 'T') { // input text field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="50" maxlength="50" class="input" onFocus="ChangeMade();">
                            <?php 
                            } elseif ($type[$i] == 'I') { // input integer field ?> 
                           <input type="text" name="<?=$column[$i]?>" value="<?=$viewrow[$column[$i]]?>" size="3" maxlength="3" class="input" onFocus="ChangeMade();">
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
// $Log: editgallery.php,v $
?>