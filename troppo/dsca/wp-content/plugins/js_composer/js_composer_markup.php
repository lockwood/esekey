<?php

/* This generates html code for layout elements. It is called
   via AJAX from visual composer:
   
   1) When user click on the menu item with 'clickable_action'
   class name or when user drops element from the menu to the
   column.
   
   2) When user click on edit icon
   
---------------------------------------------------------- */

/* Fire up WordPress stuff */
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );


$pid = (isset($_POST['pid'])) ? $_POST['pid'] : 'none';
$action = (isset($_POST['action'])) ? $_POST['action'] : 'markup';

//$element_class = (isset($_POST['element'])) ? explode(" ", $_POST['element']) : '';
$element_id = (isset($_POST['element'])) ? $_POST['element'] : '';
$column_index = (isset($_POST['column_index'])) ? $_POST['column_index'] : '';
$new_params = (isset($_POST['new_params'])) ? $_POST['new_params'] : '';
$output = '';

if ($action == 'markup') {
	$output = wpb_getElementMarkup($element_id);
}
else if ($action == 'widget_edit') {
	$output = wpb_getElementEditMarkup($element_id);
}
else if ($action == 'new_param_holders') {
	$output = returnNewParamHolders($element_id, $new_params);
}
else if ($action == 'get_html') {
	$tiny_param = array(
		'param_name' => (isset($_POST['param_name'])) ? $_POST['param_name'] : '',
		'type' => (isset($_POST['param_type'])) ? $_POST['param_type'] : 'textarea_html',
		'default_content' => (isset($_POST['default_content'])) ? $_POST['default_content'] : ''
	);
	
	if ( $tiny_param['type'] == 'textarea_html') {
		$output = getTinyHtmlTextArea($tiny_param);
	}
}
/* Output generated html back to the visual composer. */
echo $output;

/* Get initial markup
---------------------------------------------------------- */
function wpb_getElementMarkup($id) {
	global $wpb_sc, $column_index;
	$output = '';
	
	$column_controls = getColumnControls('size_delete');
	if ($id == 'column_12') {
		$output .= '<div id="column_12-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-half">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/2", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_12-12') {
		$output .= '<div id="column_12-12-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-half">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/2", $column_controls) .'</div>';
		$output .= '<div id="column_12-12-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-half">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/2", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_13') {
		$output .= '<div id="column_13-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/3", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_13-13-13') {
		$output .= '<div id="column_13-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/3", $column_controls) .'</div>';
		$output .= '<div id="column_13-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/3", $column_controls) .'</div>';
		$output .= '<div id="column_13-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/3", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_13-23') {
		$output .= '<div id="column_13-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/3", $column_controls) .'</div>';
		$output .= '<div id="column_23-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column two-third">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "2/3", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_14') {
		$output .= '<div id="column_14-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-fourth">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/4", $column_controls) .'</div>';
		return $output;
	}
	else if ($id == 'column_14-14-14-14') {
		$output .= '<div id="column_14-'.$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-fourth">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/4", $column_controls) .'</div>';
		$output .= '<div id="column_14-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-fourth">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/4", $column_controls) .'</div>';
		$output .= '<div id="column_14-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-fourth">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/4", $column_controls) .'</div>';
		$output .= '<div id="column_14-'.++$column_index.'" class="wpb_vc_column wpb_sortable wpb_droppable column one-fourth">';
		$output .= '<input type="hidden" class="wpb_vc_sc_base" name="" value="vc_column" />';
		$output .= str_replace("%column_size%", "1/4", $column_controls) .'</div>';
		return $output;
	}
	
	$column_controls = getColumnControls($wpb_sc[$id]['controls']);
	
	//'.$wpb_sc[$id]["width"].'
	$output .= '<div id="element-'.$id.'-'.$column_index.'" class="wpb_'.$wpb_sc[$id]["base"].' wpb_sortable column full-width '.$wpb_sc[$id]["class"].'">';
	$output .= '<input type="hidden" class="wpb_vc_sc_base" name="element_name-'.$id.'" value="'.$wpb_sc[$id]["base"].'" />';
	$output .= str_replace("%column_size%", "1/1", $column_controls);
	$output .= getCallbacks($id);
	$output .= getParamHolders($id);
	$output .= '</div>';
	
	return $output;
}

/* This returs block controls
---------------------------------------------------------- */
function getColumnControls($controls) {
	$controls_start = '<div class="controls">';
	$controls_end = '</div>';
	
	$controls_column_size = ' <a class="column_decrease" href="#" title=""></a> <span class="column_size">%column_size%</span> <a class="column_increase" href="#" title=""></a>';
	
	$controls_edit = ' <a class="column_edit" href="#" title=""></a>';
	$controls_popup = ' <a class="column_popup" href="#" title=""></a>';
	$controls_delete = ' <a class="column_delete" href="#" title=""></a>';
	$delete_edit_row = '<a class="row_delete" title="'.__('Delete %element%', "js_composer").'">'.__('Delete %element%', "js_composer").'</a>';
	
	$column_controls_full = $controls_start . $controls_column_size . $controls_popup . $controls_edit . $controls_delete . $controls_end;
	$column_controls_size_delete = $controls_start . $controls_column_size . $controls_delete . $controls_end;
	$column_controls_popup_delete = $controls_start . $controls_popup . $controls_delete . $controls_end;
	$column_controls_delete = $controls_start . $controls_delete . $controls_end;
	$column_controls_edit_popup_delete = $controls_start . $controls_popup . $controls_edit . $controls_delete . $controls_end;
	
	if ($controls == 'popup_delete') {
		return $column_controls_popup_delete;
	}
	else if ($controls == 'edit_popup_delete') {
		return $column_controls_edit_popup_delete;
	}
	else if ($controls == 'size_delete') {
		return $column_controls_size_delete;
	}
	else if ($controls == 'popup_delete') {
		return $column_controls_popup_delete;
	}
	else {
		return $column_controls_full;
	}
}

/* This will fire callbacks if they are defined in map.php
---------------------------------------------------------- */
function getCallbacks($id) {
	global $wpb_sc;
	$output = '';
	
	if (isset($wpb_sc[$id]['js_callback'])) {
		foreach ($wpb_sc[$id]['js_callback'] as $text_val => $val) {
			$output .= '<input type="hidden" class="wpb_vc_callback wpb_vc_'.$text_val.'_callback " name="'.$param['param_name'].'" value="'.$val.'" />';
		}
	}
	
	return $output;
}

/* Wrapper for param holders
---------------------------------------------------------- */
function getParamHolders($id) {
	global $wpb_sc;
	$output = '';
	
	if (isset($wpb_sc[$id]['params'])) {
		foreach ($wpb_sc[$id]['params'] as $param) {
			$output .= singleParamHtmlHolder($param);
		}
	}
	return $output;
}

/* Holder
---------------------------------------------------------- */
function singleParamHtmlHolder($param) {
	$output = '';
	$value = (is_string($param['value'])) ? $param['value'] : '';
	if ($param['holder'] == 'hidden' || isset($param['holder']) == false) {
		$output .= '<input type="hidden" class="wpb_vc_param_value '.$param['param_name'].' '.$param['type'].' '.$param['class'].'" name="'.$param['param_name'].'" value="'.$value.'" />';
	}
	else {
		$output .= '<'.$param['holder'].' class="wpb_vc_param_value '.$param['param_name'].' '.$param['type'].' '.$param['class'].'" name="'.$param['param_name'].'">'.$value.'</'.$param['holder'].'>';
	}
	return $output;
}

/* Markup when you click on edit button
---------------------------------------------------------- */
function wpb_getElementEditMarkup($id) {
	global $wpb_sc;
	$output = '';
	$id = explode("-", $id); //element
	$id = $id[1];
	
	////////////////////////////////////////////////////////////////
	$title_html  = '<h2 class="edit_title">%title%</h2>';
	$title_html .= '<div class="edit_form">';
	$edit_form_end = '</div>';
	$edit_form_end .= '<div class="edit_form_actions">';
	$edit_form_end .= '<a class="wpb_save_edit_form button-primary" href="#">'. __('Save') .'</a>';
	$edit_form_end .= '</div>';
	////////////////////////////////////////////////////////////////
	
	$title_html = str_replace("%title%", $wpb_sc[$id]['name'], $title_html);
	
	$output .= getElementEditLines($id);
	
	$output = $title_html . $output . $edit_form_end;
	return $output;
}

function getElementEditLines($id) {
	global $wpb_sc;
	$output = '';
	
	//$upload_media_btns = '<div class="wpb_media-buttons hide-if-no-js"> '.__('Upload/Insert').' <a title="'.__('Add an Image').'" class="wpb_insert-image" href="#"><img alt="'.__('Add an Image').'" src="'.home_url().'/wp-admin/images/media-button-image.gif"></a> <a class="wpb_switch-editors" title="'.__('Switch Editors').'" href="#">HTML mode</a></div>';
	if (isset($wpb_sc[$id]['params'])) {
		foreach ($wpb_sc[$id]['params'] as $param) {
			$param_line = '';
			if ($param['type'] == 'textfield') {
				$value = ($param['value'] != '' && isset($param['value'])) ? $param['value'] : '';
				$param_line .= '<label for="'.$param['param_name'].'">'.$param['heading'].'</label>';
				$param_line .= '<input name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$param['param_name'].' '.$param['type'].'" type="text" value="'.$value.'" />';
			}
			else if ($param['type'] == 'dropdown') {
				$param_line .= '<label for="'.$param['param_name'].'">'.$param['heading'].'</label>';
				$param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';
				foreach ($param['value'] as $text_val => $val) {
					if ( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
						$text_val = $val;
					}
					$val = strtolower(str_replace(array(" "), array("_"), $val));
					$param_line .= '<option class="'.$val.'" value="'.$val.'">'.$text_val.'</option>';
				}
				$param_line .= '</select>';
			}
			else if ($param['type'] == 'textarea_html') {
				$param_line .= '<label for="'.$param['param_name'].'">'. __('Message text', "js_composer") .'</label>';
				
				$param_line .= getTinyHtmlTextArea($param);
			}
			else if ($param['type'] == 'posttypes') {
				$param_line .= '<label class="wpb_vc_param_value wpb-checkboxes" for="'.$param['param_name'].'">'.$param['heading'].'</label>';
				$args = array(
					'public'   => true
				);
				$post_types = get_post_types($args);
				foreach ($post_types as $post_type ) {
					if ( $post_type != 'attachment' ) {
						$param_line .= '<input id="'. $post_type .'" class="'.$param['param_name'].' '.$param['type'].'" type="checkbox" name="'.$param['param_name'].'"> ' . $post_type;
					}
				}
			}
			else if ($param['type'] == 'exploded_textarea') {
				$param_line .= '<label for="'.$param['param_name'].'">'. $param['heading'] .'</label>';
				$param_line .= '<textarea name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-textarea '.$param['param_name'].' '.$param['type'].'"></textarea>';
			}
			else if ($param['type'] == 'textarea') {
				$param_line .= '<label for="'.$param['param_name'].'">'. $param['heading'] .'</label>';
				$param_line .= '<textarea name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-textarea '.$param['param_name'].' '.$param['type'].'"></textarea>';
			}
			else if ($param['type'] == 'attach_images') {
				$param_line .= '<label for="'.$param['param_name'].'">'. $param['heading'] .'</label>';
				$param_line .= '<input type="hidden" class="wpb_vc_param_value gallery_widget_attached_images_ids '.$param['param_name'].' '.$param['type'].'" name="'.$param['param_name'].'" value="" />';
				$param_line .= '<a class="button gallery_widget_add_images" href="#" title="'.__('Add images', "js_composer").'">'.__('Add images', "js_composer").'</a>';
				$param_line .= '<div class="gallery_widget_attached_images">';
					$param_line .= '<ul class="gallery_widget_attached_images_list"></ul>';
				$param_line .= '</div>';
				$param_line .= '<div class="gallery_widget_site_images">';
					$param_line .= siteAttachedImages();
				$param_line .= '</div>';
				$param_line .= '<div class="wpb_clear"></div>';
			}
			else if ($param['type'] == 'widgetised_sidebars') {
				$wpb_sidebar_ids = Array();
				$sidebars = $GLOBALS['wp_registered_sidebars'];
				
				$param_line .= '<label for="'.$param['param_name'].'">'.$param['heading'].'</label>';
				$param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';
				foreach ($sidebars as $sidebar) {
					$param_line .= '<option value="'.$sidebar["id"].'">'.$sidebar["name"].'</option>';
				}
				$param_line .= '</select>';
			}
			
			if ($param['description'] != '' && isset($param['description'])) { $param_line .= '<span class="description">'.$param['description'].'</span>'; }
			
			$output .= '<div class="edit_form_line">' . $param_line . '</div>';
		}
	}
		
	return $output;
}

function getTinyHtmlTextArea($param = array()) {
	$param_line = '';
	$upload_media_btns = '<div class="wpb_media-buttons hide-if-no-js"> '.__('Upload/Insert').' <a title="'.__('Add an Image').'" class="wpb_insert-image" href="#"><img alt="'.__('Add an Image').'" src="'.home_url().'/wp-admin/images/media-button-image.gif"></a> <a class="wpb_switch-editors" title="'.__('Switch Editors').'" href="#">HTML mode</a></div>';
	if ( function_exists('wp_editor') ) {
		//$default_content = ($param['default_content'] != '') ?  $param['default_content'] : '';
		$default_content = '';
		// WP 3.3+
		ob_start();
		wp_editor($default_content, 'wpb_tinymce_'.$param['param_name'], array('editor_class' => 'wpb_vc_param_value wpb-textarea visual_composer_tinymce '.$param['param_name'].' '.$param['type']) );
		$output_value = ob_get_contents();
		ob_end_clean();
		$param_line .= $output_value;
	} else {
		//WP older then 3.3
		$param_line .= $upload_media_btns;
		$param_line .= '<textarea name="'.$param['param_name'].'" class="wpb_tinymce_'.$param['param_name'].' wpb_vc_param_value wpb-textarea visual_composer_tinymce '.$param['param_name'].' '.$param['type'].'"></textarea>';
	}
	return $param_line;
}

/* Sometimes you decide to add new params to the existing
   shortcodes. In that case visual composer html canvas
   is already built and stored in the posts custom field.
   As a workaround we add those new param holders via AJAX.
---------------------------------------------------------- */
function returnNewParamHolders($id, $new_params) {
	global $wpb_sc;
	if ($new_params) {
		$output = '';
		$id = explode("-", $id);
		$id = $id[1];
		
		$new_params = explode(",", $new_params);
		
		if (count($new_params) > 0) {
			if (isset($wpb_sc[$id]['params'])) {
				foreach ($wpb_sc[$id]['params'] as $param) {
					if (in_array($param['param_name'], $new_params)) {
						$output .= singleParamHtmlHolder($param);
					}
				}
			}
		}
			
		return $output;
	}
}
?>