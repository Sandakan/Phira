<?php

//Load Composer's autoloader
require '../../vendor/autoload.php';
require '../../config.php';
require '../../utils/database.php';
require '../../utils/generate_random_string.php';
require '../../utils/mailer.php';

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

    try {
        $query = <<< SQL
            SELECT
                COUNT(*) AS count
            FROM
                users 
            WHERE
                email = :email;
        SQL;

        $statement = $conn->prepare($query);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();
        $data = $statement->fetch();

        if ($data["count"] > 0) {
            $email_error = "Email already exists in the system.";
            $is_error = true;
        }
    } catch (Exception $e) {
        $is_error = true;
        $email_error = $e->getMessage();
    }


    if (!$is_error) {
        try {
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
                    :first_name, 
                    :last_name, 
                    :email, 
                    :password, 
                    :token, 
                    NOW() + INTERVAL 15 DAY);
            SQL;

            sendEmail($email, $first_name, "Welcome to Phira - Verify your account", $message);

            $statement = $conn->prepare($query);
            $statement->bindParam(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindParam(":last_name", $last_name, PDO::PARAM_STR);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $statement->bindParam(":token", $random, PDO::PARAM_STR);
            $result = $statement->execute();


            if ($result) {
                header("Location: " . BASE_URL . "/pages/auth/email_verification.php");
                exit();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
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
