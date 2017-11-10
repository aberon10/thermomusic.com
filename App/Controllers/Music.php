<?php

namespace App\Controllers;

use Config;
use Core\View;
use Core\Controller;
use App\Libs\Sanitize;
use App\Libs\Session;
use App\Libs\CsrfToken;
use App\Models\Track;
use App\Models\User;
use App\Models\Favorite;

class Music extends Controller {
    public static function index() {
        try {
            parent::checkStatus(['csrf' => Session::get('csrf')]);
            View::setData('title', getenv('APP_NAME'));
            View::render('sections/user');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
	}

	public static function add_remove_track_to_favorites() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'message' => 'Ocurrio un error al agregar la canción.',
				'success' => false
			);

			$user = new User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();
			$id_user = $user_data['id_usuario'];
			$account = $user_data['id_tipo_usuario'];

			$id_track = $data['id'] ? Sanitize::filter_int($data['id']) : '';

			if ($id_track !== NULL && (int) $id_track > 0) {
				$track = new Track;
				$track->id = $id_track;

				// 1) Compruebo que la canción exista en la DB
				if ($track->get_track_by_id()) {

					$favorite = new Favorite($user_data['id_usuario'], $id_track);

					// 2) Compruebo que la canción NO SE encuentra en favoritos
					if (!$favorite->in_favorites()) {
						// 3) comprobar que no supere el limite admitido por la cuenta
						$quantity_songs_in_favorites = count($favorite->get_favorites_user());

						if (($account == Config\USER_FREE && $quantity_songs_in_favorites == Config\MAX_TRACKS_FAVORITE_FREE) ||
							($account == Config\USER_NO_REGISTER && $quantity_songs_in_favorites == Config\MAX_TRACKS_FAVORITE_NR)) {
							$response['message'] = 'Lo sentimos, alcanzaste el número máximo de canciones.';
						} else {

							//  4) Agregar la pista a favoritos.
							if ($favorite->add_track_to_favorites()) {
								$response['success'] = true;
								$response['message'] = 'Canción agregada con exito.';
							}
						}
					} else {
						// Si la canción se encuetra la quito
						if ($favorite->remove_track_to_favorites()) {
							$response['success'] = true;
							$response['message'] = 'La canción a sido quita de tus favoritos.';
						}
					}
				}
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	public static function in_favorites() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'message' => 'Ocurrio un error al agregar la canción.',
				'success' => false,
				'favorite' => false
			);

			$user = new User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();

			$id_track = $data['id'] ? Sanitize::filter_int($data['id']) : '';

			if ($id_track !== NULL && (int) $id_track > 0)  {
				$favorite = new Favorite($user_data['id_usuario'], $id_track);
				$response['favorite'] = $favorite->in_favorites();
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	// TODO:
	// LISTAR FAVORITAS EN LA SECCIÓN /music/favorites
	public static function favorites() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$response = array();

			$user = new User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();

			$favorite = new Favorite;
			$favorite->id_user = $user_data['id_usuario'];
			$response['data'] = $favorite->get_favorites_user();

			echo json_encode($response);
			exit();
		} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			try {
            	View::setData('title', getenv('APP_NAME'));
				View::render('sections/user');
				exit();
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}

		\App\Controllers\Error::error_404();
	}

	public static function top() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$response = array();

			// Top 10
			$track = new Track;
			$response['data'] = $track->get_the_most_popular();

			$user = new User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();

			// Favorites
			$favorite = new Favorite();
			$favorite->id_user = $user_data['id_usuario'];
			$response['favorites'] = $favorite->get_favorites_user();

			echo json_encode($response);
			exit();
		} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			try {
            	View::setData('title', getenv('APP_NAME'));
				View::render('sections/user');
				exit();
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}
		\App\Controllers\Error::error_404();
	}

}
