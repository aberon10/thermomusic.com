<?php
namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use Config;

class Favorite {
	use BaseClass;

	private $id_user;
	private $id_track;

	public function __construct($id_user = '', $id_track = '') {
		$this->id_user = $id_user;
		$this->id_track = $id_track;
	}

	public function add_track_to_favorites() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_add_track_to_favorites(:id_user, :id_track)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->bindParam(':id_track', $this->id_track);

			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function get_favorites_user() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_get_favorites_user(:id_user)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function in_favorites() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_in_favorites(:id_user, :id_track)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->bindParam(':id_track', $this->id_track);
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function remove_track_to_favorites() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_remove_track_to_favorites(:id_user, :id_track)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->bindParam(':id_track', $this->id_track);

			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}
