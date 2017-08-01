<?php

namespace App\Models;

use App\Database\PDOConnection;
use App\Models\BaseClass;

class PendingUser
{
	use BaseClass;

	private $token;
	private $id_user;
	private $pending;

	public function __construct($token, $id_user, $pending) {
		$this->token = $token;
		$this->id_user = $id_user;
		$this->pending = $pending;
	}

	public function addPendingAccount() {
		try {
    		$connection = PDOConnection::connect();

	   		$query = 'CALL sp_add_pending_account(:token, :id_user, :pending)';

	   		$stmt = $connection->prepare($query);
	   		$stmt->bindParam(':token', $this->token);
	   		$stmt->bindParam(':id_user', $this->id_user);
	   		$stmt->bindParam(':pending', $this->pending);
	   		
	   		return $stmt->execute();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code:'.$e->getCode();
    	}
	}
}