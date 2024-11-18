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
    <title>Select Your Gender - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container register-model-container">
        <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="input-container">
                <label for="gender">What's your gender?</label>

                <input type="radio" id="gender" name="gender" value="Man">
                <label for="html">Man</label><br>
                <input type="radio" id="gender" name="gender" value="Woman">
                <label for="html">Woman</label><br>
                <input type="radio" id="gender" name="gender" value="Other">
                <label for="html">Other</label><br>

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
