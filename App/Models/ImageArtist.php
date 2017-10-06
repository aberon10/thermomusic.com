<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class ImageArtist {
	use BaseClass;

	private $id_img;
	private $id_artist;
	private $src_img;

	public function __construct($id_artist = '', $src_img = '') {
		$this->id_artist = $id_artist;
		$this->src_img = $src_img;
	}

	public function getImageByArtist() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_image_artist(:id_artist)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_artist', $this->id_artist);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC)['src_img'];
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}