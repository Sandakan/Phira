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

$birth_day_error = "";


try {
    // Check if a record already exists for this user_id in the profiles table
    $check_query = <<<SQL
            SELECT
                COUNT(*) AS count,
                date_of_birth
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
        $birth_date = new DateTime($data['date_of_birth']);
        $current_date = new DateTime();
        $age = $current_date->diff($birth_date)->y;

        if ($age >= 18) {
            header("Location: " . BASE_URL . "/pages/onboarding/gender.php");
            exit();
        } else {
            $birth_day_error = "You must be at least 18 years old to use Phira";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_of_birth = $_POST["birth_day"];

    if (!empty($date_of_birth)) {

        // Calculate the age based on the date of birth
        $birth_date = new DateTime($date_of_birth);
        $current_date = new DateTime();
        $age = $current_date->diff($birth_date)->y;

        try {
            $query = <<<SQL
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
                    $birth_day_error = "You must be at least 18 years old to use Phira";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Date of Birth - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="container dateOfBirth-container">
        <div class="right-panel">
            <img src="<?php echo BASE_URL; ?>/public/images/dateOfBirth/dateOfBirth-reel-1.png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/dateOfBirth/dateOfBirth-reel-2.png" alt="2">

        </div>
        <div class="left-panel">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <div class="onboarding-progress-container">
                    <span class="display-icon material-symbols-rounded">cake</span>
                    <div class="onboarding-progress-container-text">
                        <p>step 1/8</p>
                        <h2>Birthday</h2>
                    </div>
                </div>
                <h1 class="dateOfBirth-h1">Your b-day?</h1>
                <p class="dateOfBirth-p">Enter your date of birth to find better matches.</p>

                <?php if ($birth_day_error != "You must be at least 18 years old to use Phira"): ?>
                    <div class="input-container">
                        <input type="date" name="birth_day" id="birth_day" placeholder="2000-01-01" required />
                        <span class="error-message"><?php echo $birth_day_error; ?></span>
                        <div>
                            <button class="btn btn-primary" type="submit">Next</button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="input-container">
                        <span class="error-message"><?php echo $birth_day_error; ?></span>
                    </div>
                <?php endif; ?>

            </form>

        </div>

    </div>
</body>

</html>