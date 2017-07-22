<?php

namespace App\Database;

use App\Database\DBConnection;

class PDOConnection extends DBConnection
{
    /**
     * $options Driver Specific Connection Options.
     * @var array
     */
    protected static $options = array(
        \PDO::MYSQL_ATTR_FOUND_ROWS   => true, // Devuelve el número de filas encontradas (coindicentes)
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, // Lanzar una PDOException si ocurre algún error
        \PDO::ATTR_CASE               => \PDO::CASE_LOWER,       // Fuerzo el nombre de columnas en minuscula
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC       // Resultados indexados por nombres de columnas
    );

    protected function __construct() {
		$dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE;

        try {
            $this->connection = new \PDO($dsn, DB_USER, DB_PASSWORD, self::$options);
            $this->connection->exec('SET CHARACTER SET '.DB_CHARSET);
        } catch (\PDOException $error) {
            exit('[ Connection error ] '.$error->getMessage().' Error code: '.$error->getCode());
        }
    }

    /**
     * connect
     * @return PDOConnection
     */
    public static function connect() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * prepare
     * Prepares a statement for execution and returns a statement object
     * @param  string $query
     * @return object PDOStatement|FALSE
     */
    public function prepare($query) {
        return $this->connection->prepare((string) $query);
    }

    /**
     * query
     * Executes an SQL statement, returning a result set as a PDOStatement object
     * @param  string $query
     * @return object PDOStatement|FALSE
     */
    public function query($query) {
        return $this->connection->query((string) $query);
    }

    /**
     * lastInsertId
     * Returns the ID of the last inserted row or sequence value
     * @return string
     */
    public function lastInsertId() {
            return $this->connection->lastInsertId();
    }
}
