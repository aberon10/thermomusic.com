<?php
namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use Config;

class Playlist {
	use BaseClass;

	private $id;
	private $name;
	private $id_user;

	public function __construct($name = '', $id_user = '') {
		$this->name = $name;
		$this->id_user = $id_user;
	}

	public function get_user_playlists() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_get_user_playlists(:id_user)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function create() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_create_playlist(:name, :id_user)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':id_user', $this->id_user);
			$stmt->execute();

			$stmt = $connection->prepare('SELECT LAST_INSERT_ID() AS last_id');
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC)['last_id'];

    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function get_playlist_content() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_get_playlist_content(:id)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function get_playlist_by_id() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_playlist_by_id(:id_playlist)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_playlist', $this->id);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function update() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_update_playlist(:id, :name)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':name', $this->name);
			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function delete() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_delete_playlist(:id)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}
