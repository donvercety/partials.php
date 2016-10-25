<?php

session_start();
include './functions.php';

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h3>With Token!</h3>
	<form action="handle.php" method="POST">
		<label for="name">Username:
			<input type="text" name="name" id="name" required="required" />
		</label>

		<label for="pass">Password
			<input type="password" name="pass" id="pass" required="required" />
		</label>

		<input type="submit" value="Go!" />
		<?php echo csrf(); ?>
	</form>
	
	<h3>Without Token!</h3>
	<form action="handle.php" method="POST">
		<label for="name">Username:
			<input type="text" name="name" id="name" required="required" />
		</label>

		<label for="pass">Password
			<input type="password" name="pass" id="pass" required="required" />
		</label>

		<input type="submit" value="Go!" />
	</form>
</body>
</html>