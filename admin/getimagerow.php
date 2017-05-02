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
$replaced_chars = array("$", "__", "_", ".jpg");
$replace_chars = array("'", ", ", " ", "");

if (is_dir($dir)) {
	$filearray = array();
	if ($dh = opendir($dir)) {
		if (isset($gallery_view)) {
			// this is the gallery for sheephouse    	
	        $activearray = array();
	        while (($file = readdir($dh)) !== false) {
	            if ($file != '.' && $file != '..') {
	                $filename = split ('[/.\]', $file);
	                if ((strtoupper(end($filename)) == 'JPG' or strtoupper(end($filename)) == 'GIF') && (substr($filename[0],0,2) == 'GG')) {
	                    $key = substr($filename[0],3);
	                	$filearray[$key] = $file;
	                    if (substr($filename[0],2,1) == 'G') {
	                    	$activearray[$key] = 'Y';
	                    } else {
	                    	$activearray[$key] = 'N';
	                }
	            }
	        }
	        }
		} else {
	        while (($file = readdir($dh)) !== false) {
	            if ($file != '.' && $file != '..') {
	                $filename = split ('[/.\]', $file);
	                if ((strtoupper(end($filename)) == 'JPG' or strtoupper(end($filename)) == 'GIF') && (substr($filename[0],0,2) != 'GG')) {
	                    $filearray[] = $file;
	                }
	            }
	        }
		}
    closedir($dh);
    }
    if (count($filearray) > 1) {
    	ksort($filearray);
    	ksort($activearray); 
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
    if (isset($gallery_view)) {
	    foreach ($filearray as $k=>$filerow) {
      	  if ($filerow == $valuearray[0]) {
			  // echo $valuearray[0];
		      $page_id = '';
	      	  $active_flag = $activearray[$k];
      	  	  $viewrow = array( 'page_id'=>$page_id,
                       			'sequence'=>'',
      	  	  					'image_name'=>$filerow,
                       			'gallery_title'=>'',
		                        'active_flag'=>$active_flag,
                         		'created_date'=>'',
                         		'last_modified_on'=>'',
                        		'last_modified_by'=>'');
	          $viewrow['gallery_title'] = str_replace($replaced_chars, $replace_chars, substr($viewrow['image_name'],6));
          	  $viewrow['sequence'] = substr($viewrow['image_name'],3,3);
      	  }
      	}
    } else {
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
	if (count($viewrow) > 0) {
	  foreach ($viewrow as $viewkey => $viewcolumn) {
	    foreach ($descriptorarray as $descriptorrow) {
	        if (($descriptorrow['field_name'] == $viewkey) && ($descriptorrow['type'] != 'P')) {// exclude passwords
	            $column[] = $viewkey;
	        }
	    }
	  }
	}
}
?>
