<?php
// +----------------------------------------------------------------------+
// | GETIMAGEDATA  - Esekey Admin Console Display Image List              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/getimagedata.php,v 1.02 2004/11/18
//


$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

if (isset($_FILES['userfile']['name'])) { // image to be uploaded before building list
    // print_r($_FILES); 
    $filename = split ('[/.\]', $_FILES['userfile']['name']);
    if (((strtoupper(end($filename)) == 'JPG') or (strtoupper(end($filename)) == 'GIF')) 
    && ($_FILES['userfile']['size'] > 0)) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dir.'/'.$_FILES['userfile']['name'])) {
            $uploadmsg = true;
            $msgtext = 'File uploaded: '.$_FILES['userfile']['name'];
			$trackhdr  = "MIME-Version: 1.0\r\n";
			$trackhdr .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$trackhdr .= "From: ".$_SESSION[$ss]['username']." <admin@esekey.com>\r\n";
			@mail('dave@esekey.com', 'File Uploaded', $_SESSION[$ss]['company_code'].': '.$_FILES['userfile']['name'], $trackhdr);
        } else {
            $uploadmsg = true;
            $msgtext = 'Error uploading file';
        }
    } else {
        if ($_SESSION[$ss]['username'] == 'Administrator') { // allow any uploads for superuser
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dir.'/'.$_FILES['userfile']['name'])) {
                $uploadmsg = true;
                $msgtext = 'File uploaded: '.$_FILES['userfile']['name'];
            } else {
                $uploadmsg = true;
                $msgtext = 'Error uploading file';
            }
        } else {
            $uploadmsg = true;
            $msgtext = 'Invalid file type - not uploaded.';
        }
    } 
}

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
		if (isset($gallery_view)) {
			// this is the gallery for sheephouse    	
	        while (($file = readdir($dh)) !== false) {
	            if ($file != '.' && $file != '..') {
	                $filename = split ('[/.\]', $file);
	                if ((strtoupper(end($filename)) == 'JPG' or strtoupper(end($filename)) == 'GIF') && (substr($filename[0],0,3) == 'GGG')) {
	                    $filearray[] = $file;
	                }
	            }
	        }
		} else {
	        while (($file = readdir($dh)) !== false) {
	            if ($file != '.' && $file != '..') {
	                $filename = split ('[/.\]', $file);
	                if ((strtoupper(end($filename)) == 'JPG' or strtoupper(end($filename)) == 'GIF') && (substr($filename[0],0,3) != 'GGG')) {
	                    $filearray[] = $file;
	                }
	            }
	        }
		}
    closedir($dh);
    }
    if (count($filearray) > 1) sort($filearray); 
    $usagearray = $db_object->getAll("
                                    SELECT DISTINCT 
                                           t1.image_name,
                                           t2.page_id,
                                           t1.active_flag
                                      FROM element as t1,
                                           page_element as t2
                                     WHERE t1.company_id = '".$_SESSION[$ss]['company_id']."'
                                       AND t1.company_id = t2.company_id
                                       AND t1.element_id = t2.element_id
                                  ORDER BY t1.image_name");

    // Create array with only one row per image even for multiple pages
    $current_image = null;
    $i = 0;
    foreach($usagearray as $usagerow) {
        if ($usagerow['image_name'] != $current_image) {// new image row
            $current_image = $usagerow['image_name'];
            $newusagearray[$i] = $usagerow;
            $i++;
        } else { // image row already exists - add page id to previous row
            $newusagearray[$i-1]['page_id'].= '<br>'.$usagerow['page_id'];
        }
    }
    if ($i > 0) { //array is not empty
        // echo 'usagearray created with '.$i.' rows<br>';
        $usagearray = $newusagearray;
    }
/*  if (substr($searchstring1, 4, 10) == 'gallery_id') { // only list images in the gallery, order by gallery_id
        foreach($galleryarray as $galleryrow) {
          for ($i=0;$i<count($filearray);$i++) {
            if ($galleryrow['image_name'] == $filearray[$i]) { // this image is in the gallery
                $gallery_id = $galleryrow['sequence'];
                $element_id = $galleryrow['element_id'];
                $active_flag = $galleryrow['active_flag'];
                $filesize = filesize($dir.'/'.$filearray[$i]);
                $imagesize = getimagesize($dir.'/'.$filearray[$i]);
                $viewrow = array('image_name'=>$filearray[$i], 
                                   'file_size'=>$filesize,
                                  'image_size'=>$imagesize,
                                  'element_id'=>$element_id,
                                  'active_flag'=>$active_flag,
                                     'gallery'=>$gallery_id);
                $viewarray[] = $viewrow;
            } 
          }
        }
    } */ 
    // list all images in alphabetical order
    for ($i=0;$i<count($filearray);$i++) {
      $filesize = filesize($dir.'/'.$filearray[$i]);
      $imagesize = getimagesize($dir.'/'.$filearray[$i]);
      $page_id = '';
      $active_flag = '';
      foreach($usagearray as $usagerow) {
        if ($usagerow['image_name'] == $filearray[$i]) { // this image is in the gallery
            $page_id = $usagerow['page_id'];
            $active_flag = $usagerow['active_flag'];
        } 
      }
      $viewrow = array('image_name'=>$filearray[$i],
                         'file_size'=>$filesize,
                        'image_size'=>$imagesize,
                        'page_id'=>$page_id,
                       'active_flag'=>$active_flag);
      $viewarray[] = $viewrow;
    }
}
?>
