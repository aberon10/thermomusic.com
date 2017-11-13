<?php
namespace App\Controllers;

use Config;
use Core\Controller;
use App\Libs\Session;
use App\Models;

class Advertising extends Controller {
	public static function index() {
		parent::checkStatus();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			header('Content-Type: application/json;charset=UTF-8');
			$response = array();

			if (Session::get('account') != \Config\USER_PREMIUM) {
				$adv = new \App\Models\Advertising;
				$adv->type_advertising = \Config\ADV_AUDIO;
				$response = $adv->get();
			}
			echo json_encode($response, JSON_FORCE_OBJECT);
			exit();
		}

		\App\Controllers\Error::error_404();
	}
}
