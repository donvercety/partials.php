<?php

/**
 * Returns the number of minutes to wait until logins are allowed again.
 * @param type $username
 * @return int
 */
function throttleFailedLogins($username, $db) {
	$throttleAt     = 5;
	$delayInMinutes = 5;
	$delay          = 60 * $delayInMinutes;
	
	$failedLogin = $db['getFailedLoginAttempts']($username);

	// once failure count is over $throttle_at value, 
	// user must wait for the $delay period to pass.
	if ($failedLogin && $failedLogin->count >= $throttleAt) {
		$remaining_delay = (strtotime($failedLogin->time) + $delay) - time();
		$remainingDelayInMinutes = ceil($remaining_delay / 60);
		return $remainingDelayInMinutes;
	}
	
    return 0;
}

function debug($something) {
    echo '<pre>' . print_r($something, true) . '</pre>';
}