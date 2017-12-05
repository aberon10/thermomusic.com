<?php

namespace App\Controllers;

require APP_PATH.'/Libs/TplMails.php';

use Core\View;
use Core\Controller;
use App\Libs\Sanitize;
use App\Libs\Validate;
use function \App\Libs\get_template_head;
use function \App\Libs\get_template_header;
use function \App\Libs\get_template_footer;
use function \App\Libs\get_template_support;

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
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			try {
				View::setData('title', getenv('APP_NAME').' | Soporte');
				View::render('sections/support');
				exit();
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json;charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array();

			if (!empty($data)) {
				// validate inputs
				$response['email'] = Validate::resolver(
					$data['email'],
					array(
						'require'  => 'Campo obligatorio',
						'username' => 'El correo ingresado no es valido.'
					)
				);

				$response['name'] = Validate::resolver($data['name'], array('require'  => 'Campo obligatorio'));
				$response['subject'] = Validate::resolver($data['subject'], array('require'  => 'Campo obligatorio'));
				$response['message'] = Validate::resolver(
					$data['message'],
					array(
						'require'  => 'Campo obligatorio',
						'max_length' => [255, 'Utilizá como máximo 255 caracteres']
					)
				);

				if (array_filter($response) != $response) {
					$response['success'] = false;
				} else {

					$to = htmlentities($data['email'], ENT_QUOTES);
					$name = htmlentities($data['name'], ENT_QUOTES);
					$message = htmlentities($data['message'], ENT_QUOTES);
					$subject = htmlentities($data['subject'], ENT_QUOTES);
					$alt_message = 'ThermoMusic - Soporte Técnico';

					$content_head = get_template_head();
					$content_header = get_template_header();
					$content_body = get_template_support($name, $to, $message);
					$content_footer = get_template_footer();
					$content = $content_head.$content_header.$content_body.$content_footer;

					$mail = new \App\Libs\Mail(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'), $subject, $content, $alt_message);

					if (!$mail->send()) {
						$response['msg'] = 'Lo sentimos, ocurrio un error al enviar el correo. Intenta más tarde.';
					} else {
						$response['msg'] = 'Mensaje enviado con éxito. A la brevedad nos pondremos en contacto. Gracias!';
						$response['success'] = true;
					}
				}
			}

			echo json_encode($response);
			exit();
		}
		\App\Controllers\Error::error_404();
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

