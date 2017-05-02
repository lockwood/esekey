<?php
// +----------------------------------------------------------------------+
// | TOP_NAV  - Esekey Admin Console Navigation Bar                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/top_nav.php,v 1.03 2004/12/06
//

session_start();

$ss = 'Admin'; // sub-session type is Admin - avoid session data conflict with type User

?>
<html>
<head>
<title>Top Frame</title>
<link href="theme/top.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/top.js" type="text/javascript"></script>
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--


var blnUnloadOk

function CheckUnload() {

    if (!blnUnloadOk) {
        var strMessage = 'Are you sure you wish to continue?\n\nAny changes you have made will be lost';
        if (confirm(strMessage)) {
            alert('Clicked Ok')	
        } else {
            alert('Clicked Cancel')		
        }
    }
}

function Logout() {

    var strMessage = 'Are you sure you wish to logout now?';
    if (confirm(strMessage)) {
        top.window.opener=self;
        top.window.close();
    }
}

//-->
</script>


</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" onload="SetSID('<?=$_COOKIE['PHPSESSID']?>')">
<table width="100%" height="53" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="212" rowspan="3" valign="top"><img src="images/esekey_logo_small.jpg" alt="Esekey Limited" border="0"></td>
    <td width="1" rowspan="3" bgcolor="#CCCCCC"><img src="images/pixel.gif" alt="" width="1" height="1" border="0"></td>
    <td align="right" height="18" bgcolor="#CCCCCC">
      <a href="javascript:Logout();"><img src="images/log_out.gif" alt="" width="55" height="18" border="0"></a></td>
  </tr>
  <tr>
    <td height="9"><img src="images/pixel.gif" alt="" width="1" height="1" border="0"></td>	
  </tr>
  <tr>
    <td height="27" class="title" nowrap> &nbsp;Administration Console for&nbsp;<?=$_SESSION[$ss]['company_name']?></td>
  </tr>
</table>

<table width="100%" height="26" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="212" bgcolor="#000000" class="bartext" nowrap>&nbsp;Menu for user: <?=$_SESSION[$ss]['username']?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="images/pixel.gif" alt="" width="1" height="1" border="0"></td>
    <td bgcolor="#000000" class="bartext" nowrap>&nbsp;
      <span id="topbarmenu">EseCompany&trade; &gt; </span>
      <span id="topbarhead1"><a href="#" onClick="window.status=''; top.Top.GoToURL('EseCompany', 'Administration Home', 'status.php?');" onMouseOver="return window.status='EseCompany&trade; &gt; Administration Home';" onMouseOut="return window.status='';">Administration Home</a></span>
      <span id="topbarhead2"></span>
      <span id="topbartext"></span>
    </td>
  </tr>
</table>
</body>
</html>
