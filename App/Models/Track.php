<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class Track
{
	use BaseClass;

	private $id;
	private $id_artist;
	private $id_genre;
	private $name_artist;

	public function __construct($id_artist= '', $id_genre = '', $name_artist = '') {
		$this->id_artist = $id_artist;
		$this->id_genre = $id_genre;
		$this->name_artist = $name_artist;
	}

	public function getMostPlayedTrackByArtist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_most_played_track_by_artist(:id_artist)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_artist', $this->id_artist);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function get_track_by_id() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_track_by_id(:id_track)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_track', $this->id);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}
