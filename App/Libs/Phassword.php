<?php

namespace App\Libs;

class Phassword
{

	public $phassword;
	public $error = FALSE;
	public $coste = 10;
	private $cryptFunction;
	private $evalFunction;
	private $vers;

	public function __construct() {
    	$this->_evalCrypt();
    	$this->_evalCryptVerify();
    	$this->_evalBlowfish();
	}

	public function cryptPhass($password_raw) {
		if ($this->{$this->cryptFunction}($password_raw) && !$this->error) {
			if (!$this->error) return $this->phassword;
		}
	}

	public function verifPhass($password_raw, $password_hash) {
		if (!$this->error) {
			return $this->{$this->evalFunction}($password_raw, $password_hash);
		}
	}

	private function _cryptAPIHash($password_raw) {
		if (function_exists('password_hash')) {
			$this->phassword = password_hash($password_raw, PASSWORD_BCRYPT, array('cost' => $this->coste));
			return TRUE;
		} else {
			$this->error = 'Lo sentimos, la función password_verify() no existe en tu versión actual de PHP.';
		}
	}

	private function _cryptAPIHashVerify($password_raw, $password_hash) {
		if (function_exists('password_verify')) {
			return password_verify($password_raw, $password_hash);
		} else {
			$this->error = 'Lo sentimos, la función password_hash() no existe en tu versión actual de PHP.';
		}
	}

	private function _crypt($password_raw) {
		$salt = "\$2y\${$this->coste}\${$this->_saltCrypt()}";
		$this->phassword = crypt($password_raw, $salt);
		return TRUE;
	}

	private function _cryptVerify($password_raw, $password_hash) {
		if (function_exists('hash_equals')){
			return hash_equals($password_hash, crypt($password_raw, $password_hash));
		} else {
			$is_valid = (crypt($password_raw, $password_hash) == $password_hash) ? TRUE : FALSE;
			return $is_valid;
		}
	}

	private function _saltCrypt() {
		$font_rand = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    $salt_length = 22;
	    $salt = array();
	    for ($i = 0; $i < $salt_length; $i++) {
	        $salt[] = $font_rand[mt_rand(0, strlen($font_rand) - 1)];
	    }
		return implode('', $salt);
	}

	private function _evalCrypt() {
		preg_match('/\d\.\d+/', $this->_vers(), $ver);
		$ver = floatval(implode($ver));
		if ($ver >= 5.5) {
			$this->cryptFunction = '_cryptAPIHash';
		} else {
			$this->cryptFunction = '_crypt';
		}
	}

	private function _evalCryptVerify() {
		preg_match('/\d\.\d+/', $this->_vers(), $ver);
		$ver = floatval(implode($ver));
		if ($ver >= 5.5) {
			$this->evalFunction = '_cryptAPIHashVerify';
		} else {
			$this->evalFunction = '_cryptVerify';
		}
	}

	private function _evalBlowfish() {
		preg_match('/\d\.\d+/', $this->_vers(), $ver);
		$ver = floatval(implode($ver));
		if ($ver >= 5.5) {
			if (!PASSWORD_BCRYPT){
				$this->error = 'Lo sentimos, su version actual de PHP no soporta el metodo de encriptación BLOWFISH' ;
			}
		} else {
			if (!CRYPT_BLOWFISH){
				$this->error = 'Lo sentimos, su version actual de PHP no soporta el metodo de encriptación BLOWFISH' ;
			}
		}
	}

	private function _vers() {
		$vers = function_exists('phpversion') ? phpversion() : PHP_VERSION;
		return $vers;
	}

}