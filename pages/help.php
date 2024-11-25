<?php
require('../config.php');
require('../utils/database.php');
session_start();

$conn = initialize_database();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Help - Phira</title>
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
                <h1>Help</h1>
                <p>Welcome to our Help Center. Find quick guides and solutions here.</p>
            </div>
    </div>
    <main>
        
        <section class="contact-form-section">

                <div class="term">
                    <h3>How to Get Started</h3>
                    <p>Learn the basics of setting up your account and navigating the platform.</p>
                </div>

                <div class="term">
                    <h3>Account Management</h3>
                    <p>Manage your account settings, update personal information, and ensure security.</p>
                </div>

                <div class="term">
                    <h3>Using Our Services</h3>
                    <p>Understand how to make the most of our features and tools for the best experience.</p>
                </div>

                <div class="term">
                    <h3>Reservations and Orders</h3>
                    <p>Get assistance with creating, modifying, or canceling reservations and orders.</p>
                </div>

                <div class="term">
                    <h3>Payment Issues</h3>
                    <p>Find solutions to common payment-related questions and problems.</p>
                </div>

                <div class="term">
                    <h3>Technical Support</h3>
                    <p>Encountering technical issues? Here’s how to troubleshoot and seek assistance.</p>
                </div>

                <div class="term">
                    <h3>Policy Updates</h3>
                    <p>Stay informed about changes to our policies and terms of service.</p>
                </div>

                <div class="term">
                    <h3>Contact Us</h3>
                    <p>If you need further help, please contact us at <a href="mailto:support@phira.com">support@phira.com</a>.</p>
                </div>
        </section>
        
    </main>
</body>

</html>
