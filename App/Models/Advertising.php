<?php
namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use App\Libs\Phassword;
use Config;

class Advertising {
	use BaseClass;

	public $type_advertising;

	public function get() {
		try {
			$connection = PDOConnection::connect();
			$query = 'CALL sp_get_advertising(:type_advertising)';
			$stmt = $connection->prepare($query);
			$stmt->bindParam(':type_advertising', $this->type_advertising);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	} catch (\Exception $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
	}
}
