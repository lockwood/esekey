<?php

$pexeto_slider_data = pexeto_get_slider_data();

$pexeto_pages_options= array( array(
"name" => "Page Settings",
"type" => "title",
"img" => PEXETO_IMAGES_URL."icon_home.png"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"home_page", "name"=>"Home"), array("id"=>"blog", "name"=>"Blog"), array("id"=>"portfolio", "name"=>"Portfolio"), array("id"=>"contact", "name"=>"Contact"))
),

/* ------------------------------------------------------------------------*
 * HOME PAGE SETTINGS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'home_page'
),

array(
"name" => "First box title",
"id" => $shortname."_home_box_title1",
"type" => "text",
"std" => "Unlimited skins"
),

array(
"name" => "First box description",
"id" => $shortname."_home_box_desc1",
"type" => "textarea",
"std" => "Changing template's colors is super simple - check out how your favorite color looks."
),

array(
"name" => "First box image",
"id" => $shortname."_home_box_icon1",
"type" => "upload",
"desc" => "Optimal image size: 263 x 160 pixels"
),

array(
"name" => "First box button text",
"id" => $shortname."_home_box_btn_text1",
"type" => "text",
"std" => "Learn More",
"desc" => "If you don't need a link, just insert a blank space."
),

array(
"name" => "First box button link",
"id" => $shortname."_home_box_btn_link1",
"type" => "text"
),

array(
"name" => "Second box title",
"id" => $shortname."_home_box_title2",
"type" => "text",
"std" => "Advanced Admin"
),

array(
"name" => "Second box description",
"id" => $shortname."_home_box_desc2",
"type" => "textarea",
"std" => "Changing template's colors is super simple - check out how your favorite color looks."
),

array(
"name" => "Second box image",
"id" => $shortname."_home_box_icon2",
"type" => "upload",
"desc" => "Optimal image size: 263 x 160 pixels"
),

array(
"name" => "Second box button text",
"id" => $shortname."_home_box_btn_text2",
"type" => "text",
"std" => "Learn More",
"desc" => "If you don't need a link, just insert a blank space."
),

array(
"name" => "Second box button link",
"id" => $shortname."_home_box_btn_link2",
"type" => "text"
),

array(
"name" => "Third box title",
"id" => $shortname."_home_box_title3",
"type" => "text",
"std" => "jQuery Powered"
),

array(
"name" => "Third box description",
"id" => $shortname."_home_box_desc3",
"type" => "textarea",
"std" => "Changing template's colors is super simple - check out how your favorite color looks."
),

array(
"name" => "Third box image",
"id" => $shortname."_home_box_icon3",
"type" => "upload",
"desc" => "Optimal image size: 263 x 160 pixels"
),

array(
"name" => "Third box button text",
"id" => $shortname."_home_box_btn_text3",
"type" => "text",
"std" => "Learn More",
"desc" => "If you don't need a link, just insert a blank space."
),

array(
"name" => "Third box button link",
"id" => $shortname."_home_box_btn_link3",
"type" => "text"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * BLOG PAGE SETTINGS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'blog'
),



array(
"name" => "Page Layout",
"id" => $shortname."_blog_layout",
"type" => "select",
"options" => array(array('id'=>'right','name'=>'Right Sidebar'), array('id'=>'left','name'=>'Left Sidebar'), array('id'=>'full','name'=>'Full width')),
"std" => 'right',
"desc" => 'This layout setting will affect the blog page, blog posts template, archives and search pages'
),

array(
"name" => "Blog sidebar",
"id" => $shortname."_blog_sidebar",
"type" => "select",
"options" => $pexeto_sidebars,
"std" => 'default',
"desc" => 'This sidebar setting will affect the blog page, blog posts template, archives and search pages'
),


array(
"name" => "Slider on posts/blog page",
"id" => $shortname."_home_slider",
"type" => "select",
"options" => array(array('id'=>'slider-thumbnail','name'=>'Thumbnail Slider', 'class'=>'thumbnailslider'),array('id'=>'slider-nivo','name'=>'Nivo Slider/Fader', 'class'=>'nivoslider'),
array('id'=>'slider-accordion','name'=>'Accordion Slider', 'class'=>'accordionslider'), array('id'=>'slider-content','name'=>'Content Slider', 'class'=>'contentslider'), array('id'=>'static-header','name'=>'Static Header Image', 'class'=>'static'),
array('id'=>'none','name'=>'None', 'class'=>'none')),
"std" => 'none'
),

array(
"name" => "Slider Name",
"id" => $shortname."_home_slider_name",
"type" => "select",
"options" => $pexeto_slider_data['data'],
"std" => 'default',
"desc" => 'If you have created additional sliders, you can select the name of the slider to be displayed
on the blog. By default the Default slider for each slider type is displayed.'
),

array(
"name" => "Static Image URL",
"id" => $shortname."_blog_static_image",
"type" => "upload",
"desc" => 'The header image URL when "Static Header Image" selected above. Optimal image size: 980 x 370 pixels.',
),

array(
"name" => "Page Subtitle",
"id" => $shortname."_posts_subtitle",
"type" => "text",
"desc" => "Available only when no slider has been selected above."
),

array(
"name" => "Exclude categories from blog",
"id" => $shortname."_exclude_cat_from_blog",
"type" => "multicheck",
"options" => $pexeto_categories,
"class"=>"exclude",
"desc" => "You can select which categories not to be shown on the blog"),

array(
"name" => "Number of posts per page",
"id" => $shortname."_post_per_page_on_blog",
"type" => "text",
"std" => "5"
),

array(
"name" => "Display post info",
"id" => $shortname."_blog_info",
"type" => "checkbox",
"std" => 'on',
"desc" => 'If you select "OFF", the post info such as category, date and author will be hidden on the blog'),


array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * PORTFOLIO PAGE SETTINGS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'portfolio'
),

array(
"name" => "Page Layout",
"id" => $shortname."_portfolio_layout",
"type" => "select",
"options" => array(array('id'=>'right','name'=>'Right Sidebar'), array('id'=>'left','name'=>'Left Sidebar'), array('id'=>'full','name'=>'Full width')),
"std" => 'right',
"desc" => 'This is the layout of the portfolio item content page'
),

array(
"name" => "Show comments",
"id" => $shortname."_portfolio_comments",
"type" => "checkbox",
"std" =>'off'
),

array(
"name" => "Content sidebar",
"id" => $shortname."_portfolio_sidebar",
"type" => "select",
"options" => $pexeto_sidebars,
"std" => 'default',
"desc" => 'This is the sidebar that is displayed on the item content page.'
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * CONTACT PAGE SETTINGS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'contact'
),

array(
"name" => "Email to which to send contact form message",
"id" => $shortname."_email",
"type" => "text"),


array(
"name" => "Ask your question",
"id" => $shortname."_ask_question_text",
"type" => "text",
"std" => "Ask your question"
),

array(
"name" => "Name text",
"id" => $shortname."_name_text",
"type" => "text",
"std" => "Name"
),

array(
"name" => "Your e-mail text",
"id" => $shortname."_your_email_text",
"type" => "text",
"std" => "Your e-mail"
),

array(
"name" => "Question text",
"id" => $shortname."_question_text",
"type" => "text",
"std" => "Question"
),

array(
"name" => "Send text",
"id" => $shortname."_send_text",
"type" => "text",
"std" => "Send"
),

array(
"name" => "Message sent text",
"id" => $shortname."_message_sent_text",
"type" => "text",
"std" => "Message sent"
),

array(
"name" => "Empty name message",
"id" => $shortname."_name_error",
"type" => "text",
"std" => "Please insert your name"
),

array(
"name" => "Invalid email message",
"id" => $shortname."_email_error",
"type" => "text",
"std" => "Please insert a valid email"
),

array(
"name" => "Empty question message",
"id" => $shortname."_question_error",
"type" => "text",
"std" => "Please insert your question"
),

array(
"name" => "Error message text",
"id" => $shortname."_contact_error",
"type" => "text",
"desc" => "This message will be displayed in an error occurs in the system and the message cannot be sent.",
"std" => "An error ocurred, the message was not sent."
),

array(
"name" => "Enable CAPTCHA",
"id" => $shortname."_captcha",
"type" => "checkbox",
"std" => 'off',
"desc" => 'reCAPTCHA will protect your contact form from spam emails that are generated from robots. If this field is enabled,
a CAPTCHA form will be added to the bottom of the contact form. The user will have to insert the text from the generated image
in order to proove that he/she is a real human and not a spamming robot.<br />
Please note that you have to also set the "CAPTCHA Public Key" and "CAPTCHA Private Key" fields below.'
),

array(
"name" => "reCAPTCHA Public Key",
"id" => $shortname."_captcha_public_key",
"type" => "text",
"desc" => 'In order to use CAPTCHA you need to register a public and private keys - you can do it on this page:<br/>
http://www.google.com/recaptcha/whyrecaptcha <br/>
For more information you can refer to the "Contact Page" section of the documentation.'
),

array(
"name" => "reCAPTCHA Private Key",
"id" => $shortname."_captcha_private_key",
"type" => "text",
"desc" => 'In order to use CAPTCHA you need to register a public and private keys - you can do it on this page:<br/>
http://www.google.com/recaptcha/whyrecaptcha <br/>
For more information you can refer to the "Contact Page" section of the documentation.'
),

array(
"name" => "CAPTCHA text",
"id" => $shortname."_captcha_text",
"type" => "text",
"std" => "Insert the text from the image"
),

array(
"name" => "Empty CAPTCHA message",
"id" => $shortname."_empty_captcha_error",
"type" => "text",
"std" => "Please insert the text from the image"
),

array(
"name" => "Wrong CAPTCHA message",
"id" => $shortname."_wrong_captcha_error",
"type" => "text",
"std" => "The text you have entered did not match the text on the image. Please try again."
),

array(
"name" => "Get a new challenge text",
"id" => $shortname."_refresh_btn_text",
"type" => "text",
"std" => "Get a new challenge"
),

array(
"name" => "Help text",
"id" => $shortname."_help_btn_text",
"type" => "text",
"std" => "Help"
),


array(
"name" => "Get a visual challenge text",
"id" => $shortname."_visual_challange_text",
"type" => "text",
"std" => "Get a visual challenge"
),

array(
"name" => "Get an audio challenge text",
"id" => $shortname."_audio_challenge_text",
"type" => "text",
"std" => "Get an audio challenge"
),

array(
"name" => "Play again text",
"id" => $shortname."_play_again_text",
"type" => "text",
"std" => "Play again"
),

array(
"name" => "Download MP3 text",
"id" => $shortname."_cant_hear_this_text",
"type" => "text",
"std" => "Download sound as MP3"
),



array(
"type" => "close"),


array(
"type" => "close"));

$pexeto_options_manager->add_options($pexeto_pages_options);