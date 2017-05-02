<?php
// +----------------------------------------------------------------------+
// | SOURCES  - Esekey Admin Console Booking Sources (Troppo)             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/sources.php,v 1.00 2007/07/21
//

//get active session
session_start();
// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');
//print_r($_SESSION[$ss]);

include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/data_settings.php');
include('Spreadsheet/Excel/Writer.php');

//TODO get this from database!
$properties = array("1"=>"Wisteria","2"=>"Gardener's Bothy","3"=>"The Smithy");

$today = date('Y-m-d');
$occupancy = $db_object->getAll("SELECT calendar_booking.booking_date, 
										calendar_booking.resource_id, 
										calendar_booking.booking_reference,
										booking.booking_status 
								   FROM calendar_booking, booking 
								  WHERE calendar_booking.booking_reference = booking.booking_reference 
									AND calendar_booking.booking_date < '".$today."'
									AND calendar_booking.company_id = '".$_SESSION[$ss]['company_id']."' 
									AND booking.company_id = '".$_SESSION[$ss]['company_id']."'
							");

$result = array();
foreach ($occupancy as $occupancy_row) {
	$result[$occupancy_row['booking_date']][$occupancy_row['resource_id']] = array("ref"=>$occupancy_row['booking_reference'],"stat"=>$occupancy_row['booking_status']);
}

ksort($result);
//********************************************
$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Occupancy_'.date('d_M_Y').'.xls');
// add formats			
$format_left =& $workbook->addFormat();
$format_left->setAlign('left');
$format_center =& $workbook->addFormat();
$format_center->setAlign('center');
$format_bold =& $workbook->addFormat();
$format_bold->setBold();
$format_bold->setAlign('center');
$format_bold_r =& $workbook->addFormat();
$format_bold_r->setBold();
$format_bold_r->setAlign('top');
$format_bold_r->setAlign('right');
$format_bold_l =& $workbook->addFormat();
$format_bold_l->setBold();
$format_bold_l->setAlign('top');
$format_bold_l->setAlign('left');


$year = '';
foreach ($result as $date=>$property_array) {
	if (substr($date,0,4) != $year) {
		$year = substr($date,0,4);
		$worksheet =& $workbook->addWorksheet($year);
		$worksheet->write(1, 0, "Date", $format_bold); 
		$worksheet->write(0, 1, "Wisteria", $format_bold_l); 
		$worksheet->write(0, 3, "Gardener's Bothy", $format_bold_l); 
		$worksheet->write(0, 5, "The Smithy", $format_bold_l); 
		$worksheet->write(1, 1, 'Ref', $format_bold); 
		$worksheet->write(1, 2, 'Occ', $format_bold); 
		$worksheet->write(1, 3, 'Ref', $format_bold); 
		$worksheet->write(1, 4, 'Occ', $format_bold); 
		$worksheet->write(1, 5, 'Ref', $format_bold); 
		$worksheet->write(1, 6, 'Occ', $format_bold); 
		$worksheet->setColumn(0,0,12);
		$worksheet->setColumn(1,6,8);
		$row = 2;
	}
	$worksheet->write($row, 0, $date);
	if ($property_array[1]['stat'] == "Balance Paid") {
		$worksheet->write($row, 1, $property_array[1]['ref']);
		$worksheet->write($row, 2, '1');
	}
	if ($property_array[2]['stat'] == "Balance Paid") {
		$worksheet->write($row, 3, $property_array[1]['ref']);
		$worksheet->write($row, 4, '1');
	}
	if ($property_array[3]['stat'] == "Balance Paid") {
		$worksheet->write($row, 5, $property_array[1]['ref']);
		$worksheet->write($row, 6, '1');
	}
	$row++;
}
$workbook->close();
return;