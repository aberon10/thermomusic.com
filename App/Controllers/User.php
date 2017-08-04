<?php

namespace App\Controllers;

require APP_PATH.'/Libs/TplMails.php';

use \Config;
use \Core\View;
use \Core\Controller;
use \App\Models;
use \App\Libs\Validate;
use \App\Libs\FlashValue;
use \App\Libs\CsrfToken;
use \App\Libs\Session;
use function \App\Libs\get_template_head;
use function \App\Libs\get_template_header;
use function \App\Libs\get_template_footer;
use function \App\Libs\get_template_welcome;

class User extends Controller
{
	public static function index() {
		try {
			if (!Session::get('username')) {
				header('location: /home/login');
				exit();
			}
			Session::checkTimeout();
			View::setData('title', getenv('APP_NAME').' | Perfil');
			View::render('sections/user');				
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function register() {
		header('Content-type: applicattion/json;charset=utf8');
		
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
					$response['user'] = $user->checkIfUserExists();
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
							
							FlashValue::delete('value_username');
							FlashValue::delete('error_username');
							FlashValue::delete('error_password');
							FlashValue::delete('error_login');

							// create session user
							Session::destroy();
							Session::set('username', trim(strtolower($_POST['username'])));
							Session::set('src_img', $src_img);
							Session::set('timeout', time());
							Session::regenerateSession(true);							

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
} 