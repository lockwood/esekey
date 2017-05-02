<?php
if (!isset($mainheight)) {
    $mainheight = 80;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

  <title>Esekey Template</title>

<meta name="author" content="Dave Lockwood" />
<meta name="copyright" content="Dave Lockwood 2004" />
<meta name="robots" content="index,follow" />

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style type="text/css" media="all">
@import "esestyles.css";
</style>

</head>


<body>
<div class="rightcol" style="position: absolute; right: 0px; top: 0px; height: 98%; padding: 5px;">
  <div class="rightcol" style="position: absolute; right: 0px; top: <?=($mainheight + 41)?>px; padding: 5px;">Now, try resizing this window by pulling the corner. The layers will move around as the page sides get closer to them, because they are positioned on the page relative to its edges, and can react if those edges change.</div>
</div>

<div class="leftcol" style="position: absolute; left: 0px; top: 0px; height: 98%; padding: 5px;">
  <div class="leftcol" style="position: absolute; left: 0px; top: <?=($mainheight + 41)?>px; padding: 5px;">This will be the navigation 'column', which will run down the left of the page.</div>
</div>

<div class="righthead" style="position: absolute; right: 0px; top: <?=$mainheight?>px; width: 95%;">&nbsp;</div>

<div class="midhead" style="position: absolute; left: 110px; top: <?=$mainheight?>px;"><br>page title</div>

<div class="lefthead" style="position: absolute; left: 0px; top: <?=$mainheight?>px;"><br>section title</div>

<div style="z-index: 1; position: absolute; left: 110px; top: <?=($mainheight + 46)?>px; right: 110px; padding: 15px; min-width: 400px; background-color: white;">And this will be the main content block. This layer may look like a table, but you may not notice that it is positioned above the layer to the left.</div>

<div class="rightfoot" style="position: absolute; right: 0px; bottom: 0px; width: 10%;">
</div>
<div class="rightfoot" style="position: absolute; left: 0px; bottom: 0px; width: 95%;">I could go on, but I think you see the brilliance of these things.</div>

<div class="mainhead" style="position:absolute; right: 0px; top: 0px; height: <?=$mainheight?>px; padding: 5px; width: 10%;">
</div>
<div nowrap class="mainhead" style="position:absolute; left: 0px; top: 0px; height: <?=$mainheight?>px; padding: 5px; width: 95%;">
<NOBR>This is the heading. This text comes last in the code, but appears top of the page, as there's 'nothing' above it.</NOBR>
</div>
</body>
</html>