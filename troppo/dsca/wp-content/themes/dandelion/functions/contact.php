<?php
add_action('wp_ajax_pexeto_send_email', 'pexeto_send_email');
add_action('wp_ajax_nopriv_pexeto_send_email', 'pexeto_send_email');


function pexeto_send_email(){
	$res = array();
	$validated = true;

	if(get_opt('_captcha')=='on'){
		//CAPTCHA VALIDATION
		require_once(PEXETO_FUNCTIONS_PATH.'/recaptchalib.php');
		$privatekey = get_opt('_captcha_private_key');
		$resp = recaptcha_check_answer ($privatekey,
		                            $_SERVER["REMOTE_ADDR"],
		                            $_POST["recaptcha_challenge_field"],
		                            $_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) {
			// CAPTCHA text not valid
			$res['success']=false;
			$res['captcha_failed']=true;
			$validated = false;
		} 
	}
	

	if($validated) {
		// CAPTCHA validation passed, send email
		if(isset($_POST["name"]) && $_POST["name"] && isset($_POST["email"]) && $_POST["email"] && isset($_POST["question"]) && $_POST["question"]){
			$name=urldecode(stripcslashes($_POST["name"]));
			$subject = "A message from ".$name;
			
			$notes = urldecode(stripcslashes($_POST["question"]));
			
			$message = " $todayis [EST] \r\n
			Question: $notes \r\n";
			
			$from = "From: ".$_POST["email"];
			
			$emailToSend=get_opt('_email');
			$headers = 'From: '.$name.' <'.$_POST["email"].'>' . "\r\n";
			$mail_res=wp_mail($emailToSend, $subject, $message, $headers);
			$res['success']=$mail_res;
		}
	}

	$json_res = json_encode($res);
	echo($json_res);
	die();
}