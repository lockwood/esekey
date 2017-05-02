<?php 
// +----------------------------------------------------------------------+
// | DROPDOWN  - populates dropdown list from table                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/dropdown.php,v 1.00 2004/10/18
//
if ($company_contacts === true)
{
	if ($company_dropdown === true)
	{
		$new_co = '';
		if ($co_id == '0') $new_co = ' SELECTED'; 
		?>
              <SELECT NAME="co_id" class="input" onChange="submit();">
              <OPTION VALUE="">** Not Applicable **</OPTION>
              <OPTION VALUE="0"<?=$new_co?>>---New Company---</OPTION>
		<?php
		foreach ($co_array as $co_row) {
  			if ($co_row['customer_company_id'] == $co_id) { ?>
              <OPTION VALUE="<?=$co_row['customer_company_id']?>" SELECTED>
                <?=$co_row['customer_company_name']?></OPTION><?php
			} else { ?>
              <OPTION VALUE="<?=$co_row['customer_company_id']?>">
                <?=$co_row['customer_company_name']?></OPTION><?php
  			}
		} ?>		
              </SELECT>
		<?php
		return;
	} elseif ($tenant_dropdown === true)
	{
		$init_val = '---New Tenant---';
		$sel_name = 'tenant_id';
		$test_id = $tenant_id;
	} else
	{
		$init_val = '---New Contact---';
		$sel_name = 'cust_id';
		$test_id = $cust_id;
	}
} else
{
	$init_val = '---New Customer---';
	$sel_name = 'cust_id';
	$test_id = $cust_id;
}
?>
              <SELECT NAME="<?=$sel_name?>" class="input" onChange="submit();">
              <OPTION VALUE="0"><?=$init_val?></OPTION>
<?php 
foreach ($tablearray as $tablerow) {
  if ($tablerow[customer_id] == $test_id) { ?>
              <OPTION VALUE="<?=$tablerow['customer_id']?>" SELECTED>
                <?=$tablerow['customer_id'].' '.$tablerow['last_name'].', '.$tablerow['first_name']?></OPTION><?php
  } else { ?>
              <OPTION VALUE="<?=$tablerow['customer_id']?>">
                <?=$tablerow['customer_id'].' '.$tablerow['last_name'].', '.$tablerow['first_name']?></OPTION><?php
  }
} ?>
              </SELECT>
