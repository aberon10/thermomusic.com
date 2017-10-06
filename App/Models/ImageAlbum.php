<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;

class ImageAlbum 
{
	use BaseClass;

	private $id_img_album;
	private $id_album;
	private $src_img;

	public function __construct($id_album = '', $src_img = '') {
		$this->id_album = $id_album;
		$this->src_img = $src_img;
	}

	public function getImageByAlbum() {
		try {
    		$connection = PDOConnection::connect();
			$query = 'CALL sp_get_image_album(:id_album)';
			$stmt = $connection->prepare($query);
			$stmt->bindValue(':id_album', $this->id_album);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC)['src_img'];
		} catch (\PDOException $e) {
			echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
		}
	}
}