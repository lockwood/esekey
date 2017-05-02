<?php
// +----------------------------------------------------------------------+
// | MENU  - Esekey Admin Console Dynamic Menu                            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/menu.php,v 1.00 2004/12/07
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');

unset($_SESSION[$ss]['menu']); // clear any previous menu entries

$menuHeading = 0;
		
$_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseCompany';
$_SESSION[$ss]['menu'][$menuHeading][1][0] = 'company_admin';
$_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Administration Home';			
$_SESSION[$ss]['menu'][$menuHeading][1][1] = 'status.php';		
$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Users';
$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=user';
$_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Company Details';
$_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=company';

	
if ($_SESSION[$ss]['permissions'] != 'NoSite') {
    $menuHeading++;

    $_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseSite';
    $_SESSION[$ss]['menu'][$menuHeading][1][0] = 'site_admin';
    $_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Page List';					
    $_SESSION[$ss]['menu'][$menuHeading][1][1] = 'list.php?view=page';		
    $_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Page Element List';			
    $_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=page_element';
    $_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Element List';				
    $_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=element';		
    $_SESSION[$ss]['menu'][$menuHeading][0][4] = 'Section List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][4] = 'list.php?view=section';	
    $_SESSION[$ss]['menu'][$menuHeading][0][5] = 'Section Page List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][5] = 'list.php?view=section_page';	
    $_SESSION[$ss]['menu'][$menuHeading][0][6] = 'Image List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][6] = 'list.php?view=image';	
    $_SESSION[$ss]['menu'][$menuHeading][0][7] = 'Gallery List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][7] = 'list.php?view=gallery';	
}	

$menuHeading++;

$_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseBooking';
$_SESSION[$ss]['menu'][$menuHeading][1][0] = 'bookings_admin';
$_SESSION[$ss]['menu'][$menuHeading][0][1] = 'View Availability';
$_SESSION[$ss]['menu'][$menuHeading][1][1] = 'admin_availability.php';		
$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'New Booking';
$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'admin_booking_frame.php';
$_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Current Booking List';
$_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=booking_view&srch1=t1.departure_date&op1=GTEQ&val1=now()';		
$_SESSION[$ss]['menu'][$menuHeading][0][4] = 'Past Booking List';
$_SESSION[$ss]['menu'][$menuHeading][1][4] = 'list.php?view=booking_view&srch1=t1.departure_date&op1=LT&val1=now()';
$_SESSION[$ss]['menu'][$menuHeading][0][5] = 'Deposits Due';
$_SESSION[$ss]['menu'][$menuHeading][1][5] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Deposit+Due';
$_SESSION[$ss]['menu'][$menuHeading][0][6] = 'Balances Due';
$_SESSION[$ss]['menu'][$menuHeading][1][6] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Balance+Due';
$_SESSION[$ss]['menu'][$menuHeading][0][7] = 'Cancelled Bookings';
$_SESSION[$ss]['menu'][$menuHeading][1][7] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Cancelled';
$_SESSION[$ss]['menu'][$menuHeading][0][8] = 'Unsent Emails';
$_SESSION[$ss]['menu'][$menuHeading][1][8] = 'list.php?view=email&srch1=sent_flag&op1=EQ&val1=N';
$_SESSION[$ss]['menu'][$menuHeading][0][9] = 'Sent Emails';
$_SESSION[$ss]['menu'][$menuHeading][1][9] = 'list.php?view=email&srch1=sent_flag&op1=EQ&val1=Y';
	
$menuHeading++;
		
$_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseCustomer';
$_SESSION[$ss]['menu'][$menuHeading][1][0] = 'customer_admin';
$_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Customers by Last Name';
$_SESSION[$ss]['menu'][$menuHeading][1][1] = 'list.php?view=customer&order=last_name,first_name';
$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Customers by ID';
$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=customer&order=customer_id';


?>
<html>
<head>
<title>Menu - Esekey Administration Console</title>
<link rel="stylesheet" href="theme/menu.css" type="text/css">
<script language="JavaScript" src="js/menu.js" type="text/javascript"></script>
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

//-->
</script>

</head>

<body bgcolor="#CCCCCC" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<?php
for ($i = 0; $i < count($_SESSION[$ss]['menu']); $i++) { ?>
    <div class="menu-heading">
    <a href="javascript:ShowLevel('<?=$_SESSION[$ss]['menu'][$i][1][0]?>')" 
    onMouseOver="return window.status='<?=$_SESSION[$ss]['menu'][$i][0][0]?>&trade;';"
    onMouseOut="return window.status='';">
    <img src="images/plus.gif" alt="" id="img_<?=$_SESSION[$ss]['menu'][$i][1][0]?>" width="9" height="9" border="0">&nbsp;
    <?=$_SESSION[$ss]['menu'][$i][0][0]?>&trade;</a><br>
    <div id="<?=$_SESSION[$ss]['menu'][$i][1][0]?>" style="display:none;" class="menu-link">
    <?php
    for ($j = 1; $j < count($_SESSION[$ss]['menu'][$i][0]); $j++) { ?>
        - <a href="#" 
        onClick="top.Top.GoToURL('<?=$_SESSION[$ss]['menu'][$i][0][0]?>', '<?=$_SESSION[$ss]['menu'][$i][0][$j]?>', '<?=$_SESSION[$ss]['menu'][$i][1][$j]?>');"
        onMouseOver="return window.status='<?=$_SESSION[$ss]['menu'][$i][0][0]?>&trade; &gt; <?=$_SESSION[$ss]['menu'][$i][0][$j]?>';"
        onMouseOut="return window.status='';"><?=$_SESSION[$ss]['menu'][$i][0][$j]?></a><br>
        <?php
    } ?>
    </div>
    </div>
    <?php
} ?>
		
</body>
</html>
