<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/generate_random_string.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../packages/PHPMailer/src/Exception.php';
require '../../packages/PHPMailer/src/PHPMailer.php';
require '../../packages/PHPMailer/src/SMTP.php';


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
        $mail->Body    = $message;

        $mail->send();


        echo 'Message has been sent';
    } catch (Exception $e) { // handle error.
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}


$conn = initialize_database();
session_start();

if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}

$first_name = $last_name = $email = $contact_number = $confirm_password = $password = "";
$first_name_error = $last_name_error = $email_error = $contact_number_error = $confirm_password_error = $password_error = "";
$is_error = false;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = test_input($_POST["first_name"]);
    if (!empty($_POST["first_name"]) && !preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $first_name_error = "Only letters are allowed.";
        $is_error = true;
    }

    $last_name = test_input($_POST["last_name"]);
    if (!empty($_POST["last_name"]) && !preg_match("/^[a-zA-Z ]+$/", $last_name)) {
        $last_name_error = "Only letters are allowed.";
        $is_error = true;
    }

    $email = test_input($_POST["email"]);
    if (!empty($_POST["email"]) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
        $is_error = true;
    }

    $password = test_input($_POST["password"]);
    $confirm_password = test_input($_POST["confirm_password"]);
    if (!empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
        if ($password != $confirm_password) {
            $password_error = "Passwords do not match";
            $is_error = true;
        }
        if (strlen($password) < 8) {
            $password_error = "Password must be at least 8 characters";
            $is_error = true;
        }
    }

    $query = "SELECT COUNT (*) AS count FROM users WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row["count"] > 0) {
        $email_error = "Email already exists in the system.";
        $is_error = true;
    }


    if (!$is_error) {
        $random = generateRandomString(25);

        $message = <<< EOT
            <html>
                <body>
                    <p>Welcome to Phira</p>

                    <h3>Hi, $first_name</h3>
                    <p>Click the link below to verify your account.</p>
                    <a href="$BASE_URL/pages/auth/email_verification.php?token=$random">Verify your account</a>
                </body>
            </html>
        EOT;

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = <<< SQL
            INSERT 
                INTO users (
                    first_name,
                    last_name, 
                    email, 
                    password, 
                    verification_token, 
                    token_expiry
                    )
                VALUES (
                    '$first_name', 
                    '$last_name', 
                    '$email', 
                    '$hashed_password', 
                    '$random', 
                    NOW() + INTERVAL 1 DAY);
            SQL;

        sendEmail($email, $first_name, "Welcome to Phira - Verify your account", $message);

        if (mysqli_query($conn, $query)) {
            $new_user_id = mysqli_insert_id($conn);
            $_SESSION["user_id"] = $new_user_id;
            $_SESSION["user_first_name"] = $first_name;
            $_SESSION["user_last_name"] = $last_name;
            $_SESSION["role"] = "USER";

            header("Location: " . BASE_URL . "/pages/auth/email_verification.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Join With Us - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="container">
        <div class="left-panel">
            <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <header id="register-header">
                    <h1>Join with us...</h1>
                    <p>With an account, you can explore exclusive benefits</p>
                </header>

                <div class="input-group-container">
                    <div class="input-container">
                        <input type="text" name="first_name" id="first_name" placeholder="First Name"
                            value="<?php echo $first_name; ?>" required />
                        <span class="error-message"><?php echo $first_name_error; ?></span>
                    </div>

                    <div class="input-container">
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                            value="<?php echo $last_name; ?>" required />
                        <span class="error-message"><?php echo $last_name_error; ?></span>
                    </div>
                </div>

                <div class="input-container">
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>"
                        required />
                    <span class="error-message"><?php echo $email_error; ?></span>
                </div>

                <div class="input-container">
                    <input type="password" name="password" id="password" placeholder="Password"
                        value="<?php echo $password; ?>" required />
                    <span class="error-message"><?php echo $password_error; ?></span>
                </div>

                <div class="input-container">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                        value="<?php echo $confirm_password; ?>" required />
                    <span class="error-message"><?php echo $confirm_password_error; ?></span>
                </div>

                <div class="register-form-actions-container">
                    <button class="btn-primary form-submit-btn" type="submit">Next</button>
                    <div class="create-account-link-container"><a href="./login.php">I already have an account.</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="right-panel">
            <img src="<?php echo BASE_URL; ?>/public/images/register/register-reel-1.png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/register/register-reel-2.png" alt="1">
        </div>
    </div>

</body>

</html>
