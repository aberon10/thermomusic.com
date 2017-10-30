<?php

namespace App\Libs;

class Sanitize
{
	public static function filter_int($var) {
		return preg_replace('/\D/', '', filter_var(trim($var), FILTER_SANITIZE_NUMBER_INT));
	}

	public static function filter_special_chars($var) {
		return filter_var(trim($var), FILTER_SANITIZE_SPECIAL_CHARS);
	}
}
