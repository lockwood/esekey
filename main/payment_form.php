<?php
// +----------------------------------------------------------------------+
// | PAYMENT_FORM  - Weekly Online Booking Payment Details (Company 1)    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/payment_form.php,v 1.00 2003/10/01
// 

if ($_SESSION[$ss]['total_cost'] == 'POA') {// No price available
    echo '<br>Although the price for this booking is not currently available, you may continue with the secure booking process if you wish to hold an option on this booking for 24 hours. Please call us on '.$_SESSION[$ss]['company_telephone'].' to confirm the price.';
} else {
    echo '<br>The cost of your current selection will be '.$_SESSION[$ss]['total_cost'].', with an initial deposit of '.$_SESSION[$ss]['deposit'].'.';
}
if ($_SESSION[$ss]['payment_method'] == "2" ) { ?>
    <p>Please complete this booking process before calling us with your payment details. Press "Next" to continue.</p>
<?php
} else if ($_SESSION[$ss]['payment_method'] == "3" ) { ?>
    <p>Please complete this booking process to ensure that your reservation is provisionally held until we receive your remittance. Press "Next" to continue.</p>
<?php
} else { ?>
    <p>Please indicate how you wish to make your initial payment.</p>
<?php
} ?>
<form name="pform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
<input type="hidden" name="id" value="<?=$_SESSION[$ss]['company_id']?>">
<input type="hidden" name="s" value="<?=$section_id?>">
<input type="hidden" name="p" value="<?=($page_id)?>">
<input type="hidden" name="r" value="<?=$_SESSION[$ss]['booking_property_id']?>">
<input type="hidden" name="t" value="p">
<input type="hidden" name="b" value="<?=$_SESSION[$ss]['booking_date']?>">
<table align="center" border="0" cellspacing="0" cellpadding="3">
    <tr><td align="right">Payment Method:</td><td align="left">
    <SELECT NAME="m" onChange="pform.submit()">
    <?php
    if ($_SESSION[$ss]['payment_method'] != "1"|"2"|"3" ) { ?>
        <OPTION SELECTED VALUE="0">Please Select</OPTION>
    <?php
    } else { ?>
        <OPTION VALUE="0">Please Select</OPTION>
    <?php
    }
    if ($_SESSION[$ss]['payment_method'] == "1" ) { ?>
        <OPTION SELECTED VALUE="1">Credit/Debit Card Online</OPTION>
    <?php
    } else { ?>
        <OPTION VALUE="1">Credit/Debit Card Online</OPTION>
    <?php
    }
    if ($_SESSION[$ss]['payment_method'] == "2" ) { ?>
        <OPTION SELECTED VALUE="2">Credit/Debit Card By Telephone</OPTION>
    <?php
    } else { ?>
        <OPTION VALUE="2">Credit/Debit Card By Telephone</OPTION>
    <?php
    }
    if ($_SESSION[$ss]['payment_method'] == "3" ) { ?>
        <OPTION SELECTED VALUE="3">Cheque By Post</OPTION>
    <?php
    } else { ?>
        <OPTION VALUE="3">Cheque By Post</OPTION>
    <?php
    }
    ?>
    </SELECT>
    </td></tr>
    <?php
    if ($_SESSION[$ss]['payment_method'] == "1" ) { ?>
        <tr><td align="right">Card Number:</td><td align="left">
        <input type="text" name="z" size="15" maxlength="15" value="">
        </td></tr>
        <tr><td align="right">Expiry Date:</td><td align="left">
        <SELECT NAME="x">
        <OPTION VALUE="01">01</OPTION>
        <OPTION VALUE="02">02</OPTION>
        <OPTION VALUE="03">03</OPTION>
        <OPTION VALUE="04">04</OPTION>
        <OPTION VALUE="05">05</OPTION>
        <OPTION VALUE="06">06</OPTION>
        <OPTION VALUE="07">07</OPTION>
        <OPTION VALUE="08">08</OPTION>
        <OPTION VALUE="09">09</OPTION>
        <OPTION VALUE="10">10</OPTION>
        <OPTION VALUE="11">11</OPTION>
        <OPTION VALUE="12">12</OPTION>
        </SELECT>
        <SELECT NAME="y">
        <OPTION VALUE="2003">2003</OPTION>
        <OPTION VALUE="2004">2004</OPTION>
        <OPTION VALUE="2005">2005</OPTION>
        <OPTION VALUE="2006">2006</OPTION>
        <OPTION VALUE="2007">2007</OPTION>
        <OPTION VALUE="2008">2008</OPTION>
        </SELECT>
        </td></tr>
        <tr><td align="right">Security Code:</td><td align="left">
        <input type="text" name="v" size="3" maxlength="3" value="">
        </td></tr>
    <?php
    } ?>
    <tr><td colspan="2" align="center"><br><br>
    <input type="button" name="goBack" value="<< Back" onClick="DoPopup('<?=$servername?>',5,<?=$menuarray[1][page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
    <?php
    if ($_SESSION[$ss]['payment_method'] > "0" ) { ?>
        <input type="button" name="subbutton" value="Next >>" onClick="DoPopup('<?=$servername?>',5,<?=$menuarray[3][page_id]?>,<?=$_SESSION[$ss]['booking_property_id']?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');">
    <?php
    } else { ?>
        <input type="button" name="disabled" value="Next >>">
    <?php
    }
    ?>
    </td></tr>
</table>
</form>