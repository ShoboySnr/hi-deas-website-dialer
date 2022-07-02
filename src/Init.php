<?php

namespace HideasLibrary;

define('HI_DEAS_CALL_CENTRAL_IMAGE_PATH', HI_DEAS_CALL_CENTRAL_PLUGIN_URL.'assets/images');
define('HI_DEAS_CALL_CENTRAL_JS_PATH', HI_DEAS_CALL_CENTRAL_PLUGIN_URL.'assets/js');

class Init {
    
    public static function init() {
        \HideasLibrary\Core\Init::init_menu_types();
    }
}