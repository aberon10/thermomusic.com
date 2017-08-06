<?php

namespace App\Models;

use PDO;
use App\Database\PDOConnection;
use App\Models\BaseClass;
use App\Libs\Phassword;
use Config;

class User
{	
	use BaseClass;

	private $id;
	private $user;
	private $password;
	private $email;
	private $birthdate;
	private $sex;
	private $id_type_user;
	private $id_google;
	private $id_facebook;
	private $name;
	private $lastname;

	public function __construct($user = '', $password = '', $email = '', $birthdate = '', $sex = '', 
		$id_type_user = '',$id_google = null, $id_facebook = null, $name = null, $lastname = null) {
		$this->user = $user;
		$this->password = $password;
		$this->email = $email;
		$this->birthdate = $birthdate;
		$this->sex = $sex;
		$this->id_type_user = $id_type_user;
		$this->id_google = $id_google;
		$this->id_facebook = $id_facebook;
		$this->name = $name;
		$this->lastname = $lastname;
	}

	/**
	 * checkIfUserExist
	 * @param  int $api NULL => account app
	 *            		1    => account Facebook
	 *              	2    => account Google
	 * @throws \PDOException|\Exception
	 * @return boolean|string Return `true` if user don't exist, else return string `El usuario ya existe`
	 */
    public function checkIfUserExist($api = NULL) {
    	try {
    		$connection = PDOConnection::connect();
    		
    		if ($api == NULL) {
    			$query = 'CALL sp_check_if_user_exist(:user, :id_free, :id_premium)';
    			$stmt = $connection->prepare($query);
    			$stmt->bindParam(':user', $this->user);
    		} else if ($api == 1) {
    			$query = 'CALL sp_check_if_fb_user_exist(:id_facebook, :id_free, :id_premium)';
    			$stmt = $connection->prepare($query);
    			$stmt->bindParam(':id_facebook', $this->id_facebook);
    		} else if ($api == 2) {
    			$query = 'CALL sp_check_if_gm_user_exist(:id_google, :id_free, :id_premium)';
    			$stmt = $connection->prepare($query);
    			$stmt->bindParam(':id_google', $this->id_google);
    		} else {
    			throw new \Exception('The value of the api parameter is not valid.');
    		}   		

    		$stmt->bindValue(':id_free', \Config\USER_FREE);
    		$stmt->bindValue(':id_premium', \Config\USER_PREMIUM);
    		$stmt->execute();

    		return (!$stmt->fetch(\PDO::FETCH_ASSOC)) ? true : 'El usuario ya existe';
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
    }

    public function createAccount() {
    	try {    		
    		$phass = new Phassword;

			if (!$phass->error) {

				$hash_password = NULL;
				
				if ($this->password != NULL) {
					$hash_password = $phass->cryptPhass($this->password);
				}

				$connection = PDOConnection::connect();

				$query = 'CALL sp_create_account(:user, :email, :password, :birthdate, :sex, :id_type_user, :id_google, :id_facebook, :name, :lastname)';

				$stmt = $connection->prepare($query);
				$stmt->bindParam(':user', $this->user);
				$stmt->bindParam(':email', $this->email);
				$stmt->bindParam(':password', $hash_password);
				$stmt->bindParam(':birthdate', $this->birthdate);
				$stmt->bindParam(':sex', $this->sex);
				$stmt->bindParam(':id_type_user', $this->id_type_user);
				$stmt->bindParam(':id_google', $this->id_google);
				$stmt->bindParam(':id_facebook', $this->id_facebook);
				$stmt->bindParam(':name', $this->name);
				$stmt->bindParam(':lastname', $this->lastname);
				$stmt->execute();

				return $stmt->fetch(\PDO::FETCH_ASSOC)['last_insert_id'];
			} else {
				throw new \Exception($phass->error);
			}
    	} catch (\Exception $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
    }

    public function login() {
    	try {
    		$connection = PDOConnection::connect();
    		
    		$query = 'CALL sp_login(:user)';

    		$stmt = $connection->prepare($query);
    		$stmt->bindParam(':user', $this->user);
    		$stmt->execute();
    		$data_user = $stmt->fetch(\PDO::FETCH_ASSOC);

    		$phass = new Phassword;

    		if (!$phass->error) {
    			return ($phass->verifPhass($this->password, $data_user['pass'])) ? $data_user['id_usuario'] : false;
			} else {
				throw new \Exception($phass->error);
			}
    	} catch (\Exception $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	} catch (\PDOException $e) {
    		echo '[ ERROR ] Message: '.$e->getMessage().' Code: '.$e->getCode();
    	}
    }
}