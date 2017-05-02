<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 10               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 10/page.php,v 1.01 2006/01/17
//

$custom_page = 1; // set flag to 1 - this custom page formatter is used for Company 0.
// Differences from generic page.php: 
//   Different meta tags for Company 0 
//   Doesn't display any property links as Company 0 has no properties
//   Doesn't display ETC badge
//   Displays other logos
//   Only displays left column menu if there is more than one menu item
if (!isset($mainheight)) {
    $mainheight = 80;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="author" content="Dave Lockwood" />
<meta name="copyright" content="Dave Lockwood 2008" />
<meta name="robots" content="index,follow" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="title" content="Classical Musicians Mallorca : Elizabeth Mayfield " />
<meta name="status" content="final" />
<meta name="keywords" content="classical,music,musician,recital,concert,song,musical,popular"/>
<meta name="abstract" content="Classical Musicians Mallorca" />
<meta name="description" content="Classical Musicians Mallorca: Elizabeth Mayfield, Soprano - Pianist" />
<meta name="security" content="Public" />
<meta name="charset" content="ISO-8859-1" />
<style type="text/css" media="all">
@import "esestyles.css";
</style>
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title?></title>
</head>
<body>
<div id="mainbody">
<br><p class=maintext>
    <?php
    // include the main content of the page
    include('main.php');  
    //display session parameters //
    //foreach ($_SESSION as $key => $value) {
    //    echo 'Key: '.$key.' Value: '.$value.'<br>';
    //}
    ?>
</div>
<div id="leftcol"><br><br><br><br><br><br><br><br>
    <?php
      //print_r($menuarray); 
      foreach ($menuarray as $menurow) { 
      if ($menurow[page_id] == $page_id) { ?>
          <div><b style="color: white"><?=$menurow[page_name]?></b><br><br></div><?php
      } else { ?>
        <div><a 
        href="<?=$menurow[page_url].'">'.$menurow[page_name]?>
        </a><br><br></div><?php
      }
    } ?>
</div>

<div class="righthead" style="z-index: 1; position: fixed !important; position: absolute; right: 0px; top: <?=$mainheight?>px; width: 95%;">&nbsp;</div>

<div id="top"><br/>&nbsp;</div>

<div id="head"><br/>&nbsp;</div>

<div id="midhead"><br/>&nbsp;<?=strtolower($page_name)?></div>

<div id="mainhead">
      <a href="index.html"><?=str_replace(' ', '&nbsp;', $_SESSION[$ss]['company_name'])?> 
      </a>
</div>

<div id="rightfoot">&nbsp;&copy; Copyright <?=$copyright_year?> Esekey Limited, UK.</div>

</body>
</html>
