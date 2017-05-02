<?php
get_header();

if(have_posts()){
	while(have_posts()){
		the_post();
		$id=get_the_ID();
		$cat=get_the_category();
		$postTitle=get_the_title();
		$post_type=get_post_type( $post );
		$subtitle='';
		$slider='none';
		$layout=get_opt('_blog_layout');
		$sidebar=get_opt('_blog_sidebar');
		
		include(TEMPLATEPATH . '/includes/page-header.php');
	
		 
		?>
		
		<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
		<div id="<?php echo $content_id; ?>">
		<!--content-->
	   	<?php

		include(TEMPLATEPATH . '/includes/post-template.php');

	}
} ?>

<div id="comments">
	<?php comments_template(); ?>
</div>
</div>

<?php 
if($layout!='full'){
	print_sidebar($sidebar); 
}
?>
<div class="clear"></div>
</div>
<?php get_footer();   ?>
