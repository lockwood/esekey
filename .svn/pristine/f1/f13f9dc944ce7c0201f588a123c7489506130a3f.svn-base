<?php
// +----------------------------------------------------------------------+
// | GALLERY  - displays image gallery for Company 4                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 4/gallery.php,v 1.01 2005/04/16
//

$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

$filearray = array();
$replaced_chars = array("$", "__", "_");
$replace_chars = array("'", ", ", " ");
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $filename = split ('[/.\]', $file);
                if ((strtoupper(end($filename)) == 'JPG') && (substr($filename[0],0,3) == 'GGG')) {
                    $text = str_replace($replaced_chars, $replace_chars, substr($filename[0],3));
                    $filearray[] = array("image_name"=>$file, "text"=>$text);
                }
            }
        }
        closedir($dh);
    }
    sort($filearray); 
}
if (count($filearray) == 0) { // gallery empty
    echo "&nbsp;<b>Sorry, the Gallery is temporarily unavailable. Please try again later.</b><br/><br/>";
    return;
}
if (!isset($_GET['exhibit'])) {
    $exhibit = 0;
} else {
    $exhibit = $_GET['exhibit'];
}
if (count($filearray) <= $exhibit) { // requested exhibit not in gallery
    $exhibit = 0;
}
$next = $exhibit + 1;
if ($exhibit > 0) {
    $prev = $exhibit - 1;
    $prevlink = '<b><a href="index.php?p='.$page_id.'&exhibit='.$prev.'"><font color=black><< Prev</font></a></b>';
} else {
    $prevlink = '<span style="color: #FFFFAA"><< Prev</span>';
}
$galleryrow = $filearray[$exhibit];
if ($filearray[$next] != null) {
    $nextlink = '<b><a href="index.php?p='.$page_id.'&exhibit='.$next.'"><font color=black>Next >></font></a></b>';
} else {
    $nextlink = '<span style="color: #FFFFAA">Next >></span>';
}
$titlelist = '<SELECT NAME="exhibit" onChange="submit();">';
for ($i=0; $i<count($filearray); $i++) {
  if ($i == $exhibit) {
      $titlelist .= '<OPTION VALUE="'.$i.'" SELECTED>'.$filearray[$i][text].'</OPTION>';
  } else {
      $titlelist .= '<OPTION VALUE="'.$i.'">'.$filearray[$i][text].'</OPTION>';
  }
}
$titlelist .= '</SELECT>';

?>
<br>
<form action="index.php" name="frmExhibit" id="frmExhibit" method="get">
<input type="hidden" name="p" value="<?=$page_id?>">
<table align="center" width="80%" cellspacing="5" cellpadding="3">
  <tr>
    <td style="text-align: left"><?=$prevlink?></td>
    <td style="text-align: center"><b><?=$titlelist?></b></td>
    <td style="text-align: right"><?=$nextlink?></td>
  </tr>
<?php
if ($galleryrow[image_name] !=null) {?>
  <tr>
    <td colspan="3" style="text-align: center"><IMG src="<?=$galleryrow[image_name]?>" border="1"></td>
  </tr><?php 
} ?>
</table>
</form>