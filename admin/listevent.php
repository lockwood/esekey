<?php
// +----------------------------------------------------------------------+
// | LIST  - Esekey Admin Console List Event   Page                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/list.php,v 1.00 2007/05/08
//


?>
    <!-- Page Number Links -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pagelinks"><?=$firstpage?> &nbsp;<?=$prevpage?> &nbsp; 
        <?php
        $pageno = 1;
        if ($pageno == $_SESSION[$ss]['pagenav']) {
            echo '<b>'.$_SESSION[$ss]['pagenav'].'</b>&nbsp;';
        } else {
            ?>
            <a href="list.php?view=<?=$view_name?>&pagenav=<?=$pageno?>&sid=<?=$sid?>"><?=$pageno?></a>&nbsp;
            <?php
        }
        for ($totrows = count($viewarray)- $pagerows; $totrows > 0; $totrows = $totrows - $pagerows) {
          $pageno++;
          if ($pageno == $_SESSION[$ss]['pagenav']) {
              echo '<b>'.$_SESSION[$ss]['pagenav'].'</b>&nbsp;';
          } else {
              ?>
              <a href="list.php?view=<?=$view_name?>&pagenav=<?=$pageno?>&sid=<?=$sid?>"><?=$pageno?></a>&nbsp;
              <?php
          }
        } ?> 
<?=$nextpage?> &nbsp;<?=$lastpage?></td>
			<td align="right" class="pagelinks">Page <?=$_SESSION[$ss]['pagenav']?> / <?=$pageno?></td>
		</tr>
	</table>

<form action="list.php" name="frmList" id="frmList" method="get">
	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">

		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                  <?php
                      $colcount = 1;
                      for ($i = 0; $i < count($label); $i++) {
                          if ($list[$i] == 'Y') { ?>
				      <td class="header-center"><?=$label[$i]?></td>
                              <?php
                              $colcount++;
                          } 
                      } ?>
			</tr>
                  <?php
                  $class = 'alt1';
                  if (count($viewarray) < 1) { // no rows found
                  ?>
                  <tr>
                  <td class="<?=$class?>-center" colspan="<?=$colcount?>">No rows matching selection criteria</td>
                  </tr>
                  <?php
                  }
                  for ($viewkey = $firstrow; $viewkey < $lastrow; $viewkey++) {
                    $viewrow = $viewarray[$viewkey]; ?>
                    <tr>
                    <?php
                        for ($i = 0; $i < count($column); $i++) {
                            if ($column[$i] == 'invoice_number') { ?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><input type="text" name="invoice_number[<?=$viewrow['event_date']?>]" value="<?=htmlentities($viewrow[$column[$i]])?>" class="input"/><input type="hidden" name="property_id[<?=$viewrow['event_date']?>]" value="<?=$viewrow['resource_id']?>"/></td>
                                <?php
                            } elseif ($list[$i] == 'Y') { ?>
                                <td class="<?=$class?>-<?=$justify[$i]?>"><?=htmlentities($viewrow[$column[$i]])?></td>
                                <?php
                            } 
						} ?>
                    </tr>
                    <?php
                    if ($class == 'alt1') {
                        $class = 'alt2';
                    }
                    else {
                        $class = 'alt1';
                    }
                  } ?>                    
		</table>

	</td></tr></table>		
		

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="33" valign="bottom" nowrap>
				<input type="button" name="btnBack" value="<< Back" class="button" 
                         onClick="top.Top.BackToURL('');">
				<input type="button" name="btnCre" value="Create from Booking" class="button-cust" 
                          onClick="if (confirm('This will clear any existing invoice reminders for this booking and create new records based on the booking data. \n\nSelect Cancel if you do not wish to override existing reminders.')){top.Top.GoToURL('2', 'List Invoice Reminders', 'list.php?view=event_view&cre=1&srch1=t2.booking_reference&op1=EQ&val1=<?=$val1?>&srch2=t1.event_type&op2=EQ&val2=I&')};">
				<input type="button" name="btnClr" value="Clear All" class="button-cust" 
                          onClick="if (confirm('This will clear all invoice reminders for this booking. \n\nSelect Cancel if you do not wish to delete existing reminders.')){top.Top.GoToURL('2', 'List Invoice Reminders', 'list.php?view=event_view&clr=1&srch1=t2.booking_reference&op1=EQ&val1=<?=$val1?>&srch2=t1.event_type&op2=EQ&val2=I&')};">
			</td>
			<td height="33" align="right" valign="bottom" nowrap><input type="submit" name="btnUpdate" value="Update" class="button">
		<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
      <input type="hidden" name="view" value="<?=$view_name?>">
      <input type="hidden" name="srch1" value="<?=$srch1?>">
      <input type="hidden" name="op1" value="<?=$op1?>">
      <input type="hidden" name="val1" value="<?=$val1?>">
      <input type="hidden" name="srch2" value="<?=$srch2?>">
      <input type="hidden" name="op2" value="<?=$op2?>">
      <input type="hidden" name="val2" value="<?=$val2?>">
      <input type="hidden" name="sid" value="<?=$sid?>">
</form>		
</div>

</body>
</html>