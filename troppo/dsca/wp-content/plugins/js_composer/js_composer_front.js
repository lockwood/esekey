jQuery(document).ready(function($){
	vc_tabsBehaviour();
	vc_toursBehaviour();
	vc_slidersBehaviour();
	vc_twitterBehaviour();
	vc_carouselBehaviour();
	
	/*** Toggle click (FAQ) ***/
	$(".wpb_toggle").click(function(e) {
		if ($(this).hasClass('wpb_toggle_title_active')) {
			$(this).removeClass('wpb_toggle_title_active').next().slideUp(500);
		} else {
			$(this).addClass('wpb_toggle_title_active').next().slideDown(500);
		}
		
	});
	
	/** prettyPhoto initialization */
	$("a.prettyPhoto, a.prettyphoto").prettyPhoto();
	
	/* Small hack for vertical rythm. If div.column last child is heading then remove bottom margin */
	var headings = ["H1", "H2", "H3", "H4", "H5", "H6"];
	$(".column:not(.column_container)").each(function(index) {
		var this_el = $(this);
		try {
			if ( jQuery.inArray(this_el.find(".wpb_wrapper :last-child")[0].nodeName, headings) > -1 ) {
				this_el.addClass("no_bottom_margin");
			}
		} catch (err) { }
	});
}); // end jQuery(document).ready



function vc_twitterBehaviour() {
	jQuery('.wpb_twitter_widget .tweets').each(function(index) {
		var this_element = jQuery(this),
			tw_name = this_element.parent().find('.tw_name').text();
			tw_count = this_element.parent().find('.tw_count').text();
		
		this_element.tweet({
			username: tw_name,
			join_text: "auto",
			avatar_size: 0,
			count: tw_count,
			template: "{avatar}{join}{text}{time}",
			auto_join_text_default: "",
			auto_join_text_ed: "",
			auto_join_text_ing: "",
			auto_join_text_reply: "",
			auto_join_text_url: "",
			loading_text: '<span class="loading_tweets">loading tweets...</span>'
        });
	});
}

function vc_slidersBehaviour() {
	//var sliders_count = 0;
	jQuery('.wpb_gallery .wpb_gallery_slides').each(function(index) {
		var this_element = jQuery(this);
		var ss_count = 0;
		
		if (this_element.hasClass('wpb_slider_fading')) {
			var sliderSpeed = 500, sliderTimeout = 5000, slider_fx = 'fade';
			var current_ss;
			
			function slideshowOnBefore(currSlideElement, nextSlideElement, options) {
				jQuery(nextSlideElement).find("div.description").animate({"opacity": 0}, 0);
			}
			
			function slideshowOnAfter(currSlideElement, nextSlideElement, options) {
				jQuery(nextSlideElement).find("div.description").animate({"opacity": 1}, 2000);
			}
			
			this_element
			.before('<div class="ss_nav ss_nav_'+ss_count+'">')
			.cycle({
				fx: slider_fx, // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				pause: 1,
				speed: sliderSpeed,
				timeout: sliderTimeout,
				delay: -ss_count * 1000,
				before: slideshowOnBefore,
				after:slideshowOnAfter,
				pager:  '.ss_nav_'+ss_count
			})
			.find('.description').width(jQuery(this).width() - 20);
			ss_count++;
			
			var simg;
			var max_h, max_w;
			max_h = max_w = 0;
			
			jQuery(this).find("img").each(function(){
				var simg = new Image();
				simg.src = jQuery(this).attr('src');
				simg.onload = function() {
					if (simg.height > max_h) { max_h = simg.height; }
					if (simg.width > max_w) { max_w = simg.width; }
					
					jQuery(current_ss).css({
						"width" : max_w,
						"height" : max_h
					});
				}
			});
		}
		
		else if (this_element.hasClass('wpb_slider_nivo')) {
			this_element.nivoSlider({
				effect:'boxRainGrow,boxRain,boxRainReverse,boxRainGrowReverse', // Specify sets like: 'fold,fade,sliceDown'
				slices:15, // For slice animations
				boxCols: 8, // For box animations
				boxRows: 4, // For box animations
				animSpeed:800, // Slide transition speed
				pauseTime:7000, // How long each slide will show
				startSlide:0, // Set starting Slide (0 index)
				directionNav:true, // Next & Prev navigation
				directionNavHide:true, // Only show on hover
				controlNav:true, // 1,2,3... navigation
				keyboardNav:false, // Use left & right arrows
				pauseOnHover:true, // Stop animation while hovering
				manualAdvance:false, // Force manual transitions
				prevText: 'Prev', // Prev directionNav text
				nextText: 'Next' // Next directionNav text
			});
		}
	});
}

function vc_tabsBehaviour() {
	var tabSpeed = 150,
		tab_fx = 'fade',
		tabs_count = 0;
	
	jQuery(".wpb_tabs").each(function(){
		jQuery(this).children().addClass("tab");
		
//		console.log(jQuery(this).closest('.column').find('.wpb_tabs_nav').length);
		/*if ( jQuery(this).closest('.column').find('.wpb_tabs_nav').length == 0 ) {
			jQuery(this).before('<div class="wpb_tabs_nav wpb_tabs_nav_'+tabs_count+'">');
		}*/
				
		jQuery(this)
		.attr("id", "wpb_tabs_"+tabs_count)
		.before('<div class="wpb_tabs_nav wpb_tabs_nav_'+tabs_count+'">')
		.cycle({
			fx: tab_fx,
			timeout: 0,
			speed: tabSpeed,
			containerResize: 1,
			before:  tabsOnBefore,
			pager:  '.wpb_tabs_nav_'+tabs_count,
			fit: 1
		});
		
		var tab = jQuery(this);
		jQuery(".wpb_tabs_nav_"+tabs_count+" a").each(function(){
			var currentTabIndex = jQuery(this).prevAll().length;
			var tabTitle = jQuery("#wpb_tabs_"+tabs_count+" span.tab-title").eq(currentTabIndex).html(),
				tab_id = jQuery("#wpb_tabs_"+tabs_count+" span.tab-title").eq(currentTabIndex).attr("id");
			jQuery(this).html(tabTitle).addClass(tab_id);
		});
		var tabtitle = jQuery(this).find("span").html();
		tabs_count++;
	});
	
	function tabsOnBefore(currSlideElement, nextSlideElement, options) {
		var tabHeight = jQuery(nextSlideElement).outerHeight() + parseInt(jQuery(nextSlideElement).css("margin-top").replace(/[^\d\.]/g, ''));
		jQuery(nextSlideElement).parent().css({"height": tabHeight+"px"});
	}
	
	if ( tabs_count > 0 ) {
		jQuery(window).load(function() {
			jQuery(".wpb_tabs").each(function() {
				var tab1, tab2;
				if ( jQuery(this).find('.wpb_tab').length == 1 ) {
					tab1 = jQuery(this).find('.wpb_tab:eq(0)');
					tab2 = tab1;
				} else {
					tab1 = jQuery(this).find('.wpb_tab:eq(0)');
					tab2 = jQuery(this).find('.wpb_tab:eq(1)');
				}
				tabsOnBefore(tab2, tab1, '');
			});
		});
	}
}

function vc_toursBehaviour() {
	var ss_count = 0;
	jQuery(".small_tour .small_tour_slides").each(function(){
		var tour_paging = jQuery(this).parent().find('.small_tour_menu_ul');
		jQuery(tour_paging).addClass('small_slides_custom_paging_'+ss_count);
		
		var prev_btn, next_btn;
		next_btn = jQuery(this).find('.tourNextSlide');
		prev_btn = jQuery(this).find('.tourPrevSlide');
		
		var wrap_width = jQuery(this).closest('.small_tour').width() - jQuery(this).css('margin-left').replace("px", "");
		jQuery(this).find('.small_tour_slide').width(wrap_width);
		//		.wrap('<div class="relative"></div>')
		jQuery(this)
		.width(wrap_width)
		.cycle({
			fx: 'scrollHorz', // choose your transition type, ex: fade, scrollUp, shuffle, etc…
			pause: 1,
			speed: 800,
			timeout: 0,
			before: beforeTours,
			containerResize: 0, //////
			delay: -ss_count * 1000,
			next: next_btn,
			prev:prev_btn,
			pager:  tour_paging,
			fit: 1,
			pagerAnchorBuilder: function(idx, slide) { 
				return '.small_slides_custom_paging_'+ss_count+' li:eq(' + idx + ') a'; 
			}
		})
		ss_count++;
		///
		var min_h = jQuery(this).closest('.small_tour').find('.small_tour_menu_ul').height() + 2;
		jQuery(this).closest('.small_tour').css({"min-height" : min_h});
	});
	
	jQuery('.small_tour_menu_ul li:odd').addClass('odd');
		
	function beforeTours(currSlideElement, nextSlideElement, options) {
		var new_h = jQuery(nextSlideElement).height();
		jQuery(nextSlideElement).parent().animate({"height" : new_h});
	}
} // end of function vc_toursBehaviour

function vc_carouselBehaviour() {
	jQuery(".wpb_carousel").each(function(){
		var carousel_width = jQuery(this).width(),
			visible_count = getColumnsCount(jQuery(this)),
			carousel_speed = 500
		if ( jQuery(this).hasClass('columns_count_1') ) {
			carousel_speed = 900;
		}
		jQuery(this).find('.wpb_wrapper:eq(0)').jCarouselLite({
	        btnNext: jQuery(this).find('.next'),
	        btnPrev: jQuery(this).find('.prev'),
	        visible: visible_count,
	        speed: carousel_speed
	    })
	    .width(carousel_width);
	});
}
function getColumnsCount(el) {
	var find = false,
		i = 1;
		
	while (find == false) {
		if (el.hasClass('columns_count_'+i)) {
			find = true;
			return i;
		}
		i++;
	}
}