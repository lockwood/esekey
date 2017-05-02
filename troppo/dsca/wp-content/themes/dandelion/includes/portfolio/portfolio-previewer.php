<?php
/**
 * This file generates the portfolio items HTML.
 */

echo '<div class="items">';

//set the query_posts args
$args= array(
         'posts_per_page' =>-1, 
		 'post_type' => 'portfolio',
		 'orderby' => 'menu_order'
	);

	if($catId!='-1'){
		$slug=pexeto_get_taxonomy_slug($catId);
		$args['portfolio_category']=$slug;
	}
	
//set the order args	
if($order=='custom'){
	$args['orderby']='menu_order';
	$args['order']='asc';
}else{
	$args['orderby']='date';
	$args['order']='desc';
}


	
query_posts($args);
	
	if(have_posts()) {
		 while (have_posts()) {
		 	the_post(); 
		 	$html = '<div class="portfolio-showcase-item">';
		 	$html.='<div class="preview-item">';
			
			$preview=get_post_meta($post->ID, 'preview_value', true);	
			
			$html.='<img class="alignleft shadow-frame portfolio-big-img" alt="" src="'.$preview.'">';
			$html.='<h1 class="page-heading">'.get_the_title().'</h1><hr/>'.do_shortcode(get_the_content());
			$html.='</div>';
			
			//generate the HTML for the smaller preview item
			$html.='<div class="showcase-item">';
			
		 	if($auto_thumbnail=='on'){
				$thumbnail=pexeto_get_resized_image($preview, 50, 46);
			}else{
				$thumbnail=get_post_meta($post->ID, 'thumbnail_value', true);
			}
			$html.='<img class="alignleft shadow-frame" alt="" src="'.$thumbnail.'">';
			
			//get the categories
		 	$terms=wp_get_post_terms($post->ID, 'portfolio_category');
			$term_string='';
			$first=true;
			foreach($terms as $term){
				if(!$first){
					$term_string.=', ';	
				}
				$term_string.=($term->name);
				$first=false;
			}
			$html.='<h6>'.get_the_title().'</h6><span>'.$term_string.'</span></div>';
			
			$html.= '</div>';
			echo $html;
		}
	}
	
echo '</div>';	
