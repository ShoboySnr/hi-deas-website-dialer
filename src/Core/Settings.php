<?php

namespace HiDeasWebsiteDialer\Core;

class Settings {
    
    public function __construct()
    {
        $basename = plugin_basename(HI_DEAS_WEBSITE_DIALER_SYSTEM_FILE_PATH);
        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_action('admin_menu', [$this, 'create_tools_submenu']);
        add_action( 'admin_init', [$this, 'register_settings'] );
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_filter("{$prefix}plugin_action_links_$basename", [$this, 'add_settings_link'], 10, 4);
    }
    
    /**
     * Create a sub menu under settings
     */
    public function create_tools_submenu() {
        add_submenu_page('options-general.php', 'Hi-Deas Website Dialer', 'Hi-Deas Website Dialer', 'manage_options',  'hi-deas-website-dialer', [$this, 'hideas_call_central_tools_content']);
    }
    
    /**
     * Render the content for the settings page
     */
    public function hideas_call_central_tools_content() {
       $extension = esc_attr(get_option('HiDeasWebsiteDialerExtension'));
       $phone = esc_attr(get_option('HiDeasWebsiteDialerPhone'));
       $hash_key = get_option('HiDeasWebsiteDialerHashedKey');
       $image_url = get_option('HiDeasWebsiteDialerPhoneIconURL');
       $display_as = esc_attr(get_option('HiDeasWebsiteDialerDisplayAs', 'image'));
       $phone_text = esc_attr(get_option('HiDeasWebsiteDialerPhoneText', 'Call Us'));
        ?>
        <div class="wrap" id="hideas-call-center">
          <h1><?= __('Hi-Deas Website Dialer', 'hi-deas-website-dialer') ?></h1>
          <form action="options.php" method="post">
            <?php settings_fields( 'hideas-call-center-group' ); ?>
            <?php do_settings_sections( 'hideas-call-center-group' ); ?>
            <table class="form-table">
              <tr valign="center">
                <th scope="row"><?= __('Shortcode', 'hi-deas-website-dialer') ?></th>
                <td>
                    <input type="text" name="HiDeasWebsiteDialerShortcode" value="<?= Shortcode::get_instance()->shortcode ?>" class="regular-text" readonly disabled />
                    <p class="description"><?= __('This is the shortcode you can copy and paste anywhere on your website', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
              
              <tr valign="center">
                <th scope="row"><?= __('Extension', 'hi-deas-website-dialer') ?></th>
                <td>
                  <input type="text" name="HiDeasWebsiteDialerExtension" value="<?= $extension ?>" class="regular-text" required />
                  <p class="description"><?= __('Enter the Extension', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Phone', 'hi-deas-website-dialer') ?></th>
                <td>
                  <input type="text" name="HiDeasWebsiteDialerPhone" value="<?= $phone ?>" class="regular-text" required/>
                  <p class="description"><?= __('Enter the Phone', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Hash Key', 'hi-deas-website-dialer') ?></th>
                <td>
                  <h4><?= $hash_key ?></h4>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Display as', 'hi-deas-website-dialer') ?></th>
                <td>
                  <select name="HiDeasWebsiteDialerDisplayAs" required>
                    <option value="image" <?php selected('image', $display_as); ?>><?= __('Image', 'hi-deas-website-dialer') ?></option>
                    <option value="text" <?php selected('text', $display_as); ?>><?= __('Text', 'hi-deas-website-dialer') ?></option>
                    <option value="floating" <?php selected('floating', $display_as); ?>><?= __('Floating', 'hi-deas-website-dialer') ?></option>
                  </select>
                  <p class="description"><?= __('Choose how to display the widget.', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
              <tr valign="center" id="HiDeasWebsiteDialerPhoneIconURLSelection" style="display: none">
                <th scope="row"><?= __('Phone Icon URL', 'hi-deas-website-dialer') ?></th>
                <td>
                  <input type="url" name="HiDeasWebsiteDialerPhoneIconURL" value="<?= $image_url ?>" class="regular-text" />
                  <p class="description"><?= __('Paste Image path to display if any', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
              <tr valign="center" id="HiDeasWebsiteDialerPhoneTextSelection" style="display: none">
                <th scope="row"><?= __('Phone Text', 'hi-deas-website-dialer') ?></th>
                <td>
                  <input type="text" name="HiDeasWebsiteDialerPhoneText" value="<?= $phone_text ?>" class="regular-text" />
                  <p class="description"><?= __('Text to display', 'hi-deas-website-dialer') ?></p>
                </td>
              </tr>
            </table>
            <?php submit_button(); ?>
            <p>For account activation and support, contact <a href="mailto:info@hideasng.com" title="Contact us">info@hideasng.com</a> or call <strong>09084426102</strong><br/>
            Visit <a href="https://www.hideasng.com/dialer" target="_blank" title="Visit our website">www.hideasng.com/dialer</a> to learn more.</p>
          </form>
        </div>
        <?php
    }
    
    /**
     * Register settings
     *
     */
    public function register_settings() {
        register_setting( 'hideas-call-center-group', 'HiDeasWebsiteDialerExtension', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'HiDeasWebsiteDialerPhone', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'HiDeasWebsiteDialerPhoneIconURL', [$this, 'sanitize_url_fields']);
        register_setting( 'hideas-call-center-group', 'HiDeasWebsiteDialerDisplayAs', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'HiDeasWebsiteDialerPhoneText', [$this, 'sanitize_text_fields']);
    }
    
    /**
     * Sanitize fields input
     *
     * @param $input
     * @return string
     */
    public function sanitize_text_fields($input) {
      return sanitize_text_field($input);
    }
    
    /**
     * Sanitize URL
     *
     * @param $input
     * @return string|null
     */
    public function sanitize_url_fields($input) {
        return sanitize_url($input);
    }
    
    /**
     * Enqueue scripts
     *
     */
    public function enqueue_scripts() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'settings_page_hi-deas-website-dialer') !== false) {
            wp_enqueue_script( 'hi-deas-website-dialer-admin-js', HI_DEAS_CALL_CENTRAL_JS_PATH . '/admin.js',['jquery'], HI_DEAS_WEBSITE_DIALER_VERSION_NUMBER, true );
        }
    }
    
    /**
     * Add link to settings in plugin actions
     *
     * @param $actions
     * @param $plugin_file
     * @param $plugin_data
     * @param $context
     * @return array
     */
    public function add_settings_link($actions, $plugin_file, $plugin_data, $context) {
      $url = menu_page_url('hi-deas-website-dialer', false);
    
        $custom_actions = array(
            'hi-deas-website-dialer_settings' => sprintf('<a href="%s">%s</a>', $url, __('Settings', 'hi-deas-website-dialer')),
        );
    
        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }
    
    
    /**
     * @return Settings
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