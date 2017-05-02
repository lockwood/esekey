<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for Company 0                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 0/page.php,v 1.01 2006/01/17
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
<meta name="copyright" content="Dave Lockwood 2005" />
<meta name="robots" content="index,follow" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="title" content="Fictional Farm Holiday Cottages : Introduction " />
<meta name="status" content="final" />
<meta name="keywords" content="Holiday, Cottages, Online, Booking, Availability, Accommodation, Self-catering, beach, farm, family, quality, discerning, comfort, luxury, tourist, board, "/>
<meta name="abstract" content="Fictional Farm Holiday Cottages." />
<meta name="description" content="Fictional Farm Holiday Cottages provide quality accommodation for the discerning holidaymaker" />
<meta name="security" content="Public" />
<meta name="charset" content="ISO-8859-1" />
<style type="text/css" media="all">
@import "esestyles.css";
</style>
<script language="JavaScript" src="eseSite.js" type="text/javascript"></script>
<title><?=$title.$_test?></title>
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
<div id="leftcol">
    <?php foreach ($menuarray as $menurow) { 
      if ($menurow[page_id] == $page_id) { ?>
          <div style="min-width: 120px;" nowrap><b style="color: white"><?=$menurow[page_name]?></b></div><?php
      } else { ?>
        <div style="min-width: 120px;" nowrap><a 
        href="<?=$menurow[page_url].'">'.$menurow[page_name]?>
        </a></div><?php
      }
    } ?>
</div>

<div class="righthead" style="z-index: 1; position: absolute; right: 0px; top: <?=$mainheight?>px; width: 95%;">&nbsp;</div>

<div id="top"><br/>&nbsp;</div>

<div id="head"><br/>&nbsp;</div>

<div id="midhead"><br/>&nbsp;<?=strtolower($page_name)?></div>

<div id="lefthead"><br/><?=strtolower($description)?>&nbsp;</div>

<div class="mainhead" style="z-index: 1; position:absolute; right: 0px; top: 0px; height: <?=$mainheight?>px; width: 10%;">
</div>
<div nowrap class="headtext" style="z-index: 99; position:absolute; left: 0px; top: 26px;">
      <a href="index.html">
      <img border="0" alt="Esekey Limited" src="esekey_logo.jpg" align="absmiddle">
      </a>
</div>
<div nowrap class="mainhead" style="z-index: 99; position:absolute; left: 0px; top: 0px; width: 100%;"><NOBR>
<?php
$sect_width = floor(100/count($descr));
$left_anchor = 0;
for ($i=0; $i<count($descr); $i++) {
    ?><div nowrap id="<?=$sect[$i]?>" style="position: absolute; left: <?=$left_anchor?>%; top: 0px; width: <?=$sect_width?>%"><a style="color: black" href="<?=$intro_url[$i]?>"><?=$descr[$i]?></a></div><?php
    $left_anchor = $left_anchor + $sect_width;
} ?></NOBR>
</div>
<div id="rightcol">
    <?php
    if (count($resourcearray) > 0) { ?>
        <b>Our cottages...</b><br>
        <br>
        <?php
        foreach ($propertyarray as $propertyrow) { ?>
            <a href="index.php?id=<?=$_SESSION[$ss]['company_id'].'&s=2&p='.$propertyrow[page_id]?>"> 
            <img border="0" alt="<?=$propertyrow[name]?>" 
             src="<?='thumbnail'.$propertyrow[property_id]?>.jpg"
            height="50" width="75"> </a><br><br>
        <?php
        }
    } ?>
</div>

<div id="rightfoot">&nbsp;&copy; Copyright <?=$copyright_year?> Esekey Limited, UK.</div>

</body>
</html>
