<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use function \Http\Request\isGet;
use function \Http\Request\isPost;
use function \Http\Request\isPut;
use function \Http\Request\isDelete;

require __DIR__ . '/http.php';

echo "Request type: {$_SERVER['REQUEST_METHOD']} <br />" . PHP_EOL;

if (isGet()) {
	echo "isGet()";
}

if (isPost()) {
	echo "isPost()";
}

if (isPut()) {
	echo "isPut()";
}

if (isDelete()) {
	echo "isDelete()";
}

if (Http\Request\isAjax()) {
	echo PHP_EOL . "isAjax()";
}

// test is ajax check
if (isGet()) {
	echo "
<!DOCTYPE HTML>
<html lang=\"en-US\">
<head>
	<meta charset=\"UTF-8\">
	<title></title>
</head>
<body>
	<script src=\"https://code.jquery.com/jquery-3.1.1.min.js\"></script>
	<script type=\"text/javascript\">
		$.ajax({
			type: 'POST',
			url: './',
			data: {},
			success: function(response) {
				console.log(response);
			},
			error: function(err) {
				console.log(err);
			}
		});
	</script>
</body>
</html>
	";
}