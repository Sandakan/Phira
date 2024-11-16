<?php
require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Verification - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container verification-model-container">
        

            <div class="input-container">
                <label for="verification">Account Verification </label>
                <p> We've sent a verification link to your email 📧. Please check your inbox and click the link to activate your account. Didn’t receive it? Check your spam folder or resend the email.</p>

            </div>

            <div class="verification-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Back to login</button>
            </div>

    </div>
</body>

</html>