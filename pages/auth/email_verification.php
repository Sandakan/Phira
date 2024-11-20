<?php
require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();

$title = "Account Verification";
$description = "We've sent a verification link to your email 📧. Please check your inbox and click the link to activate your account. Didn’t receive it? Check your spam folder or resend the email.";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM users WHERE verification_token = '$token' AND token_expiry > NOW()";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $query = "UPDATE users SET verified_at = NOW(), token_expiry = NOW() WHERE verification_token = '$token'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $title = "Account Verified Successfully";
            $description = "Your account has been verified. You can now log in to your account.";
        } else {
            $title = "Account Verification Failed";
            $description = "The verification link is invalid or has expired. Please request a new verification link.";
        }
    } else {
        $title = "Account Verification Failed";
        $description = "The verification link is invalid, expired or the account is already verified. Please request a new verification link if there is an error.";
    }
}
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

<div class="left-panel">
        <div class="input-container">
            <h1><label for="verification"><?php echo $title; ?></label></h1>
            <p><?php echo $description; ?></p>

        </div>

        <div class="verification-form-actions-container">
            <a href="<?php echo BASE_URL; ?>/pages/auth/login.php" class="btn btn-primary form-submit-btn">Back to login</a>
        </div>
        </div>
        <div class="right-panel">
            <div class="photo-reel">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 01.png" alt="1">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 02.png" alt="1">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 03.png" alt="1">
            </div>
            <div class="photo-reel1">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 04.png" alt="1">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 05.png" alt="1">
                <img src="<?php echo BASE_URL; ?>/public/images/Frame 06.png" alt="1">
            </div>
        </div>

    </div>
</body>

</html>
