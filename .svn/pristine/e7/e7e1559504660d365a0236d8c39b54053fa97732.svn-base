<?php
// +----------------------------------------------------------------------+
// | GETENQUIRYDATA  - Esekey Admin Console get enquiry view              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getenquirydata.php,v 1.00 2007/08/26
//

// set property name preference
if ($show_property_number)
{
	$name_select = "LTRIM(CONCAT(property_number, ' ', property_name)) AS property_name";
} else
{
	$name_select = "property_name";
}

// get view data and initialise array
$viewarray = $db_object->getAll("SELECT DISTINCT 
                                         t1.enquiry_reference,
										 DATE_FORMAT(t1.created_date, '%d-%b-%y') AS created_date,
                                         CONCAT(t2.last_name, ', ', t2.first_name) As last_name,
                                         t2.email,
                                         CONCAT(t1.property_id, '¬', t1.beds, '¬', t1.sleeps) as property_name,
                                         DATE_FORMAT(t1.start_date, '%d-%b-%y') AS start_date,
										 t1.nights
                                    FROM enquiry AS t1,
                                         customer AS t2
                                   WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                     AND t1.company_id = t2.company_id
                                     AND t1.contact_id = t2.customer_id
                                     AND t1.expiry > now()
                                     ".$searchstring1."
                                     ORDER BY t1.created_date, t1.enquiry_reference");
if (!is_array($viewarray)) $viewarray = array();
for ($i=0;$i<count($viewarray);$i++)
{
	$prefs = explode('¬', $viewarray[$i]['property_name']);
	$formatted_prefs = array();
	if (isset($prefs[0]) && $prefs[0] > 0)
	{
		$formatted_prefs[] = $db_object->getOne("SELECT ".$name_select." 
																FROM property 
															   WHERE property_id = ".$prefs[0]."
																 AND company_id = '".$_SESSION[$ss]['company_id']."'");
	}
	if (isset($prefs[1]) && $prefs[1] > 0)
	{
		$formatted_prefs[] = $prefs[1].' beds';
	}
	if (isset($prefs[2]) && $prefs[2] > 0)
	{
		$formatted_prefs[] = 'slps '.$prefs[2];
	}
	if ($viewarray[$i]['start_date'] == '')
	{
		$viewarray[$i]['start_date'] = 'Any';
		$viewarray[$i]['nights'] = '';
	}
	$viewarray[$i]['property_name'] = implode(', ', $formatted_prefs);
}
// cludge to override descriptor labels
$label[1] = 'Enquiry Date';
$label[2] = 'Name';
$label[4] = 'Preferences';
$label[6] = 'Nts';

$columns = $viewarray[0];
if (count($columns) > 0) {
  foreach ($columns as $viewkey => $viewcolumn) {
    foreach ($descriptorarray as $descriptorrow) {
        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
            $column[] = $viewkey;
        }
    }
  }
}
?>