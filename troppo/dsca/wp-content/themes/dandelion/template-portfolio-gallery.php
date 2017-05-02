<?php
/*
 Template Name: Portfolio Gallery
 */
get_header();

if(have_posts()){
	while(have_posts()){
		the_post();
		
		//get all the settings for the portfolio page
		$page_id=get_the_ID();
		$page_title=get_the_title();
		$subtitle=get_post_meta($page_id, 'subtitle_value', true);
		$show_cat=get_post_meta($page_id,'categories_value',true);
		$show_cat=$show_cat==='hide'?'false':'true';
		$show_desc=get_post_meta($page_id,'showdesc_value',true);
		$cat_id=get_post_meta($page_id,'postCategory_value',true);
		$post_per_page=get_post_meta($page_id,'postNumber_value',true);
		$slider=get_post_meta($post->ID, "slider_value", $single = true);
		$slider_prefix=get_post_meta($post->ID, 'slider_name_value', true);
		if($slider_prefix=='default'){
			$slider_prefix='';
		}
		$title_link=get_post_meta($post->ID, '_title_link_value', true);
		if($title_link==''){
			$title_link='on';
		}
		$auto_thumbnail=get_post_meta($post->ID, '_auto_portfolio_thumbnail_value', true);
		$column_number=get_post_meta($post->ID, 'column_number_value', true);
		if($column_number==''){
			$column_number=3;
		}
		$order=get_post_meta($post->ID, 'order_value', true);
		
		include(TEMPLATEPATH . '/includes/page-header.php');
	}
}
?>

  <div id="content-container" class="content-gradient">
<div id="full-width">
<div id="gallery">

<?php include(TEMPLATEPATH . '/includes/portfolio/portfolio-setter.php'); ?>
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#gallery').portfolioSetter({
		itemsPerPage:<?php echo $post_per_page; ?>, 
		pageWidth:900,
		showCategories:<?php echo $show_cat?>,
		showDescriptions:<?php echo $show_desc?>,
		columns:<?php echo $column_number?>
		});
});

</script>	
<div class="clear"></div>
</div>
<?php
get_footer();
?>
