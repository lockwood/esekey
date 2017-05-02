<?php
// +----------------------------------------------------------------------+
// | PERSONAL_FORM  - Weekly Online Booking Personal Details (Company 1)  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/personal_form.php,v 1.00 2003/10/01
// 

echo '<p>You would like to book '.$_SESSION[$ss]['booking_property_name'].' from '.$_SESSION[$ss]['display_date'].' for '.$_SESSION[$ss]['booking_duration'].' nights';
if ($_SESSION[$ss]['total_cost'] == 'POA') {// No price available
    echo '. Although the price for this booking is not currently available, you may continue with the secure booking process if you wish to hold an option on this booking for 24 hours. Please call us on 01628 665213 to confirm the price.';
} else {
    echo ' at a cost of '.$_SESSION[$ss]['total_cost'].', with an initial deposit of '.$_SESSION[$ss]['deposit'].'.';
}
?>
    <p>Please update and confirm the following payment details as appropriate.</p>
    <form name="pform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
    <input type="hidden" name="id" value="<?=$_SESSION[$ss]['company_id']?>">
    <input type="hidden" name="s" value="<?=$section_id?>">
    <input type="hidden" name="p" value="<?=($page_id)?>">
    <input type="hidden" name="r" value="<?=$_SESSION[$ss]['booking_property_id']?>">
    <input type="hidden" name="t" value="p">
    <input type="hidden" name="b" value="<?=$_SESSION[$ss]['booking_date']?>">
    <table align="center" border="0" cellspacing="0" cellpadding="3">
    <tr><td align="right">Title:</td><td align="left">
    <SELECT NAME="title">
    <OPTION VALUE="Mr">Mr</OPTION>
    <OPTION VALUE="Mrs">Mrs</OPTION>
    <OPTION VALUE="Miss">Miss</OPTION>
    <OPTION VALUE="Ms">Ms</OPTION>
    <OPTION VALUE="Dr">Dr</OPTION>
    <OPTION VALUE="Rev">Rev</OPTION>
    <OPTION VALUE="Prof">Prof</OPTION>
    </SELECT>
    </td></tr>
    <tr><td align="right">First Name:</td><td align="left">
    <input type="text" name="f" size="20" maxlength="20" value="">
    </td></tr>
    <tr><td align="right">Surname:</td><td align="left">
    <input type="text" name="n" size="50" maxlength="50" value="">
    </td></tr>
    <tr><td align="right">Address:</td><td align="left">
    <input type="text" name="a" size="50" maxlength="50" value="">
    </td></tr>
    <tr><td align="right">Postcode:</td><td align="left">
    <input type="text" name="q" size="10" maxlength="10" value="">
    </td></tr>
    <tr><td align="right">Email:</td><td align="left">
    <input type="text" name="e" size="50" maxlength="50" value="">
    </td></tr>
    <tr><td colspan="2" align="center"><br><br>
    <input type="button" name="goBack" value="<< Back" onClick="DoPopup('<?=$servername?>',5,<?=$menuarray[2][page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
    <input type="submit" name="subbutton" value="Next >>">
    </td></tr>
    </table>
    </form>


