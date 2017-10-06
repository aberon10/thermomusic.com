<?php

namespace App\Libs;

class Session
{	
	public static function checkSessionStatus() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
	}

	/**
	 * set
	 * Creates session variable
 	 * @param string $key  
	 * @param string $value
	 */
	public static function set($key, $value = '') {
		Session::checkSessionStatus();
		$_SESSION[$key] = $value;
	}

	/**
	 * get
	 * Get value a session variable
	 * @param  string $key
	 * @return mixed      
	 */
	public static function get($key) {
		Session::checkSessionStatus();
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : '';
	}

	/**
	 * has
	 * Check if exist a session variable
	 * @param  string  $key 
	 * @return boolean Return `true` if exist variable, else `false`.     
	 */
	public static function has($key) {
		Session::checkSessionStatus();
		return array_key_exists($key, $_SESSION);
	}

	/**
	 * delete
	 * @param  string $key
	 * @return boolean     
	 */
	public static function delete($key) {
		if (array_key_exists($key, $_SESSION)) {
			unset($_SESSION[$key]);
			return true;
		}
		return false;
	}

	/**
	 * destroy
	 * @return void
	 */
	public static function destroy() {
		Session::checkSessionStatus();
		Session::regenerateSession(true);

		$_SESSION = array();

		if (ini_get('session.use_cookies')) {
		    $params = session_get_cookie_params();
		    setcookie(
		    	session_name(), 
		    	'', 
		    	time() - 42000,
		        $params['path'], 
		        $params['domain'],
		        $params['secure'], 
		        $params['httponly']
		    );
		}

		session_destroy();
	}

	/**
	 * regenerateSession
	 * Regenerate session id
	 * @param  boolean $delete_old_session
	 * @return boolean                   
	 */
	public static function regenerateSession($delete_old_session = false) {
		return session_regenerate_id($delete_old_session);
	}

	/**
	 * checkTimeout
	 * Calculate the session's "time to live"
	 * @return boolean Redirect to login if TTL is greater than INACTIVE, else return `true`.
	 */
	public static function checkTimeout() {
		if (Session::has('timeout')) {
		    $sessionTTL = time() - Session::get('timeout');
		    if ($sessionTTL > getenv('SESSION_INACTIVE')) {
		        Session::destroy();
		        header('location: /home/login');
		        exit();
		    }
		}
		Session::set('timeout', time());
		Session::regenerateSession(true);
		return true;
	}
}