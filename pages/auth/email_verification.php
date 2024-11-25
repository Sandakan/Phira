<?php
require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();

$title = "Account Verification";
$description = "We've sent a verification link to your email 📧. Please check your inbox and click the link to activate your account. Didn’t receive it? Check your spam folder or resend the email.";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        $query = <<< SQL
        SELECT
            user_id
        FROM
            users
        WHERE
            verification_token = :token AND token_expiry > NOW();
    SQL;
        $statement = $conn->prepare($query);
        $statement->bindParam("token", $token, PDO::PARAM_STR);
        $result = $statement->execute();
        $data = $statement->fetch();

        if ($data) {
            $query = <<< SQL
            UPDATE
                users
            SET
                verified_at = NOW(),
                token_expiry = NOW()
            WHERE
                verification_token = :token;
        SQL;
            $statement = $conn->prepare($query);
            $statement->bindParam("token", $token, PDO::PARAM_STR);
            $result = $statement->execute();

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
    } catch (Exception $e) {
        $title = "Account Verification Failed";
        $description = "Something went wrong. Please try again later.";
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="container">

        <div class="left-panel">
            <div class="input-container">
                <h1><label for="verification"><?php echo $title; ?></label></h1>
                <p><?php echo $description; ?></p>

            </div>

            <div class="verification-form-actions-container">
                <a href="<?php echo BASE_URL; ?>/pages/auth/login.php" class="btn btn-primary form-submit-btn">Back to
                    login</a>
            </div>
        </div>
        <div class="email-right-panel">
            <div>
                <img src="<?php echo BASE_URL; ?>/public/images/email-varification/Left-side.png" alt="1">
            </div>
            <div>
                <img src="<?php echo BASE_URL; ?>/public/images/email-varification/Right-side.png" alt="1">
            </div>
        </div>

    </div>
</body>

</html>
