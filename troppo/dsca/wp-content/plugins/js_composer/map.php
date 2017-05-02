<?php
/* Here we are defining initial set of shortcodes and their
   parameters. Theme authors can simply extend/modify $wpb_sc
   array to add their own set of shortcodes and then users
   will be able to controls them with slick drag and drop UI
---------------------------------------------------------- */
$wpb_sc = array();

/* Textual block
---------------------------------------------------------- */
$wpb_sc["text_block_sc"] = array(
	"name"		=> __("Text block", "js_composer"),
	"base"		=> "vc_column_text",
	"class"		=> "",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", "js_composer"),
			"param_name" => "content",
			"value" => __("<p>I am text block. Click edit button to change this text.</p>", "js_composer"),
			"description" => __("Enter your content.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"value" => "",
			"description" => __("If you wish to style particular text block differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
);

/* Latest tweets
---------------------------------------------------------- */
$wpb_sc["twitter_sc"] = array(
	"name"		=> __("Twitter widget", "js_composer"),
	"base"		=> "vc_twitter",
	"class"		=> "wpb_vc_twitter_widget",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"value" => "",
			"description" => __("What text use as widget title. Leave blank if no title is needed.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter name", "js_composer"),
			"param_name" => "twitter_name",
			"value" => "",
			"description" => __("Type in twitter profile name from which load tweets.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Tweets count", "js_composer"),
			"param_name" => "tweets_count",
			"value" => array("1" => 1, 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "11" => 11, "12" => 12, "13" => 13, "14" => 14, "15" => 15),
			"description" => __("How many recent tweets to load.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"value" => "",
			"description" => __("If you wish to style particular text block differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
);

/* Separator (Divider)
---------------------------------------------------------- */
$wpb_sc["separator_sc"] = array(
	"name"		=> __("Separator (Divider)", "js_composer"),
	"base"		=> "vc_separator",
	"class"		=> "wpb_vc_separator",
	"controls"	=> 'popup_delete'
);

/* Textual block
---------------------------------------------------------- */
$wpb_sc["text_separator_sc"] = array(
	"name"		=> __("Separator (Divider) with text", "js_composer"),
	"base"		=> "vc_text_separator",
	"class"		=> "",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Title", "js_composer"),
			"param_name" => "title",
			"holder" => "div",
			"value" => __("Title", "js_composer"),
			"description" => __("Separator title.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Title position", "js_composer"),
			"param_name" => "title_align",
			"value" => array(__('Align center', "js_composer") => "separator_align_center", __('Align left', "js_composer") => "separator_align_left", __('Align right', "js_composer") => "separator_align_right"),
			"description" => __("Select title location.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"value" => "",
			"description" => __("If you wish to style particular text block differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
);

/* Message box
---------------------------------------------------------- */
$wpb_sc["message_box_sc"] = array(
	"name"		=> __("Message box", "js_composer"),
	"base"		=> "vc_message",
	"class"		=> "wpb_vc_messagebox blue_message",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "dropdown",
			"heading" => __("Message box type", "js_composer"),
			"param_name" => "color",
			"value" => array(__('Informational', "js_composer") => "blue_message", __('Warning', "js_composer") => "yellow_message", __('Success', "js_composer") => "green_message"),
			"description" => __("Select message type.", "js_composer")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "messagebox_text",
			"heading" => __("Message text", "js_composer"),
			"param_name" => "content",
			"value" => '<p>'.__("I am message box. Click edit button to change this text.", "js_composer").'</p>',
			"description" => __("Message text.", "js_composer")
		)
	)
);

/* Facebook like button
---------------------------------------------------------- */
$wpb_sc["facebookl_like_sc"] = array(
	"name"		=> __("Facebook like", "js_composer"),
	"base"		=> "vc_facebook",
	"class"		=> "wpb_vc_facebooklike",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "dropdown",
			"heading" => __("Button type", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Standard", "js_composer") => "standard", __("Button count", "js_composer") => "button_count", __("Box count", "js_composer") => "box_count"),
			"description" => __("Select button type.", "js_composer")
		)
	)
);

/* Tweetmeme button
---------------------------------------------------------- */
$wpb_sc["tweetmeme_sc"] = array(
	"name"		=> __("Tweetmeme button", "js_composer"),
	"base"		=> "vc_tweetmeme",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "dropdown",
			"heading" => __("Button type", "js_composer"),
			"param_name" => "type",
			"value" => array("Horizontal" => "horizontal", "Vertical" => "vertical", "None" => "none"),
			"description" => __("Select button type.", "js_composer")
		)
	)
);

/* Toggle (FAQ)
---------------------------------------------------------- */
$wpb_sc["toggle_sc"] = array(
	"name"		=> __("FAQ (Toggle)", "js_composer"),
	"base"		=> "vc_toggle",
	"controls"	=> "edit_popup_delete",
	"class"		=> "wpb_vc_faq",
	"params"	=> array(
		array(
			"type" => "textfield",
			"holder" => "h4",
			"class" => "toggle_title",
			"heading" => __("Toggle title", "js_composer"),
			"param_name" => "title",
			"value" => __("Toggle title", "js_composer"),
			"description" => __("Toggle block title.", "js_composer")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "toggle_content",
			"heading" => __("Toggle content", "js_composer"),
			"param_name" => "content",
			"value" => __("<p>Toggle content goes here, click edit button.</p>", "js_composer"),
			"description" => __("Toggle block content.", "js_composer")
		)
	)
);

/* Gallery/Slideshow
---------------------------------------------------------- */
$wpb_sc["gallery_sc"] = array(
	"name"		=> __("Gallery", "js_composer"),
	"base"		=> "vc_gallery",
	"class"		=> "wpb_vc_gallery_widget",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"value" => "",
			"description" => __("What text use as widget title. Leave blank if no title is needed.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Gallery type", "js_composer"),
			"param_name" => "type",
			"value" => array("Fading slideshow" => "fading", "Nivo slider" => "nivo"),
			"description" => __("Select gallery type.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("On click", "js_composer"),
			"param_name" => "onclick",
			"value" => array("Open prettyPhoto" => "link_image", "Do nothing" => "link_no"),
			"description" => __("Select gallery type.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Image size", "js_composer"),
			"param_name" => "img_size",
			"value" => "",
			"description" => __("Enter image size in pixels. Example: 500x200 (Width x Height).", "js_composer")
		),
		array(
			"type" => "attach_images",
			"heading" => __("Images", "js_composer"),
			"param_name" => "images",
			"value" => "",
			"description" => ""
		)
	)
);

/* Tabs
   This one is an advanced example. It has javascript
   callbacks in it. So basically in your theme you can do
   whatever you want. More detailed documentation located
   in the advanced documentation folder.
---------------------------------------------------------- */
$wpb_sc["tabs_sc"] = array(
	"name"		=> __("Tabs", "js_composer"),
	"base"		=> "vc_tabs",
	"class"		=> "wpb_tabs",
	"js_callback" => array("init" => "wpbTabsInitCallBack", "edit" => "wpbTabsEditCallBack", "save" => "wpbTabsSaveCallBack", "shortcode" => "wpbTabsGenerateShortcodeCallBack")
);

/* Tour section
---------------------------------------------------------- */
$wpb_sc["tour_sc"] = array(
	"name"		=> __("Tour section", "js_composer"),
	"base"		=> "vc_tour",
	"class"		=> "wpb_tour",
	"js_callback" => array("init" => "wpbTourInitCallBack", "edit" => "wpbTourEditCallBack", "save" => "wpbTourSaveCallBack", "shortcode" => "wpbTourGenerateShortcodeCallBack")
);

/* Teaser grid
---------------------------------------------------------- */
$wpb_sc["teaser_grid_sc"] = array(
	"name"		=> __("Teaser grid", "js_composer"),
	"base"		=> "vc_teaser_grid",
	"class"		=> "wpb_vc_teaser_grid_widget",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"value" => "",
			"description" => __("Heading text. Leave it empty if not needed.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns count", "js_composer"),
			"param_name" => "grid_columns_count",
			"value" => array(1, 2, 3, 4),
			"description" => __("Select columns count.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Teaser count", "js_composer"),
			"param_name" => "grid_teasers_count",
			"value" => "",
			"description" => __('How many teasers to show? Enter number or "All".', "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Content", "js_composer"),
			"param_name" => "grid_content",
			"value" => array(__("Teaser (Excerpt)", "js_composer") => "teaser", __("Full Content", "js_composer") => "content"),
			"description" => __("Teaser layout template.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Layout", "js_composer"),
			"param_name" => "grid_layout",
			"value" => array(__("Title + Thumbnail + Text", "js_composer") => "title_thumbnail_text", __("Thumbnail + Title + Text", "js_composer") => "thumbnail_title_text", __("Thumbnail + Text", "js_composer") => "thumbnail_text", __("Thumbnail + Title", "js_composer") => "thumbnail_title", __("Thumbnail only", "js_composer") => "thumbnail", __("Title + Text", "js_composer") => "title_text"),
			"description" => __("Teaser layout.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Link", "js_composer"),
			"param_name" => "grid_link",
			"value" => array(__("Link to post", "js_composer") => "link_post", __("Link to bigger image", "js_composer") => "link_image", __("Thumbnail to bigger image, title to post", "js_composer") => "link_image_post", __("No link", "js_composer") => "link_no"),
			"description" => __("Link type.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Template", "js_composer"),
			"param_name" => "grid_template",
			"value" => array(__("Grid", "js_composer") => "grid", __("Carousel", "js_composer") => "carousel"),
			"description" => __("Teaser layout template.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Thumbnail size", "js_composer"),
			"param_name" => "grid_thumb_size",
			"value" => "",
			"description" => __('Enter image thumbnail size in pixels. Example: 200x100 (Width x Height).', "js_composer")
		),
		array(
			"type" => "posttypes",
			"heading" => __("Post types", "js_composer"),
			"param_name" => "grid_posttypes",
			"description" => __("Select categories to populate teasers from.", "js_composer")
		),
		array(
			"type" => "exploded_textarea",
			"heading" => __("Categories", "js_composer"),
			"param_name" => "grid_categories",
			"description" => __("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"value" => "",
			"description" => __("If you wish to style particular posts grid differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
);

/* Widgetised sidebar
---------------------------------------------------------- */
$wpb_sc["widgetised_sidebar_sc"] = array(
	"name"		=> __("Widgetised Sidebar", "js_composer"),
	"base"		=> "vc_widget_sidebar",
	"controls"	=> "full",
	"class" 	=> "wpb_widget_sidebar_widget",
	"params"	=> array(
		array(
			"type" => "widgetised_sidebars",
			"heading" => __("Sidebar", "js_composer"),
			"param_name" => "sidebar_id",
			"value" => "",
			"description" => __("Select which widget area output.", "js_composer")
		)
	)
);


/* Button
---------------------------------------------------------- */
// [large_button text="login redirect" href="http://musikogteater.dk/" type="wpb_hammer" color="yellow" target="_blank"] 
$icons_arr = array(
	__("None", "js_composer") => "none",
	__("Address book icon", "js_composer") => "wpb_address_book",
	__("Alarm clock icon", "js_composer") => "wpb_alarm_clock",
	__("Anchor icon", "js_composer") => "wpb_anchor",
	__("Application Image icon", "js_composer") => "wpb_application_image",
	__("Arrow icon", "js_composer") => "wpb_arrow",
	__("Asterisk icon", "js_composer") => "wpb_asterisk",
	__("Hammer icon", "js_composer") => "wpb_hammer",
	__("Balloon icon", "js_composer") => "wpb_balloon",
	__("Balloon Buzz icon", "js_composer") => "wpb_balloon_buzz",
	__("Balloon Facebook icon", "js_composer") => "wpb_balloon_facebook",
	__("Balloon Twitter icon", "js_composer") => "wpb_balloon_twitter",
	__("Battery icon", "js_composer") => "wpb_battery",
	__("Binocular icon", "js_composer") => "wpb_binocular",
	__("Document Excel icon", "js_composer") => "wpb_document_excel",
	__("Document Image icon", "js_composer") => "wpb_document_image",
	__("Document Music icon", "js_composer") => "wpb_document_music",
	__("Document Office icon", "js_composer") => "wpb_document_office",
	__("Document PDF icon", "js_composer") => "wpb_document_pdf",
	__("Document Powerpoint icon", "js_composer") => "wpb_document_powerpoint",
	__("Document Word icon", "js_composer") => "wpb_document_word",
	__("Bookmark icon", "js_composer") => "wpb_bookmark",
	__("Camcorder icon", "js_composer") => "wpb_camcorder",
	__("Camera icon", "js_composer") => "wpb_camera",
	__("Chart icon", "js_composer") => "wpb_chart",
	__("Chart pie icon", "js_composer") => "wpb_chart_pie",
	__("Clock icon", "js_composer") => "wpb_clock",
	__("Fire icon", "js_composer") => "wpb_fire",
	__("Heart icon", "js_composer") => "wpb_heart",
	__("Mail icon", "js_composer") => "wpb_mail",
	__("Play icon", "js_composer") => "wpb_play",
	__("Shield icon", "js_composer") => "wpb_shield",
	__("Video icon", "js_composer") => "wpb_video"
);

$colors_arr = array(__("Grey", "js_composer") => "button_grey", __("Yellow", "js_composer") => "button_yellow", __("Green", "js_composer") => "button_green", __("Blue", "js_composer") => "button_blue", __("Red", "js_composer") => "button_red", __("Orange", "js_composer") => "button_orange");

$target_arr = array(__("Same window", "js_composer") => "_self", __("New window", "js_composer") => "_blank");

$wpb_sc["button_sc"] = array(
	"name"		=> __("Button", "js_composer"),
	"base"		=> "vc_button",
	"class"		=> "wpb_vc_button button_grey",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Text on the button", "js_composer"),
			"holder" => "div",
			"param_name" => "title",
			"value" => __("Text on the button", "js_composer"),
			"description" => __("Text on the button.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("URL (Link)", "js_composer"),
			"param_name" => "href",
			"value" => "",
			"description" => __("Button link.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Color", "js_composer"),
			"param_name" => "color",
			"value" => $colors_arr,
			"description" => __("Button color.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"value" => $icons_arr
		),
		array(
			"type" => "dropdown",
			"heading" => __("Target", "js_composer"),
			"param_name" => "target",
			"value" => $target_arr
		)
	)
);

$wpb_sc["call_to_action_button_sc"] = array(
	"name"		=> __("Call to action button", "js_composer"),
	"base"		=> "vc_cta_button",
	"class"		=> "button_grey",
	"controls"	=> "edit_popup_delete",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Text on the button", "js_composer"),
			"param_name" => "title",
			"value" => __("Text on the button", "js_composer"),
			"description" => __("Text on the button.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("URL (Link)", "js_composer"),
			"param_name" => "href",
			"value" => "",
			"description" => __("Button link.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Color", "js_composer"),
			"param_name" => "color",
			"value" => $colors_arr,
			"description" => __("Button color.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"value" => $icons_arr
		),
		array(
			"type" => "dropdown",
			"heading" => __("Target", "js_composer"),
			"param_name" => "target",
			"value" => $target_arr
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button position", "js_composer"),
			"param_name" => "position",
			"value" => array(__("Align right", "js_composer") => "cta_align_right", __("Align left", "js_composer") => "cta_align_left", __("Align bottom", "js_composer") => "cta_align_bottom"),
			"description" => __("Select button alignment.", "js_composer")
		),
		array(
			"type" => "textarea",
			"holder" => "h2",
			"class" => "",
			"heading" => __("Text", "js_composer"),
			"param_name" => "call_text",
			"value" => __("Click edit button to change this text.", "js_composer"),
			"description" => __("Enter your content.", "js_composer")
		)
	)
);

?>