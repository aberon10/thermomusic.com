<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class Genre
{
	use BaseClass;

	private $id_genre;
	private $name_genre;

	public function __construct($id_genre = '', $name_genre = '') {
		$this->id_genre = $id_genre;
		$this->name_genre = $name_genre;
	}

	public function getAll() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_all_genres()';
			$stmt = $connection->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}
