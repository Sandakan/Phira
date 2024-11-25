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
    <title>Contact Us - Phira</title>
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
            <h1>Contact Us</h1>
            <p>We'd love to hear from you!</p>
        </div>
    </div>

    <main>
        <div class="contact-container">
        <section class="contact-form-section">
            <h2>Get in Touch</h2>
            <p>If you have any questions, feedback, or need support, fill out the form below or reach us through our contact information.</p>
            <form action="submit_contact.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>

                <button type="submit">Send Message</button>
            </form>
        </section>

        <section class="contact-info-section">
            <h2>Contact Information</h2>
            <p>Email: support@phiraapp.com</p>
            <p>Phone: +94 77 123 4567</p>
            <p>Address: 123 Phira Lane, Colombo, Sri Lanka</p>
        </section>
        </div>
    </main>
</body>
</html>
