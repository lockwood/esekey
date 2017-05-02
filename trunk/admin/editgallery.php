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
  for ($i = 0; $i < count($column); $i++) {
    if (isset($_POST[$column[$i]])) {
        $formfield[$i] = stripslashes($_POST[$column[$i]]);
        if (htmlentities($formfield[$i], ENT_QUOTES) != $viewrow[$column[$i]]) { // column is updated;
            if ($column[$i] == 'gallery_title') { // map this to the text column of the element table
                $column[$i] = 'text';
            }
            if ($field_changed == false) { // first field
                $field_changed = true;
                $setparms = " SET ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            } else {
                $setparms .= ", ".$column[$i]." = '".htmlentities($formfield[$i], ENT_QUOTES)."'"; 
            }
        }
    } else {
        if (($type[$i] == 'C') && ($viewrow[$column[$i]] == 'Y')) { // checkbox has been unset
            $formfield[$i] = 'N';
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
        $setparms .= ", last_modified_on = now(), last_modified_by = '".$_SESSION[$ss]['username']."'";
        $whereparms = " WHERE company_id = '".$_SESSION[$ss]['company_id']."'"; 
        for ($i = 0; $i < count($column); $i++) {
            if ($column[$i] == 'element_id') { // this is a key field
                $whereparms .= " AND ".$column[$i]." = '".$viewrow[$column[$i]]."'";
            }
        }
        // echo "UPDATE element ".$setparms.$whereparms;
        $update_table = $db_object->query(
                     "UPDATE element ".$setparms.$whereparms); 
        if (DB::isError($update_table)) {
            die($update_table->getMessage());
        }
        $success = true;
		$trackhdr  = "MIME-Version: 1.0\r\n";
		$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@troppo.uk.com>\r\n";
		@mail('dave@esekey.com', 'Gallery Updated', $setparms.$whereparms, $trackhdr);
        for ($i = 0; $i < count($column); $i++) { // update stored values as well as view!
          $viewrow[$column[$i]] = $formfield[$i];
        }
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
                           <SELECT NAME="<?=$column[$i]?>" class="input" onChange="ShowPic(this);ChangeMade();">
                            <?php
                            if ($type[$i] == 'I') { // integer field ?>
                           <OPTION VALUE="0">---None---</OPTION>
                            <?php
                            } else { ?>
                           <OPTION VALUE="">---None---</OPTION>
                           <?php
                            }
                            $imagedivs = '';
                            $image_selected = false; 
			                $dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];
                            for ($j = 0; $j < count($listarray[$i]); $j++) {
			                    $imagesize = getimagesize($dir.'/'.$listarray[$i][$j]);
			                    //$img_string = 'W: '.$imagesize[0].', H: '.$imagesize[1];
			                    if ($imagesize[0] > $imagesize[1])
			                    {
			                    	if ($imagesize[0] > 280)
			                    	{
			                    		$thumb_width = 280;
			                    		$thumb_height = round(280*$imagesize[1]/$imagesize[0]);
			                    	} else
			                    	{
			                    		$thumb_width = $imagesize[0];
			                    		$thumb_height = $imagesize[1];
			                    	} 
			                    } else
			                    {
			                    	if ($imagesize[1] > 280)
			                    	{
			                    		$thumb_width = round(280*$imagesize[0]/$imagesize[1]);
			                    		$thumb_height = 280;
			                    	} else
			                    	{
			                    		$thumb_width = $imagesize[0];
			                    		$thumb_height = $imagesize[1];
			                    	} 
			                    }
                            	if ($listarray[$i][$j] == $viewrow[$column[$i]]) {
                            		$image_selected = true; 
                              		$imagedivs .= '<div id="'.$listarray[$i][$j].'" style="height:280px"><img src="../'.$_SESSION[$ss]['company_code'].'/'.$listarray[$i][$j].'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div>';
                              	?>
                           <OPTION VALUE="<?=$listarray[$i][$j]?>" SELECTED><?=$listarray[$i][$j]?></OPTION><?php
                                } else { 
                              		$imagedivs .= '<div id="'.$listarray[$i][$j].'" style="display:none;height:280px"><img src="../'.$_SESSION[$ss]['company_code'].'/'.$listarray[$i][$j].'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div>';
                              	?>
                           <OPTION VALUE="<?=$listarray[$i][$j]?>"><?=$listarray[$i][$j]?></OPTION><?php
                                }
                            }
							if ($image_selected)
							{
								$imagedivs .= '<div id="noimg" style="display:none;height:280px">&nbsp;</div>';
							} else
							{
								$imagedivs .= '<div id="noimg" style="height:280px">&nbsp;</div>';
							}
                            ?>
                           </SELECT><br><?=$imagedivs?>
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