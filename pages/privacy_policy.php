<?php
require('../config.php');
require('../utils/database.php');
session_start();

$conn = initialize_database();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/legal.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/index.css">
</head>
<body>
<header>
    <div class="logo">
			<a href="<?php echo BASE_URL; ?>/index.php"><img src="../public/images/logo-white" alt="logo"></a>
		</div>

		<ul class="nav-bar">
        <li><a href="./help.php">Help</a></li>
			<li><a href="./about_us.php">About</a></li>
			<li><a href="./contact_us.php">Contact</a></li>
			<li><a href="./privacy_policy.php">Privacy Policy</a></li>
		</ul>
		<a href="<?php echo BASE_URL; ?>/pages/auth/login.php" id="get">Get started</a>

    </header>
    <div class="header">
        <div class="header-content">
            <h1>Privacy Policy</h1>
            <p>Protecting your data, enhancing your experience.</p>
        </div>
    </div>

    <main class="about-container">
        <div class="about-content">
            <section class="term">
                <h3>Welcome to Phira!</h3>
                <p>Your privacy matters. This policy explains how we handle your personal information and safeguard your data.</p>
            </section>

            <section class="term">
                <h3>Information We Collect</h3>
                <p>We collect various types of information, including:</p>
                <ul>
                    <li><strong>Personal Data:</strong> Name, email address, and profile information.</li>
                    <li><strong>Usage Data:</strong> Interactions within the app, preferences, and device data.</li>
                </ul>
            </section>

            <section class="term">
                <h3>How We Use Your Data</h3>
                <p>Your information is used to:</p>
                <ul>
                    <li>Provide a personalized matchmaking experience.</li>
                    <li>Improve and enhance our services.</li>
                    <li>Communicate updates, features, and promotions.</li>
                </ul>
            </section>

            <section class="term">
                <h3>Data Security & Protection</h3>
                <p>We employ advanced security measures to protect your information. Our commitment to safety ensures that your data is always handled responsibly.</p>
            </section>

            <section class="term">
                <h3>Your Rights</h3>
                <p>You can access, update, or delete your information anytime. Contact us for any privacy-related concerns.</p>
            </section>
        </div>
    </main>
</body>
</html>
