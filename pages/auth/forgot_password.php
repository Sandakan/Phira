<?php
require '../../config.php';
require '../../utils/database.php';

$email = '';
$email_error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
  <title>Forgot Password</title>
</head>

<body>
  <div class="container ">
  <div class="left-panel">
    <h1>Forgot your password.</h1>
    <p>Enter your Email and we’ll help you reset your password.</p>
    <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">

      <label class="radio-option">
        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required>
        <span class="error-message"><?php echo $email_error ?></span>
      </label>
      <div>
        <button type="submit">Next</button>
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