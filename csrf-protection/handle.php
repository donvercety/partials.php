<?php

session_start();
include './functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (isValidCSRFToken()) {
		
		// request is safe
		echo "Valid token detected!";

	} else {
		// request not safe
		echo "Invalid token detected!";
	}
	
	debug($_POST);

} else {
	echo "Use POST Request only!";
}

