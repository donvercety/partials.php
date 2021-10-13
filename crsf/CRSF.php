<?php

// if (!function_exists('openssl_random_pseudo_bytes')) {
// 	function openssl_random_pseudo_bytes($len) {
// 		return random_bytes($len);
// 	}
// }

class CRSF {

	public static function generate() {
		return $_SESSION['token'] = base64_encode(
			openssl_random_pseudo_bytes(32)
		);
	}

	public static function check($token) {
		if (isset($_SESSION['token']) && $token === $_SESSION['token']) {
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
}