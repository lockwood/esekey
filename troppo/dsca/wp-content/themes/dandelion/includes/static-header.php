<div id="slider-container">
<div id="slider-container-shadow"></div>
<div id="static-header-img">
<?php if(is_page()){ 
	if(function_exists('has_post_thumbnail') && has_post_thumbnail()){ ?>
 <?php the_post_thumbnail('static-header-img'); ?>
<?php } 
 }else{ ?>
<img src="<?php echo $static_image; ?>"/>
<?php } ?>
</div>
</div>