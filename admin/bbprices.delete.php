<?php
// +----------------------------------------------------------------------+
// | LIST  - Esekey Admin Console List Event   Page                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/bbprices.php,v 1.01 2009/01/28
//
$errors = false;
$updates = false;
$success = false;
if (isset($_GET['btnUpdate']))
{
	// validate and perform updates if necessary
	foreach ($viewarray as $date=>$viewrow)
	{
		$input_price_1 = trim(stripslashes($_GET[$date.'_1'])); 
		if (!is_numeric($input_price_1)) 
		{
			$errors[] = 'Invalid amount specified for Sleeps 1 on '.$viewrow['display_date'];
			$viewarray[$date]['price_1'] =  $input_price_1;		
		} else
		{
			if ($input_price_1 != $viewrow['price_1'])
			{
				$messages[] = 'Sleeps 1 updated for '.$viewrow['display_date'];
				$viewarray[$date]['price_1'] =  $input_price_1;		
			} else
			{
				// unset to indicate no change
				$input_price_1 = false;
			}
		}
		$input_price_2 = trim(stripslashes($_GET[$date.'_2'])); 
		if (!is_numeric($input_price_2))
		{
			$errors[] = 'Invalid amount specified for Sleeps 2 on '.$viewrow['display_date']; 		
			$viewarray[$date]['price_2'] =  $input_price_2;		
		} else
		{
			if ($input_price_2 != $viewrow['price_2'])
			{
				$messages[] = 'Sleeps 2 updated for '.$viewrow['display_date'];
				$viewarray[$date]['price_2'] =  $input_price_2;		
			} else
			{
				// unset to indicate no change
				$input_price_2 = false;
			}
		}
    	foreach ($combined_resourcearray as $resourcerow)
		{
			if (isset($_GET[$date.$resourcerow['property_id']]) && (!($viewrow[$resourcerow['property_name'].'_sel']) || ($input_price_1 || $input_price_2) ))
			{
				// checkbox has been ticked and/or price has changed
				$messages[] = 'B&B prices selected for '.$resourcerow['property_name'].' for '.$viewrow['display_date'];
				$viewarray[$date][$resourcerow['property_name'].'_sel'] = true;
				if (!$errors)
				{
					$updates[] = "INSERT into calendar_event (	company_id, 
																resource_id, 
																event_date, 
																event_type, 
																event_data, 
																last_modified_by)
	                              						VALUES(	'".$_SESSION[$ss]['company_id']."', 
																".$resourcerow['property_id'].", 
																'".$date."', 
																'B', 
																'".$viewarray[$date]['price_1'].",".$viewarray[$date]['price_2']."',
																'".$_SESSION[$ss]['username']."' )
										ON DUPLICATE KEY UPDATE event_data = '".$viewarray[$date]['price_1'].",".$viewarray[$date]['price_2']."', 
																last_modified_by = '".$_SESSION[$ss]['username']."' ";
				}
			} elseif (!isset($_GET[$date.$resourcerow['property_id']])
						 && ($resourcerow['active_bb'] == 'N') 
					     && ($viewrow[$resourcerow['property_name'].'_sel']) 
					     && ($viewrow[$resourcerow['property_name']] == 'E'))
			{
				// checkbox has been unticked
				$messages[] = $resourcerow['property_name'].' removed from B&B availability for '.$viewrow['display_date'];
				$viewarray[$date][$resourcerow['property_name'].'_sel'] = false;
				if (!$errors)
				{
					$updates[] = "DELETE from calendar_event WHERE	company_id = '".$_SESSION[$ss]['company_id']."' 
															 AND	resource_id = ".$resourcerow['property_id']." 
															 AND	event_date = '".$date."' 
															 AND	event_type = 'B' ";
				}
			} else
			{
				// check if default price needs to be overriden for bb rooms
				if ($viewrow[$resourcerow['property_name']] == 'E' && $resourcerow['active_bb'] == 'Y')
				{
					if ($resourcerow['sleeps'] == 1 && $input_price_1 && !$errors)
					{
						$updates[] = "INSERT into calendar_event (	company_id, 
																	resource_id, 
																	event_date, 
																	event_type, 
																	event_data, 
																	last_modified_by)
		                              						VALUES(	'".$_SESSION[$ss]['company_id']."', 
																	".$resourcerow['property_id'].", 
																	'".$date."', 
																	'B', 
																	'".$input_price_1."',
																	'".$_SESSION[$ss]['username']."' )
											ON DUPLICATE KEY UPDATE event_data = '".$input_price_1."', 
																	last_modified_by = '".$_SESSION[$ss]['username']."' ";
							
					}
					if ($resourcerow['sleeps'] == 2 && $input_price_2 && !$errors)
					{
						$updates[] = "INSERT into calendar_event (	company_id, 
																	resource_id, 
																	event_date, 
																	event_type, 
																	event_data, 
																	last_modified_by)
		                              						VALUES(	'".$_SESSION[$ss]['company_id']."', 
																	".$resourcerow['property_id'].", 
																	'".$date."', 
																	'B', 
																	'".$input_price_2."',
																	'".$_SESSION[$ss]['username']."' )
											ON DUPLICATE KEY UPDATE event_data = '".$input_price_2."', 
																	last_modified_by = '".$_SESSION[$ss]['username']."' ";
							
					}
					
				}
				// apply any updates to resources that are already booked in case of cancellation
				if ($viewrow[$resourcerow['property_name']] != 'E' && !$errors)
				{
					if ($resourcerow['sleeps'] == 1  && $resourcerow['active_bb'] == 'Y')
					{
						// bb sleeps 1 only
						$updates[] = "UPDATE calendar_event  
													SET	event_data = '".$viewarray[$date]['price_1']."', 
														last_modified_by = '".$_SESSION[$ss]['username']."'
		                              				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
													AND	  resource_id = ".$resourcerow['property_id']." 
													AND	  event_date = '".$date."' 
													AND	  event_type = 'B' ";
							
					}
					if ($resourcerow['sleeps'] == 2 && $resourcerow['active_bb'] == 'Y')
					{
						// bb sleeps 2 only
						$updates[] = "UPDATE calendar_event  
													SET	event_data = '".$viewarray[$date]['price_2']."', 
														last_modified_by = '".$_SESSION[$ss]['username']."'
		                              				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
													AND	  resource_id = ".$resourcerow['property_id']." 
													AND	  event_date = '".$date."' 
													AND	  event_type = 'B' ";
							
													
					}
					if ($resourcerow['active_bb'] == 'N')
					{
						// sc
						$updates[] = "UPDATE calendar_event  
													SET	event_data = '".$viewarray[$date]['price_1'].",".$viewarray[$date]['price_2']."', 
														last_modified_by = '".$_SESSION[$ss]['username']."'
		                              				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
													AND	  resource_id = ".$resourcerow['property_id']." 
													AND	  event_date = '".$date."' 
													AND	  event_type = 'B' ";
							
													
					}
					
				}
			}
		}
	}
	if ($errors)
	{
		echo '<p style="color:red">';
		echo implode('<br>', $errors);
		echo '</p>';
	} else
	{
		// no errors - do updates
		if($updates)
		{
			foreach ($updates as $update)
			{
				$result = $db_object->query($update);
				// print_r($result);
       			if (DB::isError($result)) {
           			die($result->getMessage());
   				}
			}
			$success = true;
		}
	}
}

// print_r($viewarray);
$display_nav[] = date('d M');
$nav[] = date('Y-m-d');
$nextweek = time();
for ($k = 1; $k <= 20; $k++) {
	$nextweek = $nextweek + (7 * 24 * 60 * 60);
	$display_nav[$k] = date('d M', $nextweek);
    $nav[$k] = date('Y-m-d', $nextweek);
}


?>
<p>To add vacant self catering accommodation into both single and double B&B availability, tick the boxes for the selected dates and click the Update button.  
</p>
<form action="list.php" name="frmEdit" id="frmEdit" method="get">
    <b>For week beginning:</b>
    <SELECT NAME="start_date" onChange="submit();">
<?php 
for ($k = 0; $k <= 20; $k++) {
  if ($start_date == $nav[$k]) { ?>
      <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION>
<?php
  } else { ?>
      <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION>
<?php
  }
} ?>
    </SELECT><br><br>
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
				      <td class="header-center">Date</td>
				      <td class="header-center">Sleeps 1 Price</td>
				      <td class="header-center">Sleeps 2 Price</td><?php
					$colcount = 3;
				    foreach ($combined_resourcearray as $resourcerow)
					{
						if ($resourcerow['active_bb'] == 'Y')
						{
							echo '<td class="header-center" width="100">'.$resourcerow['property_name'].' ('.$resourcerow['sleeps'].')</td>';
						} else
						{
							echo '<td class="header-center" width="60">'.$resourcerow['property_name'].' (1/2)</td>';
						}
						$colcount++;
					}
				      ?>
			</tr>
                  <?php
                  $class = 'alt1';
                  foreach ($viewarray as $date=>$viewrow) {
                  		?>
                    <tr><?php
                    $txt1 = '<input type="text" name="'.$date.'_1" value="'.$viewrow['price_1'].'" size="3" maxlength="4" class="input" onFocus="ChangeMade();">';
                    $txt2 = '<input type="text" name="'.$date.'_2" value="'.$viewrow['price_2'].'" size="3" maxlength="4" class="input" onFocus="ChangeMade();">';
						?>
                         <td class="<?=$class?>-center" nowrap><?=$viewrow['display_date']?></td>
                         <td class="<?=$class?>-center"><?=$txt1?></td>
                         <td class="<?=$class?>-center"><?=$txt2?></td>
						<?php
				    	foreach ($combined_resourcearray as $resourcerow)
						{
							if (isset($viewrow[$resourcerow['property_name']]))
							{
								if ($viewrow[$resourcerow['property_name']] == 'E' && $resourcerow['active_bb'] != 'Y')
								{
									// resource is available - set up checkbox
	                                if ($viewrow[$resourcerow['property_name'].'_sel']) {
	                                    $chk = '<input type="checkbox" name="'.$date.$resourcerow['property_id'].'" value="1" CHECKED onFocus="ChangeMade();">'; 
	                                } else {
	                                    $chk = '<input type="checkbox" name="'.$date.$resourcerow['property_id'].'" value="1" onFocus="ChangeMade();">'; 
	                                } 
									echo '<td class="'.$viewrow[$resourcerow['property_name']].'">'.$chk.'</td>';
								} elseif($viewrow[$resourcerow['property_name']] != 'E')
								{
									// resource is not available
									$str = ' onMouseOver="doHover(this);return window.status=&#039;EseBooking&trade; &gt; Selected Booking&#039;;" onMouseOut="noHover(this);return window.status=&#039;&#039;;" onClick="top.Top.GoToURL(&#039;1&#039;, &#039;Edit Booking [Ref='.$viewrow[$resourcerow['property_name'].'_ref'].']&#039;, &#039;edit.php?view=booking_view&key=booking_reference&value='.$viewrow[$resourcerow['property_name'].'_ref'].'&&#039;);" nowrap >';
									echo '<td class="'.$viewrow[$resourcerow['property_name']].'" '.$str.$viewrow[$resourcerow['property_name'].'_ref'].'</td>';
								} else
								{
									// B&B is available
									echo '<td class="'.$viewrow[$resourcerow['property_name']].'" >&nbsp;</td>';
								}
							}
						}
						?>
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
                         onClick="history.back();">				
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
		<input type="submit" name="btnUpdate" value="Update" class="button">				
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
<?php 
if ($success)
{
	echo '<script type="text/javascript">alert("'.implode('\n', $messages).'")</script>';	
} ?>
</body>
</html>