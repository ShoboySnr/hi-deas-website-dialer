<?php
/**
 * Plugin Name: Hi-Deas Call Central
 * Plugin URI:  https://hideasng.com
 * Description: Hi-Deas Call Central for Internet Calls.
 * Author:      Hi-Deas Call Central
 * Author URI:  https://www.hideasng.com
 * Text Domain: hi-deas-call-central
 * Version:     1.0.0
 *
 * @package Hideas_Library
 */
 
require __DIR__ . '/lib/autoload.php';

define('HI_DEAS_CALL_CENTRAL_SYSTEM_FILE_PATH', __FILE__);
define('HI_DEAS_CALL_CENTRAL_PLUGIN_URL', plugin_dir_url(HI_DEAS_CALL_CENTRAL_SYSTEM_FILE_PATH));
define('HI_DEAS_CALL_CENTRAL_VERSION_NUMBER', '1.0.0');

add_action( 'plugins_loaded', 'hi_deas_call_central_library_init', 11);

register_activation_hook(__FILE__, [\HiDeasCallCentral\Base\Activation::get_instance(), 'hi_deas_call_central_generate_hash_key']);

/**
 * function to run when the plugin is loaded
 *
 */
function hi_deas_call_central_library_init() {
    \HiDeasCallCentral\Init::init();
}