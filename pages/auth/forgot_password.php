<?php
require '../../vendor/autoload.php';
require '../../config.php';
require '../../utils/database.php';
require '../../utils/generate_random_string.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function sendEmail($sendEmail, $first_name, $subject, $message)
{
  try {
    $mail = new PHPMailer(true);

    $mail->isSMTP(); // using SMTP protocol                                     
    $mail->Host = MAIL_HOST; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = MAIL_USERNAME;  // sender gmail host              
    $mail->Password = MAIL_PASSWORD; // sender gmail host password                          
    $mail->SMTPSecure = MAIL_ENCRYPTION;  // for encrypted connection                           
    $mail->Port = intval(MAIL_PORT);   // port for SMTP     

    $mail->isHTML(true);
    $mail->setFrom("info@phira.com", "Phira"); // sender's email and name
    $mail->addAddress($sendEmail, $first_name);  // receiver's email and name

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();


    echo 'Message has been sent';
  } catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
}

$conn = initialize_database();
$email = $first_name = '';
$email_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $sqlGetUserDetails = <<<SQL
      SELECT first_name 
      FROM users
      WHERE email = :email;
SQL;

    $preparedStatement = $conn->prepare($sqlGetUserDetails);
    $preparedStatement->bindParam(":email", $email, PDO::PARAM_STR);
    $isExecuted = $preparedStatement->execute();
    $user = $preparedStatement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $firstName = $user['first_name'];
      try {
        $first_name = $user['first_name'];
        $random = generateRandomString(25);

        $message = <<<EOT
                  <html>
                      <body>
                          <h4>Welcome to Phira</h4>

                          <h3>Hi, $first_name</h3>

                          <h2>Reset your password</h2>

                          <p>Click the link below to verify your account.</p>
                          <a href="$BASE_URL/pages/auth/reset_password.php?token=$random">Verify your account</a>
                      </body>
                  </html>
              EOT;

        $query = <<<SQL
              UPDATE users
              SET 
                  verification_token = :token,
                  token_expiry = NOW() + INTERVAL 1 HOUR
              WHERE 
                  email = :email;
              SQL;

        sendEmail($email, $first_name, "Welcome to Phira - Reset your password", $message);

        $statement = $conn->prepare($query);
        $statement->bindParam(":token", $random, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $result = $statement->execute();

        if ($result) {
          echo <<<JS
                    <script>
                        const baseUrl = "http://localhost:80/Phira";
                        alert('Verification link has been sent to your email. Please check your inbox.');
                        window.location.href = baseUrl + '/pages/auth/reset_password.php';
                    </script>
                    JS;
                    exit();
        }

      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
    } else {
      $email_error = "Email does not exist";
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