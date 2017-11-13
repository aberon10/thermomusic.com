<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class Album
{
	use BaseClass;

	private $id_album;
	private $id_artist;
	private $name_album;
	private $number_tracks;
	private $year;

	public function __construct($id_album = '', $id_artist= '', $name_album = '', $number_tracks = '', $year='') {
		$this->id_album = $id_album;
		$this->id_artist = $id_artist;
		$this->name_album = $name_album;
		$this->number_tracks = $number_tracks;
		$this->year = $year;
	}

	public function getAlbumByArtist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_album_by_artist(:id_artist, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_artist', $this->id_artist);
			$stmt->bindValue(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function getAlbumById() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_album_by_id(:id_album)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_album', $this->id_album);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}
