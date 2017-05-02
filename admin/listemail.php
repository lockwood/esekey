<?php
// +----------------------------------------------------------------------+
// | LISTEMAIL  - Esekey Admin Console Generic List Page                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/listemail.php,v 1.01 2004/12/08
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
                      <td width="80" class="header-center" nowrap>Action</td>
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
                    $viewrow = $viewarray[$viewkey]; ?>
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
                            if ($name[$i] == 'sent_flag') {
                                $sent = $viewrow[$column[$i]];
                            } 
                            if ($list[$i] == 'Y') { ?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=html_entity_decode($viewrow[$column[$i]], ENT_QUOTES)?></td>
                                <?php
                            } 
                        } ?>
                        <td width="80" class="<?=$class?>-center" nowrap>
                        <a href="#" onClick="top.Top.GoToURL('1', 'Email Details [Ref=<?=$value?>]', 'edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&');">Details</a>
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
			<td height="33" align="right" valign="bottom" nowrap>
		<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
		
</div>

</body>
</html>