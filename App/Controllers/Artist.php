<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Libs\CsrfToken;
use App\Libs\Session;
use App\Libs\Sanitize;

class Artist extends Controller
{
	public static function index() {
        try {
			parent::checkStatus(['csrf' => Session::get('csrf')]);				
            View::setData('title', getenv('APP_NAME'));
            View::render('sections/user');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

	public static function get_artist_by_genre() {
		try {
			header('Content-Type: application/json;charset=utf8');
			$data = (array) json_decode(file_get_contents('php://input'));

			parent::checkStatus($data);

			$response = array(
				'data' => null,
				'message' => 'No hay artistas disponibles.'
			);
			
			$id_genre = Sanitize::filter_int($data['genre']);
			
			if ($id_genre !== NULL && (int) $id_genre > 0) {
				$artist = new \App\Models\Artist;
				$artist->id_genre = $id_genre;
				$artists = $artist->getArtistsByGenre();
				$result = array();
				if (count($artists) > 0) {
					$img_artist = new \App\Models\ImageArtist;
					foreach ($artists as $artist) {
						$img_artist->id_artist = $artist['id_artista'];
						array_push($result, array(
							'id_artista' => $artist['id_artista'],
							'nombre_artista' => $artist['nombre_artista'],
							'id_genero' => $artist['id_genero'],
							'nombre_genero' => $artist['nombre_genero'],
							'src_img' => $img_artist->getImageByArtist()
						));
					}
				}

				$response['data'] = count($result) > 0 ? $result : null;
			}

			echo json_encode($response, JSON_FORCE_OBJECT);
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}

	public static function content() {
		try {
			header('Content-Type: application/json;charset=utf8');
			$data = (array) json_decode(file_get_contents('php://input'));

			parent::checkStatus($data);

			$response = array(
				'data' => null,
				'message' => 'No hay contenido disponible.'
			);
			
			$id_artist = Sanitize::filter_int($data['artist']);

			if ($id_artist !== NULL && (int) $id_artist > 0) {
				// Recupero los datos del artista
				$artist = new \App\Models\Artist;
				$artist->id_artist = $id_artist;
				$data_artist = $artist->getArtistById();
				$result = array();
				if (count($data_artist) > 0) {
					// Recupero la imágen del artista
					$img_artist = new \App\Models\ImageArtist;
					$img_artist->id_artist = $id_artist;
					$image_artist = $img_artist->getImageByArtist();

					array_push($result, array(
						'id_artista'     => $data_artist['id_artista'],
						'nombre_artista' => $data_artist['nombre_artista'],
						'id_genero'      => $data_artist['id_genero'],
						'src_img'        => $image_artist ?? ''
					));

					// Recupero los albumes
					$album = new \App\Models\Album;
					$album->id_artist = $id_artist;
					$albums = $album->getAlbumByArtist();
					
					if (count($albums) > 0) {
						// Recupero la imágen del album
						$img_album = new \App\Models\ImageAlbum;
						foreach ($albums as $key => $album) {
							$img_album->id_album = $album['id_album'];
							$albums[$key]['image'] = $img_album->getImageByAlbum();
						}
						array_push($result, $albums);
					}

					// Recupero las canciones más escuchadas de un artista
					$most_played_tracks = $artist->getMostPlayedTrackByArtist();
					if (count($most_played_tracks) > 0) {
						array_push($result, $most_played_tracks);
					}
				}

				$response['data'] = count($result) > 0 ? $result : null;
			}

			echo json_encode($response, JSON_FORCE_OBJECT);
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}
}