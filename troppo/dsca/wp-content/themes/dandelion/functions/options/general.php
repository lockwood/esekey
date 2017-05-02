<?php

$pexeto_general_options= array( array(
"name" => "General",
"type" => "title",
"img" => PEXETO_IMAGES_URL."icon_general.png"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"main", "name"=>"Main Settings"), array("id"=>"sidebars", "name"=>"Sidebars"), array("id"=>"lightbox", "name"=>"Lightbox"))
),

/* ------------------------------------------------------------------------*
 * MAIN SETTINGS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'main'
),

array(
"name" => "Favicon image URL",
"id" => $shortname."_favicon",
"type" => "upload",
"desc" => "Upload a favicon image - with .ico extention."
),

array(
"name" => "Featured Category",
"id" => $shortname."_featured_cat",
"type" => "select",
"options" => $pexeto_categories,
"desc" => "If you use the Featured Posts Template you can select the Featured category here."),

array(
"name" => "Widgetized Footer",
"id" => $shortname."_widgetized_footer",
"type" => "checkbox",
"std" => 'on'),

array(
"name" => "Display page title on pages",
"id" => $shortname."_show_page_title",
"type" => "checkbox",
"std" => 'on',
"desc" => 'If "ON" selected, the page title will be displayed in the beginning of the page content
as a main title. This option is available for the Default Page Template and Contact Page Template.'
),

array(
"name" => "Google Analytics Code",
"id" => $shortname."_analytics",
"type" => "textarea",
"desc" => "You can paste your generated Google Analytics here and it will be automatically set to the theme."
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * SIDEBARS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'sidebars'
),

array(
"name"=>"Add Sidebar",
"id"=>'sidebars',
"type"=>"custom",
"button_text"=>'Add Sidebar',
"fields"=>array(
	array('id'=>'_sidebar_name', 'type'=>'text', 'name'=>'Sidebar Name')
),
"desc"=>"You can add as many custom sidebars you like and after that for each page you will be
able to assign a different sidebar/"
),

array(
"type" => "close"),


/* ------------------------------------------------------------------------*
 * LIGHTBOX
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'lightbox'
),

array(
"name" => "Lightbox Theme",
"id" => $shortname."theme",
"type" => "select",
"options" => array(array('id'=>'light_rounded','name'=>'Light Rounded'), 
					array('id'=>'dark_rounded','name'=>'Dark Rounded'), 
					array('id'=>'pp_default','name'=>'Default'),
					array('id'=>'facebook','name'=>'Facebook'),
					array('id'=>'light_square','name'=>'Light Square'),
					array('id'=>'dark_square','name'=>'Dark Square')),

"std" => 'light_rounded',
"desc" => 'This is the global theme setting for the PrettyPhoto lightbox.'
),

array(
"name" => "Animation Speed",
"id" => $shortname."animation_speed",
"type" => "select",
"options" => array(array('id'=>'normal','name'=>'Normal'), 
					array('id'=>'fast','name'=>'Fast'), 
					array('id'=>'slow','name'=>'Slow')),
"std" => 'normal'
),

array(
"name" => "Overlay Gallery",
"id" => $shortname."overlay_gallery",
"type" => "checkbox",
"std" => 'off',
"desc" => 'If enabled, on lightbox galleries a small gallery of thumbnails will be displayed in the bottom of the preview image.'),

array(
"name" => "Resize image to fit window",
"id" => $shortname."allow_resize",
"type" => "checkbox",
"std" => 'on',
"desc" => 'If enabled, when the image is bigger than the window, it will be resized to fit it. Otherwise, the image will be displayed in its full size.'),

array(
"name" => "Twitter and Facebook buttons",
"id" => $shortname."enable_social_tools",
"type" => "checkbox",
"std" => 'off',
),

array(
"name" => "Autoplay slideshow",
"id" => $shortname."autoplay_slideshow",
"type" => "checkbox",
"std" => 'off',
),

array(
"type" => "close"),

array(
"type" => "close"));

$pexeto_options_manager->add_options($pexeto_general_options);