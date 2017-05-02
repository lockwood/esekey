<?php
// +----------------------------------------------------------------------+
// |GUEST_REVIEW_FORM  - Company 4 - Show guest review form               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2013 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/guest_review_form.php,v 1.00 2013/03/03
//
if (isset($_SESSION[$ss]['thanks'])) {
	// form submission complete, display thank you message and remove it from the session
	echo $_SESSION[$ss]['thanks'];
	unset($_SESSION[$ss]['thanks']);
	return;
}

$sel = array(6=>'');
foreach($resourcearray as $propertyrow) {
	$sel[$propertyrow['property_id']] = '';
}

if (isset($_POST) && count($_POST) > 0) {
	// form has been submitted, but errors have been found in guest_review_validate.php, otherwise we would not get here....
	$q1 = 0;
	$q2 = 0;
	$q3 = 0;
	$q4 = 0;
	$q5 = 0;
	foreach($_POST as $k=>$v) {
		if (in_array($k,array('name','arrival_date','property','q1','q2','q3','q4','q5','comments'))) {
			$$k = $v;
		}
	}
} else {
	$form_errors = '';
	$name = '';
	$arrival_date = '';
	$property = 0;
	$q1 = 0;
	$q2 = 0;
	$q3 = 0;
	$q4 = 0;
	$q5 = 0;
	$comments = ''; 
}
if ($property > 0) $sel[$property] = 'selected="selected"';
$checked = array(0=>'',1=>' checked="checked"');
$property = '<select name="property" id="property" style="font-size:1em;">
				<option value="0">Please Specify...</option>
				<option value="6" '.$sel[6].'>B &amp; B </option>';
foreach ($resourcearray as $propertyrow) {
	$property .= '
				<option value="'.$propertyrow['property_id'].'" '.$sel[$propertyrow['property_id']].'>Self Catering - '.$propertyrow['property_name'].'</option>';
}
$property .= '
			</select>';
?>
<h4 style="text-align:center">If you have stayed with us, please use this form to provide feedback.</h4>
<?=$form_errors?>
<form name="eform" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table style="margin:10px">
<tr><td colspan="6"><strong>About you and your booking</strong></td></tr>
<tr><td>Your name<span style="color:red;">*</span></td><td colspan="5"><input class="input" maxlength="20" size="20" type="text" id="name" name="name" value="<?=$name?>"/></td></tr>
<tr><td>Arrival Date<span style="color:red;">*</span></td><td colspan="5"><input class="input" maxlength="10" size="10" type="text" id="arrival_date" name="arrival_date" value="<?=$arrival_date?>"/></td></tr>
<tr><td>Accommodation<span style="color:red;">*</span></td><td colspan="5"><?=$property?></td></tr>
<tr><td colspan="6"><strong>Your feedback</strong></td></tr>
<tr><td colspan="6">Please Rate the following:</td></tr>
<tr><td colspan="6">1=poor,2=average,3=good,4=very good,5=excellent</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;&nbsp;1</td><td>&nbsp;&nbsp;2</td><td>&nbsp;&nbsp;3</td><td>&nbsp;&nbsp;4</td><td>&nbsp;&nbsp;5</td></tr>
<tr><td style="padding-left:10px;">Cleanliness<span style="color:red;">*</span></td>
	<td><input type="radio" name="q1" value="1" id="q1_1"<?=$checked[$q1==1]?> /></td>
	<td><input type="radio" name="q1" value="2" id="q1_2"<?=$checked[$q1==2]?> /></td>
	<td><input type="radio" name="q1" value="3" id="q1_3"<?=$checked[$q1==3]?> /></td>
	<td><input type="radio" name="q1" value="4" id="q1_4"<?=$checked[$q1==4]?> /></td>
	<td><input type="radio" name="q1" value="5" id="q1_5"<?=$checked[$q1==5]?> /></td>
</tr>
<tr><td style="padding-left:10px;">Comfort of room<span style="color:red;">*</span></td>
	<td><input type="radio" name="q2" value="1" id="q2_1"<?=$checked[$q2==1]?> /></td>
	<td><input type="radio" name="q2" value="2" id="q2_2"<?=$checked[$q2==2]?> /></td>
	<td><input type="radio" name="q2" value="3" id="q2_3"<?=$checked[$q2==3]?> /></td>
	<td><input type="radio" name="q2" value="4" id="q2_4"<?=$checked[$q2==4]?> /></td>
	<td><input type="radio" name="q2" value="5" id="q2_5"<?=$checked[$q2==5]?> /></td>
</tr>
<tr><td style="padding-left:10px;">Quality of food</td>
	<td><input type="radio" name="q3" value="1" id="q3_1"<?=$checked[$q3==1]?> /></td>
	<td><input type="radio" name="q3" value="2" id="q3_2"<?=$checked[$q3==2]?> /></td>
	<td><input type="radio" name="q3" value="3" id="q3_3"<?=$checked[$q3==3]?> /></td>
	<td><input type="radio" name="q3" value="4" id="q3_4"<?=$checked[$q3==4]?> /></td>
	<td><input type="radio" name="q3" value="5" id="q3_5"<?=$checked[$q3==5]?> /></td>
</tr>
<tr><td style="padding-left:10px;">Customer service</td>
	<td><input type="radio" name="q4" value="1" id="q4_1"<?=$checked[$q4==1]?> /></td>
	<td><input type="radio" name="q4" value="2" id="q4_2"<?=$checked[$q4==2]?> /></td>
	<td><input type="radio" name="q4" value="3" id="q4_3"<?=$checked[$q4==3]?> /></td>
	<td><input type="radio" name="q4" value="4" id="q4_4"<?=$checked[$q4==4]?> /></td>
	<td><input type="radio" name="q4" value="5" id="q4_5"<?=$checked[$q4==5]?> /></td>
</tr>
<tr><td style="padding-left:10px;">Value for money<span style="color:red;">*</span></td>
	<td><input type="radio" name="q5" value="1" id="q5_1"<?=$checked[$q5==1]?> /></td>
	<td><input type="radio" name="q5" value="2" id="q5_2"<?=$checked[$q5==2]?> /></td>
	<td><input type="radio" name="q5" value="3" id="q5_3"<?=$checked[$q5==3]?> /></td>
	<td><input type="radio" name="q5" value="4" id="q5_4"<?=$checked[$q5==4]?> /></td>
	<td><input type="radio" name="q5" value="5" id="q5_5"<?=$checked[$q5==5]?> /></td>
</tr>
<tr><td colspan="6">Please add your review comments<span style="color:red;">*</span></td></tr>
<tr><td colspan="6"><textarea name="comments" cols="50" rows="10" class="input"><?=$comments?></textarea></td></tr>
<tr><td colspan="6"><span style="color:red;">*</span> Required</td></tr>
<tr><td colspan="3">&nbsp;</td><td colspan="3" align="center"><input type="submit" value="Submit" class="input" name="submit" id="submit"/></td></tr>
</table>
<?php
    if ($ss != 'User') {
    ?>
<input type="hidden" name="sid" value="<?=$sid?>" />
    <?php
    }?>
</form>
