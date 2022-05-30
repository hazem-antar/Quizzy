<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);

	if ($_SESSION['type'] =="staff"){
		header("Location: staff_main.php");
		die;
	}
	header("Location: students_main.php");
	die;
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="logout.php">Logout</a>
	<h1>This is the index page</h1>

	<br>
	<?php	echo "Hello " . $_SESSION['user_id'] . " you are a " . $_SESSION['type']; ?>
</body>
</html>
