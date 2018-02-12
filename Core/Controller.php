<?php

namespace Core;

use \App\Libs\CsrfToken;
use \App\Libs\Session;

class Controller
{
    /**
     * __call
     * @param  string $method
     * @param  string $args
     * @return void
     */
    public function __call($method, $args = NULL) {
        require VIEWS_PATH.'/errors/404.php';
        exit;
    }

    /**
     * __callStatic
     * @param  string $method
     * @param  string $args
     * @return void
     */
    public static function __callStatic($method, $args = NULL) {
        require VIEWS_PATH.'/errors/404.php';
        exit;
    }


	private static function isXmlHttpRequest() {
    	$header = apache_request_headers()['X-Requested-With'] ?? null;
		return ($header === 'XMLHttpRequest');
	}

    public static function checkStatus($data = array()) {
        if (!Session::has('username')) {
			if (Controller::isXmlHttpRequest()) {
				header('Content-type: application/json;charset=utf-8');
				echo json_encode([
					'status' => 401,
					'urlRedirect' => '/home/login'
				]);
				exit;
			}

            header('location: /home/login');
            exit();
		}
        //else if (!isset($data['csrf']) ||
            //!CsrfToken::isEqual(Session::get('csrf'), $data['csrf'])) {
            //\App\Controllers\Error::error_404();
           // echo "ERROR CSRF TOKEN";
          //  exit();
        //}
        Session::checkTimeout();
    }
}
