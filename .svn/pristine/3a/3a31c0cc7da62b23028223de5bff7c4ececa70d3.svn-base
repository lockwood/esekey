<?php 
// +----------------------------------------------------------------------+
// | DATE_FORM  - Present date selection fields for availability chart    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/date_form.php,v 1.00 2008/06/16
//
if ($ss == 'User') {
?>
<form action="<?=$_SERVER[PHP_SELF]?>" name="frmAvail" id="frmAvail" method="get">
  <table width="100%">
   <tr>
    <td valign="top" align="right" style="font-size: 12;"><?=$property_string?><b>From:</b>
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 11; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
      <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION>
<?php
  } else { ?>
      <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION>
<?php
  }
} ?>
    </SELECT><?=$popup_string?>
   </td>
   <td valign="top" width="10%" align="right" style="font-size: 12;">&nbsp;&nbsp;<b>Key:<b></td>
   <td>
    <table>
     <tr><td width="22" class="E" nowrap>&nbsp;</td><td class="fill" nowrap>Available</td></tr>
     <tr><td class="P" nowrap>&nbsp;</td><td class="fill" nowrap>Provisionally Booked</td></tr>
     <tr><td class="C" nowrap>&nbsp;</td><td class="fill" nowrap>Booked</td></tr>
    </table>
   </td>
   <td width="50%" align="right"><?=$bk_string?></td>
  </tr>
 </table>
</form>
<?php
} else {
	if ($property_search && $_GET['from'] == 'search') {
?>
<a title="Go back to property search" href="Javascript:history.go(<?=$back?>)"><< Back to Search</a>
<?php
	} ?>
<form action="admin_availability.php" name="frmAdAvail" id="frmAdAvail" method="get">
For 3 month period beginning (Select from list) &nbsp;
    <SELECT NAME="sd" onChange="submit();">
<?php 
for ($k = 0; $k <= 17; $k++) {
  if ($_SESSION[$ss]['selecteddate'] == $nav[$k]) { ?>
              <OPTION VALUE="<?=$nav[$k]?>" SELECTED><?=$display_nav[$k]?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$nav[$k]?>"><?=$display_nav[$k]?></OPTION><?php
  }
} ?>
    </SELECT>
	<input type="hidden" name="sid" value="<?=$sid?>" />
	<input type="hidden" name="property" value="<?=$selected_id?>" />
	<input type="hidden" name="back" value="<?=$back?>" />
</form>
<br>
<?php
}
