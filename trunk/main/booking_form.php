<?php
// +----------------------------------------------------------------------+
// | BOOKING_FORM  - Weekly Online Booking (Company 1)                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking_form.php,v 1.00 2003/10/01
// ?>
    <p>Property available until <?=$latest_end_date?>. Current duration <?=$_SESSION[$ss]['booking_duration']?> nights.</p>
    <p>Please update and confirm the following booking details as appropriate.
    <br>To select a different start date, click &quot;Back&quot; and select another available date.</p>
    <form name="dform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
    <input type="hidden" name="id" value="<?=$_SESSION[$ss]['company_id']?>">
    <input type="hidden" name="s" value="<?=$section_id?>">
    <input type="hidden" name="p" value="<?=($page_id)?>">
    <input type="hidden" name="r" value="<?=$_SESSION[$ss]['booking_property_id']?>">
    <input type="hidden" name="t" value="p">
    <input type="hidden" name="b" value="<?=$_SESSION[$ss]['booking_date']?>">
    <table align="center" border="0" cellspacing="0" cellpadding="3">
    <tr><td align="right">Booking Reference:</td><td align="left"><?=$_SESSION[$ss]['booking_reference']?>
    </td></tr>
    <tr><td align="right">Property:</td><td align="left"><?=$_SESSION[$ss]['booking_property_name']?>
    </td></tr>
    <tr><td align="right">Start Date:</td><td align="left"><?=$_SESSION[$ss]['display_date']?>
    </td></tr>
    <tr><td align="right">Duration (nights):</td><td align="left">
    <SELECT NAME="l" onChange="dform.submit()">
    <?php
    foreach ($duration_array as $nights_value) {
        if ($_SESSION[$ss]['booking_duration'] == $nights_value) { ?>
            <OPTION SELECTED VALUE="<?=$nights_value?>"><?=$nights_value?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$nights_value?>"><?=$nights_value?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right">Total Cost (inc. VAT):</td><td align="left"><?=$_SESSION[$ss]['total_cost']?>
    </td></tr>
    <tr><td align="right">Deposit Required:</td><td align="left"><?=$_SESSION[$ss]['deposit']?>
    </td></tr>
    <tr><td colspan="2" align="center"><br><br>
    <input type="hidden" name="c" value="<?=$price?>">
    <input type="hidden" name="i" value="<?=$display_deposit?>">
    <input type="button" name="goBack" value="<< Back" onClick="DoPopup('<?=$servername?>',5,<?=$menuarray[0][page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
    <input type="button" name="goPayment" value="Next >>" onClick="DoPopup('<?=$servername?>',5,<?=$menuarray[2][page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
    </td></tr>
    </table>
    </form>
