<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;

class Home extends Controller
{
	public static function index() {
		View::setData('title', APP_NAME.' | Home');
		try {
			View::render('sections/home');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function aboutus() {
		View::setData('title', APP_NAME.' | Empresa');
		try {
			View::render('sections/aboutus');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	

	public static function offers() {
		View::setData('title', APP_NAME.' | Ofertas');
		try {
			View::render('sections/offers');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function support() {
		View::setData('title', APP_NAME.' | Soporte');
		try {
			View::render('sections/support');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	

	public static function help() {
		View::setData('title', APP_NAME.' | Ayuda');
		try {
			View::render('sections/help');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}	
}

