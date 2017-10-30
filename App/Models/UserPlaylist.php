<?php
namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class UserPlaylist {
	use BaseClass;

	private $id_user;
	private $id_playlist;
	private $date;

	public function __construct($id_user = '', $id_playlist = '') {
		$this->id_user = $id_user;
		$this->id_playlist = $id_playlist;
	}

	public function get_playlist_by_user() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_get_playlist_by_user(:id)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id', $this->id_user);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}
