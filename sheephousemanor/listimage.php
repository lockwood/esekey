<?php
// +----------------------------------------------------------------------+
// | IMAGE  - Esekey Admin Console Display and Upload Images (Co 4)       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: sheephousemanor/listimage.php,v 1.01 2004/11/15
//
$replaced_chars = array("$", "__", "_");
$replace_chars = array("'", ", ", " ");
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
                      <td class="header-center">Image</td>
                      <td class="header-center">Width</td>
                      <td class="header-center">Height</td>
                      <td class="header-center">Bytes</td>
                      <td class="header-center">Page Id</td>
                      <td class="header-center">Active</td>
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
                  for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey++) {
                    $viewrow = $viewarray[$viewkey]; ?>
                    <tr>
                      <td class="<?=$class?>-left"><?=$viewrow['image_name']?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['image_size'][0]?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['image_size'][1]?></td>
                      <td class="<?=$class?>-right"><?=$viewrow['file_size']?></td>
                      <td class="<?=$class?>-center"><?=$viewrow['page_id']?></td>
                      <td class="<?=$class?>-center"><?=$viewrow['active_flag']?></td>
                      <td width="80" class="<?=$class?>-center" nowrap><a href="https://<?=$servername.'/'.$_SESSION[$ss]['company_code'].'/'.$viewrow['image_name']?>" target="<?=$viewrow['image_name']?>">View</a>
                      <?php
                      if ($viewrow['page_id']== '') { ?> | 
                        <a href="javascript: GoDisable();">Delete</a>
                      <?php
                      } ?></td>
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
		
<form enctype="multipart/form-data" action="list.php?view=image&srch1=gallery_id&op1=GT&val1=0" method="post">

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
            <tr>
                  <td class="table-border" colspan="3">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3">
			       <tr>
                            <td class="E">	
                               <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                               <input type="hidden" name="sid" value="<?=$sid?>">Select Image for upload: 
                               <input name="userfile" type="file">
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