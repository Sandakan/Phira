<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));


if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Habits - Phira</title>
    <!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css"> -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
<div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <h1>Phira<span class="logo-accent">©</span></h1>
            <h2>Let’s dive into lifestyle choices, Vimukthi.</h2>
            <p>Do their habits align with yours?</p>
            <button class="next-btn">Next</button>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="question" data-question="drink">
                <p>How often do you drink?</p>
                <div class="options">
                    <button class="option">Newly teetotal</button>
                    <button class="option danger">Not for me</button>
                    <button class="option">On special occasions</button>
                    <button class="option">At the weekends</button>
                    <button class="option">Most nights</button>
                </div>
            </div>

            <div class="question" data-question="smoke">
                <p>How often do you smoke?</p>
                <div class="options">
                    <button class="option">Newly teetotal</button>
                    <button class="option danger">Not for me</button>
                    <button class="option">On special occasions</button>
                    <button class="option">At the weekends</button>
                    <button class="option">Most nights</button>
                </div>
            </div>

            <div class="question" data-question="exercise">
                <p>Do you exercise?</p>
                <div class="options">
                    <button class="option">Every day</button>
                    <button class="option danger">Often</button>
                    <button class="option">Sometimes</button>
                    <button class="option">Never</button>
                </div>
            </div>

            <div class="question" data-question="pets">
                <p>Do you have any pets?</p>
                <div class="options">
                    <button class="option">Dog</button>
                    <button class="option danger">Cat</button>
                    <button class="option">Fish</button>
                    <button class="option">Bird</button>
                    <button class="option">Amphibian</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>/public/scripts/habits.js"></script>
</body>

</html>
