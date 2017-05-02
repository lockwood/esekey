<?php
/**
 * This is the template for the portfolio items content.
 */
get_header();

if(have_posts()){
	while(have_posts()){
		the_post();
		$subtitle=get_post_meta($post->ID, 'subtitle_value', true);
		$slider='none';
		$layout=get_opt('_portfolio_layout');
		$sidebar=get_opt('_portfolio_sidebar');
		
		include(TEMPLATEPATH . '/includes/page-header.php');
?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
	<div id="<?php echo $content_id; ?>">
 <!--content-->

  	<h1 class="page-heading"><?php the_title(); ?></h1><hr/>	
	
	<?php echo get_the_term_list( $post->id, 'portfolio_category', '', ' | ', ''); ?>

	<?php 
	the_content();
		}
	}
	?>
	
	<?php if(get_opt('_portfolio_comments')=='on'){  ?>
	  <div id="comments">
	    <?php comments_template();  ?>
	  </div>
	<?php } ?>

  </div>
<?php 
if($layout!='full'){
	print_sidebar($sidebar); 
}
?>
<div class="clear"></div>
</div>
<?php
get_footer();
?>

