<?php  
// +----------------------------------------------------------------------+
// | BOOKING_WIZARD  - Link to Online Booking if enabled (Company 1)      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/booking_wizard.php,v 1.00 2003/10/01
//
$intropage = $db_object->getOne("SELECT page_id 
                                   FROM section_page 
                                  WHERE company_id = '".$_SESSION[$ss]['company_id']."' 
                                    AND section_id = 5 
                                    AND menu_sequence = 1"); 

?>
<a href="javascript:DoPopup('<?=$servername?>',5,<?=$intropage?>,0,'p','0',600,'0');">To Make an Online Booking, Click Here and follow Secure Booking Instructions</a><br><br>
