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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phira Dating App</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
			<div class="logo">
				<img src="./public/images/logo-white" alt="logo">
			</div>

			<ul class="nav-bar">
				<li><a href="">Help</a></li>
				<li><a href="">About</a></li>
				<li><a href="">Contact</a></li>
				<li><a href="">Privacy Policy</a></li>
			</ul>
			<a href="" id="get">Get started</a>
	</header>
	
	<section class="title"> 
		<h1>Spark some magic!</h1>
	</section>

	<section class="feedbacks">
		<div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div>
		<div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div><div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div><div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div><div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div><div id="feedback">
			<p id="comment">After going on a few dates and having a few fun nights I came across Miranda. After reading her profile I couldn’t resist swiping right after reading her final sentence... ‘Looking for my super babe for life.’ After talking for about a week we went out on our first date and I knew there was something special about her!</p>
			<div id="user">
				<img src="./public/images/FeedbackUser" alt="">
				<p id="userName">Aurara</p>
			</div>
		</div>
	</section>
</body>
</html>