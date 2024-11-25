<?php
require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();
$title = "Password Reset";
$description = "";
$password = '';
$password_error = '';

$confirm_password = '';
$confirm_password_error = '';

if (isset($_GET['token'])) {
  $token = $_GET['token'];

  try {
    $query = <<<SQL
  SELECT
      user_id
  FROM
      users
  WHERE
      verification_token = :token AND token_expiry > NOW();
SQL;

    $statement = $conn->prepare($query);
    $statement->bindParam("token", $token, PDO::PARAM_STR);
    $statement->execute();
    $data = $statement->fetch();

    if ($data) {
      $query = <<<SQL
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
        $title = "Email Verified Successfully";
        $description = "Your password has been successfully reset. You can now log in to your account with the new password.";
      } else {
        $title = "Email Verification Failed";
        $description = "The verification link is invalid or has expired. Please request a new verification link.";
      }
    } else {
      $title = "Email Verification Failed";
      $description = "The verification link is invalid, expired or the account is already verified. Please request a new verification link if there is an error.";
    }
  } catch (Exception $e) {
    $title = "Password Reset Failed";
    $description = "Something went wrong. Please try again later.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($password) >= 8) {

      if ($password !== $confirm_password) {
        $confirm_password_error = "Passwords do not match";
      } else {
        try {
          $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

          $query = <<<SQL
            UPDATE
                users
            SET
                password = :password
            WHERE
                verification_token = :token;
        SQL;
          $statement = $conn->prepare($query);
          $statement->bindParam("password", $hashedPassword, PDO::PARAM_STR);
          $statement->bindParam("token", $token, PDO::PARAM_STR);
          $result = $statement->execute();

          if ($result) {
            session_unset();
            session_destroy();
            echo <<<JS
                    <script>
                            const baseUrl = "http://localhost:80/Phira";
                            alert('Password reset successfully! Redirecting to the login page.');
                            window.location.href = baseUrl + '/pages/auth/login.php';
                    </script>
                    JS;
            exit();
          } else {
            echo <<<JS
                    <script>
                        const baseUrl = "http://localhost:80/Phira";
                        alert('Password reset failed! The verification link may have expired or is invalid.');
                        window.location.href = baseUrl + '/pages/auth/forgot_password.php';
                    </script>
                    JS;
            exit();
          }
        } catch (Exception $e) {
          echo <<<JS
                  <script>
                      const baseUrl = "http://localhost:80/Phira";
                      alert('Something went wrong. Please try again later.');
                      window.location.href = baseUrl + '/pages/auth/forgot_password.php';
                  </script>
                  JS;
          exit();
        }
      }
    } else {
      $password_error = "Password must be at least 8 characters";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
  <title>Reset Password</title>

</head>

<body>
  <div class="container">
    <div class="left-panel">
      <h1>Reset Password.</h1>
      <p>Your new password must be different from previous used password.</p>


      <span class="error-message"><?php echo $confirm_password_error; ?></span><br>


      <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">

        <label class="radio-option">
          <input type="password" name="password" id="password" placeholder="Password"
            value="<?php echo $password; ?>" required />
          <span class="error-message"><?php echo $password_error; ?></span><br>

          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
            value="<?php echo $confirm_password; ?>" required />

        </label>

        <div>
          <button type="submit">Continue</button>
        </div>
      </form>


    </div>

    <div class="right-panel">
      <div class="photo-reel">
        <img src="<?php echo BASE_URL; ?>/public/images/forgot-password/forgot-password-reel-1.png" alt="1">
      </div>

      <div class="photo-reel1">
        <img src="<?php echo BASE_URL; ?>/public/images/forgot-password/forgot-password-reel-2.png" alt="2">
      </div>

    </div>
  </div>

</body>

</html>
