<?php
declare(strict_types=1);

namespace App\Libs;

/**
 * Clase utilizada para realizar distintas validaciones.
 * @author [abzerox]
 * @version 1.0
 */
class Validate
{
    const METHOD_PREFIX = '_validate';

    const REGX_NAME = '/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ\s]+$/';

    const REGX_USERNAME = '/^[\w_\.@\[\]]{4,30}+$/';

    const REGX_EMAIL = '/^[(\w)+(\w_\.)]{4,60}+@+\w{2,25}+\.\w{2,20}+$/';

    const REGX_FORMATS_OF_DATES = '/^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|[1][012])[\/|-]((19|20)?[0-9]{2})$/';

    /**
     * resolver
     * Realiza las validaciones correspondientes sobre un valor dado.
     * 
     * @param  string|int|float|array|file  $input   
     * @param  array  $filters ['filter' => 'message'] | ['filter' => ['value', 'message']]
     * @return mixed          
     */
    public static function resolver($input, array $filters) {
    	$class = __CLASS__;

    	foreach ($filters as $key => $value) {
    		$method = $class::METHOD_PREFIX.ucfirst($key);
    		if (method_exists($class, $method)) {
    			if (in_array($key, ['regex', 'min', 'max', 'length'])) {
    				if (!is_array($value) || count($value) != 2) {
    					throw new \Exception('El filtro '.$key.' debe tener como valor un array con la forma [valor, mensaje]');
    				} else {
    					$result = $class::{$method}($value[0], $input);	
    				}
    			} else {
    				$result = $class::{$method}($input);
    			}
    			
    			if (!$result) {
    				return (is_array($value)) ? $value[1] : $value;
    			}    			
    		} else {
    			throw new \Exception('La propiedad '.$key .' no existe');
    		}
    	}

    	return true;
    }

    private static function _validateRequire($value) {
    	return empty($value) ? false : true;
    }

    private static function _validateRegex($regex, $value) {
    	return preg_match($regex, $value);
    }

    /**
     * validateUsername
     * @param  string $username
     * @return bool|string
     */
    private static function _validateUsername($username) {
        return preg_match(self::REGX_USERNAME, $username);
    }

    /**
     * validateName
     * @param  string $name
     * @return bool
     */
    private static function _validateName($name) {
        return preg_match(self::REGX_NAME, $name);
    }

    /**
     * validateEmail
     * @param  string $email
     * @return bool
     */
    private static function _validateEmail($email) {
        return preg_match(self::REGX_EMAIL, $email);
    }

    /**
     * _validateDate
     * Comprueba que una fecha sea valida utilizando el calendario gregoriano.
     * @param  string $date   
     * @return true|false
     */
	private static function _validateDate($date) {
	    if (preg_match(Validate::REGX_FORMATS_OF_DATES, $date)) {
	        $values = preg_split('[\/|-]', $date);
	        if (checkdate((int) $values[1], (int) $values[0], (int) $values[2])) {
	        	return true;
	        }	            
	    }
	    return false;
	}

	/**
	 * _validateMax
	 * @param  int $max_value 
	 * @param  int $value     
	 * @return true|false            
	 */
	private static function _validateMax($max_value, $value) {
		if (preg_match('/^[\d]+$/', (string) $value)) {
			return ($value > $max_value) ? false : true;
		} else if (is_string($value)) {
			return (strlen($value) > $max_value) ? false : true;
		}
		return false;
	}	

	/**
	 * _validateMin
	 * @param  int $max_value 
	 * @param  int $value     
	 * @return true|false            
	 */
	private static function _validateMin($min_value, $value) {
		if (preg_match('/^[\d]+$/', (string) $value)) {
			return ($value < $min_value) ? false : true;
		} else if (is_string($value)) {
			return (strlen($value) < $min_value) ? false : true;
		}
		return false;
	}

	private static function _validateLength($length, $value) {
		return is_string($value) && strlen($value) <= $length;
	}
}