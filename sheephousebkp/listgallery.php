<?php
// +----------------------------------------------------------------------+
// | LISTGALLERY  - Esekey Admin Console  List Gallery Page               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/listgallery.php,v 1.00 2004/11/15
//
$replaced_chars = array("$", "__", "_", ".jpg");
$replace_chars = array("'", ", ", " ", "");
/*
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $filename = split ('[/.\]', $file);
                if ((strtoupper(end($filename)) == 'JPG') && (substr($filename[0],0,3) == 'GGG')) {
                    $text = str_replace($replaced_chars, $replace_chars, substr($filename[0],6));
                    $filearray[] = array("image_name"=>$file, "text"=>$text);
                }
            }
        }
        closedir($dh);
    }
    sort($filearray); 
}
*/

?>
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                      <td class="header-center">Sequence</td>
                      <td class="header-center">Title</td>
                      <td class="header-center">Active</td>
                      <td class="header-center">Width</td>
                      <td class="header-center">Height</td>
                      <td class="header-center">Bytes</td>
                      <td class="header-center">Preview</td>
                      <td width="80" class="header-center" nowrap>Action</td>
			</tr>
                  <?php
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="200">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  }
                  $dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];
                  for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey++) {
                    $viewrow = $viewarray[$viewkey]; 
                   	$imagesize = getimagesize($dir.'/'.$viewrow['image_name']);
                   	//$img_string = 'W: '.$imagesize[0].', H: '.$imagesize[1];
                   	if ($imagesize[0] > $imagesize[1])
                   	{
                   		$thumb_width = 100;
                   		$thumb_height = round(100*$imagesize[1]/$imagesize[0]); 
                   	} else
                   	{
                   		$thumb_width = round(100*$imagesize[0]/$imagesize[1]);
                   		$thumb_height = 100;
                   	}
                   	$img_string = '<img src="../'.$_SESSION[$ss]['company_code'].'/'.$viewrow['image_name'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
                    $seq = substr($viewrow['image_name'],3,3); 
                    ?>
                    <tr>
                      <td class="<?=$class?>-center"><?=$seq?></td>
                      <td class="<?=$class?>-left"><?=str_replace($replaced_chars, $replace_chars, substr($viewrow['image_name'],6))?></td>
                      <td class="<?=$class?>-center"><?=$viewrow['active_flag']?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['image_size'][0]?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['image_size'][1]?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['file_size']?></td>
                      <td class="<?=$class?>-center"><?=$img_string?></td>
                      <td width="80" class="<?=$class?>-center" nowrap><a href="#" onClick="top.Top.GoToURL('<?=$level?>', '&nbsp;Edit Gallery Exhibit [Sequence=<?=$seq?>]', 'edit.php?view=<?=$view_name?>&key=image_name&value=<?=$viewrow['image_name']?>&');">Edit</a></td>
                    </tr>
                    <?php
                    if ($class == 'alt1') {
                        $class = 'alt2';
                    } else {
                        $class = 'alt1';
                    }
                  } ?>
		</table>

	</td></tr></table>
<br>		
		
<form enctype="multipart/form-data" action="list.php?view=gallery&srch1=gallery_id&op1=GT&val1=0" method="post">

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
            <tr>
                  <td class="table-border" colspan="3">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3">
			       <tr>
                            <td class="E">
                            	<?=$upload_error?>
                               <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                               <input type="hidden" name="sid" value="<?=$sid?>">Image to upload: 
                               <input name="userfile" type="file">&nbsp;&nbsp;Title:
                               <input type="text" name="title" value="<?=$title?>" size="50" maxlength="60" class="input">
                            </td>
                         </tr>
                     </table>
                 </td>
            </tr> 
		<tr>
			<td height="33" valign="bottom" nowrap>
                    <input type="submit" value="Upload" class="button">
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
</form>
		
</div>

</body>
</html>