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
?>
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
                      <td class="header-center" nowrap>Edit</td>
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
                  for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey++) {
                    $viewrow = $viewarray[$viewkey];
                    if ($viewrow[image_name] == '')
                    {
                    	$img_string = '(No Image)';
                    } else
                    {
                    	$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];
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
                    }
                    ?>
                    <tr>
                    <?php
                        unset($key);
                        for ($i = 0; $i < count($column); $i++) {
                            if ($unique[$i] == 'Y') { // unique key field - needed for Edit link
                                if (!isset($key)) {
                                    $key = $name[$i];
                                    $value = $viewrow[$column[$i]];
                                } else {
                                    $key .= ','.$name[$i];
                                    $value .= ','.$viewrow[$column[$i]];
                                } 
                            }                               
                            if ($list[$i] == 'Y') { ?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=html_entity_decode($viewrow[$column[$i]], ENT_QUOTES)?></td>
                                <?php
                            } 
                        } ?>
                        <td class="<?=$class?>-center" nowrap>
                        <a href="edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&sid=<?=$sid?>"><?=$img_string?></a>
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
			<td height="33" valign="bottom" nowrap>&nbsp;				
			</td>
			<td height="33" align="right" valign="bottom" nowrap><?php
                    if ($view_name == 'gallery') { // option to create new gallery entries
                    	$pagearray = $db_object->getAll("SELECT page_id, page_name 
                                  FROM page
                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                   AND content_source = 10
                                   AND active_flag = 'Y'");
                    	$btnstring = '';
						foreach ($pagearray as $pagerow) {
						    $btnstring .= '<input type="button" value="Add New Exhibit to Page '.$pagerow['page_id'].'" class="button-cust"';
						    $btnstring .= ' onClick="if (confirm(\'This will create a new gallery entry in page '.$pagerow['page_id'].' ('.$pagerow['page_name'].') of the site. \n\nAre you sure you wish to continue?\')){top.Top.GoToURL(\'1\', \'Gallery List\', \'list.php?view=gallery&cre=1&page='.$pagerow['page_id'].'&\')};">';
						}
                    	?>
                        <form action="list.php" name="frmList" id="frmList" method="get">
                        <input type="hidden" name="view" value="<?=$view_name?>">
                        <input type="hidden" name="gen" value="1">
	                    <input type="hidden" name="sid" value="<?=$sid?>"><?=$btnstring?><input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();"></form><?php
                    } ?>
			</td>
		</tr>
	</table>
		
</div>

</body>
</html>