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
    <title>Join With Us - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
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

            <div class="register-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>
</body>
</html>