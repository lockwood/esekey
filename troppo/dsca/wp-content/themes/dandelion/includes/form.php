<?php $captcha = get_opt('_captcha')=='on'?true:false;  
      $captcha_opt = $captcha?'true':'false';
?>
<script type="text/javascript">
jQuery(function(){
	pexetoSite.contact({sentMessage:"<?php echo get_opt('_message_sent_text');?>", 
    emptyNameMessage:"<?php echo get_opt('_name_error');?>", 
    invalidEmailMessage:"<?php echo get_opt('_email_error');?>", 
    emptyQuestionMessage:"<?php echo get_opt('_question_error');?>",
    emptyCaptchaMessage:"<?php echo get_opt('_empty_captcha_error');?>",
    wrongCaptchaMessage:"<?php echo get_opt('_wrong_captcha_error');?>",
    captcha:<?php echo $captcha_opt; ?>});
    
});
<?php if($captcha){ ?>
 var RecaptchaOptions = {
    theme : 'clean',
    tabindex : 4,
    custom_translations : {
      play_again : "<?php echo(get_opt('_play_again_text')); ?>",
      cant_hear_this : "<?php echo(get_opt('_cant_hear_this_text')); ?>",
      visual_challenge : "<?php echo(get_opt('_visual_challenge_text')); ?>",
      audio_challenge : "<?php echo(get_opt('_audio_challenge_text')); ?>",
      refresh_btn : "<?php echo(get_opt('_refresh_btn_text')); ?>",
      help_btn : "<?php echo(get_opt('_help_btn_text')); ?>"
    }
  };
<?php } ?>
</script>
<form action="" method="post" id="submit_form">
 <div class="contact_form_input">
 <h6><?php echo get_opt('_name_text');?><span class="mandatory">*</span></h6>
  <input type="text" name="name_text_box" class="input form_input" id="name_text_box" tabindex="1"/>
  </div>
  
  <div class="contact_form_input">
  <h6><?php echo get_opt('_your_email_text');?> <span class="mandatory">*</span> </h6>
  <input type="text" name="email_text_box" class="input form_input" id="email_text_box" tabindex="2"/>
 	</div>
 
 <div class="contact_form_textarea">
  <h6><?php echo get_opt('_question_text');?><span class="mandatory">*</span></h6>
  <textarea name="question_text_area" rows="" cols="" class="textArea input form_input"
    id="question_text_area" tabindex="3"></textarea>
  </div>

<?php if($captcha){ ?>
 <h6><?php echo get_opt('_captcha_text');?><span class="mandatory">*</span></h6>
  <div class="contact-captcha-container">
  <?php
     require_once(PEXETO_FUNCTIONS_PATH.'/recaptchalib.php');
    $publickey = get_opt('_captcha_public_key');
    echo recaptcha_get_html($publickey);
    ?>
  </div>
<?php } ?>
 <br/>
  <a class="button" id="send_button"><span><?php echo get_opt('_send_text');?></span></a>
  <div id="contact_status" >
   <div class="check hidden"></div>
      <!-- leave for displaying sending message status -->
  </div>
  <div class="clear"></div>
  <div class="error_box" id="error_box"><?php echo get_opt('_contact_error');?></div>
</form>


