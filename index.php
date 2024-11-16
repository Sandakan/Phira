<?php
require('config.php');
require('./utils/database.php');
session_start();

$conn = initialize_database();

// // remove this before production
// if (!isset($_SESSION["user_id"])) {
// 	header("Location: " . BASE_URL . "/pages/auth/login.php");
// }

// handle GET request to logout
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['logged_out']) && $_GET['logged_out'] == 'true') {
		session_destroy();
		header('Location: ' . BASE_URL . '/index.php');
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Phira</title>
</head>

<body>
	Welcome to Phira!
</body>

</html>
