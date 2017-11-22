<?php

namespace App\Controllers;

require APP_PATH.'/Libs/TplMails.php';
require APP_PATH.'/Utils/Utils.php';

use \Config;
use \Core\View;
use \Core\Controller;
use \App\Models;
use \App\Models\Advertising;
use \App\Libs\Validate;
use \App\Libs\FlashValue;
use \App\Libs\CsrfToken;
use \App\Libs\Session;
use \App\Libs\Sanitize;
use \App\Libs\ValidateCreditCard;
use function \App\Utils\days_in_month;
use function \App\Utils\compare_dates;
use function \App\Libs\get_template_head;
use function \App\Libs\get_template_header;
use function \App\Libs\get_template_footer;
use function \App\Libs\get_template_welcome;
use function \App\Libs\get_template_suscription;

class User extends Controller
{
	public static function index() {
		try {
			Session::set('csrf', CsrfToken::create());
			parent::checkStatus(['csrf' => Session::get('csrf')]);

			// get data user
			$user = new \App\Models\User;
			$user->user = trim(strtolower(Session::get('username')));
			$data_user = $user->get_user_by_name();

			Session::set('account', $data_user['id_tipo_usuario']);

			if ($data_user['id_tipo_usuario'] != Config\USER_PREMIUM) {
				$adv = new Advertising;
				$adv->type_advertising = Config\ADV_IMAGE;
				Session::set('adv', $adv->get());
			}

			View::setData('title', getenv('APP_NAME').' | Perfil');
			View::render('sections/user');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function register() {
		header('Content-type: application/json;charset=utf8');

		$data = json_decode(file_get_contents('php://input'), true);

		if (isset($data['requestPOST'])) {
			try {

				$response = array(
					'message'        => '<p>Registrado con éxito!</p><p>Comprueba tu cuenta de correo.</p>',
					'success'        => true,
					'user'           => true,
					'email'          => true,
					'password'       => true,
					'repeatPassword' => true,
					'date'           => true,
					'sex'            => true
				);

				// validate inputs
				$response['user'] = Validate::resolver(
					$data['user'],
					array(
						'require'  => 'Campo obligatorio',
						'username' => 'El nombre de usuario no es valido'
					)
				);

				// check if user exist
				if ($response['user']) {
					$user = new \App\Models\User;
					$user->user = $data['user'];
					$response['user'] = $user->checkIfUserExist();
				}

				$response['email'] = Validate::resolver(
					$data['email'],
					array(
						'require' => 'Campo obligatorio',
						'email'   => 'El correo ingresado no es valido'
					)
				);

				$response['date'] = Validate::resolver(
					$data['date'],
					array(
						'require' => 'Campo obligatorio',
						'date' 	  => 'La fecha no es valida'
					)
				);

				$response['password'] = Validate::resolver(
					$data['password'],
					array(
						'require'    => 'Campo Obligatorio',
						'min_length' => [8, 'Utilizá como mínimo 8 caracteres'],
						'max_length' => [30, 'Utilizá como máximo 30 caracteres']
					)
				);

				if (empty($data['repeatPassword'])) {
					$response['repeatPassword'] = 'Campo obligatorio';
				} else if ($data['repeatPassword'] !== $data['password']) {
					$response['repeatPassword'] = 'Las contraseñas con coinciden';
				}

				$response['sex'] = empty($data['sex']) ? 'Campo obligatorio.' : true;

				if ($response['user'] && $response['email'] && $response['password'] &&
					$response['repeatPassword'] && $response['date'] && $response['sex']) {

					$date = explode('-', $data['date']);

					$user = new \App\Models\User($data['user'], $data['password'], $data['email'],
						$date[2].'-'.$date[1].'-'.$date[0], $data['sex'], Config\USER_FREE);

					// create account
					if ($id_user = $user->createAccount()) {

						// register user in table pending_user
						$token = hash('sha1', (str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789').microtime()),false);
						$code = substr(str_shuffle('0123456789'), 0, 6);
						$pending_user = new \App\Models\PendingUser($token, $id_user, 'S');

						if (!$pending_user->addPendingAccount()) {
							$response['success'] = false;
							$response['message'] = 'Lo sentimos, ocurrio un error al registrar la cuenta.';
						} else {

							// avatar user
							$original_image = PROJECT_PATH.'/storage/app/public/avatars/user.jpg';
							$user_image = PROJECT_PATH.'/storage/app/public/avatars/'.$data['user'].'.jpg';

							if (copy($original_image, $user_image)) {

								$image_user = new \App\Models\ImageUser($id_user,
									getenv('APP_SRC_AVATAR_USER').$data['user'].'.jpg');

								if ($image_user->saveImage()) {

									// submit email
					                $to = $data['email'];
					                $name = $data['user'];
					                $subject = 'Bienvenido/a a '.getenv('APP_NAME');
					                $alt_message = 'Bienvenido/a a '.getenv('APP_NAME');
					                $link = 'http://thermomusic.com/home/login?token='.$token;

					                $content_head = get_template_head();
					                $content_header = get_template_header();
					                $content_body = get_template_welcome($name, $to, $link);
					                $content_footer = get_template_footer();
					                $content = $content_head.$content_header.$content_body.$content_footer;

					                $mail = new \App\Libs\Mail($to, $name, $subject, $content, $alt_message);

					                if (!$mail->send()) {
					                	$response['success'] = false;
										$response['message'] = '<p>Lo sentimos, ocurrio un error.</p>
										<p>Por favor, contacta a nuestro equipo de soporte para más ayuda.</p>';
					                }
								}
							}
						}
					} else {
						$response['success'] = false;
						$response['message'] = '<p>Lo sentimos, ocurrio un error al registrar la cuenta.</p>';
					}
				}
				echo json_encode($response, JSON_FORCE_OBJECT);
			} catch (\Exception $e) {
				die($e->getMessage());
			}
		} else {
			\App\Controllers\Error::error_404();
		}
	}

	public static function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// check validity of csrf token
			if (isset($_POST['csrf']) && CsrfToken::isEqual(Session::get('csrf'), $_POST['csrf'])) {
				if (isset($_POST['username']) && isset($_POST['password'])) {
					// old value input
					FlashValue::set('value_username', trim(strtolower($_POST['username'])));

					$error_username = Validate::resolver(strtolower($_POST['username']), [
						'require' => 'Por favor, ingresa tu nombre de usuario.'
					]);

					$error_password = Validate::resolver(strtolower($_POST['password']), [
						'require' => 'Por favor, ingresa tu contraseña.'
					]);

					if ($error_username !== true) {
						FlashValue::set('error_username', $error_username);
					}

					if ($error_password !== true) {
						FlashValue::set('error_password', $error_password);
					}

					if ($error_username === true && $error_password === true) {

						$user = new \App\Models\User;
						$user->user = trim(strtolower($_POST['username']));
						$user->password = trim($_POST['password']);

						// check user and password
						if (!$id_user = $user->login()) {
							FlashValue::set('error_login', 'El usuario y/o contraseña no coinciden.');
							header('location: /home/login');
							exit();
						} else {
							// check if is a pending account
							$pending_user = new \App\Models\PendingUser;
							$pending_user->id_user = $id_user;
							$data_pending_account = $pending_user->isPendingAccount();

							if ($data_pending_account['pending'] == 'S') {
								$token = trim(htmlspecialchars($_POST['_token'])) ?? '';

								if ($data_pending_account['token'] != $token) {
									FlashValue::set('error_login', 'Es necesario que validez tu cuenta de correo.');
									header('location: /home/login');
									exit();
								}
								$pending_user->validPendingAccount();
							}

							// get user image
							$image_user = new \App\Models\ImageUser;
							$image_user->id_user = $id_user;
							$src_img = $image_user->getImage();

							// create session user
							Session::destroy();
							Session::set('username', trim(strtolower($_POST['username'])));
							Session::set('src_img', getenv('APP_URL').'/'.$src_img);
							Session::set('timeout', time());
							Session::regenerateSession(true);

							FlashValue::delete('value_username');
							FlashValue::delete('error_username');
							FlashValue::delete('error_password');
							FlashValue::delete('error_login');

							header('location: /user/index');
							exit();
						}
					}
				}
			}
			header('location: /home/login');
			exit();
		}
		\App\Controllers\Error::error_404();
	}

	public static function login_with_facebook() {
		Session::checkSessionStatus();

		// Facebook
        $fb = new \Facebook\Facebook([
            'app_id'                => getenv('FB_ID_API'),
            'app_secret'            => getenv('FB_SECRET_KEY'),
            'default_graph_version' => getenv('FB_GRAPH_VERSION'),
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
            // Returns a `Facebook\FacebookResponse` object
            //$response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,picture', $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return false;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return false;
        }

        if (isset($accessToken)) {
        	// Returns a `Facebook\FacebookResponse` object
        	$response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,picture', $accessToken);
        	$data_user = $response->getGraphUser();

        	// check if account exist
        	$user = new \App\Models\User();
        	$user->id_facebook = $data_user['id'];

        	if ($user->checkIfUserExist(1) == true) {
        		// register account
        		$username = $data_user['email'] ?? $data_user['name'];
        		$username = strtolower(str_replace(' ', '.', $username));
	        	$user->user = $username;
	        	$user->email = $data_user['email'] ?? NULL;
	        	$user->sex = ($data_user['gender'] == 'male') ? 'M' : 'F';
	        	$user->name = $data_user['first_name'];
	        	$user->lastname = $data_user['last_name'];
	        	$user->id_type_user = Config\USER_FREE;
	        	$user->birthdate = NULL;
	        	$user->id_google = NULL;
	        	$user->password  = NULL;

	        	$id_user = $user->createAccount();

	        	$img_user = new \App\Models\ImageUser($id_user, $data_user['picture']['url']);
	        	$img_user->saveImage();
        	}

			Session::destroy();
			Session::set('username', $username);
			Session::set('src_img', $data_user['picture']['url']);
			Session::set('timeout', time());
			Session::regenerateSession(true);

			header('location: /user/index');
			exit;
        } else if ($helper->getError()) {
        	/*
			var_dump($helper->getError());
			var_dump($helper->getErrorCode());
			var_dump($helper->getErrorReason());
			var_dump($helper->getErrorDescription());
			exit;
        	*/

        }

        \App\Controllers\Error::error_404();
	}

	public static function login_with_google() {
		$google_client = new \Google_Client;
		$auth = new \App\Libs\GoogleAuth($google_client);

		if ($auth->checkRedirectCode()) {
			$data_user = $auth->getDataUser();
			$user = new \App\Models\User;
			$user->id_google = $data_user['sub'];

			if ($user->checkIfUserExist(2)) {
				$user->user = $data_user['email'];
				$user->email = $data_user['email'];
				$user->name = $data_user['given_name'];
				$user->lastname = $data_user['family_name'];
				$user->id_type_user = Config\USER_FREE;
				$user->birthdate = NULL;
				$user->sex = NULL;
				$user->password = NULL;
				$user->id_facebook = NULL;
				$id_user = $user->createAccount();

				$img_user = new \App\Models\ImageUser($id_user, $data_user['picture']);
				$img_user->saveImage();
			}

			Session::destroy();
			Session::set('username', $data_user['email']);
			Session::set('src_img', $data_user['picture']);
			Session::set('timeout', time());
			Session::regenerateSession(true);

			header('location: /user/index');
			exit();
		}

		header('location: /home/login');
		exit();
	}

	public static function logout() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['csrf']) &&
				CsrfToken::isEqual(Session::get('csrf'), $_POST['csrf']) &&
				Session::has('username')) {
				Session::destroy();
				header('location: /home/login');
				exit();
			}
		}
		\App\Controllers\Error::error_404();
	}

	public static function get_data() {
		parent::checkStatus();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-type: application/json;charset=utf8');
			try {
				$user = new \App\Models\User;
				$user->user = Session::get('username');
				$data_user = $user->get_user_by_name();

				echo json_encode(array(
					'data' => $data_user,
					'img' => Session::get('src_img')
				));
				exit();
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}
		\App\Controllers\Error::error_404();
	}

	public static function suscription() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json;charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'success' => true,
				'username' => '',
				'numberCard' => '',
				'securityCode' => '',
				'expirationDate' => '',
				'message' => '',
			);

			if (isset($data)) {
				$username = $data['user'] ?? '';
				$number_card = $data['numberCard'] ? Sanitize::filter_int($data['numberCard']) : '';
				$security_code = $data['securityCode'] ? Sanitize::filter_int($data['securityCode']) : '';
				$expiration_month = $data['expirationMonth'] ? Sanitize::filter_int($data['expirationMonth']) : '';
				$expiration_year = $data['expirationYear'] ? Sanitize::filter_int($data['expirationYear']) : '';

				if (empty($username)) {
					$response['username'] = 'Campo Requerido';
					$response['success'] = false;
				}

				if (empty($number_card) || !ValidateCreditCard::validateFormatCreditCard($number_card) ||
					!ValidateCreditCard::calculateLuhn($number_card)) {
					$response['numberCard'] = 'Por favor, ingrese un número de tarjeta valido.';
					$response['success'] = false;
				}

				if (empty($security_code) || !preg_match('/^([0-9]{3,4})$/', $security_code)) {
					$response['securityCode'] = 'Por favor, ingrese un código valido.';
					$response['success'] = false;
				}

				// fecha de vencimiento
				if (empty($expiration_month) || empty($expiration_year)) {
					$response['expirationDate'] = 'Campo Requerido';
					$response['success'] = false;
				} else {
					$expiration_date = days_in_month($expiration_month, $expiration_year).'-'.$expiration_month.'-'.$expiration_year;
					$current_date =  date('t').'-'.date('m').'-'.date('Y');

					if (compare_dates($current_date, $expiration_date) > 0) {
						$response['expirationDate'] = 'La fecha de vencimiento expiro.';
						$response['success'] = false;
					}
				}

				if ($response['success']) {
					// Compruebo si existe el usuario y si este no se encuentra suscripto.
					$user = new \App\Models\User;
					$user->user = $username;
					$data_user = $user->get_user_by_name();

					if (!empty($data_user)) {
						if ($data_user['id_tipo_usuario'] != Config\USER_PREMIUM) {
							$user->id = $data_user['id_usuario'];
							$user->id_type_user = Config\USER_PREMIUM;
							if ($user->update_account()) {

								$to = $data_user['correo'];
								$name = !empty($data_user['nombre']) ? $data_user['nombre'] : $username;
								$subject = 'Cuenta Premium';
								$alt_message = 'Hola, '. $name.' gracias por pasarte a Premium.';
								$link = 'http://thermomusic.com/home/login';

								$content_head = get_template_head();
								$content_header = get_template_header();
								$content_body = get_template_suscription($name, $link);
								$content_footer = get_template_footer();
								$content = $content_head.$content_header.$content_body.$content_footer;

								$mail = new \App\Libs\Mail($to, $name, $subject, $content, $alt_message);

								if (!$mail->send()) {
									$response['message'] = 'Lo sentimos, ocurrio un error. Contacta a nuestro equipo de soporte para más ayuda.';
									$response['success'] = false;
								} else {
									$response['message'] = 'Suscripción realizada con éxito.
											En caso que tengas una sesión activa, deberas iniciar una nueva para poder activar lo cambios.';
								}
							}
						} else {
							$response['username'] = 'El usuario ya se esta suscripto.';
							$response['success'] = false;
						}
					} else {
						$response['username'] = 'El usuario no existe.';
						$response['success'] = false;
					}
				}
			}

			echo json_encode($response, JSON_FORCE_OBJECT);
			exit();
		}

		\App\Controllers\Error::error_404();
	}
}
