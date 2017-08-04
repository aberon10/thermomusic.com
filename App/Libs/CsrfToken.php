<?php

namespace App\Libs;

class CsrfToken
{	
	/**
	 * create
	 * This token is used by forms to prevent cross site forgery attempts.
	 * @param  integer $length 
	 * @return string
	 */
	public static function create($length = 32) {
		if(!isset($length) || intval($length) <= 8 ){
	      $length = 32;
	    }
	    if (function_exists('random_bytes')) {
	        return bin2hex(random_bytes($length));
	    }
	}

	/**
	 * isEqual 
	 * Comparison between two strings to determine if they are equivalent.
     * @param string $string The value to compare.
     * @param string $other_string The other value to compare.
     * @return boolean Returns `true` if the values are equivalent, else `false`.
	 */
	public static function isEqual($string, $other_string) {
		return hash_equals($string, $other_string);
	}
}