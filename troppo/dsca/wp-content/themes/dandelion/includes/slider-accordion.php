<?php 
/**
 * This file contains the functionality of the accordion slider.
 */
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/accordion-slider.js"></script>

<script type="text/javascript">
(function($){
	$(window).load(function(){
		$('#slider').accordionSlider();
	});
})(jQuery);
</script>

<div id="slider-container">
	<div id="slider"> 
      <div id="slider-container-shadow"></div>
      <div class="loading"></div>
	
	  <?php 

			$separator='|*|';
			
			$sliderImagesString = get_option($slider_prefix.'_accord_image_names');
			$linkString=get_option($slider_prefix.'_accord_image_links');
			$titleString=get_option($slider_prefix.'_accord_image_titles');
			if($titleString==''){
				$titleString=get_option($slider_prefix.'_accord_image_title');
			}
			
			$descString=get_option($slider_prefix.'_accord_image_descs');
			if($descString==''){
				$descString=get_option($slider_prefix.'_accord_image_desc');
			}
			
			
			$sliderImagesArray=explode($separator, $sliderImagesString);
			$linkArray= explode($separator,$linkString);
			$titleArray= explode($separator,$titleString);
			$descArray= explode($separator,$descString);
			
			$count=count($sliderImagesArray);
			$linkCount=count($linkArray);
			
			for($i=0;$i<$count-1;$i++){
			
				$showDesc=false;
				if($descArray[$i]!='' || $titleArray[$i]!='' || $linkArray[$i]!=''){
					$showDesc=true;
				}
				
				if(get_opt('_accord_auto_resize')=='true' || get_opt('_accord_auto_resize')=='on'){
					$path=pexeto_get_resized_image($sliderImagesArray[$i], 700, 370);
		      	}else{
					$path=$sliderImagesArray[$i];
		      	}
				echo('<div class="accordion-holder"><img src="'.$path.'" alt="" />');
				if($showDesc){
					echo('<div class="accordion-description">');
				if($titleArray[$i]!='') echo ('<h4>'.stripslashes($titleArray[$i]).'</h4>');
				if($descArray[$i]!='') echo ('<p>'.stripslashes($descArray[$i]).'</p>');
				if($linkArray[$i]!='') echo ('<a href="'.$linkArray[$i].'">'.get_opt('_learn_more').'</a>');
				echo('</div>');
				
				}
			echo('</div>');
		}
		?>
	
	</div>
</div>