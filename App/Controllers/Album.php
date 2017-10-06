<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Libs\Session;
use App\Libs\CsrfToken;
use App\Libs\Sanitize;

class Album extends Controller
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

    public static function content() {
    	try {
    		header('Content-Type: application/json;charset=utf8');
			$data = (array) json_decode(file_get_contents('php://input'));

			parent::checkStatus($data);

			$response = array(
				'data' => null,
				'message' => 'No hay albums disponibles.'
			);

			$id_album = Sanitize::filter_int($data['album']);

			if ($id_album !== NULL && (int) $id_album > 0) {
				$albums = array();
				$album = new \App\Models\Album;
				$album->id_album = $id_album;
				$response['data'] = $album->getAlbumById();
			}

			echo json_encode($response, JSON_FORCE_OBJECT);
    	} catch (\Exception $e) {
    		exit($e->getMessage());
    	}
    } 
}