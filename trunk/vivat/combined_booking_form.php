<?php 
// +----------------------------------------------------------------------+
// | COMBINED_BOOKING_FORM  - captures daily booking/payment details      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 5/combined_booking_form.php,v 1.04 2006/02/06
//
if (isset($_SESSION[$ss]['booking_reference'])) { 
    // booking already made - show confirmation
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/confirm.php');
    return;
} ?>
<form name="eform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
  <input type="hidden" name="p" value="<?=$page_id?>">
    <?php
    if ($ss == 'User') {
    ?>
<p>Enter/amend your details and use the <i>Check Availability and Price</i> button to view the results. <br>Use the <i>Submit Booking</i> button to proceed. Your card details will NOT be validated online, and the booking will remain provisional until the card transaction is completed.
    <?php
    } else { ?>
<b>New Booking</b><input type="hidden" name="sid" value="<?=$sid?>" />
    <?php
    } ?>
  <table align="left" border="0" cellspacing="2" cellpadding="3">
    <?php
    if ($ss == 'User') {
    ?>
    <tr>
      <td class="righthead" colspan="2" style="vertical-align: middle"><b>Step One: Enter details of your stay and get a price</b></td>
      <td class="input" style="background-color: #BBFF88">
        <b>The price of your booking and other information will appear below.</b>
      </td>
    </tr>
    <?php
    } ?>
    <tr valign="top">
      <td align="left">
        <table align="left" border="0" cellspacing="1" cellpadding="1">
<?php
if ((isset($_GET['conditions']) && $_GET['conditions'] == 'Acptcl') || $fpc) { ?>
          <tr>
            <td align="left" colspan="3" nowrap class="input">
              <b>Arrival date:&nbsp;<?=$start_date_day?>&nbsp;<?=$d?>&nbsp;<?=$montharray[$m]?>&nbsp;<?=substr($y,2)?></b>
			  <input type="hidden" name="fpc" value="1">
			  <input type=hidden name="d" value="<?=$d?>">
			  <input type=hidden name="m" value="<?=$m?>">
			  <input type=hidden name="y" value="<?=$y?>">
			</td>
<?php	
} else { ?>
          <tr>
            <td align="right" class="input" nowrap>Arrive&nbsp;<?=$start_date_day?>
            </td>
            <td align="left"><SELECT NAME="d" class="input">
<?php 
for ($i=1; $i<=31; $i++) {
  if ($i == $d) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
            <td align="left" nowrap><SELECT NAME="m" class="input">
<?php 
for ($i=1; $i<=12; $i++) {
  if ($i == $m) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$montharray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$montharray[$i]?></OPTION><?php
  }
} ?>
              </SELECT>
              <SELECT NAME="y" class="input">
<?php
if ($y == $todayyear) { ?>
              <OPTION VALUE="<?=$todayyear?>" SELECTED><?=$todayyear?></OPTION><?php
} else { ?>
              <OPTION VALUE="<?=$todayyear?>"><?=$todayyear?></OPTION><?php
}
$nextyear = $todayyear + 1;
if ($y == $nextyear) { ?>
              <OPTION VALUE="<?=$nextyear?>" SELECTED><?=$nextyear?></OPTION><?php
} else { ?>
              <OPTION VALUE="<?=$nextyear?>"><?=$nextyear?></OPTION><?php
} ?>
              </SELECT>
            </td>
<?php
} ?>
          </tr>
          <tr>
            <td align="right" nowrap class="input">Stay
            </td><?php
if ($n == 1)
{
	$nt_label = "night,";
} else
{
  	$nt_label = "nights,";
}
if ($ss == 'User') {
    ?>
            <td><SELECT NAME="n" class="input">
<?php 
  $booking_pattern = 'D'; // daily
  if ($property_selected) {
  	foreach ($resourcearray as $propertyrow) {
  		if ($propertyrow['property_id'] == $selected_id) {
  			if (is_numeric($propertyrow['booking_pattern'])) {
  				// weekly booking pattern
  				$booking_pattern = 'W';
  			}
  		}
  	}
    for ($wk=1; $wk<=4; $wk++) {
	  $i = $wk * 7;
      if ($i == $n) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
      } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
      }
    }
  } else {
    for ($i=1; $i<=28; $i++) {
      if ($i == $n) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
      } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
      }
    }
  } ?>
              </SELECT>
            </td><?php
} else { 
    ?>
            <td><input type="text" class="input" name="n" size="3" maxlength="3" value="<?=$n?>"><?php
} ?>
            </td>
            <td class="input" nowrap><?=$nt_label?>&nbsp;depart&nbsp;<?=$departure_date_day?>&nbsp;<?=$departure_date?></td>
          </tr>
          <tr>
            <td align="right" nowrap class="input">For
            </td>
            <td align="right">
              <SELECT NAME="g" class="input">
<?php 
for ($i=1; $i<=5; $i++) {
  if ($i == $g) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
            <td align="left" nowrap class="input">&nbsp;Adults / Over 5&#039;s
            </td>
          </tr>
          <tr>
            <td align="right" nowrap class="input">and
            </td>
            <td align="right">
              <SELECT NAME="c" class="input">
<?php 
for ($i=0; $i<=5; $i++) {
  if ($i == $c) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
            <td align="left" nowrap class="input">&nbsp;Under 5&#039;s (free)
            </td>
          </tr>
        </table>
      </td>
      <td>
        <table border="0" cellspacing="1" cellpadding="1">
<?php   
if (count($resourcearray) == 1) { // Select single property by default
 ?>
          <tr>
            <td align="right" nowrap class="input">Location: <?=$resourcearray[0]['property_name']?></td>
            <td align="left">
              <INPUT TYPE="hidden" NAME="r<?=$resourcearray[0]['property_id']?>" VALUE="1"></td>
          </tr>
<?php
} elseif ((isset($_GET['conditions']) && $_GET['conditions'] == 'Acptcl') || $fpc) { 
	foreach ($resourcearray as $propertyrow) {
		if ($r[$propertyrow['property_id']] == "CHECKED") {
			// set up goback button for use later on
			$goback = '<input type="button" name="goBack" value="Go Back to Calendar" align="right" onClick="document.location.href=';
			$goback .= "'p3.php?property=".$propertyrow['property_id']."&popup=1&bk=1'";
			$goback .= '">';
	?>
          <tr>
            <td align="right" nowrap class="input"><b>Location: <?=$propertyrow['property_name']?></b></td>
            <td align="left"><b>
              <INPUT TYPE="hidden" NAME="r<?=$propertyrow['property_id']?>" VALUE="1"></b></td>
          </tr>
          <tr>
            <td colspan="2" nowrap class="input">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" nowrap class="input">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" nowrap class="input">&nbsp;</td>
          </tr>
<?php
		}
	}
} else
{
	if (count($booking_patterns) > 1) {
		// incompatible booking patterns - can only book one property at a time
		$property_string = '<SELECT NAME="property" class="input">';
		foreach ($resourcearray as $propertyrow) {
			if ($propertyrow['property_id'] == $selected_id) {
				$property_string .= '
	      <OPTION VALUE="'.$propertyrow['property_id'].'" SELECTED>'.$propertyrow['property_name'].'</OPTION>';
			} else {
				$property_string .= '
	      <OPTION VALUE="'.$propertyrow['property_id'].'">'.$propertyrow['property_name'].'</OPTION>';
			}
		}
		$property_string .= '</SELECT><br />'; ?>
          <tr>
            <td align="right" nowrap class="input">Choose</td>
            <td align="left" class="input">
              <?=$property_string?></td>
          </tr>
<?php   
	} else
	{
		// compatible booking patterns - can have multiple properties in one booking
		foreach ($resourcearray as $propertyrow) { ?>
          <tr>
            <td align="right" nowrap class="input"><?=$propertyrow['property_name']?></td>
            <td align="left">
              <INPUT TYPE="checkbox" NAME="r<?=$propertyrow['property_id']?>" VALUE="1" <?=$r[$propertyrow['property_id']]?>></td>
          </tr>
<?php   
		}
	}
}
// add optional extras
foreach ($labels as $index=>$label) {
    ?>
          <tr> 
            <td align="right" nowrap class="input"><?=$label?></td>
            <td align="left">
              <INPUT TYPE="checkbox" NAME="o<?=$index?>" VALUE="1" <?=$o[$index]?>>
            </td>
          </tr>
<?php
}
?>
        </table>
      </td> 
      <td rowspan="2">
        <table border="0" cellspacing="2" cellpadding="3" align="left">
    <?php
    if (isset($error1)) {
        if (!isset($_GET['conditions'])) { ?>
          <tr>
            <td class="input" style="color: red"><b>The following amendments are required:</b></td>
          </tr>
          <tr>
            <td class="input" style="color: red" valign="top"><b><?=$error1?></b></td>
          </tr>
    <?php
        }
    } else { ?>
          <tr>
            <td valign="top">
              <table align="left" border="0" cellspacing="2" cellpadding="3">
                <tr>
          <?php 
          if ($deposit_rate < 1) { // deposit due now, balance 4 weeks before arrival.
          		if ($advance_days > 10 )
          		{
          			$balance_due = $advance_days." days before ";
          		} else
          		{
          			$balance_due = "on ";
          		}
          ?>
                  <td class="input"><b>Amount due on booking <br>(<?=$deposit_rate * 100?>% Deposit):</b></td>
                  <td align="right" valign="top" class="input"><b><?='£'.number_format($deposit,2)?></b></td>
                </tr>
                <tr>
                  <td class="input"><b>Balance <br>(due <?=$balance_due?>arrival):</b></td>
                  <td align="right" valign="top" class="input"><b><?='£'.number_format($balance,2)?></b></td>
                </tr>
                <tr>
                  <td nowrap class="input"><b>Total Price:</b></td>
                  <td align="right" class="input"><b><?='£'.number_format($price,2)?></b></td>
          <?php
          } else { // Full amount is due
          ?>
                  <td nowrap class="input"><b>Total Price:</b></td>
                  <td align="right" class="input"><b><?='£'.number_format($price,2)?></b></td>
          <?php
          }
          ?>
                </tr>
                <tr>
                  <td colspan="2" class="input" valign="top"><?=$additional_info?></td>
                </tr>
              </table>
            </td>
          </tr>
    <?php
    } ?>
        </table>
      </td>
    </tr>
    <?php
    if ($ss == 'Admin') {
    ?>
    <tr>
      <td colspan="2" nowrap><input type="submit" name="checkPrice" value="Check Availability and Price" align="right"><span class="input" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Send&nbsp;email notification</span><span align="left"><INPUT TYPE="checkbox" NAME="em" VALUE="1" <?=$em?>></span></td>
    </tr>
      <?php
      if (!isset($error1)) { ?>
      <tr><td colspan="3" class="input" align="right">&nbsp;Agreed&nbsp;Price&nbsp;£<input type="text" class="input" name="ap" size="10" maxlength="8" value="<?=$ap?>"></td></tr>
      <?php 
      }
    } else {
    ?>
    <tr>
      <td><input type="submit" name="checkPrice" value="Check Availability and Price" align="right"></td><td><?=$goback?></td>
    </tr>
    <tr>
      <td class="righthead" colspan="2" style="vertical-align: middle"><b>Step Two: Enter your personal and payment details</b></td>
      <td class="input">
        <b>&nbsp;<br>&nbsp;</b>
      </td>
    </tr>
    <?php
    } 
    ?>
    <tr>
      <td style="vertical-align: top">
        <table align="left" border="0" cellspacing="1" cellpadding="1"><?php
          if ($ss == 'Admin') { ?>
          <tr>
            <td align="right" class="input">Customer</td>
            <td colspan="3"><?php
              include('dropdown.php');
              ?>
            </td>
          </tr>
          <?php
          } ?>
          <tr>
            <td class="input">&nbsp;</td>
            <td class="input">Title</td>
            <td nowrap class="input">First Name</td>
            <td nowrap class="input">Last Name</td>
          </tr>
          <tr>
            <td align="right" class="input">Name</td>
            <td>
    <SELECT NAME="t" class="input">
<?php 
for ($i=1; $i<count($titlearray); $i++) {
  if ($i == $t) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$titlearray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$titlearray[$i]?></OPTION><?php
  }
} ?>
    </SELECT>
            </td>
            <td><input type="text" class="input" name="f" size="8" maxlength="20" value="<?=$f?>">
            </td>
            <td><input type="text" class="input" name="l" size="12" maxlength="25" value="<?=stripslashes($l)?>">
            </td>
          </tr>
          <tr>
            <td nowrap align="right" valign="top" class="input">Address
            </td>
            <td align="left" colspan="3"><textarea name="a" cols="35" rows="3" class="input"><?=$a?></textarea>
            </td>
          </tr>
          <tr>
            <td nowrap align="right" class="input">Post Code
            </td>
            <td align="left" colspan="3" class="input"><input type="text" class="input" name="q" size="10" maxlength="8" value="<?=$q?>">
            &nbsp;OR&nbsp;tick<INPUT TYPE="checkbox" NAME="ouk" VALUE="1" <?=$ouk?>>&nbsp;if outside UK
            </td>
          </tr>
          <tr>
            <td align="right" class="input">Phone
            </td>
            <td align="left" colspan="3"><input type="text" class="input" name="u" size="30" maxlength="50" value="<?=$u?>">
            </td>
          </tr>
          <tr>
            <td align="right" class="input">Email
            </td>
            <td align="left" colspan="3"><input type="text" class="input" name="e" size="30" maxlength="50" value="<?=$e?>">
            </td>
          </tr>
        </table>
      </td>
      <td style="vertical-align: top">
        <table align="left" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td align="right" nowrap class="input">Card Type:</td>
            <td>
              <SELECT NAME="w" class="input">
<?php 
for ($i=1; $i<count($cardarray); $i++) {
  if ($i == $w) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$cardarray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$cardarray[$i]?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          <tr>
            <td align="right" class="input">Card&nbsp;Number:</td>
            <td align="left">
              <input type="text" class="input" name="z" size="19" maxlength="19" value="<?=$z?>">
            </td>
          </tr>
          <tr>
            <td align="right" class="input">From&nbsp;(Maestro):</td><td align="left">
              <SELECT NAME="fm" class="input">
<?php 
for ($i=1; $i<=12; $i++) {
  if ($i == $fm) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$xmntharray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$xmntharray[$i]?></OPTION><?php
  }
} ?>
              </SELECT>
              <SELECT NAME="fy" class="input">
<?php
for ($fromyear=$todayyear-5; $fromyear<=($todayyear); $fromyear++) {
  if ($fy == $fromyear) { ?>
              <OPTION VALUE="<?=$fromyear?>" SELECTED><?=$fromyear?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$fromyear?>"><?=$fromyear?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          </tr>
          <tr>
            <td align="right" class="input">Expiry Date:</td><td align="left">
              <SELECT NAME="xm" class="input">
<?php 
for ($i=1; $i<=12; $i++) {
  if ($i == $xm) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$xmntharray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$xmntharray[$i]?></OPTION><?php
  }
} ?>
              </SELECT>
              <SELECT NAME="xy" class="input">
<?php
for ($expiryyear=$todayyear; $expiryyear<=($todayyear+5); $expiryyear++) {
  if ($xy == $expiryyear) { ?>
              <OPTION VALUE="<?=$expiryyear?>" SELECTED><?=$expiryyear?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$expiryyear?>"><?=$expiryyear?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          </tr>
          <tr>
            <td align="right" class="input">Issue&nbsp;(Switch):</td>
            <td align="left" class="input">
              <input type="text" class="input" name="v" size="1" maxlength="2" value="<?=$v?>">&nbsp;Security&nbsp;Code:<input type="text" class="input" name="cv2" size="2" maxlength="3" value="<?=$cv2?>">
            </td>
          </tr>
          <tr>
            <td align="right" class="input" style="vertical-align: top">Additional<br>Information
            </td>
            <td>
              <textarea name="sr" cols="22" rows="4" class="input"><?=$sr?></textarea>
            </td>
          </tr>
        </table>
      </td>
      <td rowspan="2">
        <table align="left" border="0" cellspacing="2" cellpadding="3">
          <tr>
            <td class="input">&nbsp;</td>
          </tr>
    <?php
    if (isset($error2)) {
        if (!isset($_GET['conditions'])) { ?>
          <tr>
            <td class="input" style="color: red"><b>The following amendments are required:</b></td>
          </tr>
          <tr>
            <td class="input" style="color: red"><b><?=$error2?></b></td>
          </tr>
    <?php
        }
    }  ?>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2">
          <input type="submit" class="button-cust" name="requestBooking" value="Submit Booking" align="right">
      </td>
    </tr>
  </table>
</form>
