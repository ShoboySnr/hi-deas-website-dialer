<?php

namespace HiDeasWebsiteDialer\Core;

class Shortcode {
    
    public $shortcode = '[Hi-Deas-Website-Dialer]';
    
    private $default_image_url = HI_DEAS_CALL_CENTRAL_IMAGE_PATH.'/phone-call.jpeg';
    
    private $api_url = 'https://callcentral.hideasng.com/api/phone/dialer.php?action=call';
    
    /**
     * Constructor
     *
     */
    public function __construct() {
        add_shortcode('Hi-Deas-Website-Dialer', [$this, 'initialize_shortcode']);
        add_action( 'init', [$this, 'register_scripts'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_action( 'wp_footer', [$this, 'embed_float_options']);
    }
    
    /**
     * Implement the shortcode
     *
     * @return false|string
     */
    public function initialize_shortcode() {
        $hash_key = get_option('HiDeasWebsiteDialerHashedKey');
        $extension = get_option('HiDeasWebsiteDialerExtension');
        $phone = get_option('HiDeasWebsiteDialerExtension');
        $image_url = get_option('HiDeasWebsiteDialerPhoneIconURL');
        $display_as = get_option('HiDeasWebsiteDialerDisplayAs', 'image');
        $phone_text = get_option('HiDeasWebsiteDialerPhoneText');
        
        if(empty($extension) || empty($phone) || empty($hash_key) || $display_as == 'floating') return '';
        
        if(empty($image_url) || !file_exists($image_url)) $image_url = $this->default_image_url;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
        
        $display = '<img src="'. $image_url .'" alt="" />';
        if($display_as == 'text') $display = $phone_text;
        
        ob_start();
        
        ?>
        <a href="javascript:void(0)" class="hi-deas-website-dialer-container"><?= $display; ?></a>
        <noscript><?= __('You need Javascript to use the previous link or use', 'hi-deas-website-dialer') ?>
          <a href="<?= $call_url; ?>" target="_blank" ><?= $display; ?></a>
        </noscript>
        <style>
          a.hi-deas-website-dialer-container {
              display: inline;
          }
          a.hi-deas-website-dialer-container img {
              height: auto;
              width: auto;
          }
        </style>

        <?php
        
        return ob_get_clean();
    }
    
    /**
     * Add this function to the wp_footer hook if floating display type is chosen
     *
     * @return string|void
     */
    public function embed_float_options() {
        $hash_key = get_option('HiDeasWebsiteDialerHashedKey');
        $extension = get_option('HiDeasWebsiteDialerExtension');
        $phone = get_option('HiDeasWebsiteDialerPhone');
        $image_url = get_option('HiDeasWebsiteDialerPhoneIconURL');
        $display_as = get_option('HiDeasWebsiteDialerDisplayAs', 'image');
    
        if(empty($extension) || empty($phone) || empty($hash_key) || $display_as !== 'floating') return '';
    
        if(empty($image_url) || !file_exists($image_url)) $image_url = $this->default_image_url;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
    
        $display = '<img src="'. $image_url .'" alt="" />';
    
        ob_start();
    
        ?>
      <a href="javascript:void(0)" class="hi-deas-website-dialer-container"><?= $display; ?></a>
      <noscript><?= __('You need Javascript to use the previous link or use', 'hi-deas-website-dialer') ?>
        <a href="<?= $call_url; ?>" target="_blank" ><?= $display; ?></a>
      </noscript>
      <style>
          a.hi-deas-website-dialer-container {
              position: fixed;
              bottom: 40px;
              z-index: 999999999;
              right: 20px;
              padding: 10px;
          }
          a.hi-deas-website-dialer-container img {
              height: 90px;
              width: 90px;
          }
      </style>
    
        <?php
    
        echo ob_get_clean();
    }
    
    
    /**
     * Register scripts before enqueueing
     *
     */
    public function register_scripts() {
        wp_register_script( 'hi-deas-website-dialer-js', HI_DEAS_CALL_CENTRAL_JS_PATH . '/hideas.js',['jquery'], HI_DEAS_WEBSITE_DIALER_VERSION_NUMBER, true );
    }
    
    /**
     * Enqueue and localize scripts
     *
     */
    public function enqueue_scripts() {
        $hash_key = get_option('HiDeasWebsiteDialerHashedKey');
        $extension = get_option('HiDeasWebsiteDialerExtension');
        $phone = get_option('HiDeasWebsiteDialerPhone');
        
        if(empty($extension) || empty($phone) || empty($hash_key)) return;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
        
        wp_enqueue_script( 'hi-deas-website-dialer-js' );
        wp_localize_script('hi-deas-website-dialer-js', 'hiDeasCallCentral', [
            'call_url'                  => $call_url,
        ]);
    }
    
    
    
    /**
     * @return Shortcode
     */
    public static function get_instance()
    {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}