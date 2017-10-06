<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Libs\Session;
use App\Libs\CsrfToken;

class Playbackqueue extends Controller
{
    public static function index()
    {
        try {
            parent::checkStatus(['csrf' => Session::get('csrf')]);
            View::setData('title', getenv('APP_NAME'));
            View::render('sections/user');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }
}