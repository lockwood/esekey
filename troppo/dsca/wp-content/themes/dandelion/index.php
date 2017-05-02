<?php
get_header();


$subtitle=get_opt("_posts_subtitle");
$slider=get_opt('_home_slider');
$slider_prefix=get_opt('_home_slider_name');
if($slider_prefix=='default'){
	$slider_prefix='';
}
$layout=get_opt('_blog_layout');
$static_image=get_opt('_blog_static_image');

include(TEMPLATEPATH . '/includes/page-header.php');


?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
<div id="<?php echo $content_id; ?>"><?php

if(get_opt('_post_per_page_on_blog')==''){
	$postsPerPage=5;
}else{
	$postsPerPage=get_opt('_post_per_page_on_blog');
}

$excludeCat=explode(',',get_opt('_exclude_cat_from_blog'));

query_posts(array(
      'category__not_in' => $excludeCat,
	  'paged' => get_query_var('paged'),
	  'posts_per_page' => get_opt('_post_per_page_on_blog')
));


if(have_posts()){
	while(have_posts()){
		the_post();
		global $more;
		$more = 0;
		
	include(TEMPLATEPATH . '/includes/post-template.php');	
		
	} 

	print_pagination(); 

}else{
	echo ('No posts available');
}

?> 
</div>
<?php 
if($layout!='full'){
	 print_sidebar(get_opt('_blog_sidebar'));
}
?>

<div class="clear"></div>
</div>
<?php
get_footer();
?>
