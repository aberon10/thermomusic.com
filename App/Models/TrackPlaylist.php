<?php
namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use Config;

class TrackPlaylist {
	use BaseClass;

	private $id_track;
	private $id_playlist;

	public function __contruct($id_track = '', $id_playlist = '') {
		$this->id_track = $id_track;
		$this->id_playlist = $id_playlist;
	}

	public function in_playlist() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_in_playlist(:id_track, :id_playlist)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_track', $this->id_track);
			$stmt->bindParam(':id_playlist', $this->id_playlist);
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function add_track_to_playlist() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_add_track_to_playlist(:id_track, :id_playlist)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_track', $this->id_track);
			$stmt->bindParam(':id_playlist', $this->id_playlist);
			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function remove_song_to_playlist() {
		try {
			$connection = PDOConnection::connect();

			$sql = 'CALL sp_remove_song_to_playlist(:id_track, :id_playlist)';

			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':id_track', $this->id_track);
			$stmt->bindParam(':id_playlist', $this->id_playlist);
			return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

}
