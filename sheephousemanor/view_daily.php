<?php 
// +----------------------------------------------------------------------+
// | VIEW_DAILY  - Calculate and Layout Daily Availability              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2007 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/view_daily.php,v 1.08 2007/02/20
//
?>
<div id=scrollblock><table width="100%" border="0" cellspacing="1" cellpadding="0"><?php
$i=0;
if ($select_property == '') {
	$property_count = 5;
    $property_count_2 = count($resourcearray) - $property_count;
} else {
    $property_count = 1;
    $property_count_2 = 0;
} 
while ($month_count <= 3) { ?>
  <tr>
    <td height="100%">
      <table height="100%" width="100%" border="0" cellspacing="1" cellpadding="0"><?php
       if ($month_count == 1) { ?> 
        <tr><td class="fill">&nbsp;</td></tr><?php
       }
       if ($disp_year > 0) { ?>
        <tr><td class="year">&nbsp;<?=$disp_year?></td></tr><?php
       } ?>
        <tr><td height="100%" valign="top" class="year">&nbsp;<?=$montharray[(0 + $c_month)]?></td></tr>
      </table>
    </td> 
  <?php
  while ($datearray[$i]['booking_month'] == $c_month) { ?>
    <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0"><?php
      if ($disp_year > 0) { 
          if ($month_count == 1) { ?> 
        <tr><td class="year-center" colspan="7"><?=$c_name?></td></tr><?php
          } ?>
        <tr>
          <td class="year-center" style="width:14%;">Sa</td>
          <td class="year-center" style="width:14%;">Su</td>
          <td class="year-center" style="width:14%;">Mo</td>
          <td class="year-center" style="width:14%;">Tu</td>
          <td class="year-center" style="width:14%;">We</td>
          <td class="year-center" style="width:14%;">Th</td>
          <td class="year-center" style="width:14%;">Fr</td>
        </tr>
      <?php
      } ?>
        <tr>
        <?php 
        if ($datearray[$i]['day_of_week'] < 6) { // 1st week of month does not start on Saturday 
            for ($j = 0; $j <= $datearray[$i]['day_of_week']; $j++) {
                ?>
                <td class="fill">&nbsp;</td><?php
                $c_day++;
            }
        }
    	$full_name = $datearray[$i]['property_name'];
        while (($full_name == $c_name) && ($datearray[$i]['booking_month'] == $c_month)) {
            if ($c_day > 7) { // new row needed
                $c_day = 1;  ?>
        </tr>
        <tr>
            <?php 
            } ?>
            <td class="<?=$datearray[$i]['display_status']?>">
            <?php
            if (($datearray[$i]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
                echo '<a href="#"
                onClick="top.Top.GoToURL(&quot;EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view&srch1=t1.booking_reference&op1=EQ&val1='.$datearray[$i]['booking_reference'].'&&quot;);"
                onMouseOver="return window.status=&quot;EseBooking&trade; &gt; Selected Booking&quot;;"
                onMouseOut="return window.status=&quot;&quot;;">'.$datearray[$i]['booking_day'].'</a></td>';
            } elseif ($datearray[$i]['display_status'] == 'E' && $start_booking && $_SESSION[$ss]['booking_flag'] == 'Y') {
                echo '<a href="idxs.php?p=6&d='.(0+$datearray[$i]['booking_day']).'&m='.(0+$datearray[$i]['booking_month']).'&y='.$datearray[$i]['booking_year'].'&r'.$selected_id.'=1&n=7&conditions=Acptcl"
                onMouseOver="return window.status=&quot;Make a booking starting on '.$datearray[$i]['booking_day'].' '.$montharray[(0 + $datearray[$i]['booking_month'])].'&quot;;"
                onMouseOut="return window.status=&quot;&quot;;">'.$datearray[$i]['booking_day'].'</a></td>';
            } else {
                echo $datearray[$i]['booking_day'].'</td>';
            }
            $i++;
	    	$full_name = $datearray[$i]['property_name'];
            $c_day++;
        }
        $c_name = $full_name;
        $c_day = 1; //ready for next block of dates
        ?>
        </tr>
      </table>
    </td>
  <?php 
  } ?>  
  </tr><?php
  $month_count++;
  $c_month = $datearray[$i]['booking_month'];
  if ($c_year == $datearray[$i]['booking_year']) {// year hasn't changed, don't show it
      $disp_year = 0;
  } else {
      $c_year = $datearray[$i]['booking_year'];
      $disp_year = $datearray[$i]['booking_year'];
  }
}
$col_count = $property_count + 1;
if ($property_count_2 > 0) { ?>
	</table><br /><br />
	<table align="center" border="0" cellspacing="1" cellpadding="0"><?php
	$c_year = $datearray_2[0]['booking_year'];
	$disp_year = $datearray_2[0]['booking_year'];
	$c_month = $datearray_2[0]['booking_month'];
	$month_count = 1;
	$c_name = $datearray_2[0]['property_name'];
	$c_day = 1; // start at beginning of row
	$i = 0;
	while ($month_count <= 3) { ?>
	  <tr>
	    <td height="100%">
	      <table height="100%" width="100%" border="0" cellspacing="1" cellpadding="0"><?php
	       if ($month_count == 1) { ?> 
	        <tr><td class="fill">&nbsp;</td></tr><?php
	       }
	       if ($disp_year > 0) { ?>
	        <tr><td class="year">&nbsp;<?=$disp_year?></td></tr><?php
	       } ?>
	        <tr><td height="100%" valign="top" class="year">&nbsp;<?=$montharray[(0 + $c_month)]?></td></tr>
	      </table>
	    </td> 
	  <?php
	  while ($datearray_2[$i]['booking_month'] == $c_month) { ?>
	    <td>
	      <table width="100%" border="0" cellspacing="1" cellpadding="0"><?php
	      if ($disp_year > 0) { 
	          if ($month_count == 1) { ?> 
	        <tr><td class="year-center" colspan="7"><?=$c_name?></td></tr><?php
	          } ?>
	        <tr>
	          <td class="year-center" style="width:14%;">Sa</td>
	          <td class="year-center" style="width:14%;">Su</td>
	          <td class="year-center" style="width:14%;">Mo</td>
	          <td class="year-center" style="width:14%;">Tu</td>
	          <td class="year-center" style="width:14%;">We</td>
	          <td class="year-center" style="width:14%;">Th</td>
	          <td class="year-center" style="width:14%;">Fr</td>
	        </tr>
	      <?php
	      } ?>
	        <tr>
	        <?php 
	        if ($datearray_2[$i]['day_of_week'] < 6) { // 1st week of month does not start on Saturday 
	            for ($j = 0; $j <= $datearray_2[$i]['day_of_week']; $j++) {
	                ?>
	                <td class="fill">&nbsp;</td><?php
	                $c_day++;
	            }
	        }
	    	$full_name = $datearray_2[$i]['property_name'];
	        while (($full_name == $c_name) && ($datearray_2[$i]['booking_month'] == $c_month)) {
	            if ($c_day > 7) { // new row needed
	                $c_day = 1;  ?>
	        </tr>
	        <tr>
	            <?php 
	            } ?>
	            <td class="<?=$datearray_2[$i]['display_status']?>">
	            <?php
	            if (($datearray_2[$i]['display_status'] != 'E') && ($ss == 'Admin')) {// hyperlink to booking ref
	                echo '<a href="#"
	                onClick="top.Top.GoToURL(&quot;EseBooking&quot;, &quot;Selected Booking&quot;, &quot;list.php?view=booking_view&srch1=t1.booking_reference&op1=EQ&val1='.$datearray_2[$i]['booking_reference'].'&&quot;);"
	                onMouseOver="return window.status=&quot;EseBooking&trade; &gt; Selected Booking&quot;;"
	                onMouseOut="return window.status=&quot;&quot;;">'.$datearray_2[$i]['booking_day'].'</a></td>';
	            } elseif ($datearray_2[$i]['display_status'] == 'E' && $start_booking && $_SESSION[$ss]['booking_flag'] == 'Y') {
	                echo '<a href="idxs.php?p=6&d='.(0+$datearray_2[$i]['booking_day']).'&m='.(0+$datearray_2[$i]['booking_month']).'&y='.$datearray_2[$i]['booking_year'].'&r'.$selected_id.'=1&n=7&conditions=Acptcl"
	                onMouseOver="return window.status=&quot;Make a booking starting on '.$datearray_2[$i]['booking_day'].' '.$montharray[(0 + $datearray_2[$i]['booking_month'])].'&quot;;"
	                onMouseOut="return window.status=&quot;&quot;;">'.$datearray_2[$i]['booking_day'].'</a></td>';
	            } else {
	                echo $datearray_2[$i]['booking_day'].'</td>';
	            }
	            $i++;
		    	$full_name = $datearray_2[$i]['property_name'];
	            $c_day++;
	        }
	        $c_name = $full_name;
	        $c_day = 1; //ready for next block of dates
	        ?>
	        </tr>
	      </table>
	    </td>
	  <?php 
	  } ?>  
	  </tr><?php
	  $month_count++;
	  $c_month = $datearray_2[$i]['booking_month'];
	  if ($c_year == $datearray_2[$i]['booking_year']) {// year hasn't changed, don't show it
	      $disp_year = 0;
	  } else {
	      $c_year = $datearray_2[$i]['booking_year'];
	      $disp_year = $datearray_2[$i]['booking_year'];
	  }
	}
	$col_count = $property_count_2 + 1;
}
?>
<tr><td colspan="<?=$col_count?>" class="fill"><i>The information in this table is current and is updated online.&nbsp;
  <?='Last real time update '.substr($last_updated,6,2).'/'.substr($last_updated,4,2).'/'.substr($last_updated,0,4).' '.substr($last_updated,8,2).':'.substr($last_updated,10,2).':'.substr($last_updated,12)?></i>  
</td></tr>
</table></div> 
