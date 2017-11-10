<?php
namespace App\Controllers;

use Config;
use Core\Controller;
use App\Libs\Sanitize;
use App\Models\Track;

class Song extends Controller {
	public static function increase_counter() {
		parent::checkStatus();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json; charset=UTF-8');
			$data = json_decode(file_get_contents('php://input'), true);
			$response = array(
				'success' => true
			);

			$id_track = Sanitize::filter_int($data['idTrack']);

			if ($id_track !== NULL && (int) $id_track > 0) {
				$track = new Track;
				$track->id = $id_track;
				$response['success'] = $track->increase_counter();
			}

			echo json_encode($response);
			exit();
		}

		\App\Controllers\Error::error_404();
	}
}
