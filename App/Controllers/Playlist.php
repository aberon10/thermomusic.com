<?php
namespace App\Controllers;

use Config;
use Core\Controller;
use Core\View;
use App\Libs\Sanitize;
use App\Libs\Session;
use App\Models;
use App\Models\User as User;
use App\Models\UserPlaylist as UserPlaylist;
use App\Models\Track as Track;
use App\Models\TrackPlaylist as TrackPlaylist;
use App\Models\Favorite;

class Playlist extends Controller {
	public static function index() {
        try {
            parent::checkStatus(['csrf' => Session::get('csrf')]);
            View::setData('title', getenv('APP_NAME'));
            View::render('sections/user');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
	}

	private static function get_playlists() {
		parent::checkStatus();

		$user = new User;
        $user->user = Session::get('username');
        $user_data = $user->get_user_by_name();

		$playlist = new \App\Models\Playlist();
		$playlist->id_user = $user_data['id_usuario'];
		return $playlist->get_user_playlists();
	}

	private static function belong_playlist_to_user($id_playlist) {
		$playlists = Playlist::get_playlists();
		$count = count($playlists);
		$belongs = false;
		$i = 0;
		while ($i < $count && $belongs == false) {
			if ($playlists[$i]['id_lista'] == $id_playlist) {
				return true;
			}
			$i++;
		}
		return false;
	}

    public static function create() {
		parent::checkStatus();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-type: application/json;charset=utf-8');
            $data = json_decode(file_get_contents('php://input'), true);
            $response = array(
                'message' => 'Playlist creada con exito.',
                'success' => true
            );

            if (isset($data['playlistname'])) {
                if (strlen($data['playlistname']) <= 100) {
                    $playlistname = Sanitize::filter_special_chars($data['playlistname']);
                    $id_playlist = $data['idPlaylist'];

                    $user = new User;
                    $user->user = Session::get('username');
                    $user_data = $user->get_user_by_name();
                    $account = $user_data['id_tipo_usuario'];

                    $user_playlist = new \App\Models\UserPlaylist;
                    $user_playlist->id_user = $user_data['id_usuario'];
					$quantity_playlist_user = count($user_playlist->get_playlist_by_user());

					$playlist = new \App\Models\Playlist($playlistname, $user_data['id_usuario']);

					if ((int) $id_playlist > 0) {
						if (self::belong_playlist_to_user($id_playlist)) {
							$playlist->id = $id_playlist;
							if (!$playlist->update()) {
								$response['message'] = 'Ocurrio un error al crear la playlist';
								$response['success'] = false;
							} else {
								$response['message'] = 'Nombre actualizado con exito.';
							}
						} else {
							$response['message'] = 'Ocurrio un error al crear la playlist';
							$response['success'] = false;
						}
					} else {
						if (($account == Config\USER_FREE && $quantity_playlist_user == Config\MAX_PLAYLIST_FREE) ||
							($account == Config\USER_NO_REGISTER && $quantity_playlist_user == Config\MAX_PLAYLIST_NR)) {
							$response['success'] = false;
							$response['message'] = 'Lo sentimos, alcanzaste el máximo de playlist que puedes crear.';
						} else {
							$response['idPlaylist'] = $playlist->create();
							if (!$response['idPlaylist']) {
								$response['message'] = 'Ocurrio un error al crear la playlist';
								$response['success'] = false;
							}
						}
					}

                } else {
					$response['message'] = 'Utiliza como máximo 100 caracteres.';
					$response['success'] = false;
                }
            } else {
				$response['message'] = 'Por favor, ingresa un nombre para tu playlist.';
				$response['success'] = false;
			}

			echo json_encode($response);
			exit();
        }

        \App\Controllers\Error::error_404();
	}

	public static function get_user_playlists() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-type: application/json;charset=utf-8');
			$response = array('data' => null);
			$response['data'] = Playlist::get_playlists();

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	public static function get_content_playlist() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'data'     => [],
				'playlist' => null,
				'message'  => 'No hay datos disponibles.'
			);

			$user = new User;
            $user->user = Session::get('username');
			$user_data = $user->get_user_by_name();

			$favorite = new Favorite;
			$favorite->id_user = $user_data['id_usuario'];
			$response['favorites'] = $favorite->get_favorites_user();

			$id_playlist = Sanitize::filter_int($data['id']);

			if ($id_playlist !== NULL && (int) $id_playlist > 0 &&
				self::belong_playlist_to_user($id_playlist)) {

				$playlist = new \App\Models\Playlist;
				$playlist->id = $id_playlist;
				$response['data'] = $playlist->get_playlist_content();
				$response['playlist'] = $playlist->get_playlist_by_id();
				$response['playlist']['user'] = Session::get('username');
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	public static function add_track_to_playlist() {
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
            $account = $user->get_user_by_name()['id_tipo_usuario'];

			if (!empty($data)) {
				$id_playlist = $data['idPlaylist'] ? Sanitize::filter_int($data['idPlaylist']) : '';
				$id_track = $data['idTrack'] ? Sanitize::filter_int($data['idTrack']) : '';

				if (($id_playlist !== NULL && (int) $id_playlist > 0) && ($id_track !== NULL && (int) $id_track > 0)) {
					if (self::belong_playlist_to_user($id_playlist)) {
						// 1) Compruebo que la canción exista en la DB
						$track = new Track;
						$track->id = $id_track;

						if ($track->get_track_by_id()) {
							// 2) Comprobar que la pista NO SE ENCUENTRE en la playlist
							$track_playlist = new TrackPlaylist;
							$track_playlist->id_track = $id_track;
							$track_playlist->id_playlist = $id_playlist;

							if (!$track_playlist->in_playlist()) {
								// 3) Comprobar la cantidad de canciones presentes en la playlist no supere el máximo
								$playlist = new \App\Models\Playlist;
								$playlist->id = $id_playlist;

								$quantity_songs_in_playlist = count($playlist->get_playlist_content());
								if (($account == Config\USER_FREE && $quantity_songs_in_playlist == Config\MAX_TRACKS_FREE) ||
									($account == Config\USER_NO_REGISTER && $quantity_songs_in_playlist == Config\MAX_TRACKS_NO_REGISTER)) {
									$response['message'] = 'Lo sentimos, esta playlist alcanzo el número máximo de canciones.';
								} else {
									//  4) Agregar la pista.
									if ($track_playlist->add_track_to_playlist()) {
										$response['success'] = true;
										$response['message'] = 'Canción agregada con exito.';
									}
								}
							} else {
								$response['message'] = 'La canción ya se encuentra en la playlist.';
							}
						}
					}
				}
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	public static function delete() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'message' => 'Ocurrio un error.',
				'success' => false
			);

			$id_playlist = Sanitize::filter_int($data['id']);

			if ($id_playlist !== NULL && (int) $id_playlist > 0) {
				if (self::belong_playlist_to_user($id_playlist)) {
					$playlist = new \App\Models\Playlist;
					$playlist->id = $id_playlist;

					if ($playlist->delete()) {
						$response['message'] = 'Playlist eliminada con exito';
						$response['success'] = true;
					}
				}
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}

	public static function remove_song_to_playlist() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'message' => 'Ocurrio un error.',
				'success' => false
			);

			$id_track = Sanitize::filter_int($data['idTrack']);
			$id_playlist = Sanitize::filter_int($data['idPlaylist']);

			if (($id_playlist !== NULL && (int) $id_playlist > 0) &&
				$id_track !== NULL && (int) $id_track > 0) {
				if (self::belong_playlist_to_user($id_playlist)) {
					$track_playlist = new TrackPlaylist;
					$track_playlist->id_track = $id_track;
					$track_playlist->id_playlist = $id_playlist;

					if ($track_playlist->remove_song_to_playlist()) {
						$response['success'] = true;
					}
				}
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}
}
