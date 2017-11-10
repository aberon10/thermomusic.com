<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class Finder {
	use BaseClass;

	public $searched_word;
	public $year;
	public $filter;
	public $filter_value;
	public $entitie;
	const  LIMIT = 2;

	public function find_artist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_find_artist(:searched_word, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':searched_word', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function find_album() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_find_album(:searched_word, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':searched_word', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function find_song() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_find_song(:searched_word, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':searched_word', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function filter_artists_by_genre() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_filter_artists_by_genre(:genre, :artist, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':genre', $this->filter_value);
			$stmt->bindParam(':artist', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function filter_albums_by_artist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_filter_albums_by_artist(:genre, :artist, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':genre', $this->filter_value);
			$stmt->bindParam(':artist', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function filter_songs_by_artist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_filter_songs_by_artist(:genre, :artist, :year)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':genre', $this->filter_value);
			$stmt->bindParam(':artist', $this->searched_word);
			$stmt->bindParam(':year', $this->year);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}

	public function find() {
		try {
			if ($this->filter == 'genre') {
				if ($this->entitie == 'artist') {
					return array('data' => $this->filter_artists_by_genre());
				} else if ($this->entitie == 'album') {
					return array('data' => $this->filter_albums_by_artist());
				} else if ($this->entitie == 'song') {
					return array('data' => $this->filter_songs_by_artist());
				} else {
					return array(
						'artists' => array_slice($this->filter_artists_by_genre(), 0, self::LIMIT),
						'albums' => array_slice($this->filter_albums_by_artist(), 0, self::LIMIT),
						'songs' => array_slice($this->filter_songs_by_artist(), 0, self::LIMIT)
					);
				}
			} else {
				if ($this->entitie == 'artist') {
					return array('data' => $this->find_artist(), 'entitie' => 'artist');
				} else if ($this->entitie == 'album') {
					return array('data' =>  $this->find_album(), 'entitie' => 'album');
				} else if ($this->entitie == 'song') {
					return array('data' => $this->find_song(), 'entitie' => 'song');
				} else {
					return array(
						'artists' => array_slice($this->find_artist(), 0, self::LIMIT),
						'albums' => array_slice($this->find_album(), 0, self::LIMIT),
						'songs' => array_slice($this->find_song(), 0, self::LIMIT)
					);
				}
			}
		} catch (\Exception $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}
