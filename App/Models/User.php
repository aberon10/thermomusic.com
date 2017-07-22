<?php

namespace App\Models;

use App\Database\PDOConnection;
use App\Models\BaseClass;

class User
{	
	use BaseClass;

	private $id;
	private $name;
	private $lastname;
	private $email;

	public function __construct() {}

    public function getAllUsers() {
    	try {
    		$connection = PDOConnection::connect();
	   		$query = 'CALL sp_all_users()';
	   		$stmt = $connection->prepare($query);
	   		$stmt->execute();
	   		return $stmt->fetchAll();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code:'.$e->getCode();
    	}
    }
}