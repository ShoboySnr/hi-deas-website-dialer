<?php

namespace HideasLibrary\Core;

class Shortcode {
    
    public $shortcode = '[hideas-call-center]';
    
    public function __construct() {
    
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