<?php
/*
Plugin Name: WPBakery Visual Composer
Plugin URI: http://wpbakery.com/vc/
Description: Create content without headaches with simple drag-n-drop interface.
Version: 2.3.3
Author: Michael M - WPBakery.com
Author URI: http://wpbakery.com
License: 
*/
// don't load directly
if ( !defined('ABSPATH') ) die('-1');

define('WPB_VC_VERSION', '2.3.3');
/* Define constant with path to the folder with plugin in it
---------------------------------------------------------- */
if (in_array('plugins', explode('/', __FILE__)) || in_array('plugins', explode('\\', __FILE__))) {
	if (!load_plugin_textdomain('js_composer', '/wp-content/languages/'))
		load_plugin_textdomain('js_composer', '/wp-content/plugins/js_composer/po/');
	//
	define('WPB_JS_COMPOSER_URL', plugin_dir_url( __FILE__ ));
	define('WPB_IS_PLUGIN', true);
	//
	add_action('admin_menu', 'wpb_js_composer_settings');
	register_activation_hook(__FILE__, 'wpb_js_composer_activate');
	add_action('admin_init', 'wpb_js_composer_redirect');
} else {
	//
	define('WPB_JS_COMPOSER_URL', get_template_directory_uri() . '/wpbakery/js_composer/');
	define('WPB_IS_PLUGIN', false);
	//
	add_action('admin_menu', 'wpb_js_composer_settings');
}

function wpb_js_composer_settings() {
	if (current_user_can('administrator')) {
		if (WPB_IS_PLUGIN) {
			add_options_page(__("Visual Composer Settings", "js_composer"), __("Visual Composer", "js_composer"), 1, "wpb_vc_settings", "wpb_js_composer_settings_menu"); /* This will be used only if it runs like a plugin */
		} else {
			//add_options_page(__("Visual Composer Settings", "js_composer"), __("Visual Composer", "js_composer"), 1, "wpb_vc_settings", "wpb_js_composer_settings_menu");
		}
	}
}

function wpb_js_composer_settings_menu() {
    require('js_composer_settings_menu.php');
}

function wpb_js_composer_activate() {
    add_option('wpb_js_composer_do_activation_redirect', true);
}

function wpb_js_composer_redirect() {
    if (get_option('wpb_js_composer_do_activation_redirect', false)) {
        delete_option('wpb_js_composer_do_activation_redirect');
        wp_redirect(admin_url().'options-general.php?page=wpb_vc_settings');
    }
}

/* Include shortcode library
---------------------------------------------------------- */
require_once('shortcodes.php');

add_action('admin_init', 'wpb_register_js_composer_css');
function wpb_register_js_composer_css() {	
	if ( function_exists('wp_editor') ) {
		wp_register_script('wpb_js_composer_js', WPB_JS_COMPOSER_URL . 'js_composer.js', array('jquery'), WPB_VC_VERSION, true);
	} else {
		wp_register_script('wpb_js_composer_js', WPB_JS_COMPOSER_URL . 'js_composer_lt_wp_3.3.js', array('jquery'), WPB_VC_VERSION, true);
	}
	
	wp_register_style('wpb_js_composer_css', WPB_JS_COMPOSER_URL . 'js_composer.css');
	
	add_action('admin_print_scripts', 'wpb_js_composer_edit_screen_js');
	
	if (WPB_IS_PLUGIN) {
		$pt_array = ($pt_array = get_option('wpb_js_content_types')) ? $pt_array : array();
	}
	else {
		$pt_array = ($pt_array = get_option('wpb_js_theme_content_types')) ? $pt_array : array();
	}
	foreach ($pt_array as $pt) {
		//echo $pt;
		add_meta_box( 'wpb_visual_composer', __('Visual Composer', "js_composer"), 'wpb_composer', $pt, 'advanced', 'high');
	}
}

/* Enqueue scripts required for backend functionality
---------------------------------------------------------- */
function wpb_js_composer_edit_screen_js() {
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-draggable');
	
	wp_enqueue_script('wpb_js_composer_js');
	/* 3.3 */
	wp_enqueue_script('tiny_mce');
}

/* Attach CSS file with backend styles
---------------------------------------------------------- */
add_action('admin_print_styles', 'wpb_admin_js_composer_css');
function wpb_admin_js_composer_css() {
	wp_enqueue_style('wpb_js_composer_css');
}


/* Attach CSS file with frontend styles
---------------------------------------------------------- */
add_action( 'template_redirect', 'wpb_js_frontend_css' );
function wpb_js_frontend_css() {
	wp_enqueue_style( 'prettyphoto', WPB_JS_COMPOSER_URL . 'css/prettyPhoto.css');
	wp_enqueue_style( 'wpb_js_composer_css', WPB_JS_COMPOSER_URL . 'js_composer_front.css');
	
	if ( (get_option('wpb_js_grid_w') != '' || get_option('wpb_js_grid_g') != '' || get_option('wpb_js_grid_p') != '') && WPB_IS_PLUGIN) {
		wp_enqueue_style( 'wpb_js_composer_custom_grid', WPB_JS_COMPOSER_URL . 'css_grid.php');
	}
}

//add_action( 'wp_print_scripts', 'wpb_js_frontend_js' );
/*

Shortcode related javascript libraries are included in the shortcodes.php
they are loaded only when nescessary, this helps to save loading time

*/
/*function wpb_js_frontend_js() {
	//wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script( 'cycle', WPB_JS_COMPOSER_URL . 'js/jquery.cycle.all.js', array('jquery'));
	wp_enqueue_script( 'tweet', WPB_JS_COMPOSER_URL . 'js/jquery.tweet.js', array('jquery'));
	wp_enqueue_script( 'prettyphoto', WPB_JS_COMPOSER_URL . 'js/jquery.prettyPhoto.js', array('jquery'));
	wp_enqueue_script( 'nivo-slider', WPB_JS_COMPOSER_URL . 'js/jquery.nivo.slider.pack.js', array('jquery'));
	wp_enqueue_script( 'wpb_composer_front_js', WPB_JS_COMPOSER_URL . 'js_composer_front.js', array('jquery'));
}*/


/* Generate Visual Composer canvas, with menu and layout
   elements if they are already created
---------------------------------------------------------- */
function wpb_composer($post, $metabox) {
	//wp_editor('<p>Some content</p>', 'editortest_one' );
//	wp_editor('<p> <span style="color: rgb(255, 34, 24)">Some content</span></p>', 'editortest_one' );
	
	$output = '';
	
	$output .= '<input type="hidden" id="wpb_js_plugin_path" name="wpb_js_plugin_path" value="'. WPB_JS_COMPOSER_URL .'" />';
	$output .= '<input type="hidden" id="wpb_js_home_path" name="wpb_js_home_path" value="'. home_url() .'" />';
	
	$output .= '<ul id="wpb_visual_composer-elements">
	<li id="menu-wpbakery" class="wp-has-submenu menu-top menu-icon-wpbakery menu-top-first menu-top-last">
		<div class="wp-menu-image">
			<a href="#"><br></a>
		</div>
		
		<div class="wp-submenu">
			<div class="wp-submenu-head">WPBakery Visual Composer</div>
			<ul>
				<li>
					<div>
						<p>Select element from menu on the left. Click it to add selected element to the main post content section or drag it to the existing column.</p>
						<p>Tip: To re-arrange layout elements use your mouse to drag elements around.</p>
					</div>
				</li>
			</ul>
		</div>
	</li>
	
	<li class="wp-menu-separator"><a href="#" class="separator"><br></a></li>
	
	<li id="menu-appearance" class="wp-has-submenu menu-top menu-icon-layout menu-top-first">
		<div class="wp-menu-image"><a href="#"><br></a></div>
		
		<div class="wp-submenu">
			<div class="wp-submenu-head">'.__("Popular Layouts (Columns)", "js_composer").'</div>
			<ul>
				<li><a id="column_12" class="column_12 clickable_action" href="#"><span>1/2</span></a></li>
				<li><a id="column_12-12" class="column_12-12 clickable_action" href="#"><span>1/2 + 1/2</span></a></li>
				<li><a id="column_13" class="column_13 clickable_action" href="#"><span>1/3</span></a></li>
				<li><a id="column_13-13-13" class="column_13-13-13 clickable_action" href="#"><span>1/3 + 1/3 + 1/3</span></a></li>
				<li><a id="column_13-23" class="column_13-23 clickable_action" href="#"><span>1/3 + 2/3</span></a></li>
				<li><a id="column_14" class="column_14 clickable_action" href="#"><span>1/4</span></a></li>
				<li><a id="column_14-14-14-14" class="column_14-14-14-14 clickable_action" href="#"><span>1/4 + 1/4 + 1/4 + 1/4</span></a></li>
			</ul>
		</div>
	</li>
	
	<li id="menu-appearance" class="wp-has-submenu menu-top menu-icon-composer-elements menu-top-last">
		<div class="wp-menu-image"><a href="#"><br></a></div>
		
		<div class="wp-submenu">
			<div class="wp-submenu-head">'.__("Content Elements", "js_composer").'</div>
			<ul>'.wpb_getContentElements().'</ul>
		</div>
	</li>
	
	</ul>';
	
	
	/*
	   Spottted! :)
	   Yes that list is my todo list for future plugin releases.
	*/
	
	/*
	Saving/loading templates - http://www.w3schools.com/js/tryit.asp?filename=tryjs_prompt
	
	<li class="wp-menu-separator"><a href="#" class="separator"><br></a></li>
	<li id="menu-templates" class="wp-has-submenu menu-top menu-icon-templates menu-top-first menu-top-last">
		<div class="wp-menu-image">
			<a href="#"><br></a>
		</div>
		
		<div class="wp-submenu">
			<div class="wp-submenu-head">'.__("Templates", "js_composer").'</div>
			<a id="save_current_template" href="#" title="">'.__("Save current template", "js_composer").'</a>
			<ul>'.wpb_getSavedTemplates().'</ul>
		</div>
	</li>
	*/
	
	/*<li id="menu-appearance" class="wp-has-submenu menu-top menu-icon-appearance menu-top-last">
		<div class="wp-menu-image"><a href="#"><br></a></div>
		
		<div class="wp-submenu">
			<div class="wp-submenu-head">Todo</div>
			<ul>
				<li><a class="highlight_el dropable_el clickable_action" href="#">!!! '.__("Highlight box", "js_composer").'</a></li>
				<li><a href="#">Tour section</a></li>
				<li><a href="#">Highlight box with arrows</a></li>
			</ul>
		</div>
	</li>
	*/
	
	
	$metabox_html_value = get_post_meta($post->ID, 'wpb_composer_html', true);
    if ($metabox_html_value == "" || !isset($metabox_html_value)) {
        $metabox_html_value = '<div class="wpb_clear"></div>';
    } else {
    	$metabox_html_value = str_ireplace('<div class="clear"></div>', '<div class="wpb_clear"></div>', $metabox_html_value);
    }
	
	$output .= '<div class="metabox-composer-content">
					<div id="visual_composer_edit_form"></div>
					
					<div id="visual_composer_content" class="wpb_main_sortable main_wrapper">
						'.$metabox_html_value.'
					</div>
					
				</div>';
	
	$metabox_value = get_post_meta($post->ID, 'wpb_composer', true);
    if ($metabox_value == "" || !isset($metabox_value)) {
        $metabox_value = '';
    }
    
    $wpb_vc_status = get_post_meta($post->ID, '_wpb_vc_js_status', true);
    if ($wpb_vc_status == "" || !isset($wpb_vc_status)) {
        $wpb_vc_status = 'false';
    }
    
    $output .= '<input type="hidden" id="wpb_vc_js_status" name="wpb_vc_js_status" value="'. $wpb_vc_status .'" />';
    
	$output .= '<textarea id="visual_composer_code_holder" class="wpb_visual_composer-textarea" name="wpb_composer" cols="55" rows="10">' . $metabox_value . '</textarea>';
	$output .= '<textarea id="visual_composer_html_code_holder" class="wpb_visual_composer-textarea" name="wpb_composer_html" cols="55" rows="10">' . $metabox_html_value . '</textarea>';
	
	echo $output;
	
}

/* Get save templates
---------------------------------------------------------- */
function wpb_getSavedTemplates() {
	$wpb_templates = get_option('wpb_vc_templates');
	
	if ($wpb_templates) {
		$output = '<li><a id="column_14-14-14-14" class="column_14-14-14-14 clickable_action" href="#"><span>1/4 + 1/4 + 1/4 + 1/4</span></a></li>';
		return $output;
	}
}

/* Get links to available elements
---------------------------------------------------------- */
require_once('map.php');

function wpb_getContentElements() {
	global $wpb_sc;
	$output = '';
	
	foreach ($wpb_sc as $sc_base => $el) {
		$output .= '<li><a id="'.$sc_base.'" class="dropable_el clickable_action" href="#">'. $el["name"] .'</a></li>';
	}
	
	return $output;
}


/* Save generated shortcodes, html and visual composer
   status in posts meta
---------------------------------------------------------- */
add_action('edit_post', 'wpb_js_composer_save_metaboxes');
function wpb_js_composer_save_metaboxes($post_id) {
	/* If the save is triggered by the autosave WordPress feature don't continue executing the script */
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	
	if (isset($_POST['wpb_vc_js_status'])) {
		// Get the value
		$value = $_POST['wpb_vc_js_status'];		
		// Add value
		if (get_post_meta($post_id, '_wpb_vc_js_status') == '') { add_post_meta($post_id, '_wpb_vc_js_status', $value, true);	}
		// Update value
		elseif ($value != get_post_meta($post_id, '_wpb_vc_js_status', true)) { update_post_meta($post_id, '_wpb_vc_js_status', $value); }
		// Delete value
		elseif ($value == '') {	delete_post_meta($post_id, '_wpb_vc_js_status', get_post_meta($post_id, '_wpb_vc_js_status', true)); }
	}
	if (isset($_POST['wpb_composer'])) {
		// Get the value
		$value = $_POST['wpb_composer'];		
		// Add value
		if (get_post_meta($post_id, 'wpb_composer') == '') { add_post_meta($post_id, 'wpb_composer', $value, true);	}
		// Update value
		elseif ($value != get_post_meta($post_id, 'wpb_composer', true)) { update_post_meta($post_id, 'wpb_composer', $value); }
		// Delete value
		elseif ($value == '') {	delete_post_meta($post_id, 'wpb_composer', get_post_meta($post_id, 'wpb_composer', true)); }
	}
	if (isset($_POST['wpb_composer_html'])) {
		// Get the value
		$html_value = trim($_POST['wpb_composer_html']);
		// Add value
		if (get_post_meta($post_id, 'wpb_composer_html') == '') { add_post_meta($post_id, 'wpb_composer_html', $html_value, true); }
		// Update value
		elseif ($html_value != get_post_meta($post_id, 'wpb_composer_html', true) && $html_value != '<div class=\"wpb_clear\"></div>' && $html_value != '<div class=\"clear\"></div>') { update_post_meta($post_id, 'wpb_composer_html', $html_value); }
		// Delete value 
		elseif ($html_value == '' || $html_value == '<div class=\"wpb_clear\"></div>' || $html_value == '<div class=\"clear\"></div>') { delete_post_meta($post_id, 'wpb_composer_html', get_post_meta($post_id, 'wpb_composer_html', true)); }
	}
} //end wpb_save_metaboxes()


/* This prevents shortcode stripping from the excerpt
---------------------------------------------------------- */
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpb_improved_trim_excerpt');
function wpb_improved_trim_excerpt($text) {
    $raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
		$initial_text = $text;

		$text = strip_shortcodes( $text );
		if ( $text == '') $text = $initial_text;

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<p>');
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}

    return $text;
}




/* Helper function which returs list of site attached images,
   and if image is attached to the current post it adds class
   'added'
---------------------------------------------------------- */
if (!function_exists('siteAttachedImages')) {
function siteAttachedImages($att_ids = array()) {
	$output = '';
	
	global $wpdb;
	$media_images = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' order by ID desc");
	foreach($media_images as $image_post) {
		$thumb_src = wp_get_attachment_image_src($image_post->ID, 'thumbnail');
		$thumb_src = $thumb_src[0];
		
		$class = (in_array($image_post->ID, $att_ids)) ? ' class="added"' : '';
		
		$output .= '<li'.$class.'>
						<img rel="'.$image_post->ID.'" src="'. $thumb_src .'" alt="'. $img_details[0] .'" />
						<span class="img-added">'. __('Added', "js_composer") .'</span>
					</li>';
	}
	
	if ($output != '') {
		$output = '<ul class="gallery_widget_img_select">' . $output . '</ul>';
	}
	return $output;
} // end siteAttachedImages()
}
?>