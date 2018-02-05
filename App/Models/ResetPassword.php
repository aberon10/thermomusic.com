<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use App\Libs\Phassword;
use Config;

class ResetPassword {
	use BaseClass;

	private $id;
	private $id_user;
	private $created_at;

	public function save() {
		try {
			$connection = PDOConnection::connect();
			$query = 'insert into password_resets(id_usuario) values(:id_user)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':id_user', $this->id_user);
			return $stmt->execute();
    	} catch (\Exception $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}

	public function get_date_of_last_reset() {
		try {
			$connection = PDOConnection::connect();
			$query = 'select id_reset, id_usuario, created_at from password_resets where id_usuario=:id_user ORDER BY created_at DESC';
			$stmt = $connection->prepare($query);
    		$stmt->bindParam(':id_user', $this->id_user);
			$stmt->execute();
			return $stmt->fetch();
    	} catch (\Exception $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}
