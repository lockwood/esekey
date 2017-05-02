<?php

$pexeto_separator='|*|';
add_theme_support('automatic-feed-links');

/* ------------------------------------------------------------------------*
 * SET THE THUMBNAILS
 * ------------------------------------------------------------------------*/

if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 200, 200 );
	add_image_size('post_box_img', 580, 250, true);
	add_image_size('static-header-img', 980, 370, true);
}


function pexeto_get_resized_image($imgurl, $width, $height){
	if(function_exists('get_blogaddress_by_id')){
	//this is a WordPress Network (multi) site
	$imgurl=get_blogaddress_by_id(1).str_replace(get_blog_option($blog_id,'fileupload_url'),
													get_blog_option($blog_id,'upload_path'),
													$imgurl);
	}
	return get_template_directory_uri().'/functions/timthumb.php?src='.$imgurl.'&h='.$height.'&w='.$width.'&zc=1&q=80';
}



/**
 * Prints the pagination. Checks whether the WP-Pagenavi plugin is installed and if so, calls
 * the function for pagination of this plugin. If not- shows prints the previous and next post links.
 */
function print_pagination(){
	if(function_exists('wp_pagenavi')){
	 wp_pagenavi();
	}else{?>
<div id="blog_nav_buttons" class="navigation">
<div class="alignleft"><?php previous_posts_link('<span>&laquo;</span> '.get_opt('_previous_text')) ?>
</div>
<div class="alignright"><?php next_posts_link(get_opt('_next_text').' <span>&raquo;</span>') ?>
</div>
</div>
	<?php
	}
}


/**
 * Register the main menu for the theme.
 */
add_action( 'init', 'register_pexeto_menus' );
function register_pexeto_menus() {
	register_nav_menus(
	array(
			'pexeto_main_menu' => __( 'Main Menu' )
	)
	);
}

/**
 * Generates arrays containing all the sliders names, so that this data would be used in an drop down select.
 */
function pexeto_get_slider_data(){
	$pexeto_slider_ids=array();
	$pexeto_slider_names=array();
	$pexeto_slider_classes=array();
	$pexeto_slider_data=array();

	$pexeto_sliders=array(array('id'=>'_thum_slider_names', 'name'=>'Thumbnail Slider'),
	array('id'=>'_accord_slider_names', 'name'=>'Accordion Slider'),
	array('id'=>'_nivo_slider_names', 'name'=>'Nivo Slider'),
	array('id'=>'_content_slider_names', 'name'=>'Content Slider'),
	);

	foreach($pexeto_sliders as $slider){
		$slider_id=convert_to_class($slider['name']);

		//set the arrays for the page meta boxes
		$pexeto_slider_ids[]='disabled';
		$pexeto_slider_names[]=$slider['name'];
		$pexeto_slider_classes[]='caption';
		$pexeto_slider_ids[]='default';
		$pexeto_slider_names[]='Default Slider';
		$pexeto_slider_classes[]=$slider_id;

		//set the arrays for the options page
		$pexeto_slider_data[]=array('id'=>'disabled', 'name'=>$slider['name'], 'class'=>'caption');
		$pexeto_slider_data[]=array('id'=>'default', 'name'=>'Default', 'class'=>$slider_id);

		$names = explode('|*|', get_option($slider['id']));

		if(sizeof($names)>1){
			array_pop($names);
			foreach($names as $slidername){
				$pexeto_slider_ids[]=convert_to_class($slidername);
				$pexeto_slider_names[]=$slidername;
				$pexeto_slider_classes[]=$slider_id;
				$pexeto_slider_data[]=array('id'=>convert_to_class($slidername), 'name'=>$slidername, 'class'=>$slider_id);
			}
		}
	}

	return array('ids'=>$pexeto_slider_ids, 'names'=>$pexeto_slider_names, 'classes'=>$pexeto_slider_classes,'data'=>$pexeto_slider_data);
}


function pexeto_get_lightbox_options(){
	$opt_ids=array('theme','animation_speed','overlay_gallery', 'allow_resize', 'enable_social_tools', 'autoplay_slideshow');
	$res_arr=array();

	foreach ($opt_ids as $opt_id) {
		$option = get_opt($opt_id);
		if($option){
			if($option=='on'){
				$option = true;
			}elseif($option=='off'){
				$option = false;
			}
			$res_arr[$opt_id]=$option;
		}
	}

	return $res_arr;
}

