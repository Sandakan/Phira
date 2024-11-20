<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

// authenticate(array("USER"));


// if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
//     header("Location: " . BASE_URL . "/pages/app/matches.php");
// }
// ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Habits - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
<div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <h2>Let’s dive into lifestyle choices, Vimukthi.</h2>
            <p>Do their habits align with yours?</p>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <form action="/submit-lifestyle" method="post">
                <div class="question">
                    <p>How often do you drink?</p>
                    <div class="options">
                        <label>
                            <input type="radio" name="drink" value="Newly teetotal">
                            <span>Newly teetotal</span>
                        </label>
                        <label>
                            <input type="radio" name="drink" value="Not for me">
                            <span class="danger">Not for me</span>
                        </label>
                        <label>
                            <input type="radio" name="drink" value="On special occasions">
                            <span>On special occasions</span>
                        </label>
                        <label>
                            <input type="radio" name="drink" value="At the weekends">
                            <span>At the weekends</span>
                        </label>
                        <label>
                            <input type="radio" name="drink" value="Most nights">
                            <span>Most nights</span>
                        </label>
                    </div>
                </div>

                <div class="question">
                    <p>How often do you smoke?</p>
                    <div class="options">
                        <label>
                            <input type="radio" name="smoke" value="Newly teetotal">
                            <span>Newly teetotal</span>
                        </label>
                        <label>
                            <input type="radio" name="smoke" value="Not for me">
                            <span class="danger">Not for me</span>
                        </label>
                        <label>
                            <input type="radio" name="smoke" value="On special occasions">
                            <span>On special occasions</span>
                        </label>
                        <label>
                            <input type="radio" name="smoke" value="At the weekends">
                            <span>At the weekends</span>
                        </label>
                        <label>
                            <input type="radio" name="smoke" value="Most nights">
                            <span>Most nights</span>
                        </label>
                    </div>
                </div>

                <div class="question">
                    <p>Do you exercise?</p>
                    <div class="options">
                        <label>
                            <input type="radio" name="exercise" value="Every day">
                            <span>Every day</span>
                        </label>
                        <label>
                            <input type="radio" name="exercise" value="Often">
                            <span class="danger">Often</span>
                        </label>
                        <label>
                            <input type="radio" name="exercise" value="Sometimes">
                            <span>Sometimes</span>
                        </label>
                        <label>
                            <input type="radio" name="exercise" value="Never">
                            <span>Never</span>
                        </label>
                    </div>
                </div>

                <div class="question">
                    <p>Do you have any pets?</p>
                    <div class="options">
                        <label>
                            <input type="radio" name="pets" value="Dog">
                            <span>Dog</span>
                        </label>
                        <label>
                            <input type="radio" name="pets" value="Cat">
                            <span class="danger">Cat</span>
                        </label>
                        <label>
                            <input type="radio" name="pets" value="Fish">
                            <span>Fish</span>
                        </label>
                        <label>
                            <input type="radio" name="pets" value="Bird">
                            <span>Bird</span>
                        </label>
                        <label>
                            <input type="radio" name="pets" value="Amphibian">
                            <span>Amphibian</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="next-btn">Next</button>
            </form>
        </div>
    </div>
</body>

</html>
