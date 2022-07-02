<?php
/**
 * Plugin Name: Hi-Deas Call Central
 * Plugin URI:  https://hideasng.com
 * Description: Hi-Deas Call Central for Internet Calls.
 * Author:      Damilare Shobowale
 * Author URI:  https://www.techwithdee.com
 * Text Domain: hideas-library
 * Version:     1.0.0
 *
 * @package Hideas_Library
 */
 
require __DIR__ . '/lib/autoload.php';

define('HI_DEAS_CALL_CENTRAL_SYSTEM_FILE_PATH', __FILE__);
define('HI_DEAS_CALL_CENTRAL_PLUGIN_URL', plugin_dir_url(HI_DEAS_CALL_CENTRAL_SYSTEM_FILE_PATH));
define('HI_DEAS_CALL_CENTRAL_VERSION_NUMBER', '1.0.0');

add_action( 'plugins_loaded', 'hideas_library_init', 11);

register_activation_hook(__FILE__, [\HiDeasCallCentral\Base\Activation::get_instance(), 'hideaslibrary_generate_hash_key']);

function hideas_library_init() {
    \HiDeasCallCentral\Init::init();
}