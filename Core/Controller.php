<?php

namespace Core;

class Controller
{   
    /**
     * __call 
     * @param  string $method 
     * @param  string $args   
     * @return void
     */
    public function __call($method, $args = NULL) {
        require VIEW_PATH.'/errors/404.php';
        exit;
    }
    
    /**
     * __callStatic 
     * @param  string $method 
     * @param  string $args   
     * @return void
     */
    public static function __callStatic($method, $args = NULL) {
        require VIEW_PATH.'/errors/404.php';
        exit;
    }
}