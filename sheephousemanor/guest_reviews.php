<?php
// +----------------------------------------------------------------------+
// |GUEST_REVIEWS  - Company 4 - Show latest approved guest reviews       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/guest_reviews.php,v 1.02 2013/02/20
//

$reviewarray = $db_object->getAll("SELECT *
                                       FROM reviews
                                      WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                                        AND review_status = 'Y'
                                   ORDER BY arrival_date DESC, guest_info ASC LIMIT 50;");
$total = count($reviewarray);
$rev = 1;
?>
<div id="screen">
<p style="margin:1em 1.5em;"><a href="javascript:void(0);" style="color:blue;" class="prev" alt="prev" title="prev"><&nbsp;Prev</a><?=' Showing review #<span id="revno">'.$rev.'</span> of '.$total.' reviews. ';?><a href="javascript:void(0);" style="color:blue;" class="next" alt="next" title="next">Next&nbsp;></a></p>
<div id="sections">
<ul class="pane">
<?php
foreach ($reviewarray as $review) {
    ?>
<li class="pane <?=$rev?>">
<h4 style="text-align:center"><i><?=$review['guest_info']?></i> on <?=date('d M Y', strtotime($review['arrival_date']))?></h4>
<h2 style="text-align:center;font-size:10pt;"><?=$review['title']?></h2>
<?php
if ($review['q1'] > 0) { // only show ratings if they've been entered 
?>
<ul>
<li>Cleanliness <?=$review['q1']?></li>
<li>Comfort of room <?=$review['q2']?></li>
<?=$review['q3']>0 ? '<li>Quality of food '.$review['q3'].'</li>' : ''?>
<?=$review['q4']>0 ? '<li>Customer Service '.$review['q4'].'</li>' : ''?>
<li>Value for money <?=$review['q5']?></li>
</ul>
<?php
}
?>
<p style="margin:1em 2em;"><?=nl2br($review['comments'])?></p>
</li>
<?php
	$rev++;
}
?>
</ul>
</div></div>