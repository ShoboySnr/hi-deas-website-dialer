<?php

namespace HideasLibrary\Base;

class Activation {
    
    public static function hideaslibrary_generate_hash_key() {
        self::get_instance()->save_hash_key();
        flush_rewrite_rules();
    }
    
    public function save_hash_key() {
        $saved_hash_key = get_option('hideasCallCenterHashedKey');
        if(empty($saved_hash_key)) {
            $generate_hash = self::get_instance()->generate_random();
            update_option('hideasCallCenterHashedKey', $generate_hash);
        }
    }
    
    
    public function generate_random($length = 64) {
        $random = '';
        srand( (double) microtime() * 1000000);
        $char_list = 'abcdefghijklmnopqrstuvwxyz';
        $char_list .= '1234567890';
        
        for($i = 0; $i < $length; $i++)
        {
            $random .= substr($char_list,(rand()%(strlen($char_list))), 1);
        }
        
        return $random.time();
    }
    
    
    /**
     * @return Activation
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