<?php

namespace Core;

class App
{
    public static function init() {
        $error = false;

        $url = explode('/', $_GET['url']);
        $controller = ucfirst($url[1]); 
        $method = $url[2] ?? 'index';
        $controller_path = CONTROLLERS_PATH.$controller.'.php';

        if (file_exists($controller_path)) {
            $method = empty($method) ? 'index' : $method;
            $controller = NAMESPACE_CONTROLLERS.$controller;
            
            if (method_exists("$controller", $method)) {
                $controller::{$method}();
            } else {
                $error = true;
            }

        } else {
            $error = true;
        }

        if ($error) {
            \App\Controllers\Error::error_404();
        }
    } 
}
