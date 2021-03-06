<?php defined('ABSPATH') OR die('No direct access.');

/**
 * Template Functions
 *
 * @package Email_Encoder_Bundle
 * @category WordPress Plugins
 */

/**
 * Template function for encoding email
 * @global EebSite $EebSite
 * @param string $email
 * @param string $display  if non given will be same as email
 * @param string $extra_attrs  Optional
 * @param string $method Optional, else the default setted method will; be used
 * @return string
 */
if (!function_exists('eeb_email')):
    function eeb_email($email, $display = NULL, $extra_attrs = '', $method = NULL) {
        global $EebSite;
        return $EebSite->encode_email($email, $display, $extra_attrs, $method);
    }
endif;


/**
 * Template function for encoding content
 * @global EebSite $EebSite
 * @param string $content
 * @param string $method Optional, default NULL
 * @return string
 */
if (!function_exists('eeb_content')):
    function eeb_content($content, $method = NULL) {
        global $EebSite;
        return $EebSite->encode_content($content, $method);
    }
endif;

/**
 * Template function for encoding emails in the given content
 * @global EebSite $EebSite
 * @param string $content
 * @param boolean $enc_tags Optional, default TRUE
 * @param boolean $enc_mailtos  Optional, default TRUE
 * @param boolean $enc_plain_emails Optional, default TRUE
 * @return string
 */
if (!function_exists('eeb_email_filter')):
    function eeb_email_filter($content, $enc_tags = TRUE, $enc_mailtos = TRUE, $enc_plain_emails = TRUE) {
        global $EebSite;
        return $EebSite->encode_email_filter($content, $enc_tags, $enc_mailtos, $enc_plain_emails);
    }
endif;

/**
 * Template function for getting HTML of the encoder form (to put it on the site)
 * @global EebSite $EebSite
 * @return string
 */
if (!function_exists('eeb_form')):
    function eeb_form() {
        global $EebSite;
        return $EebSite->get_encoder_form();
    }
endif;

/* ommit PHP closing tag, to prevent unwanted whitespace at the end of the parts generated by the included files */