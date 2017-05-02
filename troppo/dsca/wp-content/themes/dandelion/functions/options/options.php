<?php 

/* ------------------------------------------------------------------------*
 * This file calls the main theme options functionality.
 * ------------------------------------------------------------------------*/


/**
 * Gets an array containing options settings and if there is an option for adding
 * multiple entities of one type, generates addional array elements for these entities.
 * For example: If there have been created 2 additional sliders, it will append
 * to option elements to this array for each slider.
 * @param $opt_array the array to be modified
 * @return an array containing the custom entity options
 */
function pexeto_add_custom_options($opt_array){
	global $pexeto_separator;	
	$new_pexeto_options=array();
	
	foreach($opt_array as $option){
		if($option['type']=='multiple_custom'){
			//insert the new custom options here
			
			$saved_values=get_option($option['refers']);
			$saved_array=explode($pexeto_separator, $saved_values);
			if(sizeof($saved_array)>1){
				array_pop($saved_array);
				foreach($saved_array as $custom_name){
					$id=convert_to_class($custom_name);
					$custom_option=array(
					"id"=>$id,
					"name"=>$option["name"].$custom_name,
					"button_text"=>$option["button_text"],
					"type"=>"custom",
					"preview"=>$id.$option["preview"]
					);
					
					//generate new fields with different unique IDs
					$fields=$option['fields'];
					for($i=0; $i<sizeof($fields);$i++){
						$fields[$i]['id']=$id.$fields[$i]['id'];
					}
					
					$custom_option['fields']=$fields;
					
					array_push($new_pexeto_options, $custom_option);
				}
			}
			
		}else{
			//this is just a normal option, just append it into the new array
			array_push($new_pexeto_options, $option);
		}
	}

	return $new_pexeto_options;
}

add_action('admin_head', 'admin_head_add');

/**
 * Add the Theme Options Page
 */
function mytheme_add_admin() {
	
	global $themename, $shortname, $options;
	
	$nonsavable_types=array('open', 'close','subtitle','title','documentation');

	//insert the default values if the fields are empty
	foreach ($options as $value) {
		if(isset($value['id']) && get_option($value['id'])=='' && isset($value['std']) && !in_array($value['type'], $nonsavable_types)){
			update_option( $value['id'], $value['std']);
		}
	}

	//save the field's values if the Save action is present
	if ( isset($_GET['page']) && $_GET['page'] == 'options' ) {
		if ( 'save' == $_REQUEST['action'] ) {
			//verify the nonce
			if ( empty($_POST) || !wp_verify_nonce($_POST['pexeto-theme-options'],'pexeto-theme-update-options') )
			{
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}else{
				if(get_option('pexeto_first_save')==''){
					update_option('pexeto_first_save', 'saved');
				}
				foreach ($options as $value) {
					if( isset( $_REQUEST[ $value['id'] ] ) && !in_array($value['type'], $nonsavable_types)) { 
							update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
						} elseif(!in_array($value['type'], $nonsavable_types)){ 
							delete_option( $value['id'] ); 
						} 
	
					if($value['type']=='custom'){
						foreach($value['fields'] as $field){
							update_option( $field['id'].'s', $_REQUEST[ $field['id'].'s' ] ); 
						}
					}
				}
				header("Location: themes.php?page=options&saved=true");
				die;
			}		
		} 
	}

	add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', 'options', 'pexeto_theme_admin');
}

require_once('pexeto_options_manager.php');
$pexeto_options_manager=new PexetoOptionsManager($themename, PEXETO_OPTIONS_URL, PEXETO_FUNCTIONS_URL, PEXETO_UPLOADS_URL, PEXETO_VERSION);

//get all the categories
$categories=get_categories('hide_empty=0');
$pexeto_categories=array();
for($i=0; $i<sizeof($categories); $i++){
	$pexeto_categories[]=array('id'=>$categories[$i]->cat_ID, 'name'=>$categories[$i]->cat_name);
}


//load the files that contain the options
$pexeto_options_files=array('general', 'pages', 'sliders', 'styles', 'translation', 'documentation');
foreach($pexeto_options_files as $file){
	require_once($file.'.php');
}


$options=$pexeto_options_manager->get_options();


/* ------------------------------------------------------------------------*
 * PRINT THE OPTIONS PAGE
 * ------------------------------------------------------------------------*/


function pexeto_theme_admin() {
	
	global $themename, $shortname, $options, $pexeto_options_manager;

	if ( $_REQUEST['saved'] ) {
		$pexeto_options_manager->print_saved_message();		
	}
	if ( $_REQUEST['reset'] ) {
		$pexeto_options_manager->print_reset_message();		
	}

	$pexeto_options_manager->print_heading(OPTIONS_HEADING);
	$pexeto_options_manager->print_options();
	$pexeto_options_manager->print_footer();
}

/**
 * Prints an option
 * @param $option the option's second part of the ID (after the theme's shortname part)
 */
function echo_option($option){
	echo(stripslashes(get_option(PEXETO_SHORTNAME.$option)));
}

/**
 * Gets an option
 * @param $option the option's second part of the ID (after the theme's shortname part)
 */
function get_opt($option){
	return stripslashes(get_option(PEXETO_SHORTNAME.$option));
}

?>