<?php
// +----------------------------------------------------------------------+
// | LISTPRICES  - Esekey Admin Console List Prices (9)Page               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/listprices.php,v 1.00 2007/03/04
//
?>
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                  <?php
                      $colcount = 1;
                      for ($i = 0; $i < count($label); $i++) {
                          if ($label[$i] == 'Start') { ?>
				      <td class="header-center">Valid From</td>
                              <?php
                              $colcount++;
                          } elseif ($label[$i] == 'Max Nights') { ?>
				      <td class="header-center">1-3 Wks</td>
				      <td class="header-center">4-11 Wks</td>
				      <td class="header-center">12+ Wks</td>
                              <?php
                              $colcount+=3;
                          } elseif ($list[$i] == 'Y' && $label[$i] != 'Daily Rate' && $label[$i] != 'Weekly Rate' && $label[$i] != 'Description') { ?>
				      <td class="header-center"><?=$label[$i]?></td><?php
                              $colcount++;
                          }
                      } ?>
                      <td class="header-center" nowrap>Action</td>
			</tr>
                 <?php
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="<?=$colcount?>">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  } else
                  {
 	                $price_code = '';
 	                $rowdata = array();
 	                $i = 0; 
                  	for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey+=3) {
    	                $viewrow = $viewarray[$viewkey];
    	                if ($viewrow['price_code'] == $price_code)
						{
							$i++; 
						} else
						{
							$price_code = $viewrow['price_code'];
							$i = 0;
						}
						if ($i == 0)
						{
							$date = substr($viewrow['start_date'],8,2).'-'.substr($viewrow['start_date'],5,2).'-'.substr($viewrow['start_date'],0,4);
							$rowdata[$price_code]['date'] = $date; 
							$rowdata[$price_code]['3wks'] = '£'.$viewrow['weekly_rate']; 
							$rowdata[$price_code]['11wks'] = '£'.$viewarray[$viewkey+1]['weekly_rate']; 
							$rowdata[$price_code]['12wks'] = '£'.$viewarray[$viewkey+2]['weekly_rate'];
						} elseif ($i == 1) 
						{
							$date = substr($viewrow['start_date'],8,2).'-'.substr($viewrow['start_date'],5,2).'-'.substr($viewrow['start_date'],0,4);
							$rowdata[$price_code]['date'] .= '<br/>'.$date; 
							$rowdata[$price_code]['3wks'] .= '<br/>£'.$viewrow['weekly_rate']; 
							$rowdata[$price_code]['11wks'] .= '<br/>£'.$viewarray[$viewkey+1]['weekly_rate']; 
							$rowdata[$price_code]['12wks'] .= '<br/>£'.$viewarray[$viewkey+2]['weekly_rate'];
						}
                  	}
                  	foreach ($rowdata as $price_code=>$row)
                  	{  ?>
                  <tr>
                  <td class="<?=$class?>-center"><?=$price_code?></td>
                  <td class="<?=$class?>-center"><?=$row['date']?></td>
                  <td class="<?=$class?>-center"><?=$row['3wks']?></td>
                  <td class="<?=$class?>-center"><?=$row['11wks']?></td>
                  <td class="<?=$class?>-center"><?=$row['12wks']?></td>
                    <?php
                        $edit_title = '[Price Code='.$price_code.']'; ?>
                        <td width="<?=$actionwidth?>" class="<?=$class?>-center" nowrap>
						<a href="#" onClick="top.Top.GoToURL('<?=$level?>', 'Edit <?=$edit_title?>', 'edit.php?view=<?=$view_name?>&key=price_code&value=<?=$price_code?>&');">Edit</a>
                        </td>
                 </tr>
                  <?php
                    	if ($class == 'alt1') {
                        $class = 'alt2';
                    	}
                    	else {
                        	$class = 'alt1';
                    	}
					}
                  } ?>
                  
 		</table>

	</td></tr></table>		
		

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap><input type="button" name="btnAdmin" value="Back" class="button" onClick="top.Top.GoToURL('EseCompany', 'Administration Home', 'status.php?');" >
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
</div>

</body>
</html>