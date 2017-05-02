<?php 
// +----------------------------------------------------------------------+
// | AVAILABILITY  - Calculate and Layout Weekly Availability             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/availability.php,v 1.00 2003/10/01
//
foreach ($menuarray as $menurow) {
      $menu_page[] = $menurow[page_id];
} 
$montharray = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan');
// $viewweeks = 13; variable set by caller
$end_of_range = $viewweeks + 1;
$currday = $startday;
$curryear = $startyear;
$currmonth = $startmonth;
$_SESSION[$ss]['date'] = $curryear.'-'.$currmonth.'-'.$currday; // set current date in session
if (!isset ($_SESSION[$ss]['start_dates'])) {
    $_SESSION[$ss]['start_dates'] = array('');
    $_SESSION[$ss]['start_dates'][0] = $startyear.'-'.$startmonth.'-'.$startday;
} else {
    if (!in_array($startyear.'-'.$startmonth.'-'.$startday,$_SESSION[$ss]['start_dates'])) { 
        $count = count($_SESSION[$ss]['start_dates']);
        $_SESSION[$ss]['start_dates'][$count] = $startyear.'-'.$startmonth.'-'.$startday;
    }
}
// Format start date for display //
$j = 0 + $startmonth; // $j is integer index for montharray - cannot have leading zero
$display_start_date = $startday.' '.$montharray[$j].' '.$startyear;
// calculate calendar column spans for years and months //
// and populate arrays with dates                       //
$nextmonth = $currmonth;
$nextyear = $curryear;
$colsarray = array(0);
$dayarray = array(0);
$jdarray = array(0);
$datearray = array('');
$colsyr = 0;
$colsyr1 = 0;
$colsmth = 0;
$monthct = 1;
for ($i = 1; $i <= $viewweeks; $i++) {
    if ($nextmonth == $currmonth) {
        $colsmth++;
        $colsyr++;
    } else {
        $colsarray[$monthct] = $colsmth;
        $monthct++;
        $colsmth = 1;
        $currmonth = $nextmonth;
        if ($nextyear == $curryear) {
            $colsyr++;
        } else {
            $colsyr1 = $colsyr;
            $colsyr = 1;
            $curryear = $nextyear;
        } 
    }
    $dayarray[$i] = $currday;
    // use seconds since the Unix Epoch / 86400 for reliable calculations including leap years etc.
    $jdarray[$i] = date("U",$nextsat)/86400;
    $datearray[$i] = $curryear.'-'.$currmonth.'-'.$currday;
    $currday = $currday + 7;
    $nextsat = mktime(0, 0, 0, $currmonth, $currday, $curryear); // converts day for new month //
    $nextmonth = date("m",$nextsat);
    $currday = date("d",$nextsat);
    $nextyear = date("Y",$nextsat);
}
$colsarray[$monthct] = $colsmth;
if ($colsyr1 == 0) { // all dates are within same year //
    $colsyr1 = $colsyr;
    $colsyr = 0;
}
//populate extra row in array with start dates of following week for calculations
$jdarray[$end_of_range] = date("U",$nextsat)/86400;
$datearray[$end_of_range] = $nextyear.'-'.$nextmonth.'-'.$currday;
// show navigation links to previous and next //     
$count = count($_SESSION[$ss]['start_dates']);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left"><b><?='View by week starting on Saturday '.$display_start_date?></b></td>
    <td align="right"><?php
    for ($i = 0; $i < $count; $i++) {
        if ($_SESSION[$ss]['start_dates'][$i] == $_SESSION[$ss]['date']) {
            if ($i > 0) { ?>
                <a href="index.php?id=<?=$_SESSION[$ss]['company_id']?>&s=5&p=<?=$menu_page[0]?>&r=0&t=<?=$window_type.'&d='.$_SESSION[$ss]['start_dates'][$i - 1]?>"><< Prev 3 months</a><?php
            } else { ?>
                << Prev 3 months
<?php
            }
        }
    }  
?>
&nbsp;<a href="index.php?id=<?=$_SESSION[$ss]['company_id']?>&s=5&p=<?=$menu_page[0]?>&r=0&t=<?=$window_type.'&d='.$datearray[$end_of_range]?>">Next 3 months >></a>
  </td></tr>
</table>
<br><br>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td class="fill">&nbsp;</td>
    <td class="year-center" colspan="<?=$colsyr1?>"><b><?=$startyear?></b></td><?php
    if ($colsyr > 0) {
        $startyear++; ?> 
        <td class="year-center" colspan="<?=$colsyr?>"><b><?=$startyear?></b></td><?php
    } ?>
  </tr>
  <tr>
    <td class="year" rowspan="2"><b>Cottage</b></td>
    <?php 
    $j = 0 + $startmonth; // $startmonth may have leading zero. $j is an integer index for $montharray //
    for ($i = 1; $i <= $monthct; $i++) { ?>
        <td class="year-center" colspan="<?=$colsarray[$i]?>"><b><?=$montharray[$j]?></b></td><?php
        $j++;
        if ($j > 12) {
            $j = 1;
        }
    } ?>
  </tr>
  <tr>
    <?php 
    for ($i = 1; $i < $end_of_range; $i++) { ?>
        <td class="year-center"><b><?=$dayarray[$i]?></b></td><?php
    } ?>
  </tr>
  <?php foreach ($resourcearray as $propertyrow) { 
      $diaryarray = $db_object->getAll("SELECT start_date,
                                               end_date,
                                               DATE_FORMAT(start_date, '%d')AS start_day,
                                               DATE_FORMAT(start_date, '%m')AS start_month, 
                                               DATE_FORMAT(start_date, '%Y')AS start_year, 
                                               DATE_FORMAT(end_date, '%d')AS end_day,
                                               DATE_FORMAT(end_date, '%m')AS end_month,
                                               DATE_FORMAT(end_date, '%Y')AS end_year,
                                               entry_status

                                          FROM diary 
                                         WHERE company_id = '".$_SESSION[$ss]['company_id']."' AND
                                               resource_id = '$propertyrow[property_id]' AND
                                               start_date < '$datearray[$end_of_range]' AND 
                                               end_date > '$datearray[1]' AND
                                               booking_reference <> '".$_SESSION[$ss]['booking_reference']."' AND
                                               expiry > now()
                                      ORDER BY start_date"); 
             // will need to look at archiving and deleting expired rows .....
  ?>
      <tr>
        <td class="year" nowrap height="20"><a 
        href="javascript:DoPopup(2,<?=$propertyrow[page_id]?>,<?=$propertyrow[property_id]?>,'p','<?=$_SESSION[$ss]['date']?>',500,'<?=$_SESSION[$ss]['booking_date']?>');"><?=$propertyrow[name]?></a></td>
        <?php 
        $i = 1;
        $daysused = 0; 
        foreach ($diaryarray as $diaryrow) {
            while ($diaryrow[start_date] >= $datearray[$i + 1] && $i < $end_of_range) {
                // this diary entry is for a future week
                if ($daysused > 0) {
                    // previous diary entry affected this week - partially booked
                    ?><td class="prov-center">X</td><?php
                    $daysused = 0;
                } else {
                    $price_found = false;
                    foreach ($pricearray as $pricerow) {
                        // find weekly price for this property
                        if ($propertyrow[price_code] == $pricerow[price_code]
                            && $pricerow[start_date] <= $datearray[$i]
                            && $pricerow[end_date] >= $datearray[$i + 1]) {
                            $price = '£'.$pricerow[weekly_rate];
                            $price_found = true;
                        }
                    }
                    if (!$price_found) {
                        $price = 'POA';
                    }
                    ?><td class="avail-center"><a 
                    href="index.php?id=<?=$_SESSION[$ss]['company_id']?>&s=5&p=<?=$menu_page[1]?>&r=<?=$propertyrow[property_id].'&t='.$window_type.'&d='.$_SESSION[$ss]['date'].'&b='.$datearray[$i]?>"><?=$price?></a></td><?php
                }
                $i++;
            }
            if ($diaryrow[start_date] < $datearray[$i + 1] && $diaryrow[end_date] >= $datearray[$i]) {
                // this is a diary entry affecting this week
                if ($diaryrow[start_date] >= $datearray[$i]) {
                    // the diary entry starts during this week
                    $jdstart = date('U', mktime(0,0,0,$diaryrow[start_month],$diaryrow[start_day],$diaryrow[start_year]))/86400;
                    $startday = $jdstart - $jdarray[$i];
                } else {
                    // the diary entry started in a previous week and continues into this one
                    $startday = 0;
                }
                $jdend = date('U', mktime(0,0,0,$diaryrow[end_month],$diaryrow[end_day],$diaryrow[end_year]))/86400;
                $endday = $jdend - $jdarray[$i];
                if ($endday > 6) {
                    // this diary entry goes beyond this week, don't use next weeks days yet
                    $daysused = $daysused + 7 - $startday;
                } else {
                    // this diary entry finishes within this week
                    $daysused = $daysused + $endday - $startday;
                }
                while ($endday > 6 && $i < $end_of_range) {
                    //entry goes up to end of this week - display the week and reset the counts
                    //do not display any weeks beyond end of range.
                    if ($daysused > 6) {
                        // diary full this week
                        ?><td class="rsrv-center">X</td><?php
                    } else { 
                        // diary part booked this week
                        ?><td class="prov-center">X</td><?php
                    }
                    $i++;
                    $endday = $endday - 7;
                    if ($endday > 6) {
                        // this diary entry goes beyond this week, don't use next weeks days yet
                        $daysused = 7;
                    } else {
                        // this diary entry finishes within this week
                        $daysused = $endday;
                    }
                } 
            } 
        }
        while ($i <= $viewweeks) {
            // no more diary entries - display remaining weeks
            if ($daysused > 0) {
                // previous diary entry affected this week - partially booked
                ?><td class="prov-center">X</td><?php
                $daysused = 0;
            } else {
                $price_found = false;
                foreach ($pricearray as $pricerow) {
                    // find weekly price for this property
                    if ($propertyrow[price_code] == $pricerow[price_code]
                        && $pricerow[start_date] <= $datearray[$i]
                        && $pricerow[end_date] >= $datearray[$i + 1]) {
                        $price = '£'.$pricerow[weekly_rate];
                        $price_found = true;
                    }
                }
                if (!$price_found) {
                    $price = 'POA';
                }
                ?><td class="avail-center"><a 
                href="index.php?id=<?=$_SESSION[$ss]['company_id']?>&s=5&p=<?=$menu_page[1]?>&r=<?=$propertyrow[property_id].'&t='.$window_type.'&d='.$_SESSION[$ss]['date'].'&b='.$datearray[$i]?>"><?=$price ?></a></td><?php
            }
            $i++;
        } ?>
      </tr>
      <?php
  } ?> 
</table>
