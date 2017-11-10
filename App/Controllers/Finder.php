<?php

namespace App\Controllers;

use Core\Controller;
use App\Libs\CsrfToken;
use App\Libs\Session;
use App\Libs\Sanitize;
use App\Models;

class Finder extends Controller {
	public static function index() {
		parent::checkStatus();

		$filters = array(
			'genre' => '/^genre:(?P<genre>[A-Za-z0-9-ÁÉÍÓÚÑáéíóúñ._\-]+)(?P<artist>\s[A-Za-z0-9-ÁÉÍÓÚÑáéíóúñ._\-\s]+)?$/'
		);

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'data' => null,
				'message' => 'No hay coincidencias.'
			);

			$response['search'] = trim($data['searchedWord']);
			$response['entitie'] = $data['entitie'] ?? null;

			$user = new \App\Models\User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();
			$account = $user_data['id_tipo_usuario'];

			$searched_word = trim($data['searchedWord']);
			$searched_word = strlen($searched_word) > 150 ? substr($searched_word, 0, 150) : $searched_word;
			$finder = new \App\Models\Finder;
			$finder->filter = null;
			$finder->entitie = $data['entitie'] ?? null;

			// Compruebar si se trata de una búsqueda avanzada
			if (preg_match($filters['genre'], $searched_word, $matches)) {
				$finder->filter = 'genre';
				$finder->filter_value = trim($matches['genre']);
				$finder->searched_word = array_key_exists('artist', $matches) ? trim($matches['artist']) : '';
			} else {
				$finder->searched_word = trim($searched_word);
			}

			$finder->year = ($account == \Config\USER_PREMIUM) ? date('Y') : date('Y') - 1;
			$response['data'] = $finder->find();

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}
}
