<?php
/**
 * Plugin Name: Hideas Library
 * Plugin URI:  https://hideasng.com
 * Description: Hideas Library for Internet Calls.
 * Author:      Damilare Shobowale
 * Author URI:  https://www.techwithdee.com
 * Text Domain: hideas-library
 * Version:     1.0.0
 *
 * @package Hideas_Library
 */
 
require __DIR__ . '/vendor/autoload.php';

define('HIDEAS_LIBRARY_SYSTEM_FILE_PATH', __FILE__);
define('HIDEAS_LIBRARY_VERSION_NUMBER', '1.0.0');

add_action( 'plugins_loaded', 'hideas_library_init', 11);

register_activation_hook(__FILE__, [\HideasLibrary\Base\Activation::get_instance(), 'hideaslibrary_generate_hash_key']);

function hideas_library_init() {
    \HideasLibrary\Init::init();
}