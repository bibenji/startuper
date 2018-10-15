<?php

namespace Database\Service;

use PDO;
use Entity\User;

class UserService implements ServiceInterface
{
	public function fetchByEmail($email)
	{
		$stmt = $this->connection->pdo->prepare(
			Finder::select('users')
				->where('email = :email')
				->getSql()
		);
		$stmt->execute(['email' => $email]);
		return User::arrayToEntity(
			$stmt->fetch(PDO::FETCH_ASSOC), new User()
		);
	}	
}
