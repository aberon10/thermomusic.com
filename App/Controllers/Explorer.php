<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Libs\Session;
use App\Libs\CsrfToken;
use App\Models\Genre;

class Explorer extends Controller
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

	public static function genres() {
		try {
			header('Content-Type: application/json;charset=utf8');
			$data = (array) json_decode(file_get_contents('php://input'));

			$response = array(
				'data' => null,
				'message' => 'No hay géneros disponibles.'
			);

			$genre = new Genre;
			$genres = $genre->getAll();
			$response['data'] = count($genres) > 0 ? $genres : null;
			echo json_encode($response, JSON_FORCE_OBJECT);
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}
}
