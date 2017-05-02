<?php

/* Load shortcode related javascript code
---------------------------------------------------------- */
$sc_js = array( 'prettyphoto' );

add_action( 'template_redirect', 'wpb_js_frontend_js_register' );
function wpb_js_frontend_js_register() {
	wp_register_script( 'wpb_composer_front_js', WPB_JS_COMPOSER_URL . 'js_composer_front.js', array( 'jquery' ));
	
	wp_register_script( 'cycle', WPB_JS_COMPOSER_URL . 'js/jquery.cycle.all.js', array( 'jquery' ));
	wp_register_script( 'tweet', WPB_JS_COMPOSER_URL . 'js/jquery.tweet.js', array( 'jquery' ));
	wp_register_script( 'prettyphoto', WPB_JS_COMPOSER_URL . 'js/jquery.prettyPhoto.js', array( 'jquery' ));
	wp_register_script( 'nivo-slider', WPB_JS_COMPOSER_URL . 'js/jquery.nivo.slider.pack.js', array( 'jquery' ));
	wp_register_script( 'jcarousellite', WPB_JS_COMPOSER_URL . 'js/jcarousellite_1.0.1.min.js', array( 'jquery' ));
}

add_action( 'wp_footer', 'wpb_shortcodes_js' );
function wpb_shortcodes_js() {
	global $sc_js;
	$sc_js = array_unique($sc_js);
	array_push($sc_js, 'wpb_composer_front_js' );
	foreach ($sc_js as $js) {
		wp_print_scripts($js);
	}
}


$text_column_count = 0;
add_shortcode( 'vc_column', 'wpb_column_func' );
add_shortcode( 'vc_column_text', 'wpb_column_func' );
function wpb_column_func($atts, $content = NULL, $base = '') {
	extract(shortcode_atts(array(
		'class' => '',
		'last' => '',
		'width' => '1/2'
	), $atts));
	
	
	$output = '';
	$extra = '';
	if ($last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	global $text_column_count; $text_column_count++;
	
	$width = wpb_getColumnWidth($width);
	if ($class != '') {
		$class = str_replace(".", "", $class) . " ";
	}
	
	if ( $base == 'vc_column' ) {
		$class .= 'column_container eq_id_'.$text_column_count.' ';
	}
	else if ( $base == 'vc_column_text' ) {
		$class .= ' wpb_text_column ';
	}
	
	// If it's first column and it's full-width then don't wrap it in div and instead output as simple text
	// This hack is needed if there is a image floated in the beginning of the post (thumbnail)
	
	if ($text_column_count == 1 && $width == 'full-widthHHH') {
	} else {
		$output .= '<div class="column '.$class.$width.$last.'">';
	}
	
	$output .= '<div class="wpb_wrapper">'.wpb_js_remove_wpautop($content).'</div>';
	
	if ($text_column_count == 1 && $width == 'full-widthHHH') {
	} else {
		$output .= '</div>';
	}
	
	$output .= $extra;
	
	return $output;
}

add_shortcode( 'vc_teaser_grid', 'wpb_teaser_grid_func' );
function wpb_teaser_grid_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'title' => '',
		'grid_columns_count' => 2,
		'grid_teasers_count' => 8,
		'grid_layout' => 'title_thumbnail_text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, title_text, thumbnail
		'grid_link' => 'link_post', // link_post, link_image, link_image_post, link_no
		'grid_template' => 'grid', //grid, carousel
		'grid_thumb_size' => '',
		'grid_posttypes' => '',
		'grid_categories' => '',
		'grid_content' => 'teaser', // teaser, content
		'class' => '',
		'last' => '',
		'width' => '1/1',
		'orderby' => NULL
	), $atts));
	$output = '';
	$extra = '';
	$teaser_width = '';
	
	if ( $last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	
	$width = wpb_getColumnWidth($width);
	switch ($grid_columns_count) {
		case '1' :
			$teaser_width = 'full-width';
			break;
		case '2' :
			$teaser_width = 'one-half';
			break;
		case '3' :
			$teaser_width = 'one-third';
			break;
		case '4' :
			$teaser_width = 'one-fourth';
			break;
	}
	
	if ( $grid_thumb_size == '' ) {
		if ( $teaser_width == 'one-fourth' ) {
			$th_w = (ONE_FOURTH_TH_W) ? ONE_FOURTH_TH_W : 212;
			$th_h = (ONE_FOURTH_TH_H) ? ONE_FOURTH_TH_H : 150;
		}
		else if ( $teaser_width == 'one-third' ) {
			$th_w = (ONE_THIRD_TH_W) ? ONE_THIRD_TH_W : 293;
			$th_h = (ONE_THIRD_TH_H) ? ONE_THIRD_TH_H : 207;
		}
		else if ( $teaser_width == 'one-half' ) {
			$th_w = (ONE_HALF_TH_W) ? ONE_HALF_TH_W : 455;
			$th_h = (ONE_HALF_TH_H) ? ONE_HALF_TH_H : 322;
		}
		else if ( $teaser_width == 'full-width' ) {
			$th_w = (FULL_WIDTH_TH_W) ? FULL_WIDTH_TH_W : 940;
			$th_h = (FULL_WIDTH_TH_H) ? FULL_WIDTH_TH_H : 665;
		}
		else {
			$th_w = 212;
			$th_h = 150;
		}
		
		$grid_thumb_size = $th_w.'x'.$th_h;
	}
		
	$grid_template = 'wpb_'.$grid_template;
	if ($class != '') {
		$class = " " . str_replace(".", "", $class);
	}
	
	$posttypes_teasers = '';
	if ( $grid_posttypes != '' ) {
		$posttypes_teasers_ar = explode(",", $grid_posttypes);
		foreach ( $posttypes_teasers_ar as $post_type ) {
			$posttypes_teasers .= ' posts_grid_'.$post_type;
		}
	}
	
	$output .= '<div class="column column_container '.$width.' posts_grid '.$grid_template.' '.$class.' columns_count_'.$grid_columns_count.' '.$grid_layout.' '.$grid_layout.'_'.$width.' columns_count_'.$grid_columns_count.'_'.$grid_layout.' '.$posttypes_teasers.$last.'">';
	if ($title != '' ) $output .= '<h2 class="wpb_heading wpb_teaser_grid_heading">'.$title.'</h2>';
	
	$query_args = array();
	/*global $post;
	$current_id = $post->ID;*/
	
	if ( $grid_teasers_count != '' && !is_numeric($grid_teasers_count) ) $grid_teasers_count = -1;
	if ( $grid_teasers_count != '' && is_numeric($grid_teasers_count) ) $query_args['posts_per_page'] = $grid_teasers_count;
	
	$pt = array();
	if ( $grid_posttypes != '' ) {
		$grid_posttypes = explode(",", $grid_posttypes);
		foreach ( $grid_posttypes as $post_type ) {
			array_push($pt, $post_type);
		}
		$query_args['post_type'] = $pt;
	}
	
	if ( $grid_categories != '' ) {
		$grid_categories = explode(",", $grid_categories);
		$gc = array();
		foreach ( $grid_categories as $grid_cat ) {
			array_push($gc, $grid_cat);
		}
		$gc = implode(",", $gc);
		////http://snipplr.com/view/17434/wordpress-get-category-slug/
		$query_args['category_name'] = $gc;
		
		$taxonomies = get_taxonomies('', 'object');
		foreach ( $taxonomies as $t ) {
			if (in_array($t->object_type[0], $pt)) {
		
				$query_args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => $t->name,//'portfolio_category',
						'field' => 'slug',
						'terms' => $grid_categories,//array( '3d', 'animation' ),
					)
				);
				
			}
		}
	}
	//var_dump($query_args);
	
	if ($orderby != NULL) {
		$query_args['orderby'] = $orderby;
	}
	
	$my_query = new WP_Query($query_args);
	$i = 0;
	
	if ($grid_template == 'wpb_carousel') {
		global $sc_js;
		array_push($sc_js, "jcarousellite");
		//$output .= '<a href="#" class="prev">&larr;</a> <a href="#" class="next">&rarr;</a>';
		$output .= apply_filters( 'vc_grid_carousel_arrows', '<a href="#" class="prev">&larr;</a> <a href="#" class="next">&rarr;</a>' );
		$output .= '<div class="wpb_wrapper"><ul>';
	}
	while ($my_query->have_posts()) {
		$i++;
		if ($i == $grid_columns_count && $grid_template != 'wpb_carousel') { $t_extra = ' last'; $i = 0; $divclear = '<div class="vc_clear"></div>'; } else { $t_extra = ''; $divclear = ''; }
		$my_query->the_post();
		$post_title = the_title("", "", false);
		$post_id = $my_query->post->ID;
		$teaser_post_type = 'posts_grid_teaser_'.$my_query->post->post_type . ' ';
		
		$content = ( $grid_content == 'teaser' ) ? get_the_excerpt() : get_the_content();
		//$content = wpb_js_remove_wpautop($content);
		$content = apply_filters('the_content', $content);
		$content = wpb_js_remove_wpautop($content);
		//$content = fix_p_tags($content);
		
		if ( $grid_link != 'link_no' ) {
			$content .= ($grid_content == 'teaser' ) ? '<a class="teaser_readmore" href="'. get_permalink($post_id) .'" title="'. sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">'. __("Read more", "js_composer") .'</a>' : '';
		}

		
		//Thumbnail logic
		$post_thumbnail = $p_img_large = '';
		if ($attach_id = get_post_thumbnail_id($post_id)) {			
			if (is_string($grid_thumb_size)) {
				$grid_thumb_size = str_replace(array( 'px', ' ' ), array( '', '' ), $grid_thumb_size);
				$grid_thumb_size = explode("x", $grid_thumb_size);
			}
			$p_img_large = wp_get_attachment_image_src($attach_id, 'large' );
			//var_dump($p_img_large);
			$p_img = wpb_resize($attach_id, null, $grid_thumb_size[0], $grid_thumb_size[1], true);
			
			if ($p_img) {
				$img_class = '';
				if ($grid_layout == 'thumbnail' ) $img_class = ' no_bottom_margin';
				$post_thumbnail = apply_filters( 'vc_grid_before_thumbnail', '', $my_query->post, $grid_link ) . '<img class="teaser_grid_img'.$img_class.'" src="'.$p_img['url'].'" width="'.$p_img['width'].'" height="'.$p_img['height'].'" alt="" />' . apply_filters( 'vc_grid_after_thumbnail', '', $my_query->post, $grid_link );
			}
		}
		
		//Link logic
		if ( $grid_link != 'link_no' ) {
			if ( $grid_link == 'link_image' || $grid_link == 'link_image_post' ) {
				$p_video = get_post_meta($post_id, "_p_video", true);
			}
		
			if ( $grid_link == 'link_post' ) {
				$link_image = '<a class="link_image" href="'.get_permalink($post_id).'" title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
				$link_title = '<a href="'.get_permalink($post_id).'" title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
			}
			else if ( $grid_link == 'link_image' ) {
				if ( $p_video != "" ) {
					$p_link = $p_video;
				} else {
					$p_link = $p_img_large[0];
				}
				$link_image = '<a class="link_image prettyphoto" href="'.$p_link.'" title="'.the_title_attribute('echo=0').'">';
				$link_title = '<a class="prettyphoto" href="'.$p_link.'" title="'.the_title_attribute('echo=0').'">';
			}
			else if ( $grid_link == 'link_image_post' ) {
				if ( $p_video != "" ) {
					$p_link = $p_video;
				} else {
					$p_link = $p_img_large[0];
				}
				$link_image = '<a class="link_image prettyphoto" href="'.$p_link.'" title="'.the_title_attribute('echo=0').'">';
				$link_title = '<a href="'.get_permalink($post_id).'" title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
			}
			$link_end = '</a>';
		} else {
			$link_image = '';
			$link_title = '';
			$link_end = '';
		}		
		
		//Layout logic
		$layout = '';
		if ($grid_layout == 'title_thumbnail_text' ) {
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_before_title', '', $my_query->post );
			$layout .= '<h3 class="teaser_title">' . $link_title . $post_title . $link_end .'</h3>';
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_after_title', '', $my_query->post );
			if ($post_thumbnail != '' ) :
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_before_thumbnail', '', $my_query->post );
			$layout .= $link_image . $post_thumbnail . $link_end;
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_after_thumbnail', '', $my_query->post );
			endif;
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_before_content', '', $my_query->post );
			$layout .= '<div class="teaser_content">'. $content . '</div> <div class="vc_clear"></div>';
			$layout .= apply_filters( 'vc_grid_title_thumbnail_text_after_content', '', $my_query->post );
		}
		else if ( $grid_layout == 'thumbnail_title_text' ) {
			if ($post_thumbnail != '' ) :
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_before_thumbnail', '', $my_query->post );
			$layout .= $link_image . $post_thumbnail . $link_end;
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_after_thumbnail', '', $my_query->post );
			endif;
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_before_title', '', $my_query->post );
			$layout .= '<h3 class="teaser_title">' . $link_title . $post_title . $link_end .'</h3>'; // . wpb_extra_markup('vc_teaser_grid_thumbnail_title_text');
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_after_title', '', $my_query->post );
			
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_before_content', '', $my_query->post );
			$layout .= '<div class="teaser_content">'. $content . '</div> <div class="vc_clear"></div>';
			$layout .= apply_filters( 'vc_grid_thumbnail_title_text_after_content', '', $my_query->post );
		}
		else if ($grid_layout == 'thumbnail_title' ) {
			if ($post_thumbnail != '' ) :
			$layout .= apply_filters( 'vc_grid_thumbnail_title_before_thumbnail', '', $my_query->post );
			$layout .= $link_image . $post_thumbnail . $link_end;
			$layout .= apply_filters( 'vc_grid_thumbnail_title_before_thumbnail', '', $my_query->post );
			endif;
			$layout .= apply_filters( 'vc_grid_thumbnail_title_before_title', '', $my_query->post );
			$layout .= '<h3 class="teaser_title">' . $link_title . $post_title . $link_end .'</h3>';
			$layout .= apply_filters( 'vc_grid_thumbnail_title_after_title', '', $my_query->post );
		}
		else if ($grid_layout == 'thumbnail_text' ) {
			if ($post_thumbnail != '' ) :
			$layout .= apply_filters( 'vc_grid_thumbnail_text_before_thumbnail', '', $my_query->post );
			$layout .= $link_image . $post_thumbnail . $link_end;
			$layout .= apply_filters( 'vc_grid_thumbnail_text_after_thumbnail', '', $my_query->post );
			endif;
			$layout .= apply_filters( 'vc_grid_thumbnail_text_before_content', '', $my_query->post );
			$layout .= '<div class="teaser_content">'. $content . '</div> <div class="vc_clear"></div>';
			$layout .= apply_filters( 'vc_grid_thumbnail_text_after_content', '', $my_query->post );
		}
		else if ($grid_layout == 'title_text' ) {
			$layout .= apply_filters( 'vc_grid_title_text_before_title', '', $my_query->post );
			$layout .= '<h3 class="teaser_title">' . $link_title . $post_title . $link_end .'</h3>';
			$layout .= apply_filters( 'vc_grid_title_text_after_title', '', $my_query->post );
			
			$layout .= apply_filters( 'vc_grid_title_text_before_content', '', $my_query->post );
			$layout .= '<div class="teaser_content">'. $content . '</div> <div class="vc_clear"></div>';
			$layout .= apply_filters( 'vc_grid_title_text_after_content', '', $my_query->post );
		}
		else if ($grid_layout == 'thumbnail' ) {
			if ($post_thumbnail != '' ) :
			$layout .= apply_filters( 'vc_grid_thumbnail_before_thumbnail', '', $my_query->post );
			$layout .= $link_image . $post_thumbnail . $link_end;
			$layout .= apply_filters( 'vc_grid_thumbnail_after_thumbnail', '', $my_query->post );
			endif;
		}
		$div_teaser_width = $teaser_width;
		if ( $grid_template == 'wpb_carousel' ) { $output .= '<li class="'.$teaser_width.'">'; $div_teaser_width = ''; }
		$output .= '<div class="teaser_grid '.$teaser_post_type.$div_teaser_width.$t_extra.'">';
		$output .= '<div class="wpb_wrapper">'.$layout.'</div>';
		$output .= '</div>' . $divclear . "\n";
		if ($grid_template == 'wpb_carousel') $output .= '</li>';
	}
	if ($grid_template == 'wpb_carousel') $output .= '</ul></div>';
	
	$output .= '</div>'.$extra;
	
	wp_reset_query();
	return $output;
}

add_shortcode( 'vc_tabs', 'wpb_tabs_func' );
function wpb_tabs_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'last' => '',
		'width' => '1/2'
	), $atts));
	$output = '';
	$extra = '';
	
	if ($last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	
	global $sc_js;
	array_push($sc_js, "cycle");
	
	$width = wpb_getColumnWidth($width);
	
	$output .= '<div class="column '.$width.$last.'"><div class="wpb_tabs">'.wpb_js_remove_wpautop($content).'</div></div>'.$extra;
	return $output;
}

add_shortcode( 'vc_tab', 'wpb_tab_func' );
function wpb_tab_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'tab_title' => ''
	), $atts));
	$output = '';
	
	$output .= '<div class="wpb_tab"><div class="vc_clear"></div><span id="tab_'.sanitize_title($tab_title).'" class="tab-title">'.$tab_title.'</span>'.wpb_js_remove_wpautop($content).'</div>';
	return $output;
}

$tour_menu = '';
add_shortcode( 'vc_tour', 'wpb_tour_func' );
function wpb_tour_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'last' => '',
		'width' => '1/1'
	), $atts));
	$output = '';
	$extra = '';
	
	$last = 'last';
	$width = '1/1';
	
	if ($last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	
	global $sc_js;
	array_push($sc_js, "cycle");
	
	$width = wpb_getColumnWidth($width);
	
	global $tour_menu;
	$tour_menu = array();
	
	$output .= '<div class="small_tour full-width last">';
    
    $output .= '<div class="small_tour_slides">';
    $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>'; //end small_tour_slides
    
    $output .= '
    <div class="small_tour_menu">
	<ul class="small_tour_menu_ul">';
	foreach ($tour_menu as $tour_m) {
		$output .= '<li class="stm_'.sanitize_title($tour_m).'"><a href="#" title="">'.$tour_m.'</a></li>';
	}
    $output .= '</ul></div>';
    
	$output .= '</div>'; //end small_tour
	$output .= $extra;
	
	return $output;
}

add_shortcode( 'vc_tour_slide', 'wpb_tour_slide_func' );
function wpb_tour_slide_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'slide_title' => ''
	), $atts));
	$output = '';
	global $tour_menu;
	array_push($tour_menu, $slide_title);
	
	$output .= '
	<div class="small_tour_slide"><div class="small_tour_slide_content">'.wpb_js_remove_wpautop($content).'</div>
	<div class="vc_clear"></div>
	<a class="tourPrevSlide" href="#nextslide" title="">'.__("Previous slide", "js_composer").'</a> <a class="tourNextSlide" href="#nextslide" title="">'.__("Next slide", "js_composer").'</a>
	</div> <!-- end small_tour_slide -->
	';
	return $output;
}


add_shortcode( 'vc_message', 'wpb_message_func' );
function wpb_message_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'color' => 'blue_message',
	), $atts));
	$output = '';
	
	$output .= '<div class="wpb_vc_messagebox message '.$color.'"><div class="messagebox_text">'.wpb_js_remove_wpautop($content).'</div></div>';
	return $output;
}

add_shortcode( 'vc_toggle', 'wpb_toggle_func' );
function wpb_toggle_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'title' => __("Click to toggle", "js_composer"),
	), $atts));
	$output = '';
	$output .= '<h4 class="wpb_toggle">'.$title.'</h4><div class="wpb_toggle_content">'.wpb_js_remove_wpautop($content).'</div>';
	
	return $output;
}

add_shortcode( 'vc_separator', 'wpb_separator_func' );
function wpb_separator_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'with_line' => '',
	), $atts));
	$output = '';
	//$with_line = ($with_line == 'true' ) ? ' separator_with_line' : '';
	//$output .= '<div class="wpb_separator'.$with_line.'"></div>';
	$output .= '<div class="wpb_separator"></div>';
	return $output;
}

add_shortcode( 'vc_text_separator', 'wpb_vc_text_separator_func' );
function wpb_vc_text_separator_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'title' => __("Title", "js_composer"),
		'title_align' => 'separator_align_center',
		'class' => ''
	), $atts));
	$output = '';
	$extra = '';
	
	$output .= '<div class="column full-width last vc_text_separator '.$title_align.' '.$class.'"><div>'.$title.'</div></div><div class="vc_clear"></div>';
	
	return $output;
}

add_shortcode( 'vc_twitter', 'wpb_twitter_func' );
function wpb_twitter_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'title' => '',
		'twitter_name' => 'twitter',
		'tweets_count' => 5,
		'last' => '',
		'width' => '1/1',
		'class' => ''
	), $atts));
	$output = '';
	$extra = '';
	
	if ($last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	
	if ($class != '') {
		$class = str_replace(".", "", $class) . " ";
	}
	
	global $sc_js;
	array_push($sc_js, "tweet");
	
	$width = wpb_getColumnWidth($width);
	
	$output .= '<div class="wpb_twitter_widget '.$class.$width.$last.'">';
	$output .= '<div class="wpb_wrapper">';
	$output .= ($title != '' ) ? '<h2 class="wpb_heading wpb_twitter_heading">'.$title.'</h2>' : '';
	//$output .= '<div class="wpb_wrapper">';
	
	$output .= '<span class="tw_name hidden">'.$twitter_name.'</span> <span class="tw_count hidden">'.$tweets_count.'</span>';
	$output .= '<div class="tweets"></div> <a class="twitter_follow_button" href="http://twitter.com/'.$twitter_name.'">'.__("Follow us on twitter", "js_composer").'</a>';
	$output .= '</div>';
	$output .= '</div>'.$extra;
	return $output;
}

add_shortcode( 'vc_facebook', 'wpb_facebook_func' );
function wpb_facebook_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'type' => 'standard',//standard, button_count, box_count
		'url' => ''
	), $atts));
	if ( $url == '') $url = wpb_curPageURL();
	$output = '<div class="fb_like fb_type_'.$type.'"><iframe src="http://www.facebook.com/plugins/like.php?href='.$url.'&amp;layout='.$type.'&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>';
	return $output;
}

add_shortcode( 'vc_tweetmeme', 'wpb_tweetmeme_func' );
function wpb_tweetmeme_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'type' => 'horizontal'//horizontal, vertical, none
	), $atts));
	$output = '<a href="http://twitter.com/share" class="twitter-share-button" data-count="'.$type.'">'. __("Tweet", "js_composer") .'</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
	return $output;
}

add_shortcode( 'vc_gallery', 'wpb_gallery_func' );
function wpb_gallery_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'title' => '',
		'type' => 'fading',
		'onclick' => 'link_image',
		'img_size' => '',
		'width' => '1/1',
		'images' => '',
		'last' => ''
	), $atts));
	$output = '';
	$extra = '';
	
	if ($images != '' ) {
		if ($last == 'last' ) {
			$last = ' last';
			$extra = ' <div class="vc_clear"></div>';
		}
		
		$images = explode( ',', $images);
		$width = wpb_getColumnWidth($width);
		
		if ( $img_size == '' ) {
			if ( $width == 'one-fourth' ) {
				$th_w = (ONE_FOURTH_TH_W) ? ONE_FOURTH_TH_W : 212;
				$th_h = (ONE_FOURTH_TH_H) ? ONE_FOURTH_TH_H : 150;
			}
			else if ( $width == 'one-third' ) {
				$th_w = (ONE_THIRD_TH_W) ? ONE_THIRD_TH_W : 293;
				$th_h = (ONE_THIRD_TH_H) ? ONE_THIRD_TH_H : 207;
			}
			else if ( $width == 'one-half' ) {
				$th_w = (ONE_HALF_TH_W) ? ONE_HALF_TH_W : 455;
				$th_h = (ONE_HALF_TH_H) ? ONE_HALF_TH_H : 322;
			}
			else if ( $width == 'full-width' ) {
				$th_w = (FULL_WIDTH_TH_W) ? FULL_WIDTH_TH_W : 940;
				$th_h = (FULL_WIDTH_TH_H) ? FULL_WIDTH_TH_H : 665;
			}
			else {
				$th_w = 212;
				$th_h = 150;
			}
			
			$img_size = $th_w.'x'.$th_h;
		}
		
		if (is_string($img_size)) {
			$img_size = str_replace(array( 'px', ' ' ), array( '', '' ), $img_size);
			$img_size = explode("x", $img_size);
		}
		
		global $sc_js;
		if ($type == 'nivo' ) {
			$type = ' wpb_slider_nivo';
			array_push($sc_js, "nivo-slider");
		} else {
			$type = ' wpb_slider_fading';
			array_push($sc_js, "cycle");
		}
		
		$output .= '<div class="wpb_gallery '.$width.$last.'">';
		if ($title != '' ) $output .= '<h2 class="wpb_heading wpb_gallery_heading">'.$title.'</h2>';
		
		$output .= '<div class="wpb_gallery_slides'.$type.'">';
		
		$pretty_rel_random = 'rel-'.rand();
		foreach ($images as $img_id) {
			$link_start = $link_end = $p_img_large = '';
			
			$image = wpb_resize($img_id, '', $img_size[0], $img_size[1], true);
			if ( $onclick == 'link_image' ) {
				$p_img_large = wp_get_attachment_image_src($img_id, 'large' );
				
				$link_start = '<a class="prettyphoto" rel="prettyPhoto['.$pretty_rel_random.']" href="'.$p_img_large[0].'" title="">';
				$link_end = '</a>';
			}
			$output .= $link_start . '<img src="'.$image['url'].'" alt="" width="'.$image['width'].'" height="'.$image['height'].'" />' . $link_end;
		}
		
		$output .= '</div>';
		$output .= '</div>'.$extra;
	}
	return $output;
}

add_shortcode( 'vc_widget_sidebar', 'vc_widget_sidebar_func' );
function vc_widget_sidebar_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'last' => '',
		'width' => '1/1',
		'sidebar_id' => ''
	), $atts));
	$output = '';
	$extra = '';
	
	if ($last == 'last' ) {
		$last = ' last';
		$extra = ' <div class="vc_clear"></div>';
	}
	
	$width = wpb_getColumnWidth($width);
	
	$output .= '<div class="wpb_widgetised_column column '.$width.$last.'">';
	ob_start();
	dynamic_sidebar($sidebar_id);
	$sidebar_value = ob_get_contents();
	ob_end_clean();
	
	$sidebar_value = trim($sidebar_value);
	
	$sidebar_value = (substr($sidebar_value, 0, 3) == '<li' ) ? '<ul>'.$sidebar_value.'</ul>' : $sidebar_value;
	
	$output .= $sidebar_value . '</div>'.$extra;
	
	return $output;
}

/* Button
---------------------------------------------------------- */
add_shortcode( 'vc_button', 'vc_button_func' );
function vc_button_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'color' => 'button_grey',
		'icon' => 'none',
		'target' => '_self',
		'href' => '',
		'title' => __('Text on the button', "js_composer")
	), $atts));
	$output = '';
	
	if ($target == 'same' || $target == '_self') { $target = ''; } //check for same -> leftover from small bug in previous versions.
	if ($target != '') {
		$target = ' target="'.$target.'"';
	}
	//$output .= '<div class="vc_clear"></div>';
	$output .= '<a class="wpb_button '.$icon.' '.$color.'" href="'.$href.'" title="'.$title.'" '.$target.'><span class="ico">'.$title.'</span></a>';
	//$output .= '<div class="vc_clear"></div>';
	
	return $output;
}

/* Call to action box
---------------------------------------------------------- */
add_shortcode( 'vc_cta_button', 'vc_cta_button_func' );
function vc_cta_button_func($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'color' => 'button_grey',
		'icon' => 'none',
		'target' => '',
		'href' => '',
		'title' => __('Text on the button', "js_composer"),
		'call_text' => '',
		'position' => 'cta_align_right'
	), $atts));
	$output = '';
	$icon_span = $title;
	
	if ($target != '') {
		$target = ' target="'.$target.'"';
	}
	
	if ($icon != 'none') {
		$icon_span = '<span class="ico">'.$title.'</span>';
	}
	
	
	$output .= '<div class="wpb_call_to_action '.$position.'">';
	if ( $position != 'cta_align_bottom' ) $output .= '<a class="wpb_button '.$icon.' '.$color.'" href="'.$href.'" title="'.$title.'" '.$target.'>'.$icon_span.'</a>';
	$output .= '<h2 class="wpb_call_text">'. $call_text . '</h2>';
	if ( $position == 'cta_align_bottom' ) $output .= '<a class="wpb_button '.$icon.' '.$color.'" href="'.$href.'" title="'.$title.'" '.$target.'>'.$icon_span.'</a>';
	$output .= '<div class="vc_clear"></div>';
	$output .= '</div>';
	
	return $output;
}



/* Helper functions
---------------------------------------------------------- */
function wpb_curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function wpb_js_remove_wpautop($content) { 
	$content = do_shortcode( shortcode_unautop($content) );
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
	return $content;
}

function wpb_getColumnWidth($width) {
	switch ($width) {
		case '1/1' :
			$width = 'full-width';
		break;
		
		case '3/4' :
			$width = 'three-fourth';
		break;
		
		case '2/3' :
			$width = 'two-third';
		break;
		
		case '1/2' :
			$width = 'one-half';
		break;
		
		case '1/3' :
			$width = 'one-third';
		break;
		
		case '1/4' :
			$width = 'one-fourth';
		break;
	}
	return $width;
}

function wpb_extra_markup( $function_name ) {
	if (function_exists( $function_name )) {
		//return eval($function_name);
		return call_user_func($function_name);
	}
}

function fix_p_tags($content = '') {
	//return str_ireplace(array("</p</p>", "</p"), array("</p>", "</p>"), $content);
	$patterns = array ('/<\/p<\/p>/',
					   '/<\/p[^>]/');
	
	$replace = array ('</p>', '</p>');
	
	//return preg_replace($patterns, $replace, $content);
	
	$content = str_ireplace("<p></p>","", $content);
	$content = preg_replace("/<\/?[a-z]+[^>]+<\/[a-z]+[^>]+>/", "", $content);
	$content = preg_replace("/<\/?[a-z]+[^>]+(<|$)/", "\\1", $content);
	return $content;
}

/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if (!function_exists( 'wpb_resize' )) {
function wpb_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

	// this is an attachment, so we have the ID
	if ( $attach_id ) {
	
		$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
		$file_path = get_attached_file( $attach_id );
	
	// this is not an attachment, let's use the image url
	} else if ( $img_url ) {
		
		$file_path = parse_url( $img_url );
		$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
		
		//$file_path = ltrim( $file_path['path'], '/' );
		//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
		
		$orig_size = getimagesize( $file_path );
		
		$image_src[0] = $img_url;
		$image_src[1] = $orig_size[0];
		$image_src[2] = $orig_size[1];
	}
	
	$file_info = pathinfo( $file_path );
	$extension = '.'. $file_info['extension'];

	// the image path without the extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// checking if the file size is larger than the target size
	// if it is smaller or the same size, stop right here and return
	if ( $image_src[1] > $width || $image_src[2] > $height ) {

		// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
		if ( file_exists( $cropped_img_path ) ) {

			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			
			$vt_image = array (
				'url' => $cropped_img_url,
				'width' => $width,
				'height' => $height
			);
			
			return $vt_image;
		}

		// $crop = false
		if ( $crop == false ) {
		
			// calculate the size proportionaly
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// checking if the file already exists
			if ( file_exists( $resized_img_path ) ) {
			
				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

				$vt_image = array (
					'url' => $resized_img_url,
					'width' => $proportional_size[0],
					'height' => $proportional_size[1]
				);
				
				return $vt_image;
			}
		}

		// no cache files - let's finally resize it
		$new_img_path = image_resize( $file_path, $width, $height, $crop );
		if ( is_string($new_img_path) == false ) { return ''; }
		$new_img_size = getimagesize( $new_img_path );
		$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

		// resized output
		$vt_image = array (
			'url' => $new_img,
			'width' => $new_img_size[0],
			'height' => $new_img_size[1]
		);
		
		return $vt_image;
	}

	// default output - without resizing
	$vt_image = array (
		'url' => $image_src[0],
		'width' => $image_src[1],
		'height' => $image_src[2]
	);
	
	return $vt_image;
}
}

?>