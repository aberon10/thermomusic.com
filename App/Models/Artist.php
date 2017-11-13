<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class Artist
{
	use BaseClass;

	private $id_artist;
	private $id_genre;
	private $name_artist;
	private $year;

	public function __construct($id_artist= '', $id_genre = '', $name_artist = '') {
		$this->id_artist = $id_artist;
		$this->id_genre = $id_genre;
		$this->name_artist = $name_artist;
	}

	public function getArtistsByGenre() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_artist_by_genre(:id_genre)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_genre', $this->id_genre);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function getArtistById() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_artist_by_id(:id_artist)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_artist', $this->id_artist);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function getMostPlayedTrackByArtist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_most_played_tracks_by_artist(:id_artist, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_artist', $this->id_artist);
			$stmt->bindValue(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}
