<?php

$pexeto_translation_options= array( array(
"name" => "Translation",
"type" => "title",
"img" => PEXETO_IMAGES_URL."icon_translate.png"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"blog", "name"=>"Blog"), array("id"=>"comment", "name"=>"Comments"), array("id"=>"portfolio", "name"=>"Portfolio"), array("id"=>"search", "name"=>"Search"), array("id"=>"other", "name"=>"Other"))
),

/* ------------------------------------------------------------------------*
 * BLOG TEXTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'blog'
),

array(
"name" => "Read more text",
"id" => $shortname."_read_more",
"type" => "text",
"std" => "Read More"
),

array(
"name" => "Learn more text",
"id" => $shortname."_learn_more",
"type" => "text",
"std" => "Learn More &raquo;"
),

array(
"name" => "By text",
"id" => $shortname."_by_text",
"type" => "text",
"std" => "By"
),

array(
"name" => "At text",
"id" => $shortname."_at_text",
"type" => "text",
"std" => "At"
),

array(
"name" => "In text",
"id" => $shortname."_in_text",
"type" => "text",
"std" => "In"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * COMMENTS TEXTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'comment'
),


array(
"name" => "No comments text",
"id" => $shortname."_no_comments_text",
"type" => "text",
"std" => "No comments"
),


array(
"name" => "One omment text",
"id" => $shortname."_one_comment_text",
"type" => "text",
"std" => "One comment"
),


array(
"name" => "Comments text",
"id" => $shortname."_comments_text",
"type" => "text",
"std" => "comments"
),

array(
"name" => "Leave a comment text",
"id" => $shortname."_leave_comment_text",
"type" => "text",
"std" => "Leave a comment"
),

array(
"name" => "Name text",
"id" => $shortname."_comment_name_text",
"type" => "text",
"std" => "Name"
),

array(
"name" => "Email text",
"id" => $shortname."_email_text",
"type" => "text",
"std" => "Email(will not be published)"
),

array(
"name" => "Website text",
"id" => $shortname."_website_text",
"type" => "text",
"std" => "Website"
),

array(
"name" => "Your comment text",
"id" => $shortname."_your_comment_text",
"type" => "text",
"std" => "Your comment"
),

array(
"name" => "Submit comment text",
"id" => $shortname."_submit_comment_text",
"type" => "text",
"std" => "Submit Comment"
),

array(
"name" => "Reply to comment text",
"id" => $shortname."_reply_text",
"type" => "text",
"std" => "Reply"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * PORTFOLIO TEXTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'portfolio'
),


array(
"name" => "Previous page text",
"id" => $shortname."_previous_text",
"type" => "text",
"std" => "Previous"
),

array(
"name" => "Next page text",
"id" => $shortname."_next_text",
"type" => "text",
"std" => "Next"
),

array(
"name" => "More Projects text",
"id" => $shortname."_more_projects_text",
"type" => "text",
"std" => "More Projects"
),


array(
"name" => "ALL text",
"id" => $shortname."_all_text",
"type" => "text",
"std" => "ALL"
),

array(
"name" => "Show me text",
"id" => $shortname."_showme_text",
"type" => "text",
"std" => "show me:"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * SEARCH TEXTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'search'
),


array(
"name" => "Search box text",
"id" => $shortname."_search_text",
"type" => "text",
"std" => "Search"
),

array(
"name" => "Search results text",
"id" => $shortname."_search_results_text",
"type" => "text",
"std" => "Search results for"
),

array(
"name" => "No results found text",
"id" => $shortname."_no_results_text",
"type" => "text",
"std" => "No results found. Try a different search?"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * OTHER TEXTS
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'other'
),

array(
"name" => "404 Page not found text",
"id" => $shortname."_404_text",
"type" => "text",
"std" => "The requested page has not been found"
),

array(
"type" => "close"),

array(
"type" => "close"));

$pexeto_options_manager->add_options($pexeto_translation_options);