<?php
// +----------------------------------------------------------------------+
// | MENU  - Esekey Admin Console Dynamic Menu                            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/menu.php,v 1.02 2006/02/13
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');

unset($_SESSION[$ss]['menu']); // clear any previous menu entries

$menuHeading = 0;
		
$_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseCompany';
$_SESSION[$ss]['menu'][$menuHeading][1][0] = 'company_admin';
$_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Administration Home';			
$_SESSION[$ss]['menu'][$menuHeading][1][1] = 'status.php?';		
if ($_SESSION[$ss]['permissions'] == '') {
	$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Company Details';
	$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=company&';
	$_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Users';
	$_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=user&';
} elseif ($_SESSION[$ss]['permissions'] == 'NoSite') {
	$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Company Details';
	$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=company&';
	$_SESSION[$ss]['menu'][$menuHeading][0][3] = 'My User Profile';
	$_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=user&srch1=user_name&op1=EQ&val1='.$_SESSION[$ss]['username'].'&';
} else {
	$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'My User Profile';
	$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=user&srch1=user_name&op1=EQ&val1='.$_SESSION[$ss]['username'].'&';
}

	
if ($_SESSION[$ss]['permissions'] == '') {
    $menuHeading++;

    $_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseSite';
    $_SESSION[$ss]['menu'][$menuHeading][1][0] = 'site_admin?';
    $_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Page List';					
    $_SESSION[$ss]['menu'][$menuHeading][1][1] = 'list.php?view=page&';		
    $_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Page Element List';			
    $_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=page_element&';
    $_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Element List';				
    $_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=element&';		
    $_SESSION[$ss]['menu'][$menuHeading][0][4] = 'Section List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][4] = 'list.php?view=section&';	
    $_SESSION[$ss]['menu'][$menuHeading][0][5] = 'Section Page List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][5] = 'list.php?view=section_page&';	
    $_SESSION[$ss]['menu'][$menuHeading][0][6] = 'Image List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][6] = 'list.php?view=image&';	
    $_SESSION[$ss]['menu'][$menuHeading][0][7] = 'Gallery List';	
    $_SESSION[$ss]['menu'][$menuHeading][1][7] = 'list.php?view=gallery&';	
    $_SESSION[$ss]['menu'][$menuHeading][0][8] = 'Page Statistics';	
    $_SESSION[$ss]['menu'][$menuHeading][1][8] = 'pagestats.php?';	
}	

$menuHeading++;
$menuItem = 0;
$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'EseBooking';
$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'bookings_admin?';
$menuItem++;

if ($property_search)
{
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'New Enquiry';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'admin_search.php?';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'List Enquiries';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=enquiry_view&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Property Calendar';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'admin_availability.php?';		
	$menuItem++;
	// $_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Cleaning Rota';
	// $_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=cleaning&';		
	// $menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Properties';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=property&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Locations';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=location&';
	$menuItem++;
} else
{		
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'View Availability';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'admin_availability.php?';		
	$menuItem++;
}
if ($_SESSION[$ss]['permissions'] != 'ViewOnly') {
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'New Booking';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'admin_booking_frame.php?';
	$menuItem++;
}
if ($_SESSION[$ss]['company_id'] == '00004')
{ 
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Current Self Catering Bookings';
} else
{
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'List Current Bookings';
}
$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.departure_date&op1=GTEQ&val1=now()&';		
$menuItem++;
if ($_SESSION[$ss]['company_id'] == '00004')
{ 
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Current B & B Bookings';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.departure_date&op1=GTEQ&val1=now()&bb=1&';
	$menuItem++;
}
$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Past Booking List';
$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.departure_date&op1=LT&val1=now()&';
$menuItem++;
if ($_SESSION[$ss]['permissions'] != 'ViewOnly') {
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Deposits Due';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Deposit+Due&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Balances Due';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Balance+Due&';
	$menuItem++;
}
$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Cancelled Bookings';
$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=booking_view&srch1=t1.booking_status&op1=EQ&val1=Cancelled&';
$menuItem++;
if ($_SESSION[$ss]['company_id'] == '00003')
{ 
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Booking Sources';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'sources.php?';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Occupancy Spreadsheet';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'occupancy.php?';
} elseif ($_SESSION[$ss]['permissions'] != 'ViewOnly')
{
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Prices';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=price&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Charges';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=charge&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Rates';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=charge_rate&';
}
if ($_SESSION[$ss]['company_id'] == '00004')
{ 
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Promotions';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=promotions&';
	$menuItem++;
	$_SESSION[$ss]['menu'][$menuHeading][0][$menuItem] = 'Manage B&B Options';
	$_SESSION[$ss]['menu'][$menuHeading][1][$menuItem] = 'list.php?view=bbmanage&';
}	
if ($_SESSION[$ss]['permissions'] != 'ViewOnly') {

	$menuHeading++;
		
	$_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseCustomer';
	$_SESSION[$ss]['menu'][$menuHeading][1][0] = 'customer_admin?';
	$_SESSION[$ss]['menu'][$menuHeading][0][1] = 'Customers by Last Name';
	$_SESSION[$ss]['menu'][$menuHeading][1][1] = 'list.php?view=customer&order=last_name,first_name&';
	$_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Customers by ID';
	$_SESSION[$ss]['menu'][$menuHeading][1][2] = 'list.php?view=customer&order=customer_id&';
}
if ($_SESSION[$ss]['company_id'] == '00004')
{ 
	$_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Unapproved Guest Reviews';
	$_SESSION[$ss]['menu'][$menuHeading][1][3] = 'list.php?view=reviews&srch1=review_status&op1=EQ&val1=N&';
	$_SESSION[$ss]['menu'][$menuHeading][0][4] = 'Live Guest Reviews';
	$_SESSION[$ss]['menu'][$menuHeading][1][4] = 'list.php?view=reviews&srch1=review_status&op1=EQ&val1=Y&';
	$_SESSION[$ss]['menu'][$menuHeading][0][5] = 'Guest Review Page';
	$_SESSION[$ss]['menu'][$menuHeading][1][5] = 'admin_guest_reviews.php?';
	$_SESSION[$ss]['menu'][$menuHeading][0][6] = 'Deleted Guest Reviews';
	$_SESSION[$ss]['menu'][$menuHeading][1][6] = 'list.php?view=reviews&srch1=review_status&op1=EQ&val1=D&';
}	
if ($_SESSION[$ss]['permissions'] == '') { 
    $menuHeading++;

    $_SESSION[$ss]['menu'][$menuHeading][0][0] = 'EseInfo';
    $_SESSION[$ss]['menu'][$menuHeading][1][0] = 'help_info?';
    $_SESSION[$ss]['menu'][$menuHeading][0][1] = 'EseSite&trade; Overview';					
    $_SESSION[$ss]['menu'][$menuHeading][1][1] = 'esesiteover.html?';		
    $_SESSION[$ss]['menu'][$menuHeading][0][2] = 'Updating Page Content';			
    $_SESSION[$ss]['menu'][$menuHeading][1][2] = 'esesitetext.html?';
    $_SESSION[$ss]['menu'][$menuHeading][0][3] = 'Adding a New Page';				
    $_SESSION[$ss]['menu'][$menuHeading][1][3] = 'esesitepage.html?';		
    $_SESSION[$ss]['menu'][$menuHeading][0][4] = 'Uploading an Image';	
    $_SESSION[$ss]['menu'][$menuHeading][1][4] = 'esesiteimg.html?';	
    $_SESSION[$ss]['menu'][$menuHeading][0][5] = 'Updating the Gallery';	
    $_SESSION[$ss]['menu'][$menuHeading][1][5] = 'esesitegall.html?';	
    $_SESSION[$ss]['menu'][$menuHeading][0][6] = 'If Something Goes Wrong...';	
    $_SESSION[$ss]['menu'][$menuHeading][1][6] = 'esesiteprob.html?';	
}	


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
