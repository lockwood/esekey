<?php
// +----------------------------------------------------------------------+
// | AVAILABILITY_SEARCH  - Availability Search Form(multi purpose)       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/availability_search.php,v 1.00 2006/12/17

$date_today = $db_object->getOne("SELECT CURDATE()");

$locationquery = "SELECT DISTINCT b.area
                        FROM property as a, location as b
                       WHERE a.postcode = b.postcode
                         AND a.active_flag = 'Y'";
if ($_SESSION[$ss]['company_id'] != '00000')
{
	$locationquery .= 	" AND a.company_id = '".$_SESSION[$ss]['company_id']."'";
	$locationquery .= 	" AND b.company_id = '".$_SESSION[$ss]['company_id']."'";
}
$locationquery .= 	"   ORDER BY  b.area";
$locations = $db_object->getCol($locationquery);

$bedquery = "SELECT  DISTINCT beds 
					  	FROM  `property`
					   WHERE  active_flag = 'Y'";
if ($_SESSION[$ss]['company_id'] != '00000')
{
	$bedquery .= 	"   AND  company_id = '".$_SESSION[$ss]['company_id']."'";
} else 
{
	// getdata does not get resources for company 0 - cludge here instead
	$resourcearray = $db_object->getAll("SELECT *
                                       FROM property
                                      WHERE active_flag = 'Y'
                                   ORDER BY company_id, property_name, property_number"); 
}
$bedquery .= 	"   ORDER BY  beds";
$bedrooms = $db_object->getCol($bedquery);
$sleepquery = "SELECT  DISTINCT sleeps 
				    	FROM  `property`
					   WHERE  active_flag = 'Y'";
if ($_SESSION[$ss]['company_id'] != '00000')
{
	$sleepquery .= 	"   AND  company_id = '".$_SESSION[$ss]['company_id']."'";
}
$sleepquery .= 	"   ORDER BY  sleeps";
$sleep_options = $db_object->getCol($sleepquery);

$duration_array = array(7,14,21,28);
$sort_array = array('Name','Location','Bedrooms','Sleeps','Parking','Price Code');

if (isset($_GET['enquiry_reference']))
{
	// load details from specified enquiry
	$enquiry_query = "SELECT *, date_add(`start_date`, interval `nights` day) as departure_date
                                       FROM enquiry
                                      WHERE enquiry_reference = ".$_GET['enquiry_reference']."
                                        AND company_id = '".$_SESSION[$ss]['company_id']."'";
	$enquiry = $db_object->getRow($enquiry_query);
	// print_r($enquiry);
	$_SESSION[$ss]['enquiry_reference'] = $enquiry['enquiry_reference'];
	$_SESSION[$ss]['property_id'] = $enquiry['property_id'];
	$_SESSION[$ss]['location'] = $enquiry['area'];
	$_SESSION[$ss]['bedrooms'] = $enquiry['beds'] == 0 ? "-- Any --" : $enquiry['beds'];
	$_SESSION[$ss]['sleeps'] = $enquiry['sleeps'] == 0 ? "-- Any --" : $enquiry['sleeps'];
	if ($enquiry['start_date'] == '0000-00-00')
	{
		$_SESSION[$ss]['arrival_date'] = '';
		$_SESSION[$ss]['sql_start_date'] = '';
		$_SESSION[$ss]['departure_date'] = '';
		$_SESSION[$ss]['sql_end_date'] = '';
		$_SESSION[$ss]['nights'] = '';
	} else
	{
		$date_bits = explode('-', $enquiry['start_date']);
		$_SESSION[$ss]['arrival_date'] = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
		$_SESSION[$ss]['sql_start_date'] = $enquiry['start_date'];
		$_SESSION[$ss]['nights'] = $enquiry['nights'];
		$date_bits = explode('-', $enquiry['departure_date']);
		$_SESSION[$ss]['departure_date'] = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
		$_SESSION[$ss]['sql_end_date'] = $enquiry['departure_date'];
	}
	$_SESSION[$ss]['nights_ind'] = '';
	$_SESSION[$ss]['sort'] = $enquiry['sort'];
    $_SESSION[$ss]['parking'] = ($enquiry['parking'] == '1' ? 'CHECKED' : '');
	$parking_style = ($enquiry['parking'] == '1' ? ' STYLE="background-color: pink"' : '');
} else
{
	$_SESSION[$ss]['enquiry_reference'] = 0;
	$_SESSION[$ss]['property_id'] = 0;
	$_SESSION[$ss]['location'] = "-- Any Location --";
	$_SESSION[$ss]['bedrooms'] = "-- Any --";
	$_SESSION[$ss]['sleeps'] = "-- Any --";
	$_SESSION[$ss]['arrival_date'] = "";
	$_SESSION[$ss]['departure_date'] = "";
	$_SESSION[$ss]['nights_ind'] = '';
	$_SESSION[$ss]['nights'] = '';
	$_SESSION[$ss]['sort'] = 'Name';
    $_SESSION[$ss]['parking'] = '';
	$parking_style = '';
}

if (isset($_GET['parking'])) { // parking flag
    $_SESSION[$ss]['parking'] = 'CHECKED';
    $parking_style = ' STYLE="background-color: pink"';
}
if (isset($_GET['property'])) { // property id
	$_SESSION[$ss]['property_id'] = $_GET['property'];
}
if (isset($_GET['location'])) { // location (area)
	$_SESSION[$ss]['location'] = $_GET['location'];
}
if (isset($_GET['bedrooms'])) { // number of bedrooms
	$_SESSION[$ss]['bedrooms'] = $_GET['bedrooms'];
}
if (isset($_GET['sleeps'])) { // number of bedrooms
	$_SESSION[$ss]['sleeps'] = $_GET['sleeps'];
}
if (isset($_GET['sd'])) { // start date
	$_SESSION[$ss]['arrival_date'] = $_GET['sd'];
	$date_bits = explode('-', $_SESSION[$ss]['arrival_date']);
	$_SESSION[$ss]['sql_start_date'] = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
	if ($_SESSION[$ss]['sql_start_date'] < date('Y-m-d'))
	{
		$_SESSION[$ss]['sql_start_date'] = '';
	}
	$_SESSION[$ss]['d'] = $date_bits[0] += 0;
	$_SESSION[$ss]['m'] = $date_bits[1] += 0;
	$_SESSION[$ss]['y'] = $date_bits[2];
}
if (isset($_GET['ed']) && $_GET['ed'] != '') { // end date
	$_SESSION[$ss]['departure_date'] = $_GET['ed'];
	$date_bits = explode('-', $_SESSION[$ss]['departure_date']);
	$_SESSION[$ss]['sql_end_date'] = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
	$_SESSION[$ss]['nights'] = $db_object->getOne("SELECT TO_DAYS('".$_SESSION[$ss]['sql_end_date']."') - TO_DAYS('".$_SESSION[$ss]['sql_start_date']."')"); 
}
if (isset($_GET['nights_ind'])) { // duration in nights - if specified, takes precedence over end date
	$_SESSION[$ss]['nights'] = 'CHECKED';
	$_SESSION[$ss]['nights'] = $_GET['nights'];
    $_SESSION[$ss]['sql_end_date'] = $db_object->getOne("SELECT date_add('".$_SESSION[$ss]['sql_start_date']."', interval '".$_SESSION[$ss]['nights']."' day)");
	$date_bits = explode('-', $_SESSION[$ss]['sql_end_date']);
	$_SESSION[$ss]['departure_date'] = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
}
if (isset($_GET['sort'])) { // sort field
	$_SESSION[$ss]['sort'] = $_GET['sort'];
}
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/customer_details_setup.php');

if ($_SESSION[$ss]['nights'] > 77)
{
	$max_nights = 9999;
	$price_label = "12+ Wks";
} elseif ($_SESSION[$ss]['nights'] > 21)
{
	$max_nights = 77;
	$price_label = "4-11 Wks";
} else
{
	$max_nights = 21;
	$price_label = "1-3 Wks";
}

$pricequery = "SELECT  price_code, weekly_rate 
				    	FROM  `price`
					   WHERE  max_nights = ".$max_nights;
if ($_SESSION[$ss]['company_id'] != '00000')
{
	$pricequery .= 	"   AND  company_id = '".$_SESSION[$ss]['company_id']."'";
}
$pricequery .= 	"   ORDER BY  price_code";
$price_options = $db_object->getAll($pricequery);
$prices = array();
foreach ($price_options as $price_option)
{
	$prices[$price_option['price_code']] = $price_option['weekly_rate'];
}

if (isset($_GET['searchbtn'])) { // search request submitted
    $searchquery = 	"SELECT  DISTINCT c.property_id, 
						    	      b.booking_date,
						    	      a.display_status
						    	FROM  `booking` as a,
									  `calendar_booking` as b,
									  `property` as c,
									  `location` as d
							   WHERE  a.company_id = b.company_id
							   	 AND  b.company_id = c.company_id
							   	 AND  a.booking_reference = b.booking_reference
							   	 AND  c.active_flag = 'Y' 
							   	 AND  c.property_id = b.resource_id 
		                         AND  c.postcode = d.postcode
							   	 AND  b.booking_date >= '".$_SESSION[$ss]['sql_start_date']."'
							   	 AND  b.booking_date < date_add('".$_SESSION[$ss]['sql_start_date']."', interval '".$_SESSION[$ss]['nights']."' day)";
	
    $resourcequery = "SELECT a.*, b.area
                        FROM property as a, location as b
                       WHERE a.postcode = b.postcode
                         AND a.active_flag = 'Y'";
	if ($_SESSION[$ss]['company_id'] != '00000')
	{
		$searchquery .= 	"   AND  a.company_id = '".$_SESSION[$ss]['company_id']."'";
		$resourcequery .= 	"   AND  a.company_id = '".$_SESSION[$ss]['company_id']."'";
	}
	if ($_SESSION[$ss]['location'] != '-- Any Location --')
	{
		$searchquery .= 	"   AND  d.area = '".$_SESSION[$ss]['location']."' ";
		$resourcequery .= 	"   AND  b.area = '".$_SESSION[$ss]['location']."' ";
	}
	if ($_SESSION[$ss]['bedrooms'] != '-- Any --')
	{
		$searchquery .= 	"   AND  c.beds = ".$_SESSION[$ss]['bedrooms'];
		$resourcequery .= 	"   AND  a.beds = ".$_SESSION[$ss]['bedrooms'];
	}
	if ($_SESSION[$ss]['sleeps'] != '-- Any --')
	{
		$searchquery .= 	"   AND  c.sleeps >= ".$_SESSION[$ss]['sleeps']." ";
		$resourcequery .= 	"   AND  a.sleeps >= ".$_SESSION[$ss]['sleeps']." ";
		$maxsleeps = $_SESSION[$ss]['sleeps'] + 2;
		$searchquery .= 	"   AND  c.sleeps <= ".$maxsleeps." ";
		$resourcequery .= 	"   AND  a.sleeps <= ".$maxsleeps." ";
	}
	if ($_SESSION[$ss]['parking'] == 'CHECKED')
	{
		$searchquery .= 	"   AND  c.parking = 'Y' ";
		$resourcequery .= 	"   AND  a.parking = 'Y' ";
	}
	if ($_SESSION[$ss]['property_id'] > 0)
	{
		$searchquery .= 	"   AND  c.property_id = ".$_SESSION[$ss]['property_id'];
		$resourcequery .= 	"   AND  a.property_id = ".$_SESSION[$ss]['property_id'];
	}
	$searchquery .= 	"   ORDER BY  c.property_id, b.booking_date";
    $availarray = 	 $db_object->getAll($searchquery); 
	$resourcequery .= 	"   ORDER BY  a.property_id";
	$searcharray = $db_object->getAll($resourcequery);
	//echo $resourcequery;
	//echo $searchquery;
	//echo count($availarray)." ";
	//echo count($searcharray)." ";
	//print_r($availarray);
    $searchrow = 0;
    $prop_id = 0;
    $available = false;
    $resultarray = array();
    if (count($availarray) == 0)
    {
    	if (count($searcharray) == 1)
    	{ 
    		$_SESSION[$ss]['search_results'] = '<p>No valid date range specified - Property Search only. 1 property found:</p>';
    	} else
    	{
    		$_SESSION[$ss]['search_results'] = '<p>No valid date range specified - Property Search only. '.count($searcharray).' properties found:</p>';
    	}
		$result_table = "<table width='100%'><tr style='height:35px;'><td></td><td>Name</td><td>Location</td><td>Bedrms</td><td>Sleeps</td><td>Parking</td><td>£/Wk (".$price_label.")</td><td>Earliest Avail</td></tr>";
		$action_table = "<table width='100%'><tr style='height:35px;'><td>&nbsp;</td></tr>";
		$resultarray = $searcharray;
    } else
    {
    	if (count($searcharray) > 0)
    	{
			foreach ($availarray as $availrow)
			{
				if (!($availrow['property_id'] < $searcharray[$searchrow]['property_id']))
				{
					if ($availrow['property_id'] > $prop_id)
					{
						if ($available)
						{
							while (($searcharray[$searchrow]['property_id'] < $prop_id) && (count($searcharray) > $searchrow))
							{
								$searchrow++;
							}
							if ($searcharray[$searchrow]['property_id'] == $prop_id)
							{
								$resultarray[$prop_id] = $searcharray[$searchrow];
							}
						}
						$prop_id = $availrow['property_id'];
						$available = true;
					}
					if ($availrow['display_status'] != 'E')
					{
						$available = false;
					}
				}
			}
			if ($available)
			{
				while (($searcharray[$searchrow]['property_id'] < $prop_id) && (count($searcharray) > $searchrow))
				{
					$searchrow++;
				}
				if ($searcharray[$searchrow]['property_id'] == $prop_id)
				{
					$resultarray[$prop_id] = $searcharray[$searchrow];
				}
			}
    	}
		if (count($resultarray) > 0)
		{
			if (count($resultarray) > 1)
			{
	    		$_SESSION[$ss]['search_results'] = '<p>Availability Search. '.count($resultarray).' properties are available for the selected dates ('.$_SESSION[$ss]['arrival_date'].' to '.$_SESSION[$ss]['departure_date'].')</p>';
			} else 
			{
	    		$_SESSION[$ss]['search_results'] = '<p>Availability Search. One property is available for the selected dates ('.$_SESSION[$ss]['arrival_date'].' to '.$_SESSION[$ss]['departure_date'].')</p>';
			}
			$result_table = "<table width='100%'><tr><td></td><td>Name</td><td>Location</td><td>Bedrms</td><td>Sleeps</td><td>Parking</td><td>£/Wk (".$price_label.")</td><td>Avail</td></tr>";
			$action_table = "<table width='100%'><tr><td>&nbsp;</td></tr>";
		} else
		{
    		$_SESSION[$ss]['search_results'] = '<p>Availability Search. No properties are available for the selected dates:</p>';
		}
    }
//	print_r($resultarray);
	if (count($resultarray) > 0)
	{
		foreach ($resultarray as $key => $resultrow)
		{
			$property_name[$key] = $resultrow['property_name'];
			$property_number[$key] = $resultrow['property_number'];
			$area[$key] = $resultrow['area'];
			$beds[$key] = $resultrow['beds'];
			$sleeps[$key] = $resultrow['sleeps'];
			$parking[$key] = $resultrow['parking'];
			$price_code[$key] = $resultrow['price_code'];
			$sorter[$resultrow['property_id']] = $resultrow[$sort_option];
			$sorted[$resultrow['property_id']] = $resultrow;
		}
		if ($_SESSION[$ss]['sort'] == 'Name')
		{
			array_multisort($property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		} elseif ($_SESSION[$ss]['sort'] == 'Location')
		{
			array_multisort($area, SORT_ASC, $property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		} elseif ($_SESSION[$ss]['sort'] == 'Bedrooms')
		{
			array_multisort($beds, SORT_ASC, $property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		} elseif ($_SESSION[$ss]['sort'] == 'Sleeps')
		{
			array_multisort($sleeps, SORT_ASC, $property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		} elseif ($_SESSION[$ss]['sort'] == 'Parking')
		{
			array_multisort($parking, SORT_DESC, $property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		} elseif ($_SESSION[$ss]['sort'] == 'Price Code')
		{
			array_multisort($price_code, SORT_ASC, $property_name, SORT_ASC, $property_number, SORT_ASC, $resultarray);
		}
			
		$row = 1;
		foreach ($resultarray as $key => $resultrow)
		{
			$result_table .= "<tr><td>".$row.".</td>";
			$full_name = '';
			if ($resultrow['property_number'] != '') {
				$full_name = $resultrow['property_number'].' ';
			}
			$full_name .= $resultrow['property_name'];
			if ($resultrow['web_page'] != '')
			{
				$result_table .= "<td><a href='".$resultrow['web_page']."' target='_popup1'>".str_replace(" ", "&nbsp;", $full_name)."</a></td>";
			} else
			{
				$result_table .= "<td>".str_replace(" ", "&nbsp;", $full_name)."</td>";
			}
			$result_table .= "<td>".$resultrow['area']."</td>";
			$result_table .= "<td align='center'>".$resultrow['beds']."</td>";
			$result_table .= "<td align='center'>".$resultrow['sleeps']."</td>";
			if ($resultrow['parking'] == 'Y')
			{
				$result_table .= "<td>Yes</td>";
			} else
			{
				$result_table .= "<td>No</td>";
			}
			$price = '?';
			if (isset($prices[$resultrow['price_code']])) $price = $prices[$resultrow['price_code']];
			$result_table .= "<td align='center'>".$price."</td>";
			// availability from - to if possible here:
			// find previous booking end and next booking start dates
			$bkgsquery = "select distinct a.* 
									 from booking as a, 
										  calendar_booking as b 
									where a.company_id = '".$_SESSION[$ss]['company_id']."' 
									  and b.company_id = '".$_SESSION[$ss]['company_id']."' 
									  and a.booking_reference = b.booking_reference 
									  and b.resource_id = ".$resultrow['property_id']." 
									  and a.departure_date > '".$date_today."' 
									  and a.display_status <> 'E' 
								 order by a.departure_date";
			$prop_bkgs = $db_object->getAll($bkgsquery);
			$avail_from = $date_today;
			$avail_to = '';
			if (count($prop_bkgs) > 0)
			{
				$test_start = '';
				if ($_SESSION[$ss]['sql_start_date'] != '' && $_SESSION[$ss]['sql_start_date'] != '--') $test_start = $_SESSION[$ss]['sql_start_date'];
				$prev_dep_date = $date_today;
				foreach ($prop_bkgs as $prop_bkg)
				{
					if ($test_start == '' && $prop_bkg['arrival_date'] > $prev_dep_date) 
					{
						$test_start = $prev_dep_date;
						$avail_from = $prev_dep_date;
					}
					if ($prop_bkg['departure_date'] <= $test_start || $test_start == '') $avail_from = $prop_bkg['departure_date'];
					if ($avail_to == '' && $test_start != '' && $prop_bkg['arrival_date'] > $test_start) $avail_to = $prop_bkg['arrival_date'];
					$prev_dep_date = $prop_bkg['departure_date'];
					//echo "Test start: ".$test_start." Prop bkg arr:".$prop_bkg['arrival_date']." Avail to: ".$avail_to;
				}
			}
			$date_bits = explode('-', $avail_from);
			$avail_from = $date_bits[2].'/'.$date_bits[1];
			if ($avail_to != '')
			{
				$date_bits = explode('-', $avail_to);
				$avail_to = $date_bits[2].'/'.$date_bits[1];
				$avail_from .= ' to '.$avail_to;
			}
			$result_table .= "<td align='center'>".$avail_from."</td></tr>";
			if (count($availarray) == 0)
			{
				$action_table .= '<tr><td><a href="#" onClick="top.Top.GoToURL('."'1', '".$full_name."', 'admin_availability.php?from=search&sid=".$sid."&property=".$resultrow['property_id']."');".'">View&nbsp;Availability</a></td></tr>';
			} else
			{
				$action_table .= "<tr><td><a href='admin_booking_frame.php?from=search&sid=".$sid."&pid=".$resultrow['property_id']."&d=".$_SESSION[$ss]['d']."&m=".$_SESSION[$ss]['m']."&y=".$_SESSION[$ss]['y']."&n=".$_SESSION[$ss]['nights']."'>Book Now</a></td></tr>";
			}
			$row++;
		}
		$result_table .= "</table>";
		$action_table .= "</table>";
	} else
	{
		$result_table = "Sorry - No properties were found matching your search criteria.";
		$action_table = "";
	}
	$_SESSION[$ss]['search_results'] .= "<table width='100%'><tr><td>".$result_table."</td><td>".$action_table."</td></tr></table>";
} else
{
    if (!isset($_GET['sort']))
    {
    	// no search request - blank out any previous search results
		$_SESSION[$ss]['search_results'] = '';
    }
}
if (isset($_GET['savebtn'])) { // save enquiry submitted
	include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/customer_details_validate.php');
	if (!isset($error2))
	{
		// insert new enquiry
		include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/enquiry.php');
		$_SESSION[$ss]['search_results'] = '<p>Enquiry '.$_SESSION[$ss]['enquiry_reference'].' was saved for customer '.$contact_id.' '.$l.'.</p>';
	}
}
if( !function_exists('memory_get_usage') ) 
{ 
    function memory_get_usage() 
    { 
        //If its Windows 
        //Tested on Win XP Pro SP2. Should work on Win 2003 Server too 
        //Doesn't work for 2000 
        //If you need it to work for 2000 look at http://us2.php.net/manual/en/function.memory-get-usage.php#54642 
        if ( substr(PHP_OS,0,3) == 'WIN') 
        { 
               if ( substr( PHP_OS, 0, 3 ) == 'WIN' ) 
                { 
                    $output = array(); 
                    exec( 'tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output ); 
        
                    return preg_replace( '/[\D]/', '', $output[5] ); 
                } 
        }else 
        { 
            //We now assume the OS is UNIX 
            //Tested on Mac OS X 10.4.6 and Linux Red Hat Enterprise 4 
            //This should work on most UNIX systems 
            $pid = getmypid(); 
            exec("ps -eo%mem,rss,pid | grep $pid", $output); 
            $output = explode("  ", $output[0]); 
            //rss is given in 1024 byte units 
            return $output[1] * 1024; 
        } 
    } 
} 


// $_SESSION[$ss]['search_results'] .= "<br />Memory usage ".memory_get_usage()." KB.";

 ?>
	<table width="100%">
	<tr>
	<td style="vertical-align:top;" nowrap>
    <p>Search for available properties.</p>
    <form name="searchform" action="<?=$_SERVER['PHP_SELF']?>" method="get">
  	<input type="hidden" name="p" value="<?=$page_id?>">
    <?php
    if ($ss == 'Admin') {
    ?>
	<input type="hidden" name="sid" value="<?=$sid?>" />
    <?php
    } ?>
    <table align="left" border="0" cellspacing="1" cellpadding="1">
    <tr><td align="right" class="input">Property Name</td><td align="left">
    <SELECT NAME="property" class="input">
    <?php
    if ($_SESSION[$ss]['property_id'] == 0)
    {
    	echo '<OPTION SELECTED VALUE="0">-- Any Property --</OPTION>';
    } else
    {
    	echo '<OPTION VALUE="0">-- Any Property --</OPTION>';
    }
    foreach ($resourcearray as $propertyrow) {
    	$full_name = '';
    	if ($propertyrow['property_number'] != '') {
    		$full_name = $propertyrow['property_number'].' ';
    	}
    	$full_name .= $propertyrow['property_name'];
        if ($_SESSION[$ss]['property_id'] == $propertyrow['property_id']) { ?>
            <OPTION STYLE="background-color: pink" SELECTED VALUE="<?=$propertyrow['property_id']?>"><?=$full_name?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$propertyrow['property_id']?>"><?=$full_name?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right" class="input">Location</td><td align="left">
    <SELECT NAME="location" class="input">
    <?php
    if ($_SESSION[$ss]['location'] == "-- Any Location --")
    {
    	echo '<OPTION SELECTED VALUE="-- Any Location --">-- Any Location --</OPTION>';
    } else
    {
    	echo '<OPTION VALUE="-- Any Location --">-- Any Location --</OPTION>';
    }
    foreach ($locations as $location) {
        if ($_SESSION[$ss]['location'] == $location) { ?>
            <OPTION STYLE="background-color: pink" SELECTED VALUE="<?=$location?>"><?=$location?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$location?>"><?=$location?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right" class="input">Bedrooms</td><td align="left">
    <SELECT NAME="bedrooms" class="input">
    <?php
    if ($_SESSION[$ss]['bedrooms'] == '-- Any --')
    {
    	echo '<OPTION SELECTED VALUE="-- Any --">-- Any --</OPTION>';
    } else
    {
    	echo '<OPTION VALUE="-- Any --">-- Any --</OPTION>';
    }
    foreach ($bedrooms as $bedroom) {
        if ($_SESSION[$ss]['bedrooms'] == $bedroom) { ?>
            <OPTION STYLE="background-color: pink" SELECTED VALUE="<?=$bedroom?>"><?=$bedroom?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$bedroom?>"><?=$bedroom?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right" class="input">Sleeps</td><td align="left">
    <SELECT NAME="sleeps" class="input">
    <?php
    if ($_SESSION[$ss]['sleeps'] == '-- Any --')
    {
    	echo '<OPTION SELECTED VALUE="-- Any --">-- Any --</OPTION>';
    } else
    {
    	echo '<OPTION VALUE="-- Any --">-- Any --</OPTION>';
    }
    foreach ($sleep_options as $sleep) {
        if ($_SESSION[$ss]['sleeps'] == $sleep) { ?>
            <OPTION STYLE="background-color: pink" SELECTED VALUE="<?=$sleep?>"><?=$sleep?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$sleep?>"><?=$sleep?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right" class="input">Parking</td><td align="left"><INPUT TYPE="checkbox" NAME="parking" <?=$parking_style?> VALUE="1" <?=$_SESSION[$ss]['parking']?>>
    </td></tr>
    <tr><td align="right" class="input">Arrival Date</td><td align="left">
    <?php
    if ($_SESSION[$ss]['arrival_date'] == '')
    { ?>
    <input type="Text" id="_sd" name="sd" class="input" value="<?=$_SESSION[$ss]['arrival_date']?>">
    <?php
    } else
    { ?>
    <input type="Text" id="_sd" name="sd" class="input" STYLE="background-color: pink" value="<?=$_SESSION[$ss]['arrival_date']?>">
	<?php
    } ?>
    </td></tr>
    <tr><td align="right" class="input">Duration (nights)</td><td align="left">
    <?php
    if ($_SESSION[$ss]['nights_ind'] == '')
    { ?>
    <INPUT TYPE="checkbox" NAME="nights_ind" VALUE="1" onchange="document.forms['searchform'].elements['nights'].disabled=false">
    <?php
    } else
    { ?>
    <INPUT TYPE="checkbox" NAME="nights_ind" VALUE="1" CHECKED onchange="document.forms['searchform'].elements['nights'].disabled=true">
	<?php
    } ?>
    <input type="text" NAME="nights" size="4" maxlength="3" class="input" value="<?=$_SESSION[$ss]['nights']?>" disabled="disabled">
    </td></tr>
    <tr><td align="right" class="input">Departure Date</td><td align="left">
    <?php
    if ($_SESSION[$ss]['departure_date'] == '')
    { ?>
    <input type="Text" id="_ed" name="ed" class="input" value="<?=$_SESSION[$ss]['departure_date']?>">
    <?php
    } else
    { ?>
    <input type="Text" id="_ed" name="ed" class="input" STYLE="background-color: pink" value="<?=$_SESSION[$ss]['departure_date']?>">
	<?php
    } ?>
    </td></tr>
    <tr><td align="right" class="input">Sort Results by</td>
    <td align="left"><SELECT name="sort" class="input">
    <?php
    foreach ($sort_array as $sort_option) {
        if ($_SESSION[$ss]['sort'] == $sort_option) { ?>
            <OPTION SELECTED VALUE="<?=$sort_option?>"><?=$sort_option?></OPTION>
    <?php
        } else { ?>
            <OPTION VALUE="<?=$sort_option?>"><?=$sort_option?></OPTION>
    <?php
        }
    }
    ?>
    </SELECT>
    </td></tr>
    <tr><td align="right">&nbsp;</td>
    <td align="left"><br /><input type="submit" name="searchbtn" value="Search" class="input">
    </td></tr>
    </table>
	</td>
	<td>&nbsp;
	</td>
	<td style="vertical-align:top; text-align:center">
	<?php
	if ($_SESSION[$ss]['enquiry_reference'] > 0)
	{
		$date_bits = explode('-', $enquiry['created_date']);
		$date_created = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0];
		$date_bits = explode('-', substr($enquiry['last_modified_on'], 0, 10));
		$time_bit = substr($enquiry['last_modified_on'], 10);
		$date_updated = $date_bits[2].'-'.$date_bits[1].'-'.$date_bits[0].' '.$time_bit;
		?>
    <p>Enquiry <?=$_SESSION[$ss]['enquiry_reference']?> created <?=$date_created?>, updated <?=$date_updated?></p>
    <input type="hidden" name="enquiry_reference" value="<?=$_SESSION[$ss]['enquiry_reference']?>"><?php
	} else
	{ ?> 
    <p>Enter customer details.</p><?php
	}
    $context = 'enquiry';
    include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/customer_details_form.php');
    if (isset($error2))
    {
    	$errm = 'The following amendments are required:<br/>'.$error2;
	} else {
		$errm = '';
	} ?>
	<span class="input" style="color: red;width:150px;text-align:left;"><b><?=$errm?></b></span>
	</td>
	</tr>
	</table>
    </form>
	<script language="JavaScript">
	<!-- // create calendar object(s) just after form tag closed
		 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
		 // note: you can have as many calendar objects as you need for your application
		// var cal1 = new calendar1(document.forms['searchform'].elements['sd']);
		// cal1.year_scroll = true;
		// cal1.time_comp = false;
		// var cal2 = new calendar2(document.forms['searchform'].elements['ed']);
		// cal2.year_scroll = true;
		// cal2.time_comp = false;
    Calendar.setup({
        inputField     :    "_sd",        // id of the input field
        ifFormat       :    "%d-%m-%Y",  //format of the input field
        showsTime      :    false        // will display a time selector
    }); 
    Calendar.setup({
        inputField     :    "_ed",        // id of the input field
        ifFormat       :    "%d-%m-%Y",  //format of the input field
        showsTime      :    false        // will display a time selector
    });
	//-->
	</script>
    <?=$_SESSION[$ss]['search_results']?>
    