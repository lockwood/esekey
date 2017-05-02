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
ini_set('memory_limit','512M'); 
ini_set('max_input_time','480'); 
ini_set('max_execution_time','480'); 

$replaced_chars = array("$", "__", "_", ".jpg");
$replace_chars = array("'", ", ", " ", "");

$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

if (is_dir($dir)) {

	if (isset($_FILES['userfile']['name'])) { // image to be uploaded before building list
		$upload_error = ''; 		
		if (isset($gallery_view)) {
			if ($_POST['title'] == '') {
				// Title is mandatory
				$upload_error = '<span style="color:red;">Please select the upload again and enter a title for this exhibit</span><br/>';
			} else {
				// check if title is a duplicate...
				$test_filename = str_replace($replace_chars, $replaced_chars, $_POST['title']);
				// echo $test_filename;
				if ($dh = opendir($dir)) {
			        while (($file = readdir($dh)) !== false) {
			            if ($file != '.' && $file != '..') {
			                $filename = split ('[/.\]', $file);
			                if ((strtoupper(end($filename)) == 'JPG' or strtoupper(end($filename)) == 'GIF') && (substr($filename[0],0,3) == 'GGG')) {
			                    if (substr($filename[0],6) == $test_filename) {
									$upload_error = '<span style="color:red;">An exhibit with this title already exists - please select the file to upload again and choose another title</span><br/>';
			                    }
			                }
			            }
			        }
			    	closedir($dh);
			    }
			}
		}
		if ($upload_error == '') { 		
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
			    	if (isset($gallery_view)) {
						// now put it at the top of the gallery
			    		$target_file = $dir.'/GGG000'.$test_filename.'.'.end($filename);
						copy($dir.'/'.$_FILES['userfile']['name'],$target_file);
		    		}
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
	}
	$filearray = array();
	$activearray = array();
	if ($dh = opendir($dir)) {
		if (isset($gallery_view)) {
			// this is the gallery for sheephouse    	
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
	      $filesize = filesize($dir.'/'.$filerow);
	      $imagesize = getimagesize($dir.'/'.$filerow);
	      $page_id = '';
      	  $active_flag = $activearray[$k];
	      $viewrow = array('image_name'=>$filerow,
	                         'file_size'=>$filesize,
	                        'image_size'=>$imagesize,
	                        'page_id'=>$page_id,
	                       'active_flag'=>$active_flag);
	      $viewarray[] = $viewrow;
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
}
?>
