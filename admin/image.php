<?php
// +----------------------------------------------------------------------+
// | IMAGE  - Esekey Admin Console Display and Upload Images              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/image.php,v 1.02 2004/11/15
//

//get active session
session_start();

// Set environment variables
require('properties.php');

// Set default directory to document root/main, where reusable scripts live.
chdir($DOCUMENT_ROOT.'/main');

// require database connection
require ('db_connect.php');
require ('admin_check_session.php');

?>
<html>
<head>
<meta http-equiv="REFRESH" content="600">
<title><?=$view_label?> List</title>
<link href="theme/esekey.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/esekey.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
<!--

document.onmousedown = NoRightClick;
document.onkeydown   = KeyHandler;

function GoAdd() {

	window.location = 'add.php?view=<?=$view_name?>&sid=<?=$sid?>';

}

//-->
</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" leftmargin="10" topmargin="15" rightmargin="10" bottommargin="15">

<!-- Set Workarea -->
<div class="workarea">

	<!-- Black Table Border -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="table-border">
		<!-- Main Table -->
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>	
                      <td class="header-center">Image</td>
                      <td width="80" class="header-center" nowrap>Action</td>
			</tr>
                  <?php
                  $class = 'alt1';

$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

if (isset($_FILES['userfile']['name'])) {
    print_r($_FILES); 
    $filename = split ('[/.\]', $_FILES['userfile']['name']);
    if (((strtoupper(end($filename)) == 'JPG') or (strtoupper(end($filename)) == 'GIF')) 
    && ($_FILES['userfile']['size'] > 0)) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dir.'/'.$_FILES['userfile']['name'])) { 
            echo 'File uploaded: '.$_FILES['userfile']['name'];
			$trackhdr  = "MIME-Version: 1.0\r\n";
			$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
//			mail('dave@esekey.com', 'File Uploaded', $dir.': '.$_FILES['userfile']['name'], $trackhdr);
			mail('dave@esekey.com', 'File Uploaded', 'Directory x File y Extension z', $trackhdr);
        } else {
            echo 'Error uploading file';
        }
    } else {
        echo 'Invalid file type - not uploaded.';
    } 
}
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $filename = split ('[/.\]', $file);
                if ((strtoupper(end($filename)) == 'JPG') or (strtoupper(end($filename)) == 'GIF')) {
                    $filearray[] = $file;
                }
            }
        }
    closedir($dh);
    }
    asort($filearray);
    foreach($filearray as $filerow) {
        echo '<tr><td class="'.$class.'-left">'.$filerow.'</td>
                  <td width="80" class="'.$class.'-center" nowrap><a href="https://'.$servername.'/'.$_SESSION[$ss]['company_code'].'/'.$filerow.'" target="x">View</a></td></tr>';
        if ($class == 'alt1') {
            $class = 'alt2';
        } else {
            $class = 'alt1';
        }
    }
}
?>
		</table>

	</td></tr></table>
<br>		
		
<form enctype="multipart/form-data" action="image.php" method="post">

	<!-- Bottom Buttons -->
	<table width="100%" height="33" border="0" cellspacing="0" cellpadding="0">
            <tr>
                  <td class="table-border" colspan="3">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3">
			       <tr>
                            <td class="E">	
                               <input type="hidden" name="MAX_FILE_SIZE" value="300000"> 
                               <input type="hidden" name="sid" value="<?=$sid?>">Select Image for upload: 
                               <input name="userfile" type="file">
                            </td>
                         </tr>
                     </table>
                 </td>
            </tr> 
		<tr>
			<td height="33" valign="bottom" nowrap>
                    <input type="submit" value="Upload" class="button">
			</td>
			<td height="33" align="right" valign="bottom" nowrap>
				<input type="button" name="btnPrint" value="Print View" class="button" onClick="window.print();">				
			</td>
		</tr>
	</table>
</form>
		
</div>

</body>
</html>