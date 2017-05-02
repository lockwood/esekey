<?php

/*-----------------------SHORTCODES-----------------------*/


/* ------------------------------------------------------------------------*
 * TYPOGRAPHY
 * ------------------------------------------------------------------------*/

function show_intro($atts, $content = null) {
	return '<div id="site-intro"><div id="site-intro-container"><span class="intro-swril swril-left"></span><span class="intro-text">'.do_shortcode($content).'</span><span class="intro-swril swril-right"></span></div></div>';
}
add_shortcode('intro', 'show_intro');


function show_highlight_one($atts, $content = null) {
	return '<span class="hihglight1">'.do_shortcode($content).'</span>';
}
add_shortcode('hg1', 'show_highlight_one');


function show_highlight_two($atts, $content = null) {
	return '<span class="hihglight2">'.do_shortcode($content).'</span>';
}
add_shortcode('hg2', 'show_highlight_two');


function show_list($atts, $content = null) {
	extract(shortcode_atts(array(
		"type" => 'check'
	), $atts));
	return '<div class="bullet_'.$type.'">'.do_shortcode($content).'</div>';
}
add_shortcode('list', 'show_list');


/* ------------------------------------------------------------------------*
 * ELEMENTS
 * ------------------------------------------------------------------------*/

function show_frame($atts, $content = null) {
	return '<div class="img-frame">'.do_shortcode($content).'</div>';
}
add_shortcode('frame', 'show_frame');


function show_frame_left($atts, $content = null) {
	return '<div class="img-frame alignleft">'.do_shortcode($content).'</div>';
}
add_shortcode('frame_left', 'show_frame_left');


function show_frame_right($atts, $content = null) {
	return '<div class="img-frame alignright">'.do_shortcode($content).'</div>';
}
add_shortcode('frame_right', 'show_frame_right');


function show_lightbox($atts, $content = null) {
	extract(shortcode_atts(array(
		"href" => 'http://',
		"desc"=>''
	), $atts));
	return '<div class="img-frame"><a rel="lightbox" href="'.$href.'" title="'.$desc.'" ><span>'.do_shortcode($content).'</span></a></div>';
}
add_shortcode('lightbox', 'show_lightbox');


function show_button($atts, $content = null) {
	extract(shortcode_atts(array(
		"href" => 'http://'
	), $atts));
	return '<a class="button" href="'.$href.'"><span>'.do_shortcode($content).'</span></a>';
}
add_shortcode('button', 'show_button');


function show_button_white($atts, $content = null) {
	extract(shortcode_atts(array(
		"href" => 'http://'
	), $atts));
	return '<a class="button-small" href="'.$href.'"><span>'.do_shortcode($content).'</span></a>';
}
add_shortcode('button_white', 'show_button_white');


function show_info($atts, $content = null) {
	return '<div class="info_box">'.do_shortcode($content).'</div>';
}
add_shortcode('info', 'show_info');


function show_note($atts, $content = null) {
	return '<div class="note_box">'.do_shortcode($content).'</div>';
}
add_shortcode('note', 'show_note');


function show_tip($atts, $content = null) {
	return '<div class="tip_box">'.do_shortcode($content).'</div>';
}
add_shortcode('tip', 'show_tip');


function show_error($atts, $content = null) {
	return '<div class="error_box">'.do_shortcode($content).'</div>';
}
add_shortcode('error', 'show_error');


function show_boxes($atts, $content = null) {
	return '<div class="columns-wrapper">'.do_shortcode($content).'</div>';
}
add_shortcode('boxes', 'show_boxes');


function show_box($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"href" => 'http://',
		"btntext" => 'Learn More',
		"price" =>''
	), $atts));
	return '<div class="pricing-box three-columns">
          <h4><span>'.$title.'</span></h4>'.do_shortcode($content).'<span class="price"> '.$price.'</span><a href="'.$href.'" class="button"><span>'.$btntext.'</span></a> </div>';
}
add_shortcode('box', 'show_box');

/* ------------------------------------------------------------------------*
 * TABS
 * ------------------------------------------------------------------------*/

function show_tabs($atts, $content = null) {
	extract(shortcode_atts(array(
		"titles" => '',
	), $atts));
	$titlearr=explode(',',$titles);
	$html='<div class="tabs-container"><ul class="tabs ">';
	foreach($titlearr as $title){
		$html.='<li class="w3"><a href="#">'.$title.'</a></li>';
	}
	$html.='</ul><div class="panes">'.do_shortcode($content).'</div></div>';
	return $html;
}
add_shortcode('tabs', 'show_tabs');


function show_pane($atts, $content = null) {
	return '<div>'.do_shortcode($content).'</div>';
}
add_shortcode('pane', 'show_pane');


function show_accordion($atts, $content = null) {
	return '<div class="accordion-container"><div id="accordion">'.do_shortcode($content).'</div></div>';
}
add_shortcode('accordion', 'show_accordion');


function show_apane($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	return '<h2>'.$title.'</h2><div class="pane">'.do_shortcode($content).'</div>';
}
add_shortcode('apane', 'show_apane');


function show_testimonials($atts, $content = null) {
	return '<div class="testimonial-container"><div id="testimonials">'.do_shortcode($content).'</div></div>';
}
add_shortcode('testimonials', 'show_testimonials');


function show_testim($atts, $content = null) {
	extract(shortcode_atts(array(
		"author" => '',
		"img" =>''
	), $atts));
	return '<img src="'.$img.'" alt="" class="img-frame" /><div class="testim-pane"><h3>'.$author.'</h3><p>'.do_shortcode($content).'</p></div>';
}
add_shortcode('testim', 'show_testim');

/* ------------------------------------------------------------------------*
 * COLUMNS
 * ------------------------------------------------------------------------*/

function show_columns($atts, $content = null) {
	return '<div class="columns-wrapper">'.do_shortcode($content).'</div>';
}
add_shortcode('columns', 'show_columns');


function show_two_column($atts, $content = null) {
	return '<div class="two-columns">'.do_shortcode($content).'</div>';
}
add_shortcode('two_column', 'show_two_column');


function show_three_column($atts, $content = null) {
	return '<div class="three-columns">'.do_shortcode($content).'</div>';
}
add_shortcode('three_column', 'show_three_column');


function show_four_column($atts, $content = null) {
	return '<div class="four-columns">'.do_shortcode($content).'</div>';
}
add_shortcode('four_column', 'show_four_column');


function show_big_letter($atts, $content = null) {
	return '<span class="drop-caps">'.$content.'</span>';
}
add_shortcode('bl', 'show_big_letter');


function show_heading($atts, $content = null) {
	return '<h1 class="page-heading">'.$content.'</h1><hr/>';
}
add_shortcode('heading', 'show_heading');


/* ------------------------------------------------------------------------*
 * ADD CUSTOM FORMATTING BUTTONS
 * ------------------------------------------------------------------------*/

$pexeto_buttons=array("pexetointro", "pexetohighlight1", "pexetohighlight2", "pexetodropcaps", "|", "pexetolistcheck", 
"pexetolistarrow", "pexetolistarrow2", "pexetolistarrow4", "pexetoliststar", "pexetolistplus", "|", "pexetolinebreak", 
"pexetoframe", "pexetolightbox", "|", "pexetobutton", "pexetoinfoboxes", "|", "pexetotwocolumns", "pexetothreecolumns", "pexetofourcolumns");

function add_pexeto_buttons() {
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_pexeto_btn_tinymce_plugin');
     add_filter('mce_buttons_3', 'register_pexeto_buttons');
   }
}

add_action('init', 'add_pexeto_buttons');


/**
 * Register the buttons
 * @param $buttons
 */
function register_pexeto_buttons($buttons) {
   global $pexeto_buttons;

   array_push($buttons, implode(',',$pexeto_buttons));
   return $buttons;
}

/**
 * Add the buttons
 * @param $plugin_array
 */
function add_pexeto_btn_tinymce_plugin($plugin_array) {
   global $pexeto_buttons;
   foreach($pexeto_buttons as $btn){
  	  $plugin_array[$btn] = PEXETO_FUNCTIONS_URL.'formatting-buttons/editor-plugin.js';
   }
   return $plugin_array;
}
