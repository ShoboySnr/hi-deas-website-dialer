<?php

namespace HideasLibrary\Core;

class Init {
    
    public static function init_menu_types() {
        Settings::get_instance();
        Shortcode::get_instance();
    }
}