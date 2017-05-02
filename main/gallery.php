<?php
// +----------------------------------------------------------------------+
// | GALLERY  - displays image gallery if enabled                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/gallery.php,v 1.02 2004/10/27
//

$galleryarray = $db_object->getAll("SELECT t1.image_name,
                                           t1.element_type,
                                           t1.text,
                                           t1.link
                                      FROM element as t1,
                                           page_element as t2,
                                           page AS t3
                                     WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND t1.company_id = t2.company_id
                                       AND t1.company_id = t3.company_id
                                       AND t1.element_id = t2.element_id
                                       AND t2.page_id = '".$page_id."'
                                       AND t2.page_id = t3.page_id
                                       AND t1.active_flag = 'Y'
                                       AND t2.active_flag = 'Y'
                                       AND t3.content_source = '10'
									ORDER BY t2.sequence");

if (!isset($_GET['exhibit'])) {
    $exhibit = 0;
} else {
    $exhibit = $_GET['exhibit'];
}
if (count($galleryarray) <= $exhibit) { // requested exhibit not in gallery
    $exhibit = 0;
}
$next = $exhibit + 1;
if ($exhibit > 0) {
    $prev = $exhibit - 1;
    $prevlink = '<b><a href="index.php?p='.$page_id.'&exhibit='.$prev.'"><< Prev</a></b>';
} else {
    $prevlink = '<span style="color: #FFFFAA"><< Prev</span>';
}
$galleryrow = $galleryarray[$exhibit];
if ($galleryarray[$next] != null) {
    $nextlink = '<b><a href="index.php?p='.$page_id.'&exhibit='.$next.'">Next >></a></b>';
} else {
    $nextlink = '<span style="color: #FFFFAA">Next >></span>';
}
$titlelist = '<SELECT NAME="exhibit" onChange="submit();">';
for ($i=0; $i<count($galleryarray); $i++) {
  if ($i == $exhibit) {
      $titlelist .= '<OPTION VALUE="'.$i.'" SELECTED>'.$galleryarray[$i][text].'</OPTION>';
  } else {
      $titlelist .= '<OPTION VALUE="'.$i.'">'.$galleryarray[$i][text].'</OPTION>';
  }
}
$titlelist .= '</SELECT>';

?>
<br>
<form action="index.php" name="frmExhibit" id="frmExhibit" method="get">
<input type="hidden" name="p" value="<?=$page_id?>">
<table align="center" width="80%" cellspacing="5" cellpadding="3" style="background-color: #FFFFAA">
  <tr>
    <td style="text-align: left"><?=$prevlink?></td>
    <td style="text-align: center"><b><?=$titlelist?></b></td>
    <td style="text-align: right"><?=$nextlink?></td>
  </tr>
<?php
if ($galleryrow[image_name] !=null) {?>
  <tr>
    <td colspan="3" style="text-align: center"><IMG src="<?=$galleryrow[image_name]?>"></td>
  </tr><?php 
} ?>
</table>
</form>