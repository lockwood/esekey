<?php
/* Fire up WordPress stuff */
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

header("Content-type: text/css");
$grid_widths = get_option('wpb_js_grid_w');
$grid_gaps = get_option('wpb_js_grid_g');
$grid_prefixs = get_option('wpb_js_grid_p');

$max_ar = max($grid_widths, $grid_gaps, $grid_prefixs);
$layout_total = ($max_ar != false) ? count($max_ar) : 0;

for ( $i = 0; $i < $layout_total; $i++ ) :
	$layout_w = ($grid_widths[$i]) ? $grid_widths[$i] : '';
	$layout_g = ($grid_gaps[$i]) ? $grid_gaps[$i] : '';
	$layout_p = ($grid_prefixs[$i]) ? $grid_prefixs[$i] : '';

	if ( ($layout_w != '' || $layout_g != '' || $layout_p != '') ) :
	
	$pp = htmlspecialchars($layout_p);
	$ww = $layout_w;
	$gg = $layout_g;
	
	$prefix = ($pp != '') ? $pp.' ' : '';
	$width = ($ww != '') ? $ww : 940;
	$width = str_replace("px", "", $width);
	
	if ($i == 0) {
		$gap = ($gg != '' && is_numeric($gg)) ? $gg : 10;
	}
	
	$_one_fourth = $one_fourth = floor(($width - ($gap*3))/4);
	$_one_third = $one_third = floor(($width - ($gap*2))/3);
	$_one_half = $one_half = floor(($width - $gap)/2);
	$_two_third = $two_third = floor($one_third*2 + $gap);
	$_three_fourth = $three_fourth = floor($one_fourth*3 + $gap*2);
	$_full_width = $full_width = $width;

		if ($i == 0) :
?>
/* Column layout
---------------------------------------------------------- */
<?php echo $prefix; ?>.one-fourth,
<?php echo $prefix; ?>.one-third,
<?php echo $prefix; ?>.one-half,
<?php echo $prefix; ?>.two-third,
<?php echo $prefix; ?>.three-fourth,
<?php echo $prefix; ?>.full-width { margin:0 <?php echo $gap; ?>px 10px 0px; }
<?php echo $prefix; ?>.small_tour_slides { margin-left: <?php echo $gap; ?>; }

<?php echo $prefix; ?>.wpb_carousel li { margin-right: <?php echo $gap; ?>px; }
<?php 	endif; //endif $i == 0 ?>



/* Column sizes - for <?php echo "width: $width; gap: $gap; prefix: $prefix \n"; ?>
---------------------------------------------------------- */
<?php echo $prefix; ?>.one-fourth { width: <?php echo $one_fourth; ?>px; }
<?php echo $prefix; ?>.one-third { width: <?php echo $one_third; ?>px; }
<?php echo $prefix; ?>.one-half { width: <?php echo $one_half; ?>px; }
<?php echo $prefix; ?>.two-third { width: <?php echo $two_third; ?>px; }
<?php echo $prefix; ?>.three-fourth { width: <?php echo $three_fourth; ?>px; }
<?php echo $prefix; ?>.full-width { width: <?php echo $full_width; ?>px; }


/* Column variations
---------------------------------------------------------- */
<?php
	$width = $_three_fourth;
	
	$one_fourth = floor(($width - ($gap*3))/4);
	$one_third = floor(($width - ($gap*2))/3);
	$one_half = floor(($width - $gap)/2);
	$two_third = floor($one_third*2 + $gap);
	$three_fourth = floor($one_fourth*3 + $gap*2);
	$full_width = $width;
?>
<?php echo $prefix; ?>.three-fourth .one-fourth { width: <?php echo $one_fourth; ?>px; }
<?php echo $prefix; ?>.three-fourth .one-third { width: <?php echo $one_third; ?>px; }
<?php echo $prefix; ?>.three-fourth .one-half { width: <?php echo $one_half; ?>px; }
<?php echo $prefix; ?>.three-fourth .two-third { width: <?php echo $two_third; ?>px; }
<?php echo $prefix; ?>.three-fourth .three-fourth { width: <?php echo $three_fourth; ?>px; }
<?php echo $prefix; ?>.three-fourth .full-width { width: <?php echo $full_width; ?>px; }

<?php
	$width = $_two_third;
	
	$one_fourth = floor(($width - ($gap*3))/4);
	$one_third = floor(($width - ($gap*2))/3);
	$one_half = floor(($width - $gap)/2);
	$two_third = floor($one_third*2 + $gap);
	$three_fourth = floor($one_fourth*3 + $gap*2);
	$full_width = $width;
?>
<?php echo $prefix; ?>.two-third .one-fourth { width: <?php echo $one_fourth; ?>px; }
<?php echo $prefix; ?>.two-third .one-third { width: <?php echo $one_third; ?>px; }
<?php echo $prefix; ?>.two-third .one-half { width: <?php echo $one_half; ?>px; }
<?php echo $prefix; ?>.two-third .two-third { width: <?php echo $two_third; ?>px; }
<?php echo $prefix; ?>.two-third .three-fourth { width: <?php echo $three_fourth; ?>px; }
<?php echo $prefix; ?>.two-third .full-width { width: <?php echo $full_width; ?>px; }

<?php
	$width = $_one_half;
	
	$one_fourth = floor(($width - ($gap*3))/4);
	$one_third = floor(($width - ($gap*2))/3);
	$one_half = floor(($width - $gap)/2);
	$two_third = floor($one_third*2 + $gap);
	$three_fourth = floor($one_fourth*3 + $gap*2);
	$full_width = $width;
?>
<?php echo $prefix; ?>.one-half .one-fourth { width: <?php echo $one_fourth; ?>px; }
<?php echo $prefix; ?>.one-half .one-third { width: <?php echo $one_third; ?>px; }
<?php echo $prefix; ?>.one-half .one-half { width: <?php echo $one_half; ?>px; }
<?php echo $prefix; ?>.one-half .two-third { width: <?php echo $two_third; ?>px; }
<?php echo $prefix; ?>.one-half .three-fourth { width: <?php echo $three_fourth; ?>px; }
<?php echo $prefix; ?>.one-half .full-width { width: <?php echo $full_width; ?>px; }

<?php
	$width = $_one_third;
	
	$one_fourth = floor(($width - ($gap*3))/4);
	$one_third = floor(($width - ($gap*2))/3);
	$one_half = floor(($width - $gap)/2);
	$two_third = floor($one_third*2 + $gap);
	$three_fourth = floor($one_fourth*3 + $gap*2);
	$full_width = $width;
?>
<?php echo $prefix; ?>.one-third .one-fourth { width: <?php echo $one_fourth; ?>px; }
<?php echo $prefix; ?>.one-third .one-third { width: <?php echo $one_third; ?>px; }
<?php echo $prefix; ?>.one-third .one-half { width: <?php echo $one_half; ?>px; }
<?php echo $prefix; ?>.one-third .two-third { width: <?php echo $two_third; ?>px; }
<?php echo $prefix; ?>.one-third .three-fourth { width: <?php echo $three_fourth; ?>px; }
<?php echo $prefix; ?>.one-third .full-width { width: <?php echo $full_width; ?>px; }

<?php
	$width = $_one_fourth;
	$full_width = $width;
?>
<?php echo $prefix; ?>.one-fourth .one-fourth,
<?php echo $prefix; ?>.one-fourth .one-third,
<?php echo $prefix; ?>.one-fourth .one-half,
<?php echo $prefix; ?>.one-fourth .two-third,
<?php echo $prefix; ?>.one-fourth .three-fourth,
<?php echo $prefix; ?>.one-fourth .full-width { width: <?php echo $full_width; ?>px; }
<?php

	endif;
endfor;
?>