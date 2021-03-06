<?php 
// +----------------------------------------------------------------------+
// | COMBINED_BOOKING_FORM  - captures daily booking/payment details      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/combined_booking_form.php,v 1.04 2006/09/03
//
if (isset($_SESSION[$ss]['booking_reference'])) { 
    // booking already made - show confirmation
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/confirm.php');
    return;
} ?>
<form name="eform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
  <input type="hidden" name="p" value="<?=$page_id?>">
    <?php
	if (!isset($book_bb) || $book_bb == 'no') {
		$book_bb = 'no';
		$form_title = 'New Self Catering Booking';
		$bb_or_sc_val = 'Switch to B&amp;B...';
		$sc_display_style = '';
		$bb_display_style = 'none';
	} else {
		$book_bb = 'yes';
		$form_title = 'New Bed & Breakfast Booking';
		$bb_or_sc_val = 'Switch to Self Catering...';
		$sc_display_style = 'none';
		$bb_display_style = '';
	}
    if ($ss == 'User') {
    ?>
Enter/amend your details and use the <i>Check Availability and Price</i> button to view the results. <br>Use the <i>Submit Booking</i> button to proceed. Your card details will NOT be validated online, and the booking will remain provisional until the card transaction is completed.<input type="hidden" name="book_bb" id="book_bb" value="<?=$book_bb?>" />
    <?php
    } else {
    	?>
<b><span id="bk_label" style="width:220px; display:inline-block;"><?=$form_title?></span></b><input type="hidden" name="book_bb" id="book_bb" value="<?=$book_bb?>" /><input type="hidden" name="sid" value="<?=$sid?>" />
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
    <tr>
      <td align="left">
        <table align="left" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td align="right" class="input" nowrap>Arrival&nbsp;date
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
            <td align="center"><SELECT NAME="m" class="input">
<?php 
for ($i=1; $i<=12; $i++) {
  if ($i == $m) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$montharray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$montharray[$i]?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
            <td align="left" nowrap>
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
          </tr>
          <tr>
            <td align="right" nowrap class="input">For
            </td><?php
if ($ss == 'User') {
    ?>
            <td><SELECT NAME="n" class="input">
<?php
  if ($book_bb == 'yes')
  {
  	$min_nights = 1;
  } else
  {
  	$min_nights = 7;
  } 
  for ($i=$min_nights; $i<=28; $i++) {
    if ($i == $n) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
    } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
    }
  } ?>
              </SELECT>
            </td><?php
} else { 
    ?>
            <td><input type="text" class="input" name="n" size="3" maxlength="3" value="<?=$n?>"><?php
} ?>
            </td>
            <td nowrap class="input" colspan="2">nights</td>
          </tr>
          <tr>
            <td align="right" nowrap class="input">Departing</td>
            <td nowrap class="input" colspan="3"><?=$departure_date?></td>
          <tr>
            <td align="right" nowrap class="input">Number of Guests</td>
            <td align="left" colspan="3">
              <SELECT NAME="g" class="input">
<?php 
for ($i=1; $i<=18; $i++) {
  if ($i == $g) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT><input NAME="c" type="hidden" value="0">
            </td>
          </tr>
        </table>
      </td>
      <td>
        <table id="sc_div" style="display:<?=$sc_display_style?>" border="0" cellspacing="1" cellpadding="1">
<?php   
foreach ($resourcearray as $propertyrow) { ?>
          <tr>
            <td align="right" nowrap class="input"><?=$propertyrow['property_name']?></td>
            <td align="left">
              <INPUT TYPE="checkbox" NAME="r<?=$propertyrow['property_id']?>" VALUE="1" <?=$r[$propertyrow['property_id']]?>></td>
          </tr>
<?php   
}
// add optional extras
if (is_array($labels))
{
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
}
?>
        </table>
        <table id="bb_div" style="display:<?=$bb_display_style?>" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td align="right" nowrap class="input">Single</td> 
            <td align="left">
              <SELECT NAME="sgl" class="input">
              <OPTION VALUE="0">Number of Rooms...</OPTION>
<?php 
for ($i=1; $i<=2; $i++) {
  if ($i == $sgl) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          </tr>
          <tr>
            <td align="right" nowrap class="input">Double</td> 
            <td align="left">
              <SELECT NAME="dbl" class="input">
              <OPTION VALUE="0">Number of Rooms...</OPTION>
<?php 
for ($i=1; $i<=2; $i++) {
  if ($i == $dbl) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          </tr>
          <tr>
            <td align="right" nowrap class="input">Twin</td> 
            <td align="left">
              <SELECT NAME="twn" class="input">
              <OPTION VALUE="0">Number of Rooms...</OPTION>
<?php 
for ($i=1; $i<=2; $i++) {
  if ($i == $twn) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$i?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$i?></OPTION><?php
  }
} ?>
              </SELECT>
            </td>
          </tr>
        </table>
      </td> 
      <td>
        <table id="status" border="0" cellspacing="2" cellpadding="3" align="left">
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
			if ($book_bb == 'yes') {
				$deposit_string = "(1 night's deposit):";
			} else
			{
				$deposit_string = "(".($deposit_rate*100)."% Deposit):";
			}
          ?>
                  <td class="input"><b>Amount due on booking <br><?=$deposit_string?></b></td>
                  <td align="right" valign="top" class="input"><b><?='�'.number_format($deposit,2)?></b></td>
                </tr>
                <tr>
                  <td class="input"><b>Balance <br>(due 28 days before arrival):</b></td>
                  <td align="right" valign="top" class="input"><b><?='�'.number_format($balance,2)?></b></td>
                </tr>
                <tr>
                  <td nowrap class="input"><b>Total Price:</b></td>
                  <td align="right" class="input"><b><?='�'.number_format($price,2)?></b></td>
          <?php
          } else { // Full amount is due
          ?>
                  <td nowrap class="input"><b>Total Price:</b></td>
                  <td align="right" class="input"><b><?='�'.number_format($price,2)?></b></td>
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
      <td colspan="2" nowrap><input type="submit" class="button-cust" name="checkPrice" value="Check Availability and Price" align="right"><span class="input" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Send&nbsp;email notification</span><span align="left"><INPUT TYPE="checkbox" NAME="em" VALUE="1" <?=$em?>></span></td>
      <?php
      if (!isset($error1)) { ?>
      <td class="input" align="right">&nbsp;Agreed&nbsp;Price&nbsp;�<input type="text" class="input" name="ap" size="10" maxlength="8" value="<?=number_format($ap,2,'.','')?>"></td>
      <?php 
      } ?>
    </tr>
    <?php
    } else {
    ?>
    <tr>
      <td colspan="2"><input type="submit" class="button-cust" name="checkPrice" value="Check Availability and Price" align="right"></td>
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
for ($expiryyear=$todayyear; $expiryyear<=($todayyear+6); $expiryyear++) {
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
               <br>Promo code,<br>Pets, Cot,<br>High Chair, etc.
            </td>
            <td>
              <textarea name="sr" cols="25" rows="4" class="input"><?=$sr?></textarea>
            </td>
          </tr>
        </table>
      </td>
      <td>
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
      <td colspan="4">
          <input type="submit" class="button-cust" name="requestBooking" value="Submit Booking" align="right">
      </td>
    </tr>
  </table>
</form>
