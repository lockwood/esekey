<?php
// +----------------------------------------------------------------------+
// | LIST  - Esekey Admin Console Manage B&B Page                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2009 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/bbmanage.php,v 1.01 2009/01/28
//
$errors = false;
$updates = false;
$success = false;
$bb_1 = array();
$bb_2 = array();
$bb_1_2 = array();
$can_1 = array();
$can_2 = array();

//print_r($viewarray);
//die; 
foreach ($viewarray as $date=>$viewrow)
{
   	$bb_1[$date] = 0;
   	$bb_2[$date] = 0;
   	$bb_1_2[$date] = 0;
   	$can_1[$date] = 0;
   	$can_2[$date] = 0;
   	foreach ($combined_resourcearray as $resourcerow)
	{
		if (isset($viewrow[$resourcerow['property_name']]))
		{
			if ($viewrow[$resourcerow['property_name']] == 'E' && $resourcerow['active_bb'] != 'Y')
			{
				// resource is available
                if ($viewrow[$resourcerow['property_name'].'_sel']) {
                	$bb_1_2[$date]++;
                } 
			} elseif($viewrow[$resourcerow['property_name']] == 'E')
			{
				$bb_2[$date]++;
				$bb_1[$date]++;
			} else
			{
				// property is booked - count cancellable (non-Esekey) bookings
				if ($viewrow[$resourcerow['property_name'].'_ref'] == 1)
				{
					$can_1[$date]++;
				}
				if ($viewrow[$resourcerow['property_name'].'_ref'] == 2)
				{
					$can_2[$date]++;
				}
			}
		}
	}
}

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
					if (!($viewrow[$resourcerow['property_name'].'_sel']))
					{
						$viewarray[$date][$resourcerow['property_name'].'_sel'] = true;
						$bb_1_2[$date]++;
					}
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
					$viewarray[$date][$resourcerow['property_name'].'_sel'] = false;
					$bb_1_2[$date] = $bb_1_2[$date] - 1;
				}
			} else
			{
				// check if default price needs to be overriden for bb rooms
				//if ($viewrow[$resourcerow['property_name']] == 'E' && $resourcerow['active_bb'] == 'Y')
				if ($resourcerow['active_bb'] == 'Y')
				{
					if (($input_price_1 || $input_price_2) && !$errors)
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
					
				}
				// apply any updates to resources that are already booked in case of cancellation
				if ($viewrow[$resourcerow['property_name']] != 'E' && !$errors)
				{
					/*
					if ($resourcerow['active_bb'] == 'Y')
					{
						// bb sleeps 1/2
						$updates[] = "UPDATE calendar_event  
													SET	event_data = '".$viewarray[$date]['price_1'].",".$viewarray[$date]['price_2']."', 
														last_modified_by = '".$_SESSION[$ss]['username']."'
		                              				WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
													AND	  resource_id = ".$resourcerow['property_id']." 
													AND	  event_date = '".$date."' 
													AND	  event_type = 'B' ";
							
					}
					// */
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
			if ((isset($_GET[$date.'_res_1'])) && ($viewrow[$resourcerow['property_name']] == 'E'))
			{
				// attempt to reserve a single
				if ($bb_1[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_res_1']);
						$bb_1[$date] = $bb_1[$date] - 1;
						$bb_2[$date] = $bb_2[$date] - 1;
						$can_1[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '1',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 single reserved for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'C';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '1';
					}
				}
			}
			if ((isset($_GET[$date.'_res_1'])) && ($bb_1[$date] == 0) && ($resourcerow['active_bb'] == 'N') && ($viewrow[$resourcerow['property_name'].'_sel']) && ($viewrow[$resourcerow['property_name']] == 'E'))
			{
				// attempt to reserve SC as a single
				if ($bb_1_2[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_res_1']);
						$bb_1_2[$date] = $bb_1_2[$date] - 1;
						$can_1[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '1',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 SC single reserved for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'C';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '1';
					}
				}
			}
			if ((isset($_GET[$date.'_can_1'])) && ($resourcerow['active_bb'] == 'N') && ($viewrow[$resourcerow['property_name'].'_ref'] == '1'))
			{
				// attempt to cancel SC booked as a single
				if ($can_1[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_can_1']);
						$can_1[$date] = $can_1[$date] - 1;
						$bb_1_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '3',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 SC single cancelled for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'E';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '3';
					}
				}
			}
			if ((isset($_GET[$date.'_can_1'])) && ($viewrow[$resourcerow['property_name'].'_ref'] == '1'))
			{
				// attempt to cancel a single
				if ($can_1[$date] > 0)
				{
					
					if (!$errors)
					{
						// cancel
						unset($_GET[$date.'_can_1']);
						$can_1[$date] = $can_1[$date] - 1;
						$bb_1[$date]++;
						$bb_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '3',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 single cancelled for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'E';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '3';
					}
				}
			}
			if ((isset($_GET[$date.'_res_2'])) && ($resourcerow['sleeps'] == 2) && ($resourcerow['active_bb'] == 'Y') && ($viewrow[$resourcerow['property_name']] == 'E'))
			{
				// attempt to reserve a double
				if ($bb_2[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_res_2']);
						$bb_1[$date] = $bb_1[$date] - 1;
						$bb_2[$date] = $bb_2[$date] - 1;
						$can_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '2',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 double reserved for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'C';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '2';
					}
				}
			}
			if ((isset($_GET[$date.'_res_2'])) && ($bb_2[$date] == 0) && ($resourcerow['active_bb'] == 'N') && ($viewrow[$resourcerow['property_name'].'_sel']) && ($viewrow[$resourcerow['property_name']] == 'E'))
			{
				// attempt to reserve SC as a double
				if ($bb_1_2[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_res_2']);
						$bb_1_2[$date] = $bb_1_2[$date] - 1;
						$can_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '2',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 SC double reserved for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'C';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '2';
					}
				}
			}
			if ((isset($_GET[$date.'_can_2'])) && ($resourcerow['active_bb'] == 'N') && ($viewrow[$resourcerow['property_name'].'_ref'] == '2'))
			{
				// attempt to cancel SC booked as a double
				if ($can_2[$date] > 0)
				{
					
					if (!$errors)
					{
						// cancel
						unset($_GET[$date.'_can_2']);
						$can_2[$date] = $can_2[$date] - 1;
						$bb_1_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '3',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 SC double cancelled for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'E';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '3';
					}
				}
			}
			if ((isset($_GET[$date.'_can_2'])) && ($resourcerow['sleeps'] == 2) && ($viewrow[$resourcerow['property_name'].'_ref'] == '2'))
			{
				// attempt to cancel a double
				if ($can_2[$date] > 0)
				{
					
					if (!$errors)
					{
						// reserve
						unset($_GET[$date.'_can_2']);
						$can_2[$date] = $can_2[$date] - 1;
						$bb_1[$date]++;
						$bb_2[$date]++;
						$updates[] = "UPDATE calendar_booking
								        SET booking_reference = '3',
			            					last_modified_on = now(),
			            					last_modified_by = '".$_SESSION[$ss]['username']."'
			      						WHERE company_id = '".$_SESSION[$ss]['company_id']."'
			        					AND booking_date = '".$date."'
				        				AND resource_id = '".$resourcerow['property_id']."'";
						$messages[] = '1 double cancelled for '.$viewrow['display_date'];
						$viewarray[$date][$resourcerow['property_name']] = 'E';
						$viewarray[$date][$resourcerow['property_name'].'_ref'] = '3';
					}
				}
			}
		}
	}
	if ($updates) {
		//print_r($updates);
		//die;
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
$display_nav[] = date('d M y');
$nav[] = date('Y-m-d');
$nextweek = time();
for ($k = 1; $k <= 52; $k++) {
	$nextweek = $nextweek + (7 * 24 * 60 * 60);
	$display_nav[$k] = date('d M y', $nextweek);
    $nav[$k] = date('Y-m-d', $nextweek);
}


?>
<p>To add vacant self catering accommodation into both single and double B&B availability, tick the Property Settings boxes for the dates required and click the Update button.  
</p>
<p>To quickly add in or remove 3rd party B&amp;B reservations and keep the B&amp;B availability up to date, use the Reserve and Cancel tick boxes for the dates required.   
</p>
<p>B&amp;B online bookings made by visitors to the site will show a clickable Booking Reference number and can be managed in the same way as Self Catering bookings.    
</p>
<form action="list.php" name="frmEdit" id="frmEdit" method="get">
    <b>For week beginning:</b>
    <SELECT NAME="start_date" onChange="submit();">
<?php 
for ($k = 0; $k <= 52; $k++) {
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
				      <td class="header-center" rowspan="2">Date</td>
				      <td class="header-center" colspan="2">Price</td>
				      <td class="header-center" colspan="8">Property Settings</td>
				      <td class="header-center" colspan="3">Available</td>
				      <td class="header-center" colspan="2">Reserve</td>
				      <td class="header-center" colspan="2">Cancel</td>
			</tr>	
			<tr>	
				      <td class="header-center">Sgl</td>
				      <td class="header-center">Dbl/Twn</td>
				      <?php
					$colcount = 6;
				    foreach ($combined_resourcearray as $resourcerow)
					{
						echo '<td class="header-center" width="60">'.$resourcerow['property_name'].'</td>';
						$colcount++;
					}
				      ?>
				      <td class="header-center">Sgl</td>
				      <td class="header-center">Dbl/Twn</td>
				      <td class="header-center">SC</td>
				      <td class="header-center">Sgl</td>
				      <td class="header-center">Dbl</td>
				      <td class="header-center">Sgl</td>
				      <td class="header-center">Dbl</td>
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
								if ($viewrow[$resourcerow['property_name']] == 'E')
								{
									if ($resourcerow['active_bb'] != 'Y')
									{
										// SC resource is available - set up checkbox
	                                	if ($viewrow[$resourcerow['property_name'].'_sel']) {
	                                    	$chk = '<input type="checkbox" name="'.$date.$resourcerow['property_id'].'" value="1" CHECKED onFocus="ChangeMade();">'; 
	                                	} else {
	                                    	$chk = '<input type="checkbox" name="'.$date.$resourcerow['property_id'].'" value="1" onFocus="ChangeMade();">'; 
	                                	} 
										echo '<td class="'.$viewrow[$resourcerow['property_name']].'">'.$chk.'</td>';
									} else
									{
										echo '<td class="'.$viewrow[$resourcerow['property_name']].'">&nbsp;</td>';
									}
								} else
								{
									// resource is not available
									if ($viewrow[$resourcerow['property_name'].'_ref'] > 2)
									{
										$str = ' onMouseOver="doHover(this);return window.status=&#039;EseBooking&trade; &gt; Selected Booking&#039;;" onMouseOut="noHover(this);return window.status=&#039;&#039;;" onClick="top.Top.GoToURL(&#039;1&#039;, &#039;Edit Booking [Ref='.$viewrow[$resourcerow['property_name'].'_ref'].']&#039;, &#039;edit.php?view=booking_view&key=booking_reference&value='.$viewrow[$resourcerow['property_name'].'_ref'].'&&#039;);" nowrap >';
										echo '<td class="'.$viewrow[$resourcerow['property_name']].'" '.$str.$viewrow[$resourcerow['property_name'].'_ref'].'</td>';
									} else
									{
										echo '<td class="'.$viewrow[$resourcerow['property_name']].'">'.$viewrow[$resourcerow['property_name'].'_ref'].'</td>';
									}
								}
							}
						}
						 ?>
                         <td class="<?=$class?>-center"><?=$bb_1[$date]?></td>
                         <td class="<?=$class?>-center"><?=$bb_2[$date]?></td>
                         <td class="<?=$class?>-center"><?=$bb_1_2[$date]?></td>
                         <?php
						if ($bb_1[$date] > 0 || $bb_1_2[$date] > 0)
						{
	                        $chk = '<input type="checkbox" name="'.$date.'_res_1" value="1" onFocus="ChangeMade();">';
	                        echo '<td class="E">'.$chk.'</td>'; 
						} else
						{
	                        echo '<td class="C">NA</td>'; 
						}
						if ($bb_2[$date] > 0 || $bb_1_2[$date] > 0)
						{
	                        $chk = '<input type="checkbox" name="'.$date.'_res_2" value="1" onFocus="ChangeMade();">';
	                        echo '<td class="E">'.$chk.'</td>'; 
						} else
						{
	                        echo '<td class="C">NA</td>'; 
						}
						if ($can_1[$date] > 0)
						{
	                        $chk = '<input type="checkbox" name="'.$date.'_can_1" value="1" onFocus="ChangeMade();">';
	                        echo '<td class="E">'.$chk.'</td>'; 
						} else
						{
	                        echo '<td class="C">NA</td>'; 
						}
						if ($can_2[$date] > 0)
						{
	                        $chk = '<input type="checkbox" name="'.$date.'_can_2" value="1" onFocus="ChangeMade();">';
	                        echo '<td class="E">'.$chk.'</td>'; 
						} else
						{
	                        echo '<td class="C">NA</td>'; 
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
			<td height="33" valign="bottom" nowrap>&nbsp;
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