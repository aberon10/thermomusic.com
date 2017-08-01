<?php

namespace App\Models;

use App\Database\PDOConnection;
use App\Models\BaseClass;

class ImageUser
{
	use BaseClass;

	private $id_img_user;
	private $id_user;
	private $src_img;

	public function __construct($id_user = '', $src_img = '') {
		$this->id_user = $id_user;
		$this->src_img = $src_img;
	}

	public function saveImage() {
		try {
    		$connection = PDOConnection::connect();
    		$query = 'CALL sp_save_image_user(:id_user, :src_img)';    		
    		$stmt = $connection->prepare($query);
    		$stmt->bindParam(':id_user', $this->id_user);
    		$stmt->bindParam(':src_img', $this->src_img);
    		return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}