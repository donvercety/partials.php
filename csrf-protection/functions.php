<?php

function generateToken() {
	return bin2hex(random_bytes(32));
}

/**
 * Generate and store CSRF token in user session.
 * Requires session to have been started already.
 * @return type
 */
function createCSRFToken() {
	$token = generateToken();

	$_SESSION['csrf.token.hash'] = $token;
	$_SESSION['csrf.token.time'] = time();
	return $token;
}

/**
 * Destroys a token by removing it from the session.
 * @return boolean
 */
function removeCSRFToken() {
	$_SESSION['csrf.token.hash'] = null;
	$_SESSION['csrf.token.time'] = null;
	return true;
}

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// :: Public functions
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

/**
 * Return an HTML tag including the CSRF token.
 * Usage: echo csrf();
 * @return string
 */
function csrf() {
	$token = createCSRFToken();
	return "<input type=\"hidden\" name=\"token_hash\" value=\"{$token}\">";
}

/**
 * Check the token validity and handle the failure.
 *
 * TODO: implement to use other request types
 * @return boolean
 */
function isValidCSRFToken() {
	if (isset($_POST['token_hash'])) {
		$formToken = $_POST['token_hash'];
		$sessToken = $_SESSION['csrf.token.hash'];
		return $formToken === $sessToken;
	}
	return false;
}

/**
 * Stop everything on failure.
 */
function dieOnCSRFTokenFailure() {
	if (!isValidCSRFToken()) {
		die("CSRF token validation failed.");
	}
}

/**
 * Optional Check!
 * Check to see if token is recent.
 * @return boolean
 */
function isRecentCSRFToken() {
	$maxElapsed = 60 * 10; // 10 minutes

	if (isset($_SESSION['csrf.token.time'])) {
		$storedTime = $_SESSION['csrf.token.time'];
		return ($storedTime + $maxElapsed) >= time();
	}

	// remove expired token
	removeCSRFToken();
	return false;
}

function debug($something) {
    echo '<pre>' . print_r($something, true) . '</pre>';
}
