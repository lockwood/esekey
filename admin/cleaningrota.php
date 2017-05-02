<?php
// +----------------------------------------------------------------------+
// | LIST  - Esekey Admin Console List Event   Page                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/cleaningrota.php,v 1.00 2007/10/03
//


?>
<form action="list.php" name="frmList" id="frmList" method="get">
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
				      <td class="header-center">Date</td>
				      <td class="header-center" style="width:80px">Name</td>
				      <td class="header-center">Start/ Finish</td>
				      <td class="header-center">No. of hours</td>
				      <td class="header-center" style="width:100px">Property</td>
				      <td class="header-center">Guests</td>
				      <td class="header-center">Type</td>
				      <td class="header-center" style="width:100px">Arrival</td>
				      <td class="header-center" style="width:100px">Notes</td>
			</tr>
                  <?php
                  $colcount = 10;
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="<?=$colcount?>">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  }
                  foreach ($viewarray as $viewrow) { ?>
                    <tr>
                         <td class="<?=$class?>-center" nowrap><?=$viewrow['booking_date']?></td>
                         <td class="<?=$class?>-center"></td>
                         <td class="<?=$class?>-center"></td>
                         <td class="<?=$class?>-center"></td>
                         <td class="<?=$class?>-center" nowrap><?=$viewrow['property_name']?></td>
                         <td class="<?=$class?>-center"><?=$viewrow['number_adults']+$viewrow['number_infants']+$viewrow['number_children']?></td>
                         <td class="<?=$class?>-center"><?=$viewrow['event_data']?></td>
                         <td class="<?=$class?>-center"><?=$viewrow['event_data'] == 'FC' ? $viewrow['arrival_notes'] : ''?></td>
                         <td class="<?=$class?>-center"><?=$viewrow['booking_notes']?></td>
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
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
		<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="srch1" value="<?=$srch1?>">
      <input type="hidden" name="op1" value="<?=$op1?>">
      <input type="hidden" name="val1" value="<?=$val1?>">
      <input type="hidden" name="srch2" value="<?=$srch2?>">
      <input type="hidden" name="op2" value="<?=$op2?>">
      <input type="hidden" name="val2" value="<?=$val2?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>		
</div>

</body>
</html>