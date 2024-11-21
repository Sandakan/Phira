<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));

if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}

$user_id = $_SESSION["user_id"];


function is_birthday_set($conn, $user_id)
{
    try {
        // Check if a record already exists for this user_id in the profiles table
        $check_query = <<< SQL
            SELECT
                COUNT(*) AS count
            FROM
                profiles
            WHERE
                user_id = :user_id AND date_of_birth IS NOT NULL;
        SQL;
        $statement = $conn->prepare($check_query);
        $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $result = $statement->execute();
        $data = $statement->fetch();

        // If a record exists, prevent further insertion
        if ($result && $data['count'] > 0) {
            header("Location: " . BASE_URL . "/pages/onboarding/gender.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$birth_day_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_of_birth = $_POST["birth_day"];

    if (!empty($date_of_birth)) {

        // Calculate the age based on the date of birth
        $birth_date = new DateTime($date_of_birth);
        $current_date = new DateTime();
        $age = $current_date->diff($birth_date)->y;

        try {
            $query = <<< SQL
            INSERT INTO
                profiles (user_id, date_of_birth)
            VALUES (
                :user_id,
                :date_of_birth
            );
        SQL;
            $statement = $conn->prepare($query);
            $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $statement->bindParam("date_of_birth", $date_of_birth, PDO::PARAM_STR);
            $result = $statement->execute();

            if ($result) {
                if ($age >= 18) {
                    header("Location: " . BASE_URL . "/pages/onboarding/gender.php");
                    exit();
                } else {
                    header("Location: " . BASE_URL . "/pages/onboarding/unauthorized.php");
                    exit();
                }
            } else {
                echo "Failed to insert data of birth";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $birth_day_error = "Birthday can not be empty";
    }
}

is_birthday_set($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Date of Birth - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>


    <div class="model-container register-model-container">
        <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="input-container">
                <label for="birth_day">Your b-day</label>
                <input type="date" name="birth_day" id="birth_day" placeholder="2000-01-01" required />
                <span class="error-message"><?php echo $birth_day_error; ?></span>
            </div>

            <div class="register-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>

</body>

</html>
