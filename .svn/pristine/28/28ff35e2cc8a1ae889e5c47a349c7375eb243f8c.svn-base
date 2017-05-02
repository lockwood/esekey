<?php 
// +----------------------------------------------------------------------+
// | DROPDOWN_VALIDATE  - populates dropdown list from table              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/dropdown_validate.php,v 1.02 2005/07/20
//

if ($company_contacts !== true)
{
	$tablearray = $db_object->getAll("SELECT *
    	                                FROM customer
        	                           WHERE company_id = '".$_SESSION[$ss]['company_id']."'
            	                    ORDER BY last_name, first_name");
} else
{
	if ($co_id == '')
	{
		// company not applicable - list all non-company customers
		$tablearray = $db_object->getAll("SELECT *
    		                                FROM customer
        		                           WHERE company_id = '".$_SESSION[$ss]['company_id']."'
        		                             AND customer_company_id = '0'
            		                    ORDER BY last_name, first_name");
	} elseif ($co_id == '0')
	{
		// new company - implies new contact - empty list
		$tablearray = array();
	} else
	{
		// list all customers for this company
		$tablearray = $db_object->getAll("SELECT *
    		                                FROM customer
        		                           WHERE company_id = '".$_SESSION[$ss]['company_id']."'
        		                             AND customer_company_id = '".$co_id."'
            		                    ORDER BY last_name, first_name");
	}
}
if (isset($cust_id)) {
    if ($cust_id > 0) {
        foreach($tablearray as $tablerow) {
            if ($cust_id == $tablerow['customer_id']) {
                $f = $tablerow['first_name'];
                $l = $tablerow['last_name'];
                for ($i=1; $i<count($titlearray); $i++) {
                  if ($titlearray[$i] == $tablerow['title']) {
                      $t = $i;
                  }
                }
                $a = $tablerow['post_address'];
                $q = $tablerow['post_code'];
                $u = $tablerow['telephone'];
                $e = $tablerow['email'];
            }
        }
    }
}

if (isset($tenant_id)) {
    if ($tenant_id > 0 && $add_tenant == 'yes') {
        foreach($tablearray as $tablerow) {
            if ($tenant_id == $tablerow['customer_id']) {
                $f_t = $tablerow['first_name'];
                $l_t = $tablerow['last_name'];
                for ($i=1; $i<count($titlearray); $i++) {
                  if ($titlearray[$i] == $tablerow['title']) {
                      $t_t = $i;
                  }
                }
                $a_t = $tablerow['post_address'];
                $q_t = $tablerow['post_code'];
                $u_t = $tablerow['telephone'];
                $e_t = $tablerow['email'];
            }
        }
    } else {
    	$tenant_id = 0;
    }
}

if ($company_contacts !== true)
{
	return;
}

$co_array = $db_object->getAll("SELECT *
                                    FROM customer_company
                                   WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                ORDER BY customer_company_name");

if (isset($co_id)) {
    if ($co_id > 0) {
        foreach($co_array as $co_row) {
            if ($co_id == $co_row['customer_company_id']) {
                $co = $co_row['customer_company_name'];
            }
        }
    }
}
