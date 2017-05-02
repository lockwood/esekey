<?php 
// +----------------------------------------------------------------------+
// | CUSTOMER_DETAILS_FORM  - shared with bookings and enquiries co 9     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 9/customer_details_form.php,v 1.00 2007/08/24
//
// $context allows minor differences between booking form and enquiry form

if ($context == 'booking')
{
	$contact_label = 'Booking&nbsp;Contact';
} else
{
	$contact_label = 'Existing&nbsp;Contact';
}

?>
        <table align="left" border="0" cellspacing="1" cellpadding="1"><?php
          if ($ss == 'Admin') { ?>
          <tr>
            <td align="right" class="input">Company</td>
            <td colspan="3"><?php
              $company_dropdown = true;
              include('dropdown.php');
              ?>
            </td>
          </tr>
          	  <?php
          	  if ($co_id == '0')
          	  {
          	  ?>
          <tr>
            <td align="right" class="input">Company Name
            </td>
            <td align="left" colspan="3"><input type="text" class="input" name="co" size="30" maxlength="50" value="<?=$co?>">
            </td>
          </tr>
          <?php
          	  }
          } ?>
          <tr>
            <td align="right" class="input"><?=$contact_label?></td>
            <td colspan="3"><?php
              $company_dropdown = false;
              include('dropdown.php');
              ?>
            </td>
          </tr>
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
          <?php
if ($context == 'booking')
{ ?>
          <tr>
            <td nowrap align="right" valign="top" class="input">Address
            </td>
            <td align="left" colspan="3"><textarea name="a" cols="36" rows="3" class="input"><?=$a?></textarea>
            </td>
          </tr>
          <tr>
            <td nowrap align="right" class="input">Post Code
            </td>
            <td align="left" colspan="3" class="input"><input type="text" class="input" name="q" size="11" maxlength="8" value="<?=$q?>">
            &nbsp;OR&nbsp;tick<INPUT TYPE="checkbox" NAME="ouk" VALUE="1" <?=$ouk?>>&nbsp;if outside UK
            </td>
          </tr>
          <?php
} ?>
          <tr>
            <td align="right" class="input">Email
            </td>
            <td align="left" colspan="3"><input type="text" class="input" name="e" size="36" maxlength="50" value="<?=$e?>">
            </td>
          </tr>
          <tr>
            <td align="right" class="input">Phone1
            </td>
            <td align="left" colspan="3" class="input"><input type="text" class="input" name="u" size="11" maxlength="50" value="<?=$u?>">&nbsp;&nbsp;Phone2&nbsp;<input type="text" class="input" name="u1" size="11" maxlength="50" value="<?=$u1?>">
            </td>
          </tr><?php
          if ($co_id != '' && $context == 'booking') { 
          		if ($add_tenant == 'yes') {
          			$now_or_later_val = 'Add Later...';
          			$display_style = '';
          		} else {
          			$add_tenant = 'no';
          			$now_or_later_val = 'Add Now...';
          			$display_style = 'none';
				}
          			?>
          <tr>
            <td align="right" class="input">Tenant&nbsp;Details</td>
            <td colspan="3"><input type="button" id="now_or_later" value="<?=$now_or_later_val?>" class="button-small" style="vertical-align:middle;" onClick='ShowHideTenant();'/><input type="hidden" name="add_tenant" id="add_tenant" value="<?=$add_tenant?>" />
            </td>
          </tr>
          <tr id="tenant0" style="display:<?=$display_style?>">
            <td align="right" class="input">Tenant</td>
            <td colspan="3"><?php
              $company_dropdown = false;
              $tenant_dropdown = true;
              include('dropdown.php');
              ?>
            </td>
          </tr>
          <tr id="tenant1" style="display:<?=$display_style?>">
            <td class="input">&nbsp;</td>
            <td class="input">Title</td>
            <td nowrap class="input">First Name</td>
            <td nowrap class="input">Last Name</td>
          </tr>
          <tr id="tenant2" style="display:<?=$display_style?>">
            <td align="right" class="input">Name</td>
            <td>
    <SELECT NAME="t_t" class="input">
<?php 
for ($i=1; $i<count($titlearray); $i++) {
  if ($i == $t_t) { ?>
              <OPTION VALUE="<?=$i?>" SELECTED><?=$titlearray[$i]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$i?>"><?=$titlearray[$i]?></OPTION><?php
  }
} ?>
    </SELECT>
            </td>
            <td><input type="text" class="input" name="f_t" size="8" maxlength="20" value="<?=$f_t?>">
            </td>
            <td><input type="text" class="input" name="l_t" size="12" maxlength="25" value="<?=stripslashes($l_t)?>">
            </td>
          </tr>
          <tr id="tenant3" style="display:<?=$display_style?>">
            <td nowrap align="right" valign="top" class="input">Address
            </td>
            <td align="left" colspan="3"><textarea name="a_t" cols="36" rows="3" class="input"><?=$a_t?></textarea>
            </td>
          </tr>
          <tr id="tenant4" style="display:<?=$display_style?>">
            <td nowrap align="right" class="input">Post Code
            </td>
            <td align="left" colspan="3" class="input"><input type="text" class="input" name="q_t" size="11" maxlength="8" value="<?=$q_t?>">
            &nbsp;OR&nbsp;tick<INPUT TYPE="checkbox" NAME="ouk_t" VALUE="1" <?=$ouk_t?>>&nbsp;if outside UK
            </td>
          </tr>
          <tr id="tenant5" style="display:<?=$display_style?>">
            <td align="right" class="input">Email
            </td>
            <td align="left" colspan="3"><input type="text" class="input" name="e_t" size="36" maxlength="50" value="<?=$e_t?>">
            </td>
          </tr>
          <tr id="tenant6" style="display:<?=$display_style?>">
            <td align="right" class="input">Phone1
            </td>
            <td align="left" colspan="3" class="input"><input type="text" class="input" name="u_t" size="11" maxlength="50" value="<?=$u_t?>">&nbsp;&nbsp;Phone2&nbsp;<input type="text" class="input" name="u1_t" size="11" maxlength="50" value="<?=$u1_t?>">
            </td>
          </tr>
          <?php
}
if ($context == 'enquiry')
{ ?>
          <tr>
            <td nowrap align="right" valign="top" class="input">Enquiry Notes
            </td>
            <td align="left" colspan="3"><textarea name="notes" cols="36" rows="5" class="input"><?=$notes?></textarea>
            </td>
          </tr>
    	  <tr>
    	    <td align="right">&nbsp;</td>
            <td align="left" colspan="3"><br /><input type="submit" class="input" name="savebtn" value="Save Enquiry">
    		</td>
    	  </tr>
    	  <?php
}
          ?>
        </table>
