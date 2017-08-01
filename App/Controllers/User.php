<?php

namespace App\Controllers;

require APP_PATH.'/Libs/TplMails.php';

use \Config;
use \Core\View;
use \Core\Controller;
use \App\Models;
use \App\Libs\Validate;
use function \App\Libs\get_template_head;
use function \App\Libs\get_template_header;
use function \App\Libs\get_template_footer;
use function \App\Libs\get_template_welcome;

class User extends Controller
{
	public static function index() {
		try {
			// index
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
							$src_img = '/storage/app/public/avatars/'.$data['user'].'.jpg';
							$user_image = PROJECT_PATH.$src_img;

							if (copy($original_image, $user_image)) {

								$image_user = new \App\Models\ImageUser($id_user, $src_img);

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
}