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

$sleeparray = array (1=>"1-2", 2=>"2-5", 3=>"2-3", 4=>"2-3", 5=>"2-5", 9=>"3-6", 10=>"2-3");
$typearray = array (1=>"Studio with double bed, kitchenette and shower room",
                    2=>"Main bedroom with double and a single chair bed, 2nd bedroom with twin beds and en-suite bathroom. Shower room, lounge/dining room, kitchen",
                    3=>"Double bedroom, lounge with sofa bed, kitchen and bathroom",
                    4=>"Large studio with double bed, sofa bed, kitchen and bathroom",
                    5=>"Double and twin bedrooms, bathrooms, kitchen/diner, lounge with sofa bed, patio garden",
                    9=>"One double and two twin bedded rooms, three bathrooms, and kitchen/diner",
                    10=>"Double bedroom, lounge with sofa bed, kitchen and bathroom.");
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
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4">Bed &amp; Breakfast</th>
  </tr>
  <tr>
    <td colspan="4">B &amp; B Prices include continental buffet, VAT and service.</td>
  </tr>
  <tr>
    <td><b>2014 Rates</b></td><td colspan="3">Single en suite from &pound;60.00 per night.  Double or twin en suite from &pound;70.00 per night<br/>Fri/Sat nights from &pound;75.00 / &pound;85.00. Saturday night bookings, minimum stay 2 nights.</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
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
    <th colspan="4">Promotional Offer<?=$plural?></th>
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
    <td colspan="4"><strong><?=$promo['title'].'</strong><br />'.$valid;?><br />To claim, enter code PROMO<?=$promo['promotion_id']?> in Additional Information on the booking form.</td>
  </tr>
 		<?php
	}
	?>
  <tr>
    <td colspan="4"><?=$limit?>The price shown on the booking form will be the full price - the promotional offer will be applied when the provisional booking is confirmed. <br />&nbsp;</td>
  </tr>
	<?php
 }
  ?>
  <tr>
    <th colspan="4">Self Catering</th>
  </tr>
  <tr>
    <th>Cottage<sup> </sup></th><th width="100" style="text-align:left;">Type<sup> </sup></th><th>Sleeps<sup> </sup></th><th>Weekly<sup> </sup></th>
  </tr>
  <?php
$low_array = array(1=>60,2=>120,3=>75,4=>75,5=>135,9=>140,10=>75);
//$high_array = array(1=>50,2=>100,3=>65,4=>65,5=>110);
foreach ($resourcearray as $propertyrow) {
//    foreach ($pricearray as $pricerow) {
//        if ($pricerow['price_code'] == $propertyrow['price_code']) {
            echo '<tr><td align="center">'.$propertyrow['property_name'].'</td>';
            echo '<td width="400">'.$typearray[$propertyrow[property_id]].'</td>';
            echo '<td align="center">'.$sleeparray[$propertyrow[property_id]].'</td>';
            echo '<td align="center">£'.number_format($low_array[$propertyrow[property_id]]*7.00,2).'</td></tr>';
//        }
//    }
} ?>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Self Catering Prices include VAT and Service, towels, linen, heating, lighting and weekly cleaning. One week minimum let.<br/><br/>
Pets £13.00 per night per pet.</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4">Legoland / Chessington World of Adventures / Thorpe Park</th>
  </tr>
  <tr>
    <td colspan="4">Tickets for 2 consecutive days at each of these venues may be booked with
your accommodation for &pound;45.00 per adult or child.
Tickets valid for 1 venue each and must be prepaid and are non refundable.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table> 
