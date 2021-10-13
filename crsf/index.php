<?php

session_start();
require_once('CRSF.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (CRSF::check(filter_input(INPUT_POST, 'token'))) {
		die('OK !!!');
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>A Basic HTML5 Template</title>
	<meta name="description" content="A simple HTML5 Template for new projects.">

	<link rel="icon" href="/favicon.ico">
	<link rel="icon" href="/favicon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
</head>

<body>
	<form action="" method="post">
		<div>
			<strong>Product</strong>
			<br>
			<input type="submit" name="Order">
			<input type="hidden" name="token" value="<?= CRSF::generate() ?>">
		</div>
	</form>
</body>
</html>