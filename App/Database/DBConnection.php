<?php

namespace App\Database;

abstract class DBConnection
{
    /**
     * @var object
     */
    protected static $instance;

    /**
     * PDO|mysqli
     * @var object
     */
    protected $connection;

    protected function __construct() {}

    abstract public static function connect();
    abstract public function prepare($query);
    abstract public function query($query);
    abstract public function lastInsertId();

    public function __clone() {
    	trigger_error('[ ERROR ] Cloning of this object is not allowed ', E_USER_ERROR);
    }
}
