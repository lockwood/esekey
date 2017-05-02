<?php
// +----------------------------------------------------------------------+
// | LISTBOOKING  - Esekey Admin Console List Booking Page                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/listbooking.php,v 1.03 2004/12/06
//
$level = '1';
if (isset($_GET['back']) && ($_GET['back'] == '2')) $level = '2';
if ($_SESSION[$ss]['permissions'] == 'ViewOnly')
{
	$action = 'View';
} else
{
	$action = 'Edit';
}
?>
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                  <?php
                      $colcount = 1;
                      for ($i = 0; $i < count($label); $i++) {
                          if (($list[$i] == 'Y') && ($label[$i] != 'Adults')) { 
                          	  if (($_SESSION[$ss]['permissions'] != 'ViewOnly') || (($label[$i] != 'Status') && ($label[$i] != 'Price'))) { ?>
				      <td class="header-center"><?=$label[$i]?></td>
                              <?php
                              	  $colcount++;
							  }	
                          } elseif (($label[$i] == 'Adults') && ($_SESSION[$ss]['permissions'] != 'ViewOnly')) { ?>
				      <td class="header-center">Guests</td><?php
                              $colcount++;
                          } elseif ($label[$i] == 'Adults') { ?>
				      <td class="header-center">Adults</td><td class="header-center">Children</td><td class="header-center">Infants</td><?php
                              $colcount+=3;
                          }
                      }
                      if ($_SESSION[$ss]['permissions'] == 'ViewOnly') { ?>
                      <td class="header-center">Notes</td><?php
					  } else { ?>
                      <td class="header-center" nowrap>Action</td><?php
					  } ?>
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
                        for ($i = 0; $i < count($column); $i++) {
                            if ($unique[$i] == 'Y') { // unique key field - needed for Edit/View link
                                $key = $name[$i];
                                $value = $viewrow[$column[$i]];
                            }                               
                            if (($list[$i] == 'Y') && ($column[$i] != 'number_adults')) { 
                            	if (($_SESSION[$ss]['permissions'] != 'ViewOnly') || (($column[$i] != 'booking_status') && ($column[$i] != 'total_amount'))) {?>
                                <td class="<?=$class?>-<?=$justify[$i]?>" nowrap><?=html_entity_decode($viewrow[$column[$i]], ENT_QUOTES)?></td>
                                <?php
								}
                            } elseif (($column[$i] == 'number_adults') && ($_SESSION[$ss]['permissions'] != 'ViewOnly')) {
                            	$number_guests = $viewrow['number_adults'] + $viewrow['number_children'] + $viewrow['number_infants'];
                            	?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=$number_guests?></td>
                            	<?php
                            } elseif ($column[$i] == 'number_adults') {	?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=$viewrow['number_adults']?></td>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=$viewrow['number_children']?></td>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=$viewrow['number_infants']?></td>
                            	<?php
                            }
                        } 
                        if ($_SESSION[$ss]['permissions'] != 'ViewOnly') { ?>
                        <td class="<?=$class?>-center" nowrap>
                        <a href="#" onClick="top.Top.GoToURL('<?=$level?>', '<?=$action?> Booking [Ref=<?=$value?>]', 'edit.php?view=<?=$view_name?>&key=<?=$key?>&value=<?=$value?>&');"><?=$action?></a>
                        </td><?php
						} else { ?>
						<td class="<?=$class?>-left"><?=$viewrow['booking_notes']?></td><?php
						} ?>
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
<?php
if (isset($_GET['back'])) {
	if ($_GET['back'] == '1') {
		// have come from availability
		$backparms = "top.Top.GoToURL('EseBooking', 'View Availability', 'admin_availability.php?');";		
	} else {
		// have come from property
		$backparms = "top.Top.GoToURL('EseBooking', 'Properties', 'list.php?view=property&');";
	}		
} else {
	// have come from status
	$backparms = "top.Top.GoToURL('EseCompany', 'Administration Home', 'status.php?');";		
} ?>

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap><input type="button" name="btnAdmin" value="Back" class="button" onClick="<?=$backparms?>" >
			</td>
			<td height="33" align="right" valign="bottom" nowrap><?php
if ($_SESSION[$ss]['permissions'] != 'ViewOnly')
{ ?>
				<input type="button" name="btnAddNew" value="Add New" class="button" onClick="top.Top.GoToURL('EseSite', 'New Booking', 'admin_booking_frame.php?');" ><?php
} ?>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
		
</div>

</body>
</html>