<?php
// +----------------------------------------------------------------------+
// | GENERATE  - the EseSite static page generator                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: generate.php,v 1.02 2004/11/18
//

// initialise all variables

$dir = $DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'];

chdir($dir);
$where_sect = "";
if (isset($section_id))
{
	$where_sect = "
									  AND c.section_id = '".$section_id."' ";
}
$row = $db_object->getRow("SELECT a.content_source, a.page_name, b.section_id, b.menu_sequence, c.description 
                                      FROM page as a, section_page as b, section as c 
                                     WHERE a.company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND b.company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND c.company_id = '".$_SESSION[$ss]['company_id']."' 
                                       AND b.section_id = c.section_id ".$where_sect."
									   AND b.active_flag = 'Y' 
                                       AND a.page_id = b.page_id 
                                       AND a.page_id = '".$page_id."'"); 
if ($row['content_source'] != 1) {
    // Not a static page - create a static php wrapper
	$targetfilename = 'p'.$page_id.'.php';
	if ($_SESSION[$ss]['company_id'] == 7)
	{
		$targetfilename = '';
		if ($row['section_id'] > 1)
		{
			$section_name = str_replace(' ', '_', $row['description']);
			if (!is_dir($section_name)) mkdir($section_name);
			$targetfilename = $section_name."/";
		}
		$targetfilename .= str_replace(' ', '_', $row['page_name']).'_page.php'; 
		if ($fh = fopen($targetfilename, "wb"))
		{
			$string2 = '$_GET'."['p'] = ".$page_id.";";
			$string1 = "<?php
// +----------------------------------------------------------------------+
// | Parameter   initialisation of EseSite runtime driver                 |
// | Provides static navigation wrapper, passing param 'p' to index.php   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: p.php,v 1.00 2003/10/01
//
";
			if ($row['section_id'] > 1)
			{
				fwrite($fh, "$string1\r\n$string2\r\nrequire('../index.php');\r\n?>");
			} else
			{
				fwrite($fh, "$string1\r\n$string2\r\nrequire('index.php');\r\n?>");
			}
			fclose($fh);
	        $msgtext .= '\n'.$targetfilename.' Created'; 
		} else
		{
        	$msgtext .= '\n'.$targetfilename.' Create failed'; 
		}
		return;
	}
    if (@copy('template.php', $targetfilename)) { // success
        $msgtext .= '\n'.$targetfilename.' Created'; 
    } else { 
        $msgtext .= '\n'.$targetfilename.' Create failed'; 
    }
    return;
}
// echo 'Page = '.$dir.'/p'.$page_id.'.html<br>';

$url = 'http://'.$servername; 
$sourcepage = $url.'/'.$_SESSION[$ss]['company_code'].'/index.php?p='.$page_id; 

$tempfilename = 'tmpfile.html'; 
$targetfilename = 'p'.$page_id.'.html';
if ($_SESSION[$ss]['company_id'] == 7)
{
	$targetfilename = '';
	if ($row['section_id'] > 1)
	{
		$section_name = str_replace(' ', '_', $row['description']);
		if (!is_dir($section_name)) mkdir($section_name);
		$targetfilename = $section_name."/";
	}
	$targetfilename .= str_replace(' ', '_', $row['page_name']).'.html'; 
}
$htmldata = file_get_contents($sourcepage); 
$tempfile = fopen($tempfilename, 'wb'); 

if (!$tempfile) { 
    $msgtext .= '/nUnable to open temporary output file for p'.$page_id.'.html';
    return; 
} 

fwrite($tempfile, $htmldata); 
fclose($tempfile); 

if (@copy($tempfilename, $targetfilename)) { // success; 
    if (($page_id == 1)||($page_id == 14 && $_SESSION[$ss]['company_id']==3)) { // home page - generate index.html as well
        if (@copy($targetfilename, 'index.html')) {
            $msgtext .= '\nindex.html and '.$targetfilename.' Created';
        } else {
            $msgtext .= '\nindex.html copy failed, '.$targetfilename.' Created';
        }
    } else {
    	if ($_SESSION[$ss]['company_id'] == 7 && $row['menu_sequence'] == 1)
    	{
    		// need an index page for each section
	        if (@copy($targetfilename, $section_name."/".'index.html')) {
	            $msgtext .= '\nindex.html and '.$targetfilename.' Created';
	        } else {
	            $msgtext .= '\nindex.html copy failed, '.$targetfilename.' Created';
	        }
    	} else
    	{
        	$msgtext .= '\n'.$targetfilename.' Created';
    	} 
    }
} else {
    $msgtext .= '\n'.$targetfilename.' Create Failed';
}
unlink($tempfilename); 

?>