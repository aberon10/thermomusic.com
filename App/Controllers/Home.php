<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;

class Home extends Controller
{
	public static function index() {
		try {
			View::setData('title', getenv('APP_NAME').' | Home');
			View::render('sections/home');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function aboutus() {
		try {
			View::setData('title', getenv('APP_NAME').' | Empresa');
			View::render('sections/aboutus');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	

	public static function offers() {
		try {
			View::setData('title', getenv('APP_NAME').' | Ofertas');
			View::render('sections/offers');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function support() {
		try {
			View::setData('title', getenv('APP_NAME').' | Soporte');
			View::render('sections/support');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	

	public static function help() {
		try {
			View::setData('title', getenv('APP_NAME').' | Ayuda');
			View::render('sections/help');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	

	public static function login() {
		try {
			View::setData('title', getenv('APP_NAME').' | Iniciar sesión');
			View::render('sections/login');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}		

	public static function register() {
		try {
			View::setData('title', getenv('APP_NAME').' | Registrarse');
			View::render('sections/register');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	
}

