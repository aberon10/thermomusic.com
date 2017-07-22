<?php

namespace App\Models;

trait BaseClass
{
	/**
     * __get
     * @param  string $var 
     */
    public function __get($var) {
        if (property_exists(__CLASS__, $var)) {
            return $this->$var;
        } else {
        	throw new \Exception('Property '.$var.' do not exist.');
        }
    }

    /**
     * __set
     * @param string $var   
     * @param mixed  $value
     */
    public function __set($var, $value) {
    	if (property_exists(__CLASS__, $var)) {
            $this->$var = $value;
        } else {
        	throw new \Exception('Property '.$var.' do not exist.');
        }
    }
}