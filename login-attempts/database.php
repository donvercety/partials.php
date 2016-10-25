<?php

$dbh = new PDO("mysql:host=localhost;dbname=test", 'test', 'qwerty');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->exec("SET CHARACTER SET utf8");

$db = [

	'userExists' => function($username) use ($dbh) {
		$stmt = $dbh->prepare('SELECT count(*) AS count FROM vb_users WHERE username = :username');
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->execute();
		return (int) $stmt->fetch(PDO::FETCH_OBJ)->count;
	},

	'userRegister' => function($username, $password) use ($dbh) {
		$password_hashed = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $dbh->prepare('INSERT INTO vb_users(`username`, `password`) VALUES(:username, :password)');
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR, 255);
		return $stmt->execute();
	},

	'userLogin' => function($username) use ($dbh) {
		$stmt = $dbh->prepare('SELECT password FROM vb_users WHERE username = :username');
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ)->password;
	},

	'setFailedLoginAttempt' => function($username) use ($dbh){
		$stmt = $dbh->prepare(
			'INSERT INTO vb_failed_login_attempts(`username`, `count`)' .
			'VALUES(:username, :count)' .
			'ON DUPLICATE KEY UPDATE count = count + 1'
		);
		
		$count = 1;
		
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->bindParam(':count', $count, PDO::PARAM_INT);
		return $stmt->execute();
	},

	'getFailedLoginAttempts' => function($username) use ($dbh){
		$stmt = $dbh->prepare(
			'SELECT * FROM vb_failed_login_attempts WHERE username = :username'
		);
		
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	},
	
	'clearFailedLogins' => function($username) use ($dbh) {
		$stmt = $dbh->prepare(
			'INSERT INTO vb_failed_login_attempts(`username`, `count`)' .
			'VALUES(:username, :count)' .
			'ON DUPLICATE KEY UPDATE count = 0'
		);
		
		$count = 0;
		
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 64);
		$stmt->bindParam(':count', $count, PDO::PARAM_INT);
		return $stmt->execute();		
	}
];
