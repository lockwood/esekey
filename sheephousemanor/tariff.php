<?php
// +----------------------------------------------------------------------+
// | TARIFF  - EseSite booking tariff display - Company 4                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/tariff.php,v 1.05 2006/10/19
//

$sleeparray = array (1=>"2", 2=>"4", 3=>"2", 4=>"2", 5=>"2-4", 9=>"3-6", 10=>"2");
$typearray = array (1=>"Studio with double bed, kitchenette and shower room",
                    2=>"Main bedroom with double and a single chair bed, 2nd bedroom with twin beds and en-suite bathroom. Shower room, lounge/dining room, kitchen",
                    3=>"Double bedroom, lounge with sofa bed, kitchen and en-suite shower",
                    4=>"Large studio with double bed, sofa bed, kitchen and en-suite shower",
                    5=>"Double and twin bedrooms, bathrooms, kitchen/diner, lounge, patio garden",
                    9=>"One double and two twin bedded rooms, three bathrooms, and kitchen/diner/area with TV",
                    10=>"Double bedroom, lounge with sofa bed, kitchen and en-suite shower");
$promoarray = $db_object->getAll("SELECT *
                                       FROM promotions
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND active_flag = 'Y'
										AND end_date > DATE_ADD(CURDATE(), INTERVAL min_nights DAY )
                                   ORDER BY end_date;");
$today = date('Y-m-d');                    
?>
<table width="750" cellspacing="0" align="center" cellpadding="4">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>  <tr>    <td><b>2015/16 Rates</b></td><td colspan="4">&nbsp;</td>  </tr>
  <?php
 if (count($promoarray) > 0) {
 	if (count($promoarray) > 1 ) {
 		$plural = 's';
 		$limit = 'Only one offer applicable per booking.<br />';
 	} else {
 		$plural = '';
 		$limit = '';
 	}
	?>
  <tr>
    <th colspan="5">Promotional Offer<?=$plural?></th>
  </tr>
 	<?php
 	foreach ($promoarray as $promo) {
 		if ($promo['start_date'] < $today) {
			$valid = 'Valid until '.date('jS F', strtotime($promo['end_date'])).'.';	
 		} else {
 			$valid = 'Valid from '.date('jS F', strtotime($promo['start_date'])).' until '.date('jS F', strtotime($promo['end_date'])).' inclusive.';
 		}
 		?>
  <tr>
    <td colspan="5"><strong><?=$promo['title'].'</strong><br />'.$valid;?><br />To claim, enter code PROMO<?=$promo['promotion_id']?> in Additional Information on the booking form.</td>
  </tr>
 		<?php
	}
	?>
  <tr>
    <td colspan="5"><?=$limit?>The price shown on the booking form will be the full price - the promotional offer will be applied when the provisional booking is confirmed. <br />&nbsp;</td>
  </tr>
	<?php
 }
  ?>
  <tr>
    <th colspan="5">Self Catering</th>
  </tr>
  <tr>
    <th>Cottage<sup> </sup></th><th width="100" style="text-align:left;">Type<sup> </sup></th><th>Sleeps<sup> </sup></th><th>Weekly<sup> </sup></th><th>Peak<sup>*</sup></th>
  </tr>
  <?php$chalet1_rate = 60; // 86 for Olympics$chalet2_rate = 120; // 172 for Olympics$chalet3_rate = 75; // 114 for Olympics$southlands_rate = 150; // 172 for Olympics$ww_rate = 140; // 214 for Olympics// peak rates re-instated for 2014-15$end_date = $db_object->getOne("SELECT date_add('".$start_date."', interval '".$n."' day)");$chalet1_rate_p = 70; // 86 for Olympics$chalet2_rate_p = 140; // 172 for Olympics$chalet3_rate_p = 85; // 114 for Olympics$southlands_rate_p = 170; // 172 for Olympics$ww_rate_p = 165; // 214 for Olympics  
$low_array = array(1=>50,2=>100,3=>65,4=>65,5=>110,9=>125,10=>65);
$high_array = array(1=>60,2=>120,3=>75,4=>75,5=>135,9=>140,10=>75);
foreach ($resourcearray as $propertyrow) {
//    foreach ($pricearray as $pricerow) {
//        if ($pricerow['price_code'] == $propertyrow['price_code']) {
            echo '<tr><td align="center">'.$propertyrow['property_name'].'</td>';
            echo '<td width="400">'.$typearray[$propertyrow[property_id]].'</td>';
            echo '<td align="center">'.$sleeparray[$propertyrow[property_id]].'</td>';
            echo '<td align="center">£'.number_format($low_array[$propertyrow[property_id]]*7.00,2).'</td>';            echo '<td align="center">£'.number_format($high_array[$propertyrow[property_id]]*7.00,2).'</td></tr>';            //        }
//    }
} ?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>    <td><b>*</b>Peak&nbsp;rate&nbsp;periods</td>    <td colspan="5">13.06.2015 - 05.09.2015; 19.12.2015 - 03.01.2016; 14.06.2016 - 06.09.2016</td>  </tr>  <tr>
    <td colspan="5">Self Catering Prices include VAT and Service, towels, linen, heating, lighting and weekly cleaning. One week minimum let.<br/><br/>
Pets £5.00 per night per pet.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>    <td colspan="5"><b>B&amp;B</b></td>  </tr>  <tr>    <td colspan="5">Singles from £75.00/night. Double or twin from £80.00/night. Fri/Sat nights from £90. Minimum 2 nights stay on Saturdays. Inclusive of VAT and continental breakfast.</td>  </tr>  <tr>    <td colspan="5">&nbsp;</td>  </tr>  <tr>
    <th colspan="5">Legoland / Chessington World of Adventures / Thorpe Park</th>
  </tr>
  <tr>
    <td colspan="5">Tickets for 2 consecutive days at each of these venues may be booked with
your accommodation for &pound;45.00 per adult or child.
Tickets valid for 1 venue each and must be prepaid and are non refundable.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table> 
