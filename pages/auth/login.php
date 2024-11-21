<?php

// phpinfo();

require '../../config.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();

if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}

$email = $password = "";
$email_error = $password_error = "";
$is_error = false;

if (isset($_SESSION['user_id']) && isset($_GET['redirect'])) {
    header("Location: " . urldecode($_GET['redirect']));
    exit();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    if ($is_error) {
        $email_error = "Invalid email or password";
        exit();
    }

    $query = <<< SQL
            SELECT
                U.user_id,
                U.first_name,
                U.last_name,
                U.role,
                U.password,
                U.onboarding_completed_at,
                P.date_of_birth,
                P.gender,
                P.distance_range,
                P.biography,
                P.profile_picture_url
            FROM
                users AS U
                LEFT JOIN profiles AS P ON U.user_id = P.user_id
            WHERE
                email = :email 
            LIMIT 1;
        SQL;

    $statement = $conn->prepare($query);
    $statement->bindParam("email", $email, PDO::PARAM_STR);
    $result = $statement->execute();
    $row = $statement->fetch();


    if ($row) {
        $hashed_password = $row["password"];
        $is_password_valid = password_verify($password, $hashed_password);

        if ($is_password_valid) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["onboarding_completed"] = isset($row["onboarding_completed_at"]);
            $_SESSION["profile_picture_url"] = $row["profile_picture_url"];

            $gender = $row["gender"];
            $distance_range = $row["distance_range"];
            $biography = $row["biography"];

            if (isset($row["onboarding_completed_at"])) {
                if (isset($_GET['redirect'])) {
                    $redirectUrl = urldecode($_GET['redirect']);
                    header("Location: " . $redirectUrl);
                } else
                    header("Location: " . BASE_URL . "/pages/app/matches.php");
            } else {

                if (!isset($row["date_of_birth"])) {
                    header("Location: " . BASE_URL . "/pages/onboarding/date_of_birth.php");
                    exit();
                }
                if (!isset($gender)) {
                    header("Location: " . BASE_URL . "/pages/onboarding/gender.php");
                    exit();
                }
                if (!isset($distance_range)) {
                    header("Location: " . BASE_URL . "/pages/onboarding/distance_range.php");
                    exit();
                }
                if (!isset($biography)) {
                    header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
                    exit();
                }


                $query = <<< SQL
                SELECT
                    U.user_id,
                    PR.preference_name,
                    PRO.option_text
                FROM
                    users AS U
                    LEFT JOIN profiles AS P ON U.user_id = P.user_id
                    LEFT JOIN user_preferences AS UPR ON U.user_id = UPR.user_id
                    LEFT JOIN preference_options AS PRO ON UPR.preference_option_id = PRO.preference_option_id 
                    LEFT JOIN preferences AS PR ON PRO.preference_id = PR.preference_id
                WHERE
                    email = :email;
                SQL;

                $statement = $conn->prepare($query);
                $statement->bindParam("email", $email, PDO::PARAM_STR);
                $result = $statement->execute();
                $data = $statement->fetchAll();

                if ($data) {
                    foreach ($data as $row) {
                        $name = preg_replace('/\W/', '_', strtoupper($row["preference_name"]));
                        $text = preg_replace('/\W/', '_', strtoupper($row["option_text"]));

                        if ($name == "RELATIONSHIP_TYPE" && $text == "") {
                            header("Location: " . BASE_URL . "/pages/onboarding/relationship_type.php");
                            exit();
                        }

                        // drink, smoke, exercise, pets preferences are all in the 'habits' group
                        // so checking drink preference will be enough
                        if ($name == "DRINK" && $text == "") {
                            header("Location: " . BASE_URL . "/pages/onboarding/habits.php");
                            exit();
                        }

                        // communication style, expected love type, eductation level, sleeping habits are in the 'preferences' group
                        // so checking communication style preference will be enough
                        if ($name == "COMMUNICATION_STYLE" && $text == "") {
                            header("Location: " . BASE_URL . "/pages/onboarding/preferences.php");
                            exit();
                        }

                        $query = <<< SQL
                        SELECT
                            COUNT(P.photo_id) AS photo_count
                        FROM
                            users AS U
                            INNER JOIN photos AS P ON U.user_id = P.user_id
                        WHERE
                            email = :email; 
                        SQL;

                        $statement = $conn->prepare($query);
                        $statement->bindParam("email", $email, PDO::PARAM_STR);
                        $result = $statement->execute();
                        $data = $statement->fetch();

                        if ($data) {
                            header("Location: " . BASE_URL . "/pages/app/matches.php");
                            exit();
                        } else {
                            header("Location: " . BASE_URL . "/pages/onboarding/show_off.php");
                            exit();
                        }
                    }
                } else {
                    $email_error = "Failed to fetch preference data";
                }
            }
        } else {
            $password_error = "Invalid email or password";
        }
    } else {
        $email_error = "Invalid email or password";
    }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
    <title>Login - Phira</title>
</head>

<body>
    <!-- Left Panel -->
    <div class="left-panel">
        <h1>Let’s Start.</h1>
        <p>Login to your account to find connections, start chatting, and make meaningful connections.</p>
        <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">

            <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required>
            <span class="error-message"><?php echo $email_error ?></span>

            <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>"
                required>
            <span class="error-message"><?php echo $password_error ?></span>

            <a href="#" class="forgot-password">I forgot my password</a>
            <div id="form-actions">
                <button type="submit">Next</button>
                <a href="<?php echo BASE_URL; ?>/pages/auth/register.php" class="signup-link">I Don’t have an
                    account</a>
            </div>
        </form>
    </div>
    <!-- Right Panel -->
    <div class="right-panel">
        <div class="photo-reel">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPics (Nila).png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPic (Tara).png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPic (Noor).png" alt="1">
        </div>
        <div class="photo-reel1">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPic (Aurora).png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPic (Anne).png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/DesignPic (3).png" alt="1">
        </div>
    </div>
</body>

</html>
