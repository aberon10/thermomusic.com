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
			\App\Libs\Session::checkSessionStatus();

			// Login with Facebook
	       	$fb = new \Facebook\Facebook([
	            'app_id'                => getenv('FB_ID_API'),
	            'app_secret'            => getenv('FB_SECRET_KEY'),
	            'default_graph_version' => getenv('FB_GRAPH_VERSION'),
	        ]);

            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['public_profile', 'email'];
            $redirect_url = 'http://thermomusic.com/user/login_with_facebook';
            $fb_url = $helper->getLoginUrl($redirect_url, $permissions);
            
            // Login with Google
            $google_client = new \Google_Client;
            $auth = new \App\Libs\GoogleAuth($google_client);
            $google_auth_url = $auth->getAuthUrl();

			View::setData('fb_url', $fb_url);
			View::setData('google_url', $google_auth_url);
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

