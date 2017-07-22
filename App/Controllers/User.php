<?php

namespace App\Controllers;

use App\Models;
use Core\View;
use Core\Controller;

class User extends Controller
{
	public static function index() {
		try {
			$user = new Models\User;
			$users = $user->getAllUsers();

			View::setData('users', $users);
			View::render('sections/user');
		} catch (\Exception $e) {
			exit($e->getMessage());
		}
	}
}