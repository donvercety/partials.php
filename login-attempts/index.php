<?php

// how to use
//
// login-attempts/?action=register&user=tommy&pass=qwerty	[ for registration ]
// login-attempts/?action=login&user=tommy&pass=qwerty		[ for login ]

include './database.php';
include './functions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['action']) && $_GET['action'] === 'register') {
	if (!isset($_GET['user']) || !isset($_GET['pass'])) {
		echo "Wrong parameters";

	} else {
		$user = $_GET['user'];
		$pass = $_GET['pass'];

		$exists = $db['userExists']($user);

		if ($exists) {
			echo "User {$user} already exist!";
		} else {
			$registration = $db['userRegister']($user, $pass);

			if ($registration) {
				echo "User {$user} registration successful!";
			} else {
				echo "Unsuccessful registration attempt for user {$user}";
			}
		}	
	}

} else if (isset($_GET['action']) && $_GET['action'] === 'login') {
	$user = $_GET['user'];
	$pass = $_GET['pass'];

	$throttleFor = throttleFailedLogins($user, $db);
	
	if ($throttleFor > 0) {
		echo "Too many wrong attempts, please try again after {$throttleFor} minutes!";
			
	} else {
		$auth = password_verify($pass, $db['userLogin']($user));
	
		if ($auth) {
			$db['clearFailedLogins']($user);
			echo "Authentication successful!";
		} else {
			$db['setFailedLoginAttempt']($user);
			echo "Wrong credentials";
		}	
	}
}

echo '<hr />';
debug($_GET);
