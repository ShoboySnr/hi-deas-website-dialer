<?php

namespace HideasLibrary\Core;

class Settings {
    
    public function __construct()
    {
        add_action('admin_menu', [$this, 'create_tools_submenu']);
        add_action( 'admin_init', [$this, 'register_settings'] );
    }
    
    public function create_tools_submenu() {
        add_submenu_page('options-general.php', 'Hideas Call Center Setup', 'Hideas Library', 'manage_options',  'hideas-library', [$this, 'hideas_call_cemter_tools_content']);
    }
    
    public function hideas_call_cemter_tools_content() {
       $extension = esc_attr(get_option('hideasCallCenterExtension'));
       $phone = esc_attr(get_option('hideasCallCenterPhone'));
       $hash_key = get_option('hideasCallCenterHashedKey');
       $image_url = get_option('hideasCallCenterPhoneIconURL');
        ?>
        <div class="wrap" id="hideas-call-center">
          <h1><?= __('Hideas Call Center Setup', 'hideas-library') ?></h1>
          <form action="options.php" method="post">
            <?php settings_fields( 'hideas-call-center-group' ); ?>
            <?php do_settings_sections( 'hideas-call-center-group' ); ?>
            <table class="form-table">
              <tr valign="center">
                <th scope="row"><?= __('Hash Key', 'hideas-library') ?></th>
                <td>
                  <h4><?= $hash_key ?></h4>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Shortcode', 'hideas-library') ?></th>
                <td>
                    <input type="text" name="hideasCallCenterShortcode" value="<?= Shortcode::get_instance()->shortcode ?>" readonly disabled />
                    <p class="description"><?= __('This is the shortcode you can copy and paste anywhere on your website', 'hideas-library') ?></p>
                </td>
              </tr>
              
              <tr valign="center">
                <th scope="row"><?= __('Extension', 'hideas-library') ?></th>
                <td>
                  <input type="text" name="hideasCallCenterExtension" value="<?= $extension ?>" required />
                  <p class="description"><?= __('Enter the Extension', 'hideas-library') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Phone', 'hideas-library') ?></th>
                <td>
                  <input type="text" name="hideasCallCenterPhone" value="<?= $phone ?>" required/>
                  <p class="description"><?= __('Enter the Phone', 'hideas-library') ?></p>
                </td>
              </tr>
              <tr valign="center">
                <th scope="row"><?= __('Phone Icon URL', 'hideas-library') ?></th>
                <td>
                  <input type="text" name="hideasCallCenterPhoneIconURL" value="<?= $image_url ?>" />
                  <p class="description"><?= __('If you want to replace the default phone icon, paste the image url here ', 'hideas-library') ?></p>
                </td>
              </tr>
            </table>
            <?php submit_button(); ?>
          </form>
        </div>
        <?php
    }
    
    public function register_settings() {
        register_setting( 'hideas-call-center-group', 'hideasCallCenterExtension', [$this, 'sanitize_fields']);
        register_setting( 'hideas-call-center-group', 'hideasCallCenterPhone', [$this, 'sanitize_fields']);
    }
    
    public function sanitize_fields($input) {
      return sanitize_text_field($input);
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