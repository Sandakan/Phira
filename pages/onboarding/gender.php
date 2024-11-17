<?php
require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: " . BASE_URL . "/index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gender - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>


    <form class="gender-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            <div class="left-panel">
                <h1>What’s your gender?</h1>
                <p>How do you roll?</p>
                <div class="gender-options">
                    <label class="radio-option">
                        <input type="radio" name="gender" value="woman">
                        <span>Woman</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="man">
                        <span>Man</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="other">
                        <span>Other</span>
                    </label>
                </div>
                <button id="next-button">Next</button>
            </div>
            <div class="right-panel">
                <div class="photo-reel">
                    <div class="profile-card">Tiana, 34</div>
                    <div class="profile-card">Kathy, 22</div>
                   
                </div>
            </div>
        </div>

    </form>

    <script>
        const nextButton = document.getElementById('next-button');
        const photoReel = document.querySelector('.photo-reel');

        let currentSlide = 0;

        nextButton.addEventListener('click', () => {
            currentSlide++;
            if (currentSlide > 3) currentSlide = 0; // Reset to first slide if end reached

            photoReel.style.transform = `translateX(-${currentSlide * 240}px)`; // Adjust based on card width + gap
        });

    </script>

</body>

</html>