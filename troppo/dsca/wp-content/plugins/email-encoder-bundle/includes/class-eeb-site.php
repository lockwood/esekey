<?php defined('ABSPATH') OR die('No direct access.');

/**
 * Class EebSite
 *
 * @extends Eeb_Admin
 * @description Contains all nescessary code for the site part
 *
 * @package Email_Encoder_Bundle
 * @category WordPress Plugins
 */
if (!class_exists('EebSite')):

class EebSite extends Eeb_Admin {

    /**
     * Regexp
     * @var array
     */
    protected $regexp_patterns = array(
        'mailto' => '/<a([^<>]*?)href=["\']mailto:(.*?)["\'](.*?)>(.*?)<\/a[\s+]*>/is',
        'email' => '/([A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6})/is',
    );

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * wp action
     */
    public function wp() {
        parent::wp();

        if (is_feed()) {
        // rss feed
            $rss_filters = array('the_title', 'the_content', 'the_excerpt', 'the_title_rss', 'the_content_rss', 'the_excerpt_rss',
                                'comment_text_rss', 'comment_author_rss', 'the_category_rss', 'the_content_feed', 'author_feed_link', 'feed_link');

            foreach($rss_filters as $filter) {
                if ($this->options['remove_shortcodes_rss']) {
                    add_filter($filter, array($this, 'callback_rss_remove_shortcodes'), 9);
                }

                if ($this->options['filter_rss']) {
                    add_filter($filter, array($this, 'callback_filter_rss'), 100);
                }
            }
        } else {
        // site
            $filters = array();

            // post content
            if ($this->options['filter_posts']) {
                array_push($filters, 'the_title', 'the_content', 'the_excerpt', 'get_the_excerpt');
            }

            // comments
            if ($this->options['filter_comments']) {
                array_push($filters, 'comment_text', 'comment_excerpt', 'comment_url', 'get_comment_author_url', 'get_comment_author_link', 'get_comment_author_url_link');
            }

            // widgets
            if ($this->options['filter_widgets']) {
                array_push($filters, 'widget_title', 'widget_text', 'widget_content');

                // also replace shortcodes
                if ($this->options['shortcodes_in_widgets']) {
                    add_filter('widget_text', 'do_shortcode', 100);
                    add_filter('widget_content', 'do_shortcode', 100); // widget_content id filter of Widget Logic plugin
                }
            }

            foreach($filters as $filter) {
                add_filter($filter, array($this, 'callback_filter'), 100);
            }
        }

        // actions
        add_action('wp_head', array($this, 'wp_head'));

        // shortcodes
        add_shortcode('eeb_form', array($this, 'shortcode_email_encoder_form'));
        add_shortcode('eeb_email', array($this, 'shortcode_encode_email'));
        add_shortcode('eeb_content', array($this, 'shortcode_encode_content'));

        // hook
        do_action('eeb_ready', array($this, 'callback_filter'), $this);

        // support for deprecated action and shortcodes
        if ($this->options['support_deprecated_names'] == 1) {
            // deprecated template functions
            require_once('deprecated.php');

            // deprecated shortcodes
            add_shortcode('email_encoder_form', array($this, 'shortcode_email_encoder_form'));
            add_shortcode('encode_email', array($this, 'shortcode_encode_email'));
            add_shortcode('encode_content', array($this, 'shortcode_encode_content'));

            // deprecated hooks
            do_action('init_email_encoder_bundle', array($this, 'callback_filter'), $this);
        }
    }

    /**
     * WP head
     */
    public function wp_head() {
            // add styling for encoding check message + icon
            if ($this->is_admin_user && $this->options['show_encoded_check']) {
                echo <<<CSS
<style type="text/css">
    a.encoded-check { opacity:0.5; position:absolute; text-decoration:none !important; font:10px Arial !important; margin-top:-3px; color:#629632; font-weight:bold; }
    a.encoded-check:hover { opacity:1; cursor:help; }
    a.encoded-check img { width:10px; height:10px; }
</style>
CSS;
            }
    }

    /* -------------------------------------------------------------------------
     *  Filter Callbacks
     * -------------------------------------------------------------------------/

    /**
     * WP filter callback
     * @param string $content
     * @return string
     */
    public function callback_filter($content) {
        global $post;

        if (isset($post) && in_array($post->ID, $this->skip_posts)) {
            return $content;
        }

        return $this->encode_email_filter($content, TRUE, $this->options['encode_mailtos'], $this->options['encode_emails']);
    }

    /**
     * RSS Filter callback
     * @param string $content
     * @return string
     */
    public function callback_filter_rss($content) {
        $content = preg_replace($this->regexp_patterns, $this->options['protection_text_rss'], $content);

        return $content;
    }

    /**
     * RSS Callback Remove shortcodes
     * @param string $content
     * @return string
     */
    public function callback_rss_remove_shortcodes($content) {
        // strip shortcodes like [eeb_content], [eeb_form]
        $content = strip_shortcodes($content);

        return $content;
    }

    /**
     * Filter content for encoding
     * @param string $content
     * @param boolean $enc_tags Optional, default TRUE
     * @param boolean $enc_mailtos  Optional, default TRUE
     * @param boolean $enc_plain_emails Optional, default TRUE
     * @return string
     */
    public function encode_email_filter($content, $enc_tags = TRUE, $enc_mailtos = TRUE, $enc_plain_emails = TRUE) {
        // encode mailto links
        if ($enc_mailtos) {
            $content = preg_replace_callback($this->regexp_patterns['mailto'], array($this, 'callback_encode_email'), $content);
        }

        // replace plain emails
        if ($enc_plain_emails) {
            $content = preg_replace_callback($this->regexp_patterns['email'], array($this, 'callback_encode_email'), $content);
        }

        // workaround for double encoding bug when auto-protect mailto is enabled and method is enc_html
        if ($this->options['encode_mailtos'] == 1) {
            // change back to html tag
            $content = str_replace('[a-replacement]', '<a', $content);
        }

        return $content;
    }

    /**
     * Callback for encoding email
     * @param array $match
     * @return string
     */
    public function callback_encode_email($match) {
        if (count($match) < 3) {
            return $this->encode_email($match[1]);
        } else if (count($match) == 3) {
            return $this->encode_email($match[2]);
        }

        return $this->encode_email($match[2], $match[4], $match[1] . ' ' . $match[3]);
    }

    /* -------------------------------------------------------------------------
     *  Shortcode Functions
     * -------------------------------------------------------------------------/

    /**
     * Shortcode showing encoder form
     * @return string
     */
    public function shortcode_email_encoder_form() {
        // add style and script for ajax encoder
//        wp_enqueue_script('email_encoder', plugins_url('js/src/email-encoder-bundle.js', EMAIL_ENCODER_BUNDLE_FILE), array('jquery'), EMAIL_ENCODER_BUNDLE_VERSION);
        wp_enqueue_script('email_encoder', plugins_url('js/email-encoder-bundle.min.js', EMAIL_ENCODER_BUNDLE_FILE), array('jquery'), EMAIL_ENCODER_BUNDLE_VERSION);

        return $this->get_encoder_form();
    }

    /**
     * Shortcode encoding email
     * @param array $attrs
     * @return string
     */
    public function shortcode_encode_email($attrs) {
        if (!is_array($attrs) || !key_exists('email', $attrs)) {
            return '';
        }

        $email = $attrs['email'];
        $display = (key_exists('display', $attrs)) ? $attrs['display'] : $attrs['email'];
        $method = (key_exists('method', $attrs)) ? $attrs['method'] : NULL;
        $extra_attrs = (key_exists('extra_attrs', $attrs)) ? $attrs['extra_attrs'] : NULL;

        $encoded = $this->encode_email($email, $display, $extra_attrs, $method);

        // workaround for double encoding bug when auto-protect mailto is enabled and method is enc_html
        if ($this->options['encode_mailtos'] == 1 && $method === 'enc_html') {
            // change html tag to entity
            $encoded = str_replace('<a', '[a-replacement]', $encoded);
        }

        return $encoded;
    }

    /**
     * Shortcode encoding content
     * @param array $attrs
     * @param string $content Optional
     * @return string
     */
    public function shortcode_encode_content($attrs, $content = '') {
        $method = (is_array($attrs) && key_exists('method', $attrs)) ? $attrs['method'] : NULL;

        return $this->encode_content($content, $method);
    }

    /* -------------------------------------------------------------------------
     *  Encode Functions
     * -------------------------------------------------------------------------/

    /**
     * Encode the given email into an encoded HTML link
     * @param string $content
     * @param string $method Optional, else the default setted method will; be used
     * @param boolean $no_html_checked
     * @return string
     */
    public function encode_content($content, $method = NULL, $no_html_checked = FALSE) {
        // get encode method
        $method = $this->get_method($method, $this->method);

        // get encoded email code
        $content = $this->{$method}($content);

        // add visual check
        if ($no_html_checked !== TRUE) {
            $content = $this->get_success_check($content);
        }

        return $content;
    }

    /**
     * Encode the given email into an encoded HTML link
     * @param string $email
     * @param string $display Optional, if not set display will be the email
     * @param string $extra_attrs Optional
     * @param string $method Optional, else the default setted method will; be used
     * @param boolean $no_html_checked
     * @return string
     */
    public function encode_email($email, $display = NULL, $extra_attrs = '', $method = NULL, $no_html_checked = FALSE) {
        // get encode method
        $method = $this->get_method($method, $this->method);

        // decode entities
        $email = html_entity_decode($email);

        // set email as display
        if ($display === NULL) {
            $display = $email;

            if ($method === 'enc_html') {
                $display = $this->enc_html($display);
            }
        } else {
            $display = html_entity_decode($display);
        }

        if ($method === 'enc_html') {
            $email = $this->enc_html($email);
        }

        $class = $this->options['class_name'];
        $extra_attrs = ' ' . trim($extra_attrs);
        $mailto = '<a class="'. $class .'" href="mailto:' . $email . '"'. $extra_attrs . '>' . $display . '</a>';

        if ($method === 'enc_html') {
            // add visual check
            if ($no_html_checked !== TRUE) {
                $mailto = $this->get_success_check($mailto);
            }
        } else {
            $mailto = $this->encode_content($mailto, $method, $no_html_checked);
        }

        // get encoded email code
        return $mailto;
    }

    /**
     * Add html to encoded content to show check icon and text
     * @param string $content
     * @return string
     */
    private function get_success_check($content) {
        if (!$this->is_admin_user || !$this->options['show_encoded_check']) {
            return $content;
        }

        return $content
                . '<a href="javascript:;" class="encoded-check"'
                . ' title="' . __('Successfully Encoded (this is a check and only visible when logged in as admin)', EMAIL_ENCODER_BUNDLE_DOMAIN) . '">'
                . '<img class="encoded-check-icon" src="' . plugins_url('images/icon-email-encoder-bundle.png', EMAIL_ENCODER_BUNDLE_FILE)
                . '" alt="' . __('Encoded', EMAIL_ENCODER_BUNDLE_DOMAIN) . '" />'
                . __('Successfully Encoded', EMAIL_ENCODER_BUNDLE_DOMAIN) . '</a>';
    }

    /* -------------------------------------------------------------------------
     *  Different Encoding Methods
     * -------------------------------------------------------------------------/

    /**
     * ASCII method
     * Based on function from Tyler Akins (http://rumkin.com/tools/mailto_encoder/)
     *
     * @param string $value
     * @return string
     */
    private function enc_ascii($value) {
        $mail_link = $value;

        $mail_letters = '';

        for ($i = 0; $i < strlen($mail_link); $i ++) {
            $l = substr($mail_link, $i, 1);

            if (strpos($mail_letters, $l) === FALSE) {
                $p = rand(0, strlen($mail_letters));
                $mail_letters = substr($mail_letters, 0, $p) .
                $l . substr($mail_letters, $p, strlen($mail_letters));
            }
        }

        $mail_letters_enc = str_replace("\\", "\\\\", $mail_letters);
        $mail_letters_enc = str_replace("\"", "\\\"", $mail_letters_enc);

        $mail_indices = '';
        for ($i = 0; $i < strlen($mail_link); $i ++) {
            $index = strpos($mail_letters, substr($mail_link, $i, 1));
            $index += 48;
            $mail_indices .= chr($index);
        }

        $mail_indices = str_replace("\\", "\\\\", $mail_indices);
        $mail_indices = str_replace("\"", "\\\"", $mail_indices);

        return '<script type="text/javascript">'
                . '(function(){'
                . 'var ml="'. $mail_letters_enc .'",mi="'. $mail_indices .'",o="";'
                . 'for(var j=0,l=mi.length;j<l;j++){'
                . 'o+=ml.charAt(mi.charCodeAt(j)-48);'
                . '}document.write(o);'
                . '}());'
                . '</script><noscript>'
                . $this->options['protection_text']
                . '</noscript>';
    }

    /**
     * Escape method
     * Taken from the plugin "Email Spam Protection" by Adam Hunter (http://blueberryware.net/2008/09/14/email-spam-protection/)
     *
     * @param string $value
     * @return string
     */
    private function enc_escape($value) {
        $string = 'document.write(\'' . $value . '\')';

        /* break string into array of characters, we can't use string_split because its php5 only :( */
        $split = preg_split('||', $string);
        $out =  '<script type="text/javascript">' . "eval(unescape('";

        foreach ($split as $c) {
            /* preg split will return empty first and last characters, check for them and ignore */
            if (!empty($c)) {
                $out .= '%' . dechex(ord($c));
            }
        }

        $out .= "'))" . '</script><noscript>'
            . $this->options['protection_text']
            . '</noscript>';

        return $out;
    }

    /**
     * Convert randomly chars to htmlentities
     * This method is partly taken from WordPress
     * @link http://codex.wordpress.org/Function_Reference/antispambot
     *
     * @param string $value
     * @return string
     */
    private function enc_html($value) {
        // check for built-in WP function
        if (function_exists('antispambot')) {
            $emailNOSPAMaddy = antispambot($value);
        } else {
            $emailNOSPAMaddy = '';
            srand ((float) microtime() * 1000000);
            for ($i = 0; $i < strlen($emailaddy); $i = $i + 1) {
                $j = floor(rand(0, 1+$mailto));
                if ($j==0) {
                    $emailNOSPAMaddy .= '&#'.ord(substr($emailaddy,$i,1)).';';
                } elseif ($j==1) {
                    $emailNOSPAMaddy .= substr($emailaddy,$i,1);
                } elseif ($j==2) {
                    $emailNOSPAMaddy .= '%'.zeroise(dechex(ord(substr($emailaddy, $i, 1))), 2);
                }
            }
            $emailNOSPAMaddy = str_replace('@','&#64;',$emailNOSPAMaddy);
        }

        $emailNOSPAMaddy = str_replace('@', '&#64;', $emailNOSPAMaddy);

        return $emailNOSPAMaddy;
    }

} // end class EebSite

endif;

/* ommit PHP closing tag, to prevent unwanted whitespace at the end of the parts generated by the included files */