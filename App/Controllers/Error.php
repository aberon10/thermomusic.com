<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;

class Error extends Controller
{
	public static function error_404() {
		try {
			header('Content-Type: text/html;charset=utf8');
        	header('HTTP/1.0 404 Not Found');
        	
			View::setData('message', 'Prueba');
			View::render('errors/404');	
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}
}