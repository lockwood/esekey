<?php
// +----------------------------------------------------------------------+
// | LISTGALLERY  - Esekey Admin Console  List Commission Page            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/listcommission.php,v 1.01 2005/03/21
//
?>
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                      <td class="header-center"><?=$label[0]?></td>
                      <td class="header-center"><?=$label[4]?></td>
                      <td class="header-center"><?=$label[5]?></td>
                      <td class="header-center"><?=$label[6]?></td>
                      <td class="header-center" nowrap>Action</td>
			</tr>
                  <?php
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="5">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  }
                  $c_quarter = $viewarray[$firstrow][$column[0]];
                  $c_revenue = 0;
                  $c_commission = 0;
                  $c_status = 'Final';
                  for ($viewkey = $firstrow; $viewkey < count($viewarray); $viewkey++) {
                    $viewrow = $viewarray[$viewkey];
                    if ($viewrow[$column[0]] == $c_quarter) {
                        $c_revenue = $c_revenue + $viewrow[$column[4]];
                        $c_commission = $c_commission + $viewrow[$column[5]];
                        if ($viewrow[$column[6]] != 'Final') {
                            $c_status = $viewrow[$column[6]];
                        }
                    } else {
                    ?>
                    <tr>
                        <td class="<?=$class?>-center"><?=$c_quarter?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format($c_revenue,2)?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format($c_commission,2)?></td>
                        <td class="<?=$class?>-center"><?=$c_status?></td>
                        <td class="<?=$class?>-center" nowrap>
                        <a href="#" onClick="top.Top.GoToURL('1', 'Selected [Quarter=<?=$c_quarter?>]', 'list.php?view=commission&srch1=quarter&op1=EQ&val1=<?=$c_quarter?>&');">Details</a>
                        </td>
                    </tr>
                    <?php
                        if ($class == 'alt1') {
                            $class = 'alt2';
                        } else {
                            $class = 'alt1';
                        }
                        $c_quarter++;
                        if (substr($c_quarter,5,1) > 4) {
                            $c_year = substr($c_quarter,0,4);
                            $c_year++;
                            $c_quarter = $c_year.'Q1';
                        }
                        while ($c_quarter < $viewrow[$column[0]]) { ?>
                    <tr>
                        <td class="<?=$class?>-center"><?=$c_quarter?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format('0',2)?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format('0',2)?></td>
                        <td class="<?=$class?>-center">Final</td>
                        <td class="<?=$class?>-center" nowrap>
                        <a href="#" onClick="top.Top.GoToURL('1', 'Selected [Quarter=<?=$c_quarter?>]', 'list.php?view=commission&srch1=quarter&op1=EQ&val1=<?=$c_quarter?>');">Details</a>
                        </td>
                    </tr><?php
                          if ($class == 'alt1') {
                              $class = 'alt2';
                          } else {
                              $class = 'alt1';
                          }
                          $c_quarter++;
                          if (substr($c_quarter,5,1) > 4) {
                              $c_year = substr($c_quarter,0,4);
                              $c_year++;
                              $c_quarter = $c_year.'Q1';
                          }
                        }
                        $c_quarter = $viewrow[$column[0]];
                        $c_revenue = $viewrow[$column[4]];
                        $c_commission = $viewrow[$column[5]];
                        if ($viewrow[$column[5]] != 'Final') {
                            $c_status = $viewrow[$column[6]];
                        } else {
                            $c_status = 'Final';
                        }
                    }
                  } 
                  if (count($viewarray) > 0) { // only show row if there is data to display
                  ?>                    
                    <tr>
                        <td class="<?=$class?>-center"><?=$c_quarter?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format($c_revenue,2)?></td>
                        <td class="<?=$class?>-right"><?='£'.number_format($c_commission,2)?></td>
                        <td class="<?=$class?>-center"><?=$c_status?></td>
                        <td class="<?=$class?>-center" nowrap>
                        <a href="#" onClick="top.Top.GoToURL('1', 'Selected [Quarter=<?=$c_quarter?>]', 'list.php?view=commission&srch1=quarter&op1=EQ&val1=<?=$c_quarter?>&');">Details</a>
                        </td>
                    </tr><?php
                  } ?>
		</table>

	</td></tr></table>		
		

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>&nbsp;				
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnAdd" value="Add New" class="button" onClick="GoAdd();">
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
		
</div>

</body>
</html>