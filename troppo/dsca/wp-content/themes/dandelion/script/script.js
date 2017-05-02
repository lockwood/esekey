/**
 * This file contains the functionality for initializing all the scripts in the
 * site and also there are some main initial settings included here, such as
 * setting rounded corners automatically, setting the Twitter functionality,
 * etc.
 * 
 * @author Pexeto
 */

var pexetoSite;

(function($){
pexetoSite = {
	enableCufon:'off',
	lightboxOptions : {},
	initSite : function() {
	
		// sets the colorbox lightbox
		jQuery(".gallery a").each(function(){
			var lightbox=jQuery(this).parents('.preview-item').length?'lightbox':'lightbox[group]';
			jQuery(this).attr("rel", lightbox);
		});
		
		this.setLightbox(jQuery("a[rel^='lightbox']"));
		
		this.setTestimonialFunc();
		
		//set the tabs functionality
		jQuery("ul.tabs").tabs("div.panes > div");
		
		//set the accordion functionality
		jQuery('.accordion-container').each(function(){
			jQuery(this).tabs(jQuery(this).find('div.pane'), {tabs: 'h2', effect: 'slide', initialIndex: 0});
		});
		
		this.set_submit_comment();
		
		//SET THE SEARCH BUTTON CLICK HANDLER
		jQuery('#search_button').click(function(event){
			event.preventDefault();
			jQuery('#searchform').submit();
		});
		
		//set the hover animation of the images within anchors
		jQuery('a img').hover(function(){
			jQuery(this).stop().animate({opacity:0.85}, 300);
		},function(){
			jQuery(this).stop().animate({opacity:1}, 300);
		});
		
		this.setColumns();
		
		this.setDropDown();
		this.loadCufon();
	},
		
	loadCufon:function(){
		if(this.enableCufon==='on'){
			Cufon.replace('h1,h2,h3,h4,h5,h6,#portfolio-big-pagination,.showcase-item span,a.button span,.intro-text, a.button-small span,.drop-caps');
		}
	},
	
	
	setScrollable:function(){
		return jQuery('#slider-navigation').scrollable();
	},
	
	setPortfolioLightbox:function(){
		this.setLightbox(jQuery('a[rel="lightbox"]'));
	},
	
	setLightbox:function(elem){
		var defaults = {animation_speed:'normal', theme:'light_rounded', overlay_gallery: false, deeplinking:false},
			options = jQuery.extend(defaults, pexetoSite.lightboxOptions);

		if(!pexetoSite.lightboxOptions.enable_social_tools){
			options['social_tools']='';
		}
		elem.prettyPhoto(options);
	},
	
	/**
	 * Adds a drop down functionality.
	 */
	setDropDown:function(){
		var padding=jQuery.browser.msie?5:12;
		
		jQuery("#menu ul li").each(function(){
			if(jQuery(this).children('ul').length>0){
				jQuery(this).find('a:first').append('<span class="drop-arrow">&raquo;</span>');
			}
		});
		
		jQuery("#menu ul ul").data('padding', 15);
		jQuery("#menu ul ul ul").data('padding', 0);
		
		jQuery("#menu ul li").hover(function(){
			if(jQuery(this).children('ul.sub-menu').length>0){
				var ul = jQuery(this).find('ul:first');
				ul.stop().css({paddingTop:ul.data('padding'), height:'auto'}).slideDown(300, function()
				{
					ul.css({overflow:"visible", visibility:'visible'});
				});
			}
		}, function(){
			if(jQuery(this).children('ul.sub-menu').length>0){
				var ul = jQuery(this).find('ul:first');
				ul.stop().slideUp(300, function()
				{	
					ul.css({overflow:"hidden", display:"none"});
				});
			}
		});
		
		if(jQuery.browser.opera){
			jQuery("#menu ul li").mouseover(function(e){
				jQuery(this).css({backgroundColor:'#fff'});
			});
		}
		
		if(jQuery.browser.safari){
		var hiddenul=jQuery('<ul><li></li></ul>').css({visibility:'hidden',display:'block'});
		jQuery('#menu ul:first').find('li').not('#menu ul li li').eq(-1).append(hiddenul);
		}
	},
	
	/**
	 * Sets the testimonials accordion functionality.
	 */
	setTestimonialFunc:function(){
		jQuery('.testimonial-container').each(function(){
			jQuery(this).find('div.testim-pane:first').addClass('first');
			jQuery(this).tabs(jQuery(this).find('div.testim-pane'), {
				tabs: 'img', 
				effect: 'horizontal'
			})
		});
	},
	
	setColumns:function(){
		jQuery('#content-container .columns-wrapper').each(function(){
			if(jQuery(this).find('.nomargin').length!==1){
				jQuery(this).find('.two-columns').eq(-1).addClass('nomargin');
				jQuery(this).find('.three-columns').not('.services-box').eq(-1).addClass('nomargin');
				jQuery(this).find('.four-columns').eq(-1).addClass('nomargin');
			}
		});
	},
	
	/**
	 * Loads the Nivo image slider.
	 */
	loadNivoSlider : function(obj, effect, showButtons, showArrows, slices, speed, interval, pauseOnHover, autoplay, columns, rows) {
		obj.find('img:first').css({zIndex:10000});
		
		// load the Nivo slider	
		jQuery(window)
				.load(function() {
					obj.nivoSlider( {
						effect : effect, // Specify sets like:
						// 'fold,fade,sliceDown'
						slices : slices,
						boxCols: columns, // For box animations
					    boxRows: rows, // For box animations
						animSpeed : speed,
						pauseTime : interval,
						startSlide : 0, // Set starting Slide (0 index)
						directionNav : showArrows, // Next & Prev
						directionNavHide : true, // Only show on hover
						controlNav : showButtons, // 1,2,3...
						controlNavThumbs : false, // Use thumbnails for
						// Control
						// Nav
						controlNavThumbsFromRel : false, // Use image rel for
						// thumbs
						keyboardNav : true, // Use left & right arrows
						pauseOnHover : pauseOnHover, // Stop animation while hovering
						manualAdvance : !autoplay, // Force manual transitions
						captionOpacity : 0.8, // Universal caption opacity
						beforeChange : function() {
						},
						afterChange : function() {
						},
						slideshowEnd : function() {
						} // Triggers after all slides have been shown
					});

					// remove numbers from navigation
						jQuery('.nivo-controlNav a').html('');
						jQuery('.nivo-directionNav a').html('');

						// center the slider navigation
						var slideNumber = jQuery('.nivo-controlNav a').length;
						var slideLeft = 980 / 2 - slideNumber * 21 / 2;
						jQuery('.nivo-controlNav:first').css( {
							left : slideLeft
						});
		    });
	},
	
	set_submit_comment:function(){
		jQuery('#submit_comment_button').click(function(event){
			event.preventDefault();
			jQuery('#commentform').submit();
		});
	},

	/**
	 * Contains the functionality of the send email form. Makes the validation and
	 * sends the message.
	 */
	contact : function(options){
		var defaults = {
			emptyNameMessage : 'Please fill in your name',
			invalidEmailMessage : 'Please insert a valid email address',
			emptyQuestionMessage : 'Please write your question',
			emptyCaptchaMessage : 'Please insert the text from the image',
			sentMessage : 'Message Sent',
			wrongCaptchaMessage : "The text you have entered doesn't match the text on the image",
			actionPath:'',
			captcha: true
		},
		o=$.extend(defaults, options),
		captchaTextBox = null,
		nameTextBox = $("#name_text_box"),
		emailTextBox = $("#email_text_box"),
		questionTextArea = $("#question_text_area"),
		form = $('#submit_form'),
		valid = true;

		
		function init() {
			setSendButtonClickHandler();
			setInputClickHandler();

			if(o.captcha){
				captchaTextBox=$('input[name$="recaptcha_response_field"]').removeAttr( 'style' );
			}
			setMessageHover();
			
		}

		/**
		 * Sets the send button click event handler. Validates the inputs and if they are
		 * not valid, displays error messages. If they are valid- makes an AJAX request to the
		 * PHP script to send the message.
		 */
		function setSendButtonClickHandler() {
			var contact = pexetoSite.contact;
			$("#send_button")
					.click(function(event) {
						var name='',
							email='',
							question='',
							captcha='',
							captchaChallenge='';

						
						event.preventDefault();
						valid = true;

							// remove previous validation error messages and warning styles
							nameTextBox.removeClass('invalid');
							emailTextBox.removeClass('invalid');
							questionTextArea.removeClass('invalid');
							$('#recaptcha_widget_div').removeClass('invalid');
							$('#invalid_input').hide();
							$('#sent_successful').hide();
							$('.question_icon').remove();
							$('.contact_message').remove();
							$('#error_box').hide();

							// verify whether the name text box is empty
							name = nameTextBox.val();
							validateIfEmpty(nameTextBox, name, o.emptyNameMessage);

							// verify whether the inserted email address is valid
							email = emailTextBox.val();
							validateIfEmailValid(emailTextBox, email, o.invalidEmailMessage);

							// verify whether the question text area is empty
							question = questionTextArea.val();
							validateIfEmpty(questionTextArea, question, o.emptyQuestionMessage);

							// verify whether the captcha field is empty
							if(o.captcha){
								captcha = captchaTextBox.val(),
								captchaChallenge = $('input[name$="recaptcha_challenge_field"]').val();
								validateIfEmpty(captchaTextBox, captcha, o.emptyCaptchaMessage);
							}
							

							if (valid) {
								// show the loading icon
								$('#contact_status').html(
										'<div class="contact_loader"></div>');

								var data = {name:escape(name), 
											question:escape(question), 
											email:email, 
											action:'pexeto_send_email',
											recaptcha_response_field: captcha,
											recaptcha_challenge_field: captchaChallenge
										};
								if(o.captcha){
									data.recaptcha_response_field=captcha;
									data.recaptcha_challenge_field=captchaChallenge;	
								}


								$
										.ajax( {
											type : "POST",
											url : pexetoSite.ajaxurl,
											data : data,
											dataType: 'json',
											success : function(res) {
												if(res.success){
													doOnMessageSent();
												}else{
													$('#contact_status').html('');
													if(o.captcha && res.captcha_failed){
														Recaptcha.reload();
														showValidationError(captchaTextBox, o.wrongCaptchaMessage, {captcha:true});

													}else{
														doOnMessageSendFailed();
													}
												}
												
											}
										});
							}
						});
		}

		function setMessageHover(){
			form.on('mouseover', '.question_icon', function(){
				$(this).css( {
						cursor : 'pointer'
				});
				$(this).siblings('.contact_message')
					.stop().show().animate( {
						opacity : 1
					}, 200);
			}).on('mouseout', '.question_icon', function(){
				$(this).siblings('.contact_message')
					.stop().animate( {
						opacity : 0
					}).hide();
			});
		}

		function doOnMessageSent(){
			form.each(function() {
				this.reset();
			});
			$('#contact_status')
					.html(
							'<div class="check"></div><span>' + o.sentMessage + '</span>');
			setTimeout(function() {
				$('#contact_status').fadeOut(
						500,
						function() {
							$(this).html('')
									.show();
						});
			}, 3000);
		}

		function doOnMessageSendFailed(){
			$('#error_box').animate({"height":"show"});
		}

		function setInputClickHandler() {
			$('#submit_form input, #submit_form textarea').on("focusin", function() {
				$(this).removeClass('invalid');
			});
		}

		function validateIfEmpty(field, value, message){
			if (value == '' || value == null) {
				showValidationError(field, message, {});
			}
		}

		function validateIfEmailValid(field, value, message){
			if (!isValidEmailAddress(value)) {
				showValidationError(field, message, {});
			}
		}

		function showValidationError(field, message, options){
				if(options.captcha){
					$('#recaptcha_widget_div').addClass('invalid');
				}else{
					field.addClass('invalid');
				}
				valid = false;
				$('<div class="question_icon"></div><div class="contact_message"><p>' + message + '</p></div>')
					.insertAfter(field);
		}

		/**
		 * Checks if an email address is a valid one.
		 * 
		 * @param emailAddress
		 *            the email address to validate
		 * @return true if the address is a valid one
		 */
		function isValidEmailAddress(emailAddress) {
			var pattern = new RegExp(
					/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		}

		init();
	}		
};
}(jQuery));









