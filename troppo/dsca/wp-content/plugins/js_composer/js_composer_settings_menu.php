<?php
// don't load directly
if ( !defined('ABSPATH') ) die('-1');

$excluded = array('attachment', 'revision', 'nav_menu_item', 'mediapage');
$post_types = get_post_types(array('public'   => true));

// if this fails, check_admin_referer() will automatically print a "failed" page and die.
if ( !empty($_POST) && check_admin_referer('wpb_js_settings_save_action', 'wpb_js_nonce_field') ) {
		
	// process form data
	$pt_arr = array();
	foreach ($_POST as $pt) {
		if (!in_array($pt, $excluded) && in_array($pt, $post_types)) {
			$pt_array[] = $pt;
		}
	}
	
	if (count($pt_array) > 0) {
		update_option('wpb_js_content_types', $pt_array);
	} else {
		delete_option('wpb_js_content_types');
	}
	
	if (isset($_POST['grid_w'])) { // && is_numeric($_POST['grid_w'])
		update_option('wpb_js_grid_w', $_POST['grid_w']);
	} else {
		delete_option('wpb_js_grid_w');
	}
	
	if (isset($_POST['grid_g'])) { // && is_numeric($_POST['grid_g'])
		update_option('wpb_js_grid_g', $_POST['grid_g']);
	} else {
		delete_option('wpb_js_grid_g');
	}
	
	if (isset($_POST['grid_p'])) {
		update_option('wpb_js_grid_p', $_POST['grid_p']);
	} else {
		delete_option('wpb_js_grid_p');
	}
}


if (current_user_can('switch_themes')) : ?>
	<div id="custom-background" class="wrap">
		<div class="icon32" id="icon-themes"><br></div>
		
		<h2><?php _e("Visual Composer Settings", "js_composer"); ?></h2>
		
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php _e("Content types", "js_composer"); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span><?php _e("Post types", "js_composer"); ?></span></legend>
								<?php
								$pt_array = ($pt_array = get_option('wpb_js_content_types')) ? $pt_array : array();
								foreach ($post_types as $pt) {
									if (!in_array($pt, $excluded)) {
										$checked = (in_array($pt, $pt_array)) ? ' checked="checked"' : '';
									?>
										<label for="use_smilies">
											<input type="checkbox"<?php echo $checked; ?> value="<?php echo $pt; ?>" id="check_<?php echo $pt; ?>" name="post_type_<?php echo $pt; ?>">
												<?php echo $pt; ?>
										</label><br>
									<?php }
								}
								?>
							</fieldset>
						</td>
					</tr>
					
					<tr valign="top">
						<th>&nbsp;</th>
						<td>
							<p class="description indicator-hint"><?php _e("Select for which content types Visual Composer should be available during post creation/editing.", "js_composer"); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
<?php if (WPB_IS_PLUGIN) : ?>
			<h2><?php _e("Custom Grid", "js_composer"); ?></h2>
			<?php
			
			$grid_widths = get_option('wpb_js_grid_w');
			$grid_gaps = get_option('wpb_js_grid_g');
			$grid_prefixs = get_option('wpb_js_grid_p');
			
			$max_ar = max($grid_widths, $grid_gaps, $grid_prefixs);
			$layout_total = ($max_ar != false) ? count($max_ar) : 0;
			$layout_total++;
			
			for ( $i = 0; $i < $layout_total; $i++ ) :
				$layout_w = ($grid_widths[$i]) ? $grid_widths[$i] : '';
				$layout_g = ($grid_gaps[$i]) ? $grid_gaps[$i] : '';
				$layout_p = ($grid_prefixs[$i]) ? $grid_prefixs[$i] : '';
			
				if ( ($layout_w != '' || $layout_g != '' || $layout_p != '') || $i == $layout_total-1 ) :
			?>
			<table class="form-table">
				<tbody>				
				<tr id="password">
					<th><label><?php _e("Grid details", "js_composer"); ?></label></th>
					<td>
						<input type="text" value="<?php echo $layout_w; ?>" size="16" id="grid_w_<?php echo $i; ?>" name="grid_w[]"> <span class="description"><?php _e("Container width", "js_composer"); ?></span><br/>
						<input type="text" value="<?php echo $layout_g; ?>" size="16" id="grid_g_<?php echo $i; ?>" name="grid_g[]"> <span class="description"><?php _e("Gap between columns", "js_composer"); ?></span><br/>
						<input type="text" value="<?php echo $layout_p; ?>" size="16" id="grid_p_<?php echo $i; ?>" name="grid_p[]"> <span class="description"><?php _e("CSS rule prefix. Example (.class-name or #id)", "js_composer"); ?></span><br/>
					</td>
				</tr>
				</tbody>
			</table>
			<?php
				endif;
			endfor;
			?>
			<p class="description indicator-hint"><?php _e("If you will leave Custom grid settings empty, then percent based values will be used instead.", "js_composer"); ?></p>
			<p class="description indicator-hint"><?php _e("Hint: Grid width should be a number in pixels, this is contents inner width value. CSS prefix is useful if you want to generate multiple grids. Eg. one for fullwidth page, one for page with column.", "js_composer"); ?></p>
			
<?php endif; ?>
			<?php wp_nonce_field('wpb_js_settings_save_action', 'wpb_js_nonce_field'); ?>
			<p class="submit">
				<input type="submit" value="Save Changes" class="button-primary" id="save-background-options" name="save-background-options">
			</p>
		</form>
		
		<div>
			<h2><?php _e("Thank you", "js_composer"); ?></h2>
			<p><?php _e("Visual Composer will save you a lot of time while working with your sites content.", "js_composer"); ?></p>
			<p><?php _e('If you have comments or simply want to say "Hi", please check <a href="http://wpbakery.com/vc/" title="" target="_blank">plugins homepage</a>.', "js_composer"); ?></p>
		</div>
		
	</div>
<?php endif; ?>
<?php ?>