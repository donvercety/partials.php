<?php

session_start();
include './functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isValidCSRFToken()) {
		echo "<p>Valid token detected!</p>"; // request is safe

		if (isRecentCSRFToken()) {
			echo "<p>Token is recent!</p>"; // request is safe safe
		}

	} else {
		echo "<p>Invalid token detected!</p>"; // request not safe
	}

	debug($_POST);

} else {
	echo "Use POST Request only!";
}

