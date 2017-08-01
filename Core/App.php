<?php

namespace Core;

class App
{
    public static function init() {
        $url = explode('/', $_GET['url']);
        $controller = ucfirst($url[1]); 
        $method = $url[2] ?? 'index';
        $controller_path = CONTROLLERS_PATH.$controller.'.php';

        if (file_exists($controller_path)) {

            $method = empty($method) ? 'index' : $method;
            $controller = '\App\Controllers\\'.$controller;

            if (method_exists($controller, $method)) {
                $controller::{$method}();
            } else {
                \App\Controllers\Error::error_404();
            }
            
        } else {
            \App\Controllers\Error::error_404();
        }
    } 
}
