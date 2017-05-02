<?php
// +----------------------------------------------------------------------+
// | PAGE  - layout of EseSite runtime pages for default Company          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2006 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: main/page.php,v 1.02 2006/01/17
//

$custom_page = null; // set flag to null - if custom page formatter is found it will set this flag
include($DOCUMENT_ROOT.'/'.$_SESSION[$ss]['company_code'].'/page.php'); // call custom page formatter
if ($custom_page != null) { //don't use this page formatter, a custom one has been found and used
    return;
}
if (!isset($mainheight)) {
    $mainheight = 80;
}
?>
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
<div class="rightcol" style="float: right; margin-top: <?=($mainheight + 40)?>px; height: 65%;">
    <?php
    if (count($propertyarray) > 0) { ?>
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

<div style="margin-left: 120px; margin-top: <?=($mainheight + 46)?>px; min-width: 480px; background-color: white;">
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

<div class="rightfoot" style="clear: both; width: 100%;">&nbsp;&copy; Copyright <?$copyright_year?> Esekey Limited, UK.</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 0px; top: 0px; height: 65%; margin-top: <?=($mainheight + 40)?>px;">
    <?php foreach ($menuarray as $menurow) { ?>
      <hr width="80%"><?php
      if ($menurow[page_id] == $page_id) { ?>
          <div style="min-width: 120px;" nowrap><b style="color: white"><?=$menurow[page_name]?></b></div><?php
      } else { ?>
        <div style="min-width: 120px;" nowrap><a 
        href="<?=$menurow[page_url].'">'.$menurow[page_name]?>
        </a></div><?php
      }
    } ?>
    <hr width="80%">
    <img border="0" src="tourismbadge.jpg" alt="English Tourism Council">
</div>

<div class="righthead" style="z-index: 1; position: absolute; right: 0px; top: <?=$mainheight?>px; width: 95%;">&nbsp;</div>

<div class="midhead" style="z-index: 1; position: absolute; left: 120px; top: <?=$mainheight?>px;"><br/>&nbsp;<?=strtolower($page_name)?></div>

<div class="lefthead" style="z-index: 1; position: absolute; left: 0px; top: <?=$mainheight?>px;"><br/><?=strtolower($description)?>&nbsp;</div>

<div class="mainhead" style="z-index: 1; position:absolute; right: 0px; top: 0px; height: <?=$mainheight?>px; width: 10%;">
</div>
<div nowrap class="headtext" style="z-index: 1; position:absolute; left: 0px; top: 26px;"><NOBR><?=$_SESSION[$ss]['company_name']?></NOBR></div>
<div nowrap class="mainhead" style="z-index: 1; position:absolute; left: 0px; top: 0px; width: 95%;"><NOBR>
<?php
$sect_width = floor(100/count($descr)) - 1;
$left_anchor = 1;
for ($i=0; $i<count($descr); $i++) {
    ?><div nowrap class="<?=$sect[$i]?>" style="position: absolute; left: <?=$left_anchor?>%; top: 0px; width: <?=$sect_width?>%; margin-left: 2px;"><a style="color: black" href="<?=$intro_url[$i]?>"><?=$descr[$i]?></a></div><?php
    $left_anchor = $left_anchor + $sect_width + 1;
} ?></NOBR>
</div>
</div>

</body>
</html>
