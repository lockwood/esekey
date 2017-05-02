jQuery(document).ready(function($){
	/* Insert visual composer switch button */
	if ($("#wpb_visual_composer").length == 1) {
		$('div#titlediv').after('<p class="composer-switch"><a class="wpb_switch-to-composer button-primary" href="#">Visual Composer</a></p>');
		
		$('#visual_composer_content a').click(function(e) {
			e.preventDefault();
		});
		
		
		var postdivrich = $('#postdivrich'),
			visualcomposer = $('#wpb_visual_composer');
			
		$('.wpb_switch-to-composer').click(function(e){
			e.preventDefault();
			if (postdivrich.is(":visible")) {
				
				//if (jQuery("#edButtonHTML").hasClass('active')) {content-html
				/*if (jQuery("#wp-content-wrap").hasClass('html-active')) {
					switchEditors.go('content', 'tinymce');
				}*/
				switchDefaultEditorToVisualMode();
				var content_empty = true;
				
				if ( tinyMCE.get('content').getContent() != '') {
					content_empty = false;
					var answer = confirm ("Default WordPress editor has some content, switching to Visual Composer will remove it. Press OK to proceed, Cancel to leave.");
					if (answer) {
						content_empty = true;
					}
				}
				//
				if ( content_empty ) {
					
					postdivrich.hide();
					visualcomposer.show();
					$('#wpb_vc_js_status').val("true");
					$(this).html('Classic editor');
				}
			}
			else {
				postdivrich.show();
				visualcomposer.hide();
				$('#wpb_vc_js_status').val("false");
				$(this).html('Visual Composer');
			}
		});
		
		
		/* Decide what editor to show on load
		---------------------------------------------------------- */
		if ($('#wpb_vc_js_status').val() == 'true') {
			switchDefaultEditorToVisualMode();
			//
			postdivrich.hide();
			visualcomposer.show();
			$('.wpb_switch-to-composer').html('Classic editor');
		} else {
			postdivrich.show();
			visualcomposer.hide();
			$('.wpb_switch-to-composer').html('Visual Composer');
		}
		
		/* On load initialize sortable and dragable elements
		---------------------------------------------------------- */
		$('.wpb_main_sortable').sortable({
			forcePlaceholderSize: true,
			placeholder: "widgets-placeholder",
			cursorAt: { left: 10, top : 20 },
			cursor: "move",
			items: "div.sortable_1st_level",//wpb_sortable
			update: function() { save_composer_html(); }
		});
		
		$( "#wpb_visual_composer .dropable_el" ).draggable({
			helper: onDragPlaceholder,
			revert: "invalid",
			zIndex: 50,
			cursorAt: { left: 10, top : 20 },
			cursor: "move",
			appendTo: "body",
			start: function(event, ui) { renderCorrectPlaceholder(event, ui);  }
		});
		
		
		initDroppable(); /* Make menu elements dropable */
		columnControls(); /* Set action for column sizes and delete buttons */
		
		initTabs(); /* Init tabs */
	
		/* Add action for menu buttons with 'clickable_action' class name */
		$("#wpb_visual_composer-elements .clickable_action").click(function(e) {
			e.preventDefault();
			getElementMarkup($('.main_wrapper'), $(this), "initDroppable");
		});
		
		/* Save current template */
		$("#save_current_template").click(function(e) {
			e.preventDefault();
			saveCurrentTemplate();
		});
		
		/* Elements drop down menu */
		$("#wpb_visual_composer li.menu-top").hover(
			function () {
				//mouse hover
				var menu_el = $(this);
				if (menu_el.children('.wp-submenu').length == 1) {
					menu_el.children('.wp-submenu').addClass('sub-open');
				}
			}, 
			function () {
				//mouse out
				var menu_el = $(this);
				if (menu_el.children('.wp-submenu').length == 1) {
					menu_el.children('.wp-submenu').removeClass('sub-open');
				}
			}
		);
		/** Position Elements menu */
		$(window).bind('scroll resize', function() {
			var scrollpos = $("body").scrollTop(),
				vc_tools = $("#wpb_visual_composer").parent(),
				offset = vc_tools.offset(),
				vc_height = $("#wpb_visual_composer").outerHeight() + offset.top - $('#wpb_visual_composer-elements').outerHeight() - 20;
			if (scrollpos == 0) { scrollpos = $("html").scrollTop(); }
			if (scrollpos > offset.top + 25 && scrollpos < vc_height) {
				$('#wpb_visual_composer-elements').css({
					"position" : "fixed",
					"top" : 10
				});
			} else {
				$('#wpb_visual_composer-elements').css({
					"position" : "absolute",
					"top" : "auto"
				});
			}
		});
		
		
		/*** Insert image button in tinyMce editor ***/
		$(".wpb_media-buttons a.wpb_insert-image").live("click", function(e) {
			e.preventDefault();
			
			var post_ID;
	        	post_ID = $('#post_ID').val();
	        
	        var active_editor = jQuery(this).parent().parent().find('textarea.visual_composer_tinymce').attr('id');
	        jQuery.each(tinymce.editors, function(index, value) {
				if (tinymce.editors[index]['editorId'] == active_editor) {
					tinymce.activeEditor = tinymce.editors[index];
				}
	        });
	        
		
			wpb_title = "Add an Image";
			tb_show(wpb_title, 'media-upload.php?post_id='+post_ID+'&amp;type=image&amp;TB_iframe=1');
			
			// placed right after tb_show call
			$("#TB_window,#TB_overlay,#TB_HideSelect").one("unload", killTheDamnUnloadEvent);
				function killTheDamnUnloadEvent(e) {
				    // you
				    e.stopPropagation();
				    // must
				    e.stopImmediatePropagation();
				    // DIE!
				    return false;
				}
		});
		
		/*** Switch between Visual/HTML modes in tinyMCE editors */
		$(".wpb_media-buttons a.wpb_switch-editors").live("click", function(e) {
			e.preventDefault();
			var mce_id = jQuery(this).parent().parent().find('textarea.visual_composer_tinymce').attr('id');
			
			if ($(this).text() == "HTML mode") {
				$(this).text("Visual mode");
				/* remove tinymce */
				tinyMCE.execCommand('mceRemoveControl', false, mce_id);
			}
			else {
				$(this).text("HTML mode");
				var val = $("#visual_composer_edit_form textarea.visual_composer_tinymce").val();			
				val = switchEditors.wpautop(val);
				$("#visual_composer_edit_form textarea.visual_composer_tinymce").val(val);
				/* add tinymce */
				tinyMCE.execCommand('mceAddControl', false, mce_id);
			}
		});
		
		
		/*** Toggle click (FAQ) ***/
		$(".toggle_title").live("click", function(e) {
			if ($(this).hasClass('toggle_title_active')) {
				$(this).removeClass('toggle_title_active').next().hide();
			} else {
				$(this).addClass('toggle_title_active').next().show();
			}
			
		});
	}
	
	galleryImagesControls(); /* Actions for gallery images handling */
	$('.gallery_widget_attached_images_list').each(function(index) {
		attachedImgSortable($(this));
	});
	/*25.10
	var gwail = $('.gallery_widget_attached_images_list');
	if (gwail.length > 0) {
		attachedImgSortable(gwail);
	}*/			
}); // end jQuery(document).ready

function switchDefaultEditorToVisualMode() {
	if (jQuery("#wp-content-wrap").hasClass('html-active')) {
		switchEditors.go('content', 'tinymce');
	}
}




/* Set action for column size and delete buttons
---------------------------------------------------------- */
function columnControls() {
	jQuery(".column_delete").live("click", function(e) {
		e.preventDefault();
		var answer = confirm ("Press OK to delete section, Cancel to leave");
		if (answer) {
			jQuery(this).closest(".column").remove();
			save_composer_html();
		}
	});
	
	jQuery(".column .column .column_popup").live("click", function(e) {
		e.preventDefault();
		var answer = confirm ("Press OK to pop (move) section to the top level, Cancel to leave");
		if (answer) {
			jQuery(this).closest(".column").insertBefore('.wpb_main_sortable div.wpb_clear:last');
			initDroppable();
			save_composer_html();
		}
	});
	
	jQuery(".column_edit").live("click", function(e) {
		e.preventDefault();
		var element = jQuery(this).closest('.column');
		showEditForm(element);
	});
	
	
	jQuery(".column_increase").live("click", function(e) {
		e.preventDefault();
		var column = jQuery(this).closest(".column"),
			sizes = getColumnSize(column);
		if (sizes[1]) {
			column.removeClass(sizes[0]).addClass(sizes[1]);
			/* get updated column size */
			sizes = getColumnSize(column);
			jQuery(column).find(".column_size:first").html(sizes[3]);
			save_composer_html();
		}
	});
	
	jQuery(".column_decrease").live("click", function(e) {
		e.preventDefault();
		var column = jQuery(this).closest(".column"),
			sizes = getColumnSize(column);
		if (sizes[2]) {
			column.removeClass(sizes[0]).addClass(sizes[2]);
			/* get updated column size */
			sizes = getColumnSize(column);
			jQuery(column).find(".column_size:first").html(sizes[3]);
			save_composer_html();
		}
	});
} // end columnControls()

function galleryImagesControls() {
	jQuery('.gallery_widget_add_images').live("click", function(e) {
		e.preventDefault();
		var attached_img_div = jQuery(this).next(),
			site_img_div	 = jQuery(this).next().next();
			
		if (attached_img_div.css('display') == 'block') {
			jQuery(this).addClass('button-primary').text('Finish Adding Images');
			//
			attached_img_div.hide();
			site_img_div.show();
			
			hideEditFormSaveButton();
		}
		else {
			jQuery(this).removeClass('button-primary').text('Add Images');
			//
			attached_img_div.show();
			site_img_div.hide();
			
			cloneSelectedImages(site_img_div, attached_img_div);
			
			showEditFormSaveButton();
		}
	});
	
	jQuery('.gallery_widget_img_select li').live("click", function(e) {
		jQuery(this).toggleClass('added');
		
		var hidden_ids = jQuery(this).parent().parent().prev().prev().prev(),
			ids_array = (hidden_ids.val().length > 0) ? hidden_ids.val().split(",") : new Array(),
			img_rel = jQuery(this).find("img").attr("rel"),
			id_pos = jQuery.inArray(img_rel, ids_array);
		
		/* if not found */
		if (id_pos == -1) {
			ids_array.push(img_rel);
		}
		else {
			ids_array.splice(id_pos, 1);
		}
		
		hidden_ids.val(ids_array.join(","));
		
	});
}

function hideEditFormSaveButton() {
	jQuery('#visual_composer_edit_form .edit_form_actions').hide();
}
function showEditFormSaveButton() {
	jQuery('#visual_composer_edit_form .edit_form_actions').show();
}

/* Updates ids order in hidden input field, on drag-n-drop reorder */
function updateSelectedImagesOrderIds(img_ul) {
	var img_ids = new Array();
	
	jQuery(img_ul).find('.added img').each(function() {
		img_ids.push(jQuery(this).attr("rel"));
	});
	
	jQuery(img_ul).parent().prev().prev().val(img_ids.join(','));
}

/* Takes ids from hidden field and clone li's */
function cloneSelectedImages(site_img_div, attached_img_div) {
	var hidden_ids = jQuery(attached_img_div).prev().prev(),
		ids_array = (hidden_ids.val().length > 0) ? hidden_ids.val().split(",") : new Array(),
		img_ul = attached_img_div.find('.gallery_widget_attached_images_list');
	
	img_ul.html('');
	
	jQuery.each(ids_array, function(index, value) {
		jQuery(site_img_div).find('img[rel='+value+']').parent().clone().appendTo(img_ul);
	});
	attachedImgSortable(img_ul);
}

function attachedImgSortable(img_ul) {
	jQuery(img_ul).sortable({
		forcePlaceholderSize: true,
		placeholder: "widgets-placeholder",
		cursor: "move",
		items: "li",
		update: function() { updateSelectedImagesOrderIds(img_ul); }
	});
}

/* on edit initializing highlights selected images, takes ids from hidden input field */
function highlightSelectedImages(ids) {
	var img_ids = ids.val().split(","),
		site_img_div = ids.next().next().next();
	
	jQuery.each(img_ids, function(index, value) {
		jQuery(site_img_div).find('img[rel='+img_ids[index]+']').parent().addClass('added');
	});
} //end highlightSelectedImages()


/* Show widget edit form
---------------------------------------------------------- */
function showEditForm(element) {
	jQuery.ajax({
		type: "POST",
		url: wpb_js_plugin_path + "js_composer_markup.php",
		//data: "pid="+jQuery('#post_ID').val()+"&action=widget_edit&tabs_count="+element.find('.ui-tabs-nav li').length+"&element="+element.attr('class'),
		data: "action=widget_edit&tabs_count="+element.find('.ui-tabs-nav li').length+"&element="+element.attr('id'),

		success: function(msg) {
			initializeFormEditing(element, msg);			
		}
	}); // end of AJAX call
} // end showEditForm()


/* Show form with options available for current content
   block
---------------------------------------------------------- */
function initializeFormEditing(element, msg) {
	jQuery("#publish").hide(); // hide main publish button
	//
	jQuery('#wpb_visual_composer').addClass('wpb_vc_edit_mode');
	jQuery('#visual_composer_edit_form').html(msg).show();
	jQuery('.wpb_main_sortable, #wpb_visual_composer-elements > li:not(:first)').hide();
	
	
	jQuery(element).find(".wpb_vc_param_value").each(function(index) {
		var element_to_update = jQuery(this).attr("name"),
			new_value = '';
		
		jQuery('#visual_composer_edit_form .'+element_to_update).addClass('holder_exist');
		
		if (jQuery(this).hasClass("textfield")) {
			if (jQuery(this).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong')) {
				new_value = jQuery(this).html();
			} else {
				new_value = jQuery(this).val();
			}
		}
		else if (jQuery(this).hasClass("dropdown")) {
			new_value = jQuery(this).val();
		}
		
		else if (jQuery(this).hasClass("textarea_html")) {
			new_value = '';
			var html_val = jQuery(this).html();
			
			jQuery('#visual_composer_edit_form .'+element_to_update).val(html_val);
			initTinyMce(element_to_update);
		}
		
		else if (jQuery(this).hasClass("posttypes")) {
			var posttypes = jQuery(this).val(),
				posttypes_arr = posttypes.split(','),
				name_posttypes = jQuery(this).attr("name");
			
			jQuery.each(posttypes_arr, function(i, value) {
				jQuery('#visual_composer_edit_form .'+name_posttypes).closest('.edit_form_line').find('.'+name_posttypes+'[id='+value+']').attr('checked', 'checked');
			});
		}
		
		else if (jQuery(this).hasClass("exploded_textarea")) {
			new_value = jQuery(this).val().replace(/,/g, "\n");
		}
		
		else if (jQuery(this).hasClass("textarea")) {
			if (jQuery(this).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong')) {
				new_value = jQuery(this).html();
			} else {
				new_value = jQuery(this).val();
			}
		}
		
		else if (jQuery(this).hasClass("attach_images")) {
			var gallery_widget_attached_images_ids = jQuery(this).val();
			new_value = '';
			if (gallery_widget_attached_images_ids != '') {
				jQuery('#visual_composer_edit_form .'+element_to_update).val(gallery_widget_attached_images_ids);
				//
				highlightSelectedImages(jQuery('#visual_composer_edit_form .'+element_to_update));
				
				var site_img_div = jQuery('#visual_composer_edit_form .'+element_to_update).closest('.edit_form_line').find('.gallery_widget_site_images'),
					attached_img_div = jQuery('#visual_composer_edit_form .'+element_to_update).closest('.edit_form_line').find('.gallery_widget_attached_images');
				
				cloneSelectedImages(site_img_div, attached_img_div);
			}
		}
		
		else if (jQuery(this).hasClass("widgetised_sidebars")) {
			new_value = jQuery(this).val();
		}
		
		if (new_value != '') jQuery('#visual_composer_edit_form .'+element_to_update).val(new_value);
	});
	
	//check if new params were defined in $wpb_sc[]
	updateHtmlMarkupWithNewParams(element);
	
	
	//Fire EDIT callback if it is defined
	var cb = element.find(".wpb_vc_edit_callback"),
		el_id = element.attr('id');	
	if (cb.length == 1) { eval(cb.attr("value")+'("'+el_id+'")'); }
	////////////////////////
		
	jQuery('.wpb_save_edit_form').click(function(e) {
		e.preventDefault();
		saveFormEditing(element);
	});
	
	changeUrlAnchor('wpb_visual_composer');
} // end initializeFormEditing()


/* Check if there are new params in the map.php, if so - 
   adds param holders to the Visual Composer canvas
---------------------------------------------------------- */
function updateHtmlMarkupWithNewParams(element) {
	var params_to_add = new Array();
	jQuery('#visual_composer_edit_form .wpb_vc_param_value:not(.holder_exist, label)').each(function() {
		params_to_add.push(jQuery(this).attr("name"));
	});
	
	if (params_to_add.length > 0) {
		jQuery.ajax({
			type: "POST",
			url: wpb_js_plugin_path + "js_composer_markup.php",
			data: "action=new_param_holders&new_params="+params_to_add+"&element="+element.attr('id'),

			success: function(msg) {
				element.append(msg);
			}
		}); // end of AJAX call
	}
}


/* On editing form save, generate new html + shortcodes
---------------------------------------------------------- */
function saveFormEditing(element) {
	jQuery("#publish").show(); // show main publish button
	jQuery('#wpb_visual_composer').removeClass('wpb_vc_edit_mode');
	
	var formError = false;
	
	jQuery("#visual_composer_edit_form .wpb_vc_param_value").each(function(index) {
		var element_to_update = jQuery(this).attr("name"),
			new_value = '';
		
		if (jQuery(this).hasClass("textfield")) {
			new_value = jQuery(this).val();
		}
		else if (jQuery(this).hasClass("dropdown")) {
			new_value = jQuery(this).val(); // get selected element
			
			var all_classes_ar = new Array(),
				all_classes = '';
			jQuery(this).find('option').each(function() {
				var val = jQuery(this).attr('value');
				all_classes_ar.push(val); //populate all posible dropdown values
			});

			all_classes = all_classes_ar.join(" "); // convert array to string
			
			element.removeClass(all_classes).addClass(new_value); // remove all possible class names and add only selected one
		}
		else if (jQuery(this).hasClass("textarea_html")) {
			new_value = getTinyMceHtml(jQuery(this));
		}
		else if (jQuery(this).hasClass("wpb-checkboxes")) {
			var posstypes_arr = new Array();
			jQuery(this).closest('.edit_form_line').find('input').each(function(index) {
				var self = jQuery(this);
				element_to_update = self.attr("name");
				if (self.is(':checked')) {
					posstypes_arr.push(self.attr("id"));
				}
			});
			new_value = posstypes_arr.join(',');
		}
		else if (jQuery(this).hasClass("exploded_textarea")) {
			new_value = jQuery(this).val().replace(/\n/g, ",");
		}
		else if (jQuery(this).hasClass("textarea")) {
			new_value = jQuery(this).val();
		}
		else if (jQuery(this).hasClass("attach_images")) {
			new_value = jQuery(this).val();
		}
		else if (jQuery(this).hasClass("widgetised_sidebars")) {
			new_value = jQuery(this).val(); // get selected element
			
			var all_classes_ar = new Array(),
				all_classes = '';
			jQuery(this).find('option').each(function() {
				var val = jQuery(this).attr('value');
				all_classes_ar.push(val); //populate all posible dropdown values
			});

			all_classes = all_classes_ar.join(" "); // convert array to string
			
			element.removeClass(all_classes).addClass(new_value); // remove all possible class names and add only selected one
		}
		element_to_update = element_to_update.replace('wpb_tinymce_', '');
		
		if (element.find('.'+element_to_update).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong')) {
			element.find('.'+element_to_update).html(new_value);
		} else {
			element.find('.'+element_to_update).val(new_value);
		}
		//console.log(element_to_update);
	});
	
	//Fire SAVE callback if it is defined
	var cb = element.find(".wpb_vc_save_callback"),
		el_id = element.attr('id');
	if (cb.length == 1) { eval(cb.attr("value")+'("'+el_id+'")'); }
	//////////////

	// close edit form
	if (formError == false) closeFormEditing();
} // end saveFormEditing()

function closeFormEditing() {
	jQuery('#visual_composer_edit_form').html('').hide();
	jQuery('.wpb_main_sortable, #wpb_visual_composer-elements > li:not(:first)').show();
	
	save_composer_html();
	changeUrlAnchor('wpb_visual_composer');
}

function changeUrlAnchor(anchor) {
	var currentHref = window.location.href;
	window.location.href = currentHref.substr(0, currentHref.lastIndexOf("#")) + "#" + anchor;
}

function initTinyMce(classname) {
	//var myTinyMCEPreInit = tinyMCEPreInit;
	
		//myTinyMCEPreInit['mceInit']['editor_selector'] = classname;
		//myTinyMCEPreInit['qtInit']['content']['id'] = 'textarea_html';
		//console.log(jQuery(classname).attr('id'));
		//console.log(myTinyMCEPreInit['qtInit']['content']['id']);
		//qtInit : {'content' :{ id:"content"
		
	
	/* 3.3 tinyMCE.init(myTinyMCEPreInit.mceInit);*/
	
	/*var myTinyMCEPreInit = tinyMCEPreInit;
	
		myTinyMCEPreInit['mceInit']['editor_selector'] = classname;
	
	//tinyMCE.init(myTinyMCEPreInit.mceInit);
	jQuery("."+classname).attr({"id": "aaa"});
	tinyMCE.execCommand("mceAddControl", true, "aaa");*/
	
	jQuery('#visual_composer_edit_form .textarea_html, #visual_composer_edit_form .tab_content, #visual_composer_edit_form .slide_content').each(function(index) {
		var textfield_id = jQuery(this).attr('id');
		tinyMCE.execCommand("mceAddControl", true, textfield_id);
		
		jQuery(this).closest('.edit_form_line').find('.wp-switch-editor').removeAttr("onclick");
		jQuery(this).closest('.edit_form_line').find('.switch-tmce').click(function() {
			//console.log("switch-tmce click");
			jQuery(this).closest('.edit_form_line').find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
			tinyMCE.execCommand("mceAddControl", true, textfield_id);
		});
		jQuery(this).closest('.edit_form_line').find('.switch-html').click(function() {
			//console.log("switch-html click");
			jQuery(this).closest('.edit_form_line').find('.wp-editor-wrap').removeClass('tmce-active').addClass('html-active');
			tinyMCE.execCommand("mceRemoveControl", true, textfield_id);
		});
	});
}
function getTinyMceHtml(obj) {
	
	var mce_id = obj.attr('id'),
		html_back;
	
	//html_back = tinyMCE.get(mce_id).getContent();
		
	//tinyMCE.execCommand('mceRemoveControl', false, mce_id);
	try {
		html_back = tinyMCE.get(mce_id).getContent();
		tinyMCE.execCommand('mceRemoveControl', false, mce_id);
	}
	catch (err) {
		html_back = switchEditors.wpautop(obj.val());
	}
	
		/*3.3 if (obj.closest(".edit_form_line").find(".wpb_media-buttons a.wpb_switch-editors").text() == "Visual mode") {
			//switchEditors.go(mce_id, 'tinymce');
			html_back = switchEditors.wpautop(obj.val());
		} else {
			html_back = tinyMCE.get(mce_id).getContent();
			// destroy tinyMCE editor form
			tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		}*/
		//element.find("div.toggle_content").html(html_back);
		return html_back;
}

/* This function helps when you need to determine current
   column size.
   
   Returns Array("current size", "larger size", "smaller size", "size string");
---------------------------------------------------------- */
function getColumnSize(column) {
	if (column.hasClass("full-width"))
		return new Array("full-width", false, "three-fourth", "1/1");
	
	else if (column.hasClass("three-fourth"))
		return new Array("three-fourth", "full-width", "two-third", "3/4");
	
	else if (column.hasClass("two-third"))
		return new Array("two-third", "three-fourth", "one-half", "2/3");
	
	else if (column.hasClass("one-half"))
		return new Array("one-half", "two-third", "one-third", "1/2");
	
	else if (column.hasClass("one-third"))
		return new Array("one-third", "one-half", "one-fourth", "1/3");
	
	else if (column.hasClass("one-fourth"))
		return new Array("one-fourth", "one-third", false, "1/4");
	
	else 
		return false;
} // end getColumnSize()



/* Generates shortcode values and saves it in the special
   field, also injects shortcode to the main WP editor
---------------------------------------------------------- */
function generateShortcodesFromHtml(dom_tree) {
	var output = '';
	
	jQuery(dom_tree).children(".column").each(function(index) {
		var element = jQuery(this),
			sc_base = element.find('.wpb_vc_sc_base').val(),
			column_el_width = getColumnSize(element),
			params = '',
			sc_ending = ']';
			
			element.children('.wpb_vc_param_value').each(function(index) {
				var param_name = jQuery(this).attr("name"),
					new_value = '';
				
				if (jQuery(this).hasClass("textfield")) {
					if (jQuery(this).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong')) {
						new_value = jQuery(this).html();
					} else {
						new_value = jQuery(this).val();
					}
				}
				else if (jQuery(this).hasClass("dropdown")) {
					new_value = jQuery(this).val();
				}
				else if (jQuery(this).hasClass("textarea_html") && element.children('.column').length == 0) {
					content_value = jQuery(this).html();
					sc_ending = '] '+content_value+' [/'+sc_base+']';
				}
				else if (jQuery(this).hasClass("posttypes")) {
					new_value = jQuery(this).val();
				}
				else if (jQuery(this).hasClass("exploded_textarea")) {
					new_value = jQuery(this).val();
				}
				else if (jQuery(this).hasClass("textarea")) {
					if (jQuery(this).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong')) {
						new_value = jQuery(this).html();
					} else {
						new_value = jQuery(this).val();
					}
				}
				else if (jQuery(this).hasClass("attach_images")) {
					new_value = jQuery(this).val();
				}
				else if (jQuery(this).hasClass("widgetised_sidebars")) {
					new_value = jQuery(this).val();
				}
				
				if (new_value != '') { params += ' '+param_name+'="'+new_value+'"'; }
			});
			
			
			params += ' width="'+column_el_width[3]+'"'
			params += (element.hasClass("last")) ? ' last="last"' : '';
			
			output += '['+sc_base+params+sc_ending+' ';
			
			//deeper
			if (element.children('.column').length > 0) {
				output += generateShortcodesFromHtml(element);
				output += '[/'+sc_base+'] ';
			}
			
			//Fire SHORTCODE GENERATION callback if it is defined
			var cb = element.children(".wpb_vc_shortcode_callback"),
				el_id = element.attr('id');
			if (cb.length == 1) { output += eval(cb.attr("value")+'("'+el_id+'")'); }
	});
	
	return output;
} // end generateShortcodesFromHtml()





/* This functions copies html code into custom field and
   then on page reload/refresh it is used to build the
   initial layout.
---------------------------------------------------------- */
function save_composer_html() {
	addLastClass(jQuery(".wpb_main_sortable"));
	
	var val = jQuery.trim(jQuery(".wpb_main_sortable").html());
	jQuery("#visual_composer_html_code_holder").val(val);

	var shortcodes = generateShortcodesFromHtml(jQuery(".wpb_main_sortable"));
	jQuery("#visual_composer_code_holder").val(shortcodes);
	
	var tiny_val = switchEditors.wpautop(shortcodes);
	
	//[REVISE] Should determine what mode is currently on Visual/HTML
	tinyMCE.get('content').setContent(tiny_val, {format : 'raw'});
	
	/*try {
		tinyMCE.get('content').setContent(tiny_val, {format : 'raw'});
	}
	catch (err) {
		switchEditors.go('content', 'html');
		jQuery('#content').val(shortcodes);
	}*/
}

/* This functions goes throw the dom tree and automatically
   adds 'last' class name to the columns elements.
---------------------------------------------------------- */
function addLastClass(dom_tree) {
	var total_width = 0,
		width = 0;
	
	if (jQuery(dom_tree).hasClass("wpb_main_sortable")) {
		jQuery(dom_tree).find(".column .column").removeClass("sortable_1st_level");
		jQuery(dom_tree).children(".column").addClass("sortable_1st_level");
	}
	
	jQuery(dom_tree).children(".column").removeClass("first last");
	
	jQuery(dom_tree).children(".column").each(function(index) {
		var cur_el = jQuery(this);		
		
		if (   cur_el.hasClass("full-width") 
			|| cur_el.hasClass("wpb_widget"))		{ width = 1; }
		else if (cur_el.hasClass("three-fourth")) 	{ width = 0.75; }
		else if (cur_el.hasClass("two-third")) 		{ width = 0.66; }
		else if (cur_el.hasClass("one-half")) 		{ width = 0.5; }
		else if (cur_el.hasClass("one-third")) 		{ width = 0.33; }
		else if (cur_el.hasClass("one-fourth")) 	{ width = 0.25; }
		
		total_width += width;
		
		/* If total_width > 0.95 and <= 1 then add 'last' class name to the column */
		if (total_width >= 0.95 && total_width <= 1) {
			cur_el.addClass("last");
			cur_el.next('.column').addClass("first");
			total_width = 0;
		}
		/* If total_width > 1 then add 'first' class name to the current column and
		  'last' to the previous. 'first' class name is needed to clear floats */
		if (total_width > 1) {
			cur_el.addClass("first");
			cur_el.prev(".column").addClass("last");
			total_width = width;
		}
		
		/* If current column have column elements inside, then go throw them too */
		//if (cur_el.children(".column").length > 1) {
		if (cur_el.hasClass('wpb_vc_column')) {
			if (cur_el.children(".column").length > 0) {
				cur_el.removeClass('empty_column');
				cur_el.addClass('not_empty_column');
				addLastClass(cur_el);
			}
			else if (cur_el.children(".column").length == 0) {
				cur_el.removeClass('not_empty_column');
				cur_el.addClass('empty_column');
			}
			else {
				cur_el.removeClass('empty_column not_empty_column');
			}
		}
	});
	jQuery(dom_tree).children(".column:first").addClass("first");
	jQuery(dom_tree).children(".column:last").addClass("last");
} // end addLastClass()


function initTabs() {
	jQuery("#wpb_visual_composer .wpb_tabs").tabs();
}

/* This makes layout elements droppable, so user can drag
   them from on column to another and sort them (re-order)
   within the current column
---------------------------------------------------------- */
function initDroppable() {
	addLastClass(jQuery(".wpb_main_sortable"));
	
	jQuery('.wpb_sortable').sortable({
		//connectWith: ".wpb_sortable",
		connectWith: ".sortable_1st_level.wpb_vc_column",
		forcePlaceholderSize: true,
		placeholder: "widgets-placeholder",
		cursorAt: { left: 10, top : 20 },
		cursor: "move",
		//items: "div:not(.controls)",
		items: "div.wpb_sortable",
		update: function() { save_composer_html(); }
	});
	
	//jQuery('.wpb_droppable').droppable({
	jQuery('.sortable_1st_level.wpb_vc_column').droppable({
		accept: ".dropable_el",
		hoverClass: "ui-state-active",
		drop: function( event, ui ) {
			//console.log(jQuery(this));
			if ( jQuery("#wpb_wp_version").val() != 'lt_wp_3.3' ) {
				getElementMarkup(jQuery(this), ui.draggable, "addLastClass");
			} else {
				//old WP. Lower then 3.3
				getElementMarkup(event.target, ui.draggable, "addLastClass");
			}
		}
	});
	
	
} // end initDroppable()

/* This function is making an AJAX call to js_composer_markup.php
   and loads elements html
---------------------------------------------------------- */
var wpb_js_plugin_path = jQuery('#wpb_js_plugin_path').val();

function getElementMarkup (target, element, action) {
	//element;
	var column_index = jQuery(".wpb_main_sortable .column").length + 1;
	jQuery.ajax({
		type: "POST",
		url: wpb_js_plugin_path + "js_composer_markup.php",
		data: "column_index="+column_index+"&element="+element.attr('id'),

		success: function(msg) {
			/* inject (append) generated html to the target element */
			/* Make sure to insert new element before div.wpb_clear */
			if (jQuery(target).hasClass('wpb_main_sortable')) {
				jQuery(msg).insertBefore('.wpb_main_sortable div.wpb_clear:last');
			} else {
				jQuery(target).append(msg);
			}
			
			//Fire INIT callback if it is defined
			var cb = jQuery(msg).find(".wpb_vc_init_callback"),
				el_id = jQuery(msg).attr('id');			
			if (cb.length == 1) { eval(cb.attr("value")+'("'+el_id+'")'); }
			////
			
			initTabs();
			
			if (action == 'initDroppable') { initDroppable(); }
			
			save_composer_html();
		}
	}); // end of AJAX call
} // end getElementMarkup()

function saveCurrentTemplate() {
	var template = jQuery('#visual_composer_content').html();
	
	jQuery("body").append('<div id="template_tmp"></div>');
	jQuery("#template_tmp").html(template);
	jQuery("#template_tmp .column").removeAttr('style');
	
} //end of saveCurrentTemplate

/* This adds a div with id 'drag_placeholder' to the page
   dom, so then we can replace its content with element
   specific html markup
---------------------------------------------------------- */
function onDragPlaceholder() {
	return jQuery('<div id="drag_placeholder"></div>');
} // end onDragPlaceholder()

/* This function adds a class name to the div#drag_placeholder,
   and this helps us to give a style to the draging placeholder
---------------------------------------------------------- */
function renderCorrectPlaceholder(event, ui) {
	jQuery("#drag_placeholder").addClass("column_placeholder").html("Drag and drop me in the column");
}

/* This function gets html markup via ajax
---------------------------------------------------------- */
function getHtmlField ( field, index ) {
	var response = 'response';
	jQuery.ajax({
		type: "POST",
		url: wpb_js_plugin_path + "js_composer_markup.php",
		data: 'action=get_html&param_name=content_'+index+'&param_type='+field,//+'&default_content='+content
		
		async : false,
		
		success: function(msg) {
			response = msg;
		}
	}); // end of AJAX call
	return response;
}


/* Build in callbacks
   This should give you the overview how I handled a more
   complex shortcode like Tabs.
---------------------------------------------------------- */
var home_path = jQuery('#wpb_js_home_path').val(),
	upload_media_btns = '<div class="wpb_media-buttons hide-if-no-js"> Upload/Insert <a title="Add an Image" class="wpb_insert-image" href="#"><img alt="Add an Image" src="'+home_path+'/wp-admin/images/media-button-image.gif"></a> <a class="wpb_switch-editors" title="Switch Editors" href="#">HTML mode</a></div>';

function wpbTabsInitCallBack(id) {
	var html = '<div class="wpb_tabs">\
					<ul>\
						<li><a href="#tabs-1">Tab 1</a></li>\
						<li><a href="#tabs-2">Tab 2</a></li>\
					</ul>\
					<div id="tabs-1">\
						<p>Click edit button to change content</p>\
					</div>\
					<div id="tabs-2">\
						<p>I am tab</p>\
					</div>\
				</div>';
	
	jQuery('#'+id).append(html);
}

function wpbTabsEditCallBack(id) {
	var element = jQuery('#'+id),
		html = '',
		delete_edit_row = '<a class="row_delete" title="Delete tab">Delete tab</a>';
		
	html += '<div class="tab_sortables">';
	element.find(".ui-tabs-nav li").each(function(index) {
		var tab_href = jQuery(this).find("a"),
			tab_title = tab_href.text();//,
			//tab_content = switchEditors.wpautop(element.find('div#'+tab_href.attr('href')).html());
		
		var text_area = getHtmlField('textarea_html', index);
		
		html += '<div class="tab_section">';
		html += '<div class="edit_form_line">\
						<label for="tab_title-'+index+'">Tab title</label>\
						<input name="tab_title-'+index+'" class="wpb-textinput tab_title" type="text" value="'+tab_title+'" />\
						<span class="description">Enter tab title.</span>\
					</div>';
		
		html += '<div class="edit_form_line">\
						<label for="tab_content-'+index+'">Tab content</label>\
						'+text_area+'\
						<span class="description">Tab content.</span>\
					</div>';
		
		/*html += '<div class="edit_form_line">\
						<label for="tab_content-'+index+'">Tab content</label>\
						'+upload_media_btns+'\
						<textarea id="wpb_tab_textarea_html_'+index+'" name="tab_content-'+index+'" class="tab_content wpb-textarea visual_composer_tinymce">'+tab_content+'</textarea>\
						<span class="description">Tab content.</span>\
					</div>';*/
		html += delete_edit_row;
		html += '<hr class="divider" />';
		html += '</div>';
		
		//console.log(jQuery(html).find('#wpb_tinymce_content_'+index));
	});
	html += '</div>';
	
	html += '<a class="button tab_add_tab" href="#" title="Add tab">Add tab</a>';
		
	jQuery('#visual_composer_edit_form .edit_form').html(html);
	
	
	jQuery('#visual_composer_edit_form .edit_form .tab_sortables').sortable({
		axis: "y",
		items: ".tab_section",
		forcePlaceholderSize: true,
		placeholder: "widgets-placeholder",
		cursor: "move",
		start: function(event, ui) { 
			var mce_id = jQuery(ui.item).find('textarea.visual_composer_tinymce').attr('id');
			// temporary disable tinyMCE edito
			tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		},
		stop: function(event, ui) { 
			var mce_id = jQuery(ui.item).find('textarea.visual_composer_tinymce').attr('id');
			// re-enable tinyMCE editor
			tinyMCE.execCommand('mceAddControl', false, mce_id);
		}
	});
	
	initTinyMce("tab_content");
	element.find(".ui-tabs-nav li").each(function(index) {
		var tab_href = jQuery(this).find("a"),
			tab_content = switchEditors.wpautop(element.find('div#'+tab_href.attr('href')).html());
		tinyMCE.get('wpb_tinymce_content_'+index).setContent(tab_content, {format : 'raw'});
	});
	
	
	jQuery('.tab_add_tab').click(function(e) {
		e.preventDefault();
		
		var html = '',
			index = jQuery('#visual_composer_edit_form .tab_section').length + 1;
		
		var text_area = getHtmlField('textarea_html', index);
		
		html += '<div class="tab_section">';
		html += '<div class="edit_form_line">\
						<label for="tab_title-'+index+'">Tab title</label>\
						<input name="tab_title-'+index+'" class="wpb-textinput tab_title" type="text" value="" />\
						<span class="description">Enter tab title.</span>\
					</div>';
		html += '<div class="edit_form_line">\
						<label for="tab_content-'+index+'">Tab content</label>\
						'+text_area+'\
						<span class="description">Tab content.</span>\
					</div>';
		/*html += '<div class="edit_form_line">\
						<label for="tab_content-'+index+'">Tab content</label>\
						'+upload_media_btns+'\
						<textarea id="wpb_tab_textarea_html_'+index+'" name="tab_content-'+index+'" class="tab_content wpb-textarea visual_composer_tinymce"></textarea>\
						<span class="description">Tab content.</span>\
					</div>';*/
		html += delete_edit_row;
		html += '<hr class="divider" />';
		html += '</div>';
		
		jQuery('#visual_composer_edit_form .tab_sortables').append(html);
		initTinyMce("tab_content");
	});
	
	jQuery("#visual_composer_edit_form .row_delete").live("click", function() {
		var answer = confirm ("Press OK to delete section, Cancel to leave")
		if (answer) jQuery(this).closest('.tab_section').remove();
	});
}

function wpbTabsSaveCallBack(id) {
	//alert("save " + id);
	var tabs_el = jQuery('#'+id).find(".wpb_tabs");
	//
	tabs_el.tabs("destroy").html('<ul class="tabsnav"></ul>');
	jQuery('#visual_composer_edit_form .tab_section').each(function(index) {
		var tab_title = jQuery('#visual_composer_edit_form .tab_section:eq('+index+') .tab_title').val();
		var mce_id = jQuery('#visual_composer_edit_form .tab_section:eq('+index+')').find('textarea.visual_composer_tinymce').attr('id'),
			tab_content_textarea = jQuery('#visual_composer_edit_form .tab_section:eq('+index+')').find('textarea.textarea_html'),
			html_back;
		
		//html_back = getTinyMceHtml(tab_content_textarea);
		tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		
		html_back = switchEditors.wpautop(tab_content_textarea.val());
		
		//wp 3.3 html_back = getTinyMceHtml(jQuery(this).find('.tab_content'));
		// destroy tinyMCE editor
		//wp 3.3 tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		//
		if (tab_title != '') {
			var new_li = '<li><a href="#tabs-'+index+'">'+tab_title+'</a></li>',
				new_content = '<div id="tabs-'+index+'">'+html_back+'</div>';
				
			tabs_el.find('ul.tabsnav').append(new_li);
			tabs_el.append(new_content);
		}
		
	});
	initTabs();
}

function wpbTabsGenerateShortcodeCallBack(id) {
	var element = jQuery('#'+id),
		output = '';
	
	element.find(".ui-tabs-nav li").each(function(index) {
		var tab_href = jQuery(this).find("a"),
			tab_title = tab_href.text(),
			tab_content = switchEditors.wpautop(element.find('div#'+tab_href.attr('href')).html());
		output += '[vc_tab tab_title="'+tab_title+'"]'+tab_content+'[/vc_tab] ';
	});
	
	output += '[/'+element.find('.wpb_vc_sc_base').attr('value')+'] ';
	
	return output;
}

/* Tour section
---------------------------------------------------------- */
function wpbTourInitCallBack(id) {
	var html = '<div class="wpb_tour">\
				<div class="wpb_tour_slide">\
					<h4 class="wpb_slide_title">Slide title 1</h4>\
					<div class="wpb_slide_content"><p>slide content 1</p></div>\
				</div>\
				<div class="wpb_tour_slide">\
					<h4 class="wpb_slide_title">Slide title 2</h4>\
					<div class="wpb_slide_content"><p>slide content 2</p></div>\
				</div>\
				</div>';
	
	jQuery('#'+id).append(html);
}
function wpbTourEditCallBack(id) {
	var element = jQuery('#'+id),
		html = '',
		delete_edit_row = '<a class="row_delete" title="Delete slide">Delete slide</a>';
	
	html += '<div class="slide_sortables">';
	element.find(".wpb_tour_slide").each(function(index) {
		var slide_title = jQuery(this).find("h4.wpb_slide_title").text();//,
			//slide_content = switchEditors.wpautop(element.find('div.wpb_slide_content:eq('+index+')').html());
		
		var text_area = getHtmlField('textarea_html', index);
		
		html += '<div class="slide_section">';
		html += '<div class="edit_form_line">\
						<label for="slide_title-'+index+'">Slide title</label>\
						<input name="slide_title-'+index+'" class="wpb-textinput slide_title" type="text" value="'+slide_title+'" />\
						<span class="description">Enter slide title.</span>\
					</div>';
		html += '<div class="edit_form_line">\
						<label for="slide_content-'+index+'">Slide content</label>\
						'+text_area+'\
						<span class="description">Slide content.</span>\
					</div>';
		html += delete_edit_row;
		html += '<hr class="divider" />';
		html += '</div>';
	});
	html += '</div>';
	
	html += '<a class="button tab_add_tab" href="#" title="Add slide">Add slide</a>';
	
	jQuery('#visual_composer_edit_form .edit_form').html(html);
	
	
	jQuery('#visual_composer_edit_form .edit_form .slide_sortables').sortable({
		axis: "y",
		items: ".slide_section",
		forcePlaceholderSize: true,
		placeholder: "widgets-placeholder",
		cursor: "move",
		start: function(event, ui) { 
			var mce_id = jQuery(ui.item).find('textarea.visual_composer_tinymce').attr('id');
			// temporary disable tinyMCE edito
			tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		},
		stop: function(event, ui) { 
			var mce_id = jQuery(ui.item).find('textarea.visual_composer_tinymce').attr('id');
			// re-enable tinyMCE editor
			tinyMCE.execCommand('mceAddControl', false, mce_id);
		}
	});
	
	initTinyMce("slide_content");
	element.find(".wpb_tour_slide").each(function(index) {
		var slide_content = switchEditors.wpautop(element.find('div.wpb_slide_content:eq('+index+')').html());
		tinyMCE.get('wpb_tinymce_content_'+index).setContent(slide_content, {format : 'raw'});
	});
	
	jQuery('.tab_add_tab').click(function(e) {
		e.preventDefault();
		
		var html = '',
			index = jQuery('#visual_composer_edit_form .slide_section').length + 1;
			
		var text_area = getHtmlField('textarea_html', index);
		
		html += '<div class="slide_section">';
		html += '<div class="edit_form_line">\
						<label for="slide_title-'+index+'">Slide title</label>\
						<input name="slide_title-'+index+'" class="wpb-textinput slide_title" type="text" value="" />\
						<span class="description">Enter slide title.</span>\
					</div>';
		html += '<div class="edit_form_line">\
						<label for="slide_content-'+index+'">Slide content</label>\
						'+text_area+'\
						<span class="description">Slide content.</span>\
					</div>';
		html += delete_edit_row;
		html += '<hr class="divider" />';
		html += '</div>';
		
		jQuery('#visual_composer_edit_form .slide_sortables').append(html);
		initTinyMce("slide_content");
	});
	
	jQuery("#visual_composer_edit_form .row_delete").live("click", function() {
		var answer = confirm ("Press OK to delete section, Cancel to leave")
		if (answer) jQuery(this).closest('.slide_section').remove();
	});
}

function wpbTourSaveCallBack(id) {
	//alert("save " + id);
	var slides_el = jQuery('#'+id).find(".wpb_tour");
	//
	slides_el.html('');
	jQuery('#visual_composer_edit_form .slide_section').each(function(index) {
		var tab_title = jQuery('#visual_composer_edit_form .slide_section:eq('+index+') .slide_title').val();
		var mce_id = jQuery('#visual_composer_edit_form .slide_section:eq('+index+')').find('textarea.visual_composer_tinymce').attr('id'),
			slide_content_textarea = jQuery('#visual_composer_edit_form .slide_section:eq('+index+')').find('textarea.textarea_html'),
			html_back;
		
		//wp3.3 html_back = getTinyMceHtml(jQuery(this).find('.slide_content'));
		// destroy tinyMCE editor
		//wp 3.3 tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		tinyMCE.execCommand('mceRemoveControl', false, mce_id);
		html_back = switchEditors.wpautop(slide_content_textarea.val());
		//
		//if (tab_title != '') {
		var new_content = '<div class="wpb_tour_slide"><h4 class="wpb_slide_title">'+tab_title+'</h4> <div class="wpb_slide_content">'+html_back+'</div></div>';
			
		slides_el.append(new_content);
		//}
		
	});
	//initTabs();
}

function wpbTourGenerateShortcodeCallBack(id) {
	var element = jQuery('#'+id),
		output = '';
	
	element.find(".wpb_tour .wpb_tour_slide").each(function(index) {
		var slide_title = jQuery(this).find("h4.wpb_slide_title").text(),
			slide_content = switchEditors.wpautop(element.find('div.wpb_slide_content:eq('+index+')').html());
		output += '[vc_tour_slide slide_title="'+slide_title+'"]'+slide_content+'[/vc_tour_slide] ';
	});
	
	output += '[/'+element.find('.wpb_vc_sc_base').attr('value')+'] ';
	
	return output;
}




/* helpers */
function isset(varname) {
	if (typeof(window[varname]) != "undefined") return true;
	else return false;
}

/* Remove duplicates from array 
   usage: var unique = arr.unique();
*/
Array.prototype.unique = function () {
	var r = new Array();
	o:for(var i = 0, n = this.length; i < n; i++)
	{
		for(var x = 0, y = r.length; x < y; x++)
		{
			if(r[x]==this[i])
			{
				continue o;
			}
		}
		r[r.length] = this[i];
	}
	return r;
}