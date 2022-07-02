<?php

namespace HideasLibrary\Core;

class Settings {
    
    public function __construct()
    {
        add_action('admin_menu', [$this, 'create_tools_submenu']);
        add_action( 'admin_init', [$this, 'register_settings'] );
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
    }
    
    public function create_tools_submenu() {
        add_submenu_page('options-general.php', 'Hi-Deas Call Central', 'Hi-Deas Call Central', 'manage_options',  'hi-deas-call-central', [$this, 'hideas_call_central_tools_content']);
    }
    
    public function hideas_call_central_tools_content() {
       $extension = esc_attr(get_option('hideasCallCentralExtension'));
       $phone = esc_attr(get_option('hideasCallCentralPhone'));
       $hash_key = get_option('hideasCallCenterHashedKey');
       $image_url = get_option('hideasCallCentralPhoneIconURL');
       $display_as = esc_attr(get_option('hideasCallCenterDisplayAs', 'image'));
       $phone_text = esc_attr(get_option('hideasCallCentralPhoneText', 'Call Us'));
        ?>
        <div class="wrap" id="hideas-call-center">
          <h1><?= __('Hi-Deas Call Central', 'hi-deas-call-central') ?></h1>
          <form action="options.php" method="post">
            <?php settings_fields( 'hideas-call-center-group' ); ?>
            <?php do_settings_sections( 'hideas-call-center-group' ); ?>
            <table class="form-table">
              <tr valign="center">
                <th scope="row"><?= __('Shortcode', 'hi-deas-call-central') ?></th>
                <td>
                    <input type="text" name="hideasCallCenterShortcode" value="<?= Shortcode::get_instance()->shortcode ?>" class="regular-text" readonly disabled />
                    <p class="description"><?= __('This is the shortcode you can copy and paste anywhere on your website', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
              
              <tr valign="center">
                <th scope="row"><?= __('Extension', 'hi-deas-call-central') ?></th>
                <td>
                  <input type="text" name="hideasCallCentralExtension" value="<?= $extension ?>" class="regular-text" required />
                  <p class="description"><?= __('Enter the Extension', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Phone', 'hi-deas-call-central') ?></th>
                <td>
                  <input type="text" name="hideasCallCentralPhone" value="<?= $phone ?>" class="regular-text" required/>
                  <p class="description"><?= __('Enter the Phone', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Hash Key', 'hi-deas-call-central') ?></th>
                <td>
                  <h4><?= $hash_key ?></h4>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Display as', 'hi-deas-call-central') ?></th>
                <td>
                  <select name="hideasCallCenterDisplayAs">
                    <option value="image" <?php selected('image', $display_as); ?>><?= __('Image', 'hi-deas-call-central') ?></option>
                    <option value="text" <?php selected('text', $display_as); ?>><?= __('Text', 'hi-deas-call-central') ?></option>
                  </select>
                  <p class="description"><?= __('Choose how to display the widget.', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
              <tr valign="center" id="hideasCallCentralPhoneIconURLSelection" style="display: none">
                <th scope="row"><?= __('Phone Icon URL', 'hi-deas-call-central') ?></th>
                <td>
                  <input type="url" name="hideasCallCentralPhoneIconURL" value="<?= $image_url ?>" class="regular-text" />
                  <p class="description"><?= __('Paste Image path to display if any', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
              <tr valign="center" id="hideasCallCentralPhoneTextSelection" style="display: none">
                <th scope="row"><?= __('Phone Text', 'hi-deas-call-central') ?></th>
                <td>
                  <input type="text" name="hideasCallCentralPhoneText" value="<?= $phone_text ?>" class="regular-text" />
                  <p class="description"><?= __('Text to display', 'hi-deas-call-central') ?></p>
                </td>
              </tr>
            </table>
            <?php submit_button(); ?>
            <p>For account activation and support, contact <a href="mailto:info@hideasng.com" title="Contact us">info@hideasng.com</a> or call <strong>09084426102</strong><br/>
            Visit <a href="https://hideasng.com/dialer" target="_blank" title="Visit our website">hideasng.com/dialer</a> to learn more.</p>
          </form>
        </div>
        <?php
    }
    
    public function register_settings() {
        register_setting( 'hideas-call-center-group', 'hideasCallCentralExtension', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'hideasCallCentralPhone', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'hideasCallCentralPhoneIconURL', [$this, 'sanitize_url_fields']);
        register_setting( 'hideas-call-center-group', 'hideasCallCenterDisplayAs', [$this, 'sanitize_text_fields']);
        register_setting( 'hideas-call-center-group', 'hideasCallCentralPhoneText', [$this, 'sanitize_text_fields']);
    }
    
    public function sanitize_text_fields($input) {
      return sanitize_text_field($input);
    }
    
    public function sanitize_url_fields($input) {
        return sanitize_url($input);
    }
    
    public function enqueue_scripts() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'settings_page_hi-deas-call-central') !== false) {
            wp_enqueue_script( 'hi-deas-call-central-admin-js', HI_DEAS_CALL_CENTRAL_JS_PATH . '/admin.js',['jquery'], HI_DEAS_CALL_CENTRAL_VERSION_NUMBER, true );
        }
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