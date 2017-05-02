<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/slider.js"></script>
<?php 
	if(get_opt('_thum_autoplay')=='true' || get_opt('_thum_autoplay')=='on'){
		$autoplay='true';
	}else{
		$autoplay='false';
	}
	$interval=get_opt('_thum_interval');
	$pauseInterval=get_opt('_thum_pause');
	if(get_opt('_thum_pause_hover')=='true' || get_opt('_thum_pause_hover')=='on'){
		$pauseOnHover='true';
	}else{
		$pauseOnHover='false';		
	}
?>	
	
<script type="text/javascript">
	(function($){
	$(window).load(function(){
		$('#slider').slider({thumbContainerId:'slider-navigation', autoplay:<?php echo($autoplay); ?>, interval:<?php echo($interval);?>, pauseInterval:<?php echo($pauseInterval);?>, pauseOnHover:<?php echo($pauseOnHover); ?>});
	});
})(jQuery);
</script>

<div id="slider-container">
    <div id="slider"> 
      <div id="slider-container-shadow"></div>
		<div class="loading"></div>
			  <?php 
		
					$separator='|*|';
					
					
					$sliderImagesString = get_option($slider_prefix.'_thum_image_names');
					$linkString=get_option($slider_prefix.'_thum_image_links');
					$descString=get_option($slider_prefix.'_thum_image_descs');
					if($descString==''){
						$descString=get_option($slider_prefix.'_thum_image_desc');
					}
					
					$sliderImagesArray=explode($separator, $sliderImagesString);
					$linkArray= explode($separator,$linkString);
					$descArray= explode($separator,$descString);
					
					$count=count($sliderImagesArray);
					$linkCount=count($linkArray);
					
					for($i=0;$i<$count-1;$i++){
					
						if($i<$linkCount && $linkArray[$i]!=''){
							echo('<a href="'.$linkArray[$i].'">');
						}
						echo('<img src="');
					if(get_opt('_thum_auto_resize')=='true' || get_opt('_thum_auto_resize')=='on'){
						$path=pexeto_get_resized_image($sliderImagesArray[$i], 980, 370);
		      		}else{
						$path=$sliderImagesArray[$i];
		      		}
					echo($path);
					echo('" alt=""');
					if($descArray[$i]!=''){
						echo(' title="'.stripslashes($descArray[$i]).'"');
					}
					if($i==0){
						echo(' class="first"');
					}
					echo('/>');
					if($i<$linkCount && $linkArray[$i]!=''){
						echo('</a>');
					}
				}
				?>									
	
 	</div>
 	</div>
 	<?php $nav_class=$count<=8?'no-arrows':'with-arrows'; ?>
    <div id="slider-navigation-container" class="center <?php echo $nav_class; ?>">
      <div class="relative">
        <div id="slider-navigation" >
      	  <div class="items">
	      	<?php 
	      	$closed=true;
	      	for($i=0;$i<$count-1;$i++){
	      		if($i%8==0){ 
	      			echo('<div>'); 
	      			$closed=false;
	      		}
	      		if(get_opt('_thum_auto_resize')=='true' || get_opt('_thum_auto_resize')=='on'){
	      			echo('<img src="'.$path=pexeto_get_resized_image($sliderImagesArray[$i], 70, 50).'" alt="" />');
	      		}else{
					echo('<img src="'.$sliderImagesArray[$i].'" alt="" />');
	      		}
				if(($i+1)%8==0){
					echo('</div>');
					$closed=true;
				}
			}
			if(!$closed){
				echo('</div>');
			}
	      	?>
        </div>
      </div>
    </div>
  </div>
