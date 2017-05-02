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
<div style="position: absolute; left: 1%; top: 1%; height: 98%; width: 98%;">
<div class="rightcol" style="float: right; margin-top: <?=($mainheight + 40)?>px; height: 65%;">Now, try resizing this window by pulling the corner. The layers will move around as the page sides get closer to them, because they are positioned on the page relative to its edges, and can react if those edges change.
</div>
<div style="margin-left: 120px; margin-top: <?=($mainheight + 46)?>px; min-width: 400px; background-color: white; overflow: scroll;">And this will be the main content block. This layer may look like a table, but you may not notice that it is positioned below the layer to the left.</div>
<div class="rightfoot" style="clear: both; width: 100%;">I could go on, but I think you see the brilliance of these things.</div>
<div class="leftcol" style="z-index: 1; position: absolute; left: 0px; top: 0px; height: 65%; margin-top: <?=($mainheight + 40)?>px;">This will be the navigation 'column', which will run down the left of the page.
</div>

<div class="righthead" style="z-index: 1; position: absolute; right: 0px; top: <?=$mainheight?>px; width: 95%;">&nbsp;</div>

<div class="midhead" style="z-index: 1; position: absolute; left: 120px; top: <?=$mainheight?>px;"><br>page title</div>

<div class="lefthead" style="z-index: 1; position: absolute; left: 0px; top: <?=$mainheight?>px;"><br>section title</div>

<div class="mainhead" style="z-index: 1; position:absolute; right: 0px; top: 0px; height: <?=$mainheight?>px; width: 10%;">
</div>
<div class="mainhead" style="z-index: 1; position:absolute; left: 0px; top: 0px; height: <?=$mainheight?>px; width: 100%;">This is the heading. This text comes almost last in the code, but appears top of the page, as there's 'nothing' above it.
</div>
</div>

</body>
</html>