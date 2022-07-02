<?php

namespace HiDeasCallCentral\Core;

class Shortcode {
    
    public $shortcode = '[hi-deas-call-central]';
    
    private $default_image_url = HI_DEAS_CALL_CENTRAL_IMAGE_PATH.'/phone-call.png';
    
    private $api_url = 'https://callcentral.hideasng.com/api/phone/dialer.php?action=call';
    
    /**
     * Constructor
     *
     */
    public function __construct() {
        add_shortcode('hi-deas-call-central', [$this, 'initialize_shortcode']);
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
        $hash_key = get_option('hideasCallCenterHashedKey');
        $extension = get_option('hideasCallCentralExtension');
        $phone = get_option('hideasCallCentralExtension');
        $image_url = get_option('hideasCallCentralPhoneIconURL');
        $display_as = get_option('hideasCallCenterDisplayAs', 'image');
        $phone_text = get_option('hideasCallCentralPhoneText');
        
        if(empty($extension) || empty($phone) || empty($hash_key) || $display_as == 'floating') return '';
        
        if(empty($image_url)) $image_url = $this->default_image_url;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
        
        $display = '<img src="'. $image_url .'" alt="" />';
        if($display_as == 'text') $display = $phone_text;
        
        ob_start();
        
        ?>
        <a href="javascript:void(0)" class="hi-deas-call-central-container"><?= $display; ?></a>
        <noscript><?= __('You need Javascript to use the previous link or use', 'hi-deas-call-central') ?>
          <a href="<?= $call_url; ?>" target="_blank" ><?= $display; ?></a>
        </noscript>
        <style>
          a.hi-deas-call-central-container {
              display: inline;
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
        $hash_key = get_option('hideasCallCenterHashedKey');
        $extension = get_option('hideasCallCentralExtension');
        $phone = get_option('hideasCallCentralExtension');
        $image_url = get_option('hideasCallCentralPhoneIconURL');
        $display_as = get_option('hideasCallCenterDisplayAs', 'image');
    
        if(empty($extension) || empty($phone) || empty($hash_key) || $display_as !== 'floating') return '';
    
        if(empty($image_url)) $image_url = $this->default_image_url;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
    
        $display = '<img src="'. $image_url .'" alt="" />';
    
        ob_start();
    
        ?>
      <a href="javascript:void(0)" class="hi-deas-call-central-container"><?= $display; ?></a>
      <noscript><?= __('You need Javascript to use the previous link or use', 'hi-deas-call-central') ?>
        <a href="<?= $call_url; ?>" target="_blank" ><?= $display; ?></a>
      </noscript>
      <style>
          a.hi-deas-call-central-container {
              position: fixed;
              bottom: 40px;
              z-index: 999999999;
              right: 20px;
              background-color: #ffffff;
              padding: 10px;
              border-radius: 50%;
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
        wp_register_script( 'hi-deas-call-central-js', HI_DEAS_CALL_CENTRAL_JS_PATH . '/hideas.js',['jquery'], HI_DEAS_CALL_CENTRAL_VERSION_NUMBER, true );
    }
    
    /**
     * Enqueue and localize scripts
     *
     */
    public function enqueue_scripts() {
        $hash_key = get_option('hideasCallCenterHashedKey');
        $extension = get_option('hideasCallCentralExtension');
        $phone = get_option('hideasCallCentralExtension');
        
        if(empty($extension) || empty($phone) || empty($hash_key)) return;
    
        $call_url = add_query_arg(['hash' => $hash_key, 'extension' => $extension, 'phone' => $phone], $this->api_url);
        
        wp_enqueue_script( 'hi-deas-call-central-js' );
        wp_localize_script('hi-deas-call-central-js', 'hiDeasCallCentral', [
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