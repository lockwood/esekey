<?php

/*

 Template Name: Apartment page

 */



get_header();

if(have_posts()){

	while(have_posts()){

		the_post();

		$title=get_the_title();

		$pageId=get_the_ID();

		$subtitle=get_post_meta($pageId, 'subtitle_value', true);

		$slider=get_post_meta($pageId, 'slider_value', true);	

		$slider_prefix=get_post_meta($post->ID, 'slider_name_value', true);

		if($slider_prefix=='default'){

			$slider_prefix='';

		} 

		$layout=get_post_meta($post->ID, 'layout_value', true);

		if($layout==''){

			$layout='right';

		}

		$show_title=get_opt('_show_page_title');

		$sidebar=get_post_meta($post->ID, 'sidebar_value', $single = true);

		if($sidebar==''){

			$sidebar='default';

		}

		

		include(TEMPLATEPATH . '/includes/page-header.php');

?>



<div id="content-container" class="content-gradient"> <?php echo $layoutclass; ?>

<div id="<?php echo $content_id; ?>">

	   <!--content-->

    <?php 

    

    if($show_title!='off'){?>

    	<h1 class="page-heading"><?php the_title(); ?></h1><hr/>	

    <?php }



// Wisteria pageID 20, property_Id 1

// GB pageID 17, property_Id 2

// Smithy pageID 22, property_Id 3

$properties = array(20=>1,17=>2,22=>3);

$avail = '';

if (isset($properties[$pageId])) {

	$sd = '';

	if (isset($_GET['sd'])) $sd = '&sd='.$_GET['sd'];

	$result = file_get_contents('http://www.allmybookings.co.uk/availability.php?cid=3&property='.$properties[$pageId].$sd);

	$bits = explode('</head>',$result);

	if (isset($bits[1])) $avail = $bits[1];

	$avail = str_replace(array('<body>','</body>','</html>'),'',$avail);

	$avail = str_replace('/availability.php', 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $avail);

} else {
	// all properties
	$sd = '';

	if (isset($_GET['sd'])) $sd = '&sd='.$_GET['sd'];

	$result = file_get_contents('http://www.allmybookings.co.uk/availability.php?cid=3&property=0'.$sd);

	$bits = explode('</head>',$result);

	if (isset($bits[1])) $avail = $bits[1];

	$avail = str_replace(array('<body>','</body>','</html>'),'',$avail);

	$avail = str_replace('/availability.php', 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $avail);
}

//echo $avail;

$content = get_the_content();

$content = apply_filters('the_content', $content);

$content = str_replace(']]>', ']]&gt;', $content);

$content = str_replace('Chart Here', $avail, $content);

echo $content;

wp_link_pages();

	}

}

?>



  </div>

<?php 

if($layout!='full'){

	print_sidebar($sidebar); 

}

?>

<div class="clear"></div>

  </div>

<?php

get_footer();

?>

