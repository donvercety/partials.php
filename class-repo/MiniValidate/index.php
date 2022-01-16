<?php
	
include('Validate.php');
$v = new Validate();

$valid = $v->check($_POST, [
	'username'   => ['required' => TRUE, 'min' => 6, 'alpha_dash' => TRUE],
	'email   '   => ['required' => TRUE, 'valid_email' => TRUE],
	'password'   => ['required' => TRUE, 'min' => 8],
	'repeatpass' => ['matches' => 'password'],
]);

var_dump($valid->errors());
var_dump($valid->passed());

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Validate</title>
</head>
<body>
	<form method="POST" action="">
		<input type="text" name="username" placeholder="username"/>
		<input type="text" name="email" placeholder="email"/>
		<input type="password" name="password" placeholder="password"/>
		<input type="password" name="repeatpass" placeholder="repeat password"/>
		<input type="submit" value="Send">
	</form>
</body>
</html>
