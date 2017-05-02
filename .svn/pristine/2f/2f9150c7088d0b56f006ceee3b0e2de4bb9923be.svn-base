<?php
// +----------------------------------------------------------------------+
// | SENDEMAIL  - Admin Console Email Send script                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/sendemail.php,v 1.01 2005/01/21
//

// initial test
if ($_SESSION[$ss]['email_sent']) { // email has already been sent - do not proceed
    $emailmsg = false;
    return;
}
// if we get here, email has not yet been sent, so retrieve details and send.
$emailmsg = true;
$value = $_GET['value'];
$valuearray = split('[,]', $value);

$emailrow = $db_object->getRow("SELECT * FROM email".$_SESSION[$ss]['_test']."
                                 WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                   AND booking_reference = '".$valuearray[0]."'
                                   AND email_sequence = '".$valuearray[1]."' ");

if (DB::isError($emailrow)) {
    $msgtext = 'DB Read Error - Email not sent - Booking Ref. '.$valuearray[0].', Id '.$valuearray[1].'.';
    return;
}
// reassemble entire email from database fields
/* recipients */
$to  = $emailrow['email_to'];
$newemail = '';
if ($_GET['newemail'] == 'Y')
{
	// email address has changed on customer table - need to use the new one
	$to = $db_object->getOne("SELECT b.email
										  FROM booking as a,
										       customer as b
										 WHERE a.booking_reference = '".$valuearray[0]."'
										   AND a.company_id = '".$_SESSION[$ss]['company_id']."' 
										   AND b.company_id = '".$_SESSION[$ss]['company_id']."' 
										   AND a.contact_id = b.customer_id");
	$newemail = ", email_to = '".$to."' ";
}
/* subject */
$subject = $emailrow['email_subject'];

// message is made up of the following components:
// $email_top - the style sheet data and html header tags
// $email_top_text - a string that is updatable via the Admin Console for personalised messages
// $email_body - the generated body of the email containing the booking data
// $email_tail_text - a string that is updatable via the Admin Console for personalised messages
// $email_tail - the closing html tags

$email_top = $emailrow['email_top'];
$email_top_text = nl2br($emailrow['email_top_text']); // convert new lines to xhtml line breaks 
$email_body = $emailrow['email_body'];
$email_tail_text = nl2br($emailrow['email_tail_text']);
$email_tail = $emailrow['email_tail'];

$complete_message = $email_top.$email_top_text.$email_body.$email_tail_text.$email_tail;

$headers = $emailrow['email_headers'];

/* and now mail it */
if (@mail($to, $subject, $complete_message, $headers)) { // email sent
    $_SESSION[$ss]['email_sent'] = true; // flag email as sent to prevent duplicates when list is refreshed
    $email_update = "UPDATE email".$_SESSION[$ss]['_test']."
                  SET sent_flag = 'Y'".$newemail."  
                WHERE company_id = '".$_SESSION[$ss]['company_id']."'
                  AND booking_reference = '".$valuearray[0]."'
                  AND email_sequence = '".$valuearray[1]."'";
//  echo $email_update; //
    $sent_email = $db_object->query($email_update);
    if (DB::isError($sent_email)) {
        $msgtext = 'DB Write Error - Email sent but not marked as sent - Booking Ref. '.$valuearray[0].', Id '.$valuearray[1].'.';
    } else {
        $msgtext = 'Email sent to '.$to.'\n\nBooking Ref. '.$valuearray[0].', Id '.$valuearray[1].'.';
    }
} else { // failed to send
    $msgtext = 'Warning - Send Email Failed for Booking Ref. '.$valuearray[0].', Id '.$valuearray[1].'.';
}
?>
