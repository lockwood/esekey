<?php
$themename = "Dandelion";
$shortname = "dandelion";

$functions_path= TEMPLATEPATH . '/functions/';
add_action('admin_menu', 'mytheme_add_admin');

if(is_admin()){
require('update-notifier.php');
}

/* ------------------------------------------------------------------------*
 * DEFINE THE MAIN CONSTANTS THAT WILL BE USED WITHIN THE THEME
 * ------------------------------------------------------------------------*/

define("PEXETO_FUNCTIONS_PATH", TEMPLATEPATH . '/functions/');
define("PEXETO_FUNCTIONS_URL", get_template_directory_uri().'/functions/');
define("PEXETO_TIMTHUMB_URL", PEXETO_FUNCTIONS_URL.'timthumb.php');
define("PEXETO_OPTIONS_URL", get_template_directory_uri().'/functions/options/');
define("PEXETO_OPTIONS_PATH", PEXETO_FUNCTIONS_PATH.'/options/');
define("PEXETO_IMAGES_URL", PEXETO_OPTIONS_URL.'images/');
define("PEXETO_CSS_URL", PEXETO_OPTIONS_URL.'css/');
define("PEXETO_SCRIPT_URL", PEXETO_OPTIONS_URL.'script/');
define("PEXETO_PATTERNS_URL", PEXETO_OPTIONS_URL.'images/pattern_samples/');
define("PEXETO_SEPARATOR", '|*|');

define("PEXETO_SHORTNAME", $shortname);

$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
define("PEXETO_VERSION", $theme_data['Version']);

$uploadsdir=wp_upload_dir();
define("PEXETO_UPLOADS_URL", $uploadsdir['url']);


define("OPTIONS_HEADING", 'This is the '.$themename.' options page where you can do most of the theme settings. Please note
that there is a documentation included where all the theme customization settings are explained. The documentation
is located within the <strong>documentation</strong> folder. <br/><br/>
<strong>If you have any questions, please refer to the Support section of the documentation.</strong>');

/* ------------------------------------------------------------------------*
 * INCLUDE THE FUNCTIONS FILES
 * ------------------------------------------------------------------------*/
require_once (PEXETO_FUNCTIONS_PATH.'general.php');  //some main common functions
require_once (PEXETO_FUNCTIONS_PATH.'sidebars.php');  //the sidebar functionality
require_once (PEXETO_OPTIONS_PATH.'options.php');  //the theme options functionality
require_once (PEXETO_FUNCTIONS_PATH.'portfolio.php');  //portfolio functionality
require_once (PEXETO_FUNCTIONS_PATH.'comments.php');  //the comments functionality
require_once (PEXETO_FUNCTIONS_PATH.'meta.php');  //adds the custom meta fields to the posts and pages
require_once (PEXETO_FUNCTIONS_PATH.'shortcodes.php');  //the shortcodes functionality
require_once (PEXETO_FUNCTIONS_PATH.'contact.php');  //contact form functionality



add_action('admin_enqueue_scripts', 'pexeto_admin_init');

/**
 * Enqueues the JavaScript files needed depending on the current section.
 */
function pexeto_admin_init(){
	global $current_screen;
	
	//enqueue the script and CSS files for the TinyMCE editor formatting buttons
	if($current_screen->base=='post'){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		
		//set the style files
		add_editor_style('functions/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('pexeto-page-style',PEXETO_CSS_URL.'page_style.css');
	}
	
	if(isset($_GET['page']) && $_GET['page']=='options'){
		//enqueue the scripts for the Options page
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('pexeto-jquery-co',PEXETO_SCRIPT_URL.'jquery-co.js');
		wp_enqueue_script('pexeto-ajaxupload',PEXETO_SCRIPT_URL.'ajaxupload.js');
		wp_enqueue_script('pexeto-colorpicker',PEXETO_SCRIPT_URL.'colorpicker.js');
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'options.js');

		//enqueue the styles for the Options page
		wp_enqueue_style('pexeto-admin-style',PEXETO_CSS_URL.'admin_style.css');
		wp_enqueue_style('pexeto-colorpicker-style',PEXETO_CSS_URL.'colorpicker.css');
	}
	
	if($current_screen->id=='portfolio'){
		//enqueue the scripts needed for the add/edit portfolio post
		wp_enqueue_script('pexeto-ajaxupload',PEXETO_SCRIPT_URL.'ajaxupload.js');
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'options.js');
	}

	if($current_screen->id=='page'){
		//enqueue the scripts needed for the add/edit page page
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'page-options.js');
	}
}


/**
 * Load all the CSS and JavaScript files needed for the Pexeto Panel.
 */
function admin_head_add()
{
	if(isset($_GET['page']) && $_GET['page']=='options'){
		
		//init the options js functionality
		echo '<script>jQuery(function(){
				pexetoOptions.init({cookie:true});
							
			});</script>
			<!--[if IE 9]>
		<style type="text/css">
		.tab_navigation ul li.ui-tabs-selected a.tab span, .tab_navigation ul li.ui-tabs-selected a.tab span{
		top:-1px;
		position:relative;
		}
		
		.tab_navigation ul li.ui-tabs-selected a.tab{
		position:relative;
		top:1px;
		}
		</style>
		<![endif]-->';
	}
}



?>