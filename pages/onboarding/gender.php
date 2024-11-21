<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

/*$conn = initialize_database();
session_start();

authenticate(array("USER"));


if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}
$user_id = $_SESSION["user_id"];

function is_gender_set($conn, $user_id)
{

    try {
        // Check if a record already exists for this user_id in the profiles table
        $check_query = <<< SQL
            SELECT
                COUNT(*) AS count
            FROM
                profiles
            WHERE
                user_id = :user_id AND distance_range IS NOT NULL;
        SQL;
        $statement = $conn->prepare($check_query);
        $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $result = $statement->execute();
        $data = $statement->fetch();

        // If gender is already set, redirect to the next page (or wherever needed)
        if ($data['count'] > 0) {
            header("Location: " . BASE_URL . "/pages/onboarding/distance_preference.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $gender = $_POST["gender"];

    if (!empty($user_id)) {

        if (empty($gender)) {
            $gender_error = "Gender can not be empty";
        }

        try {
            $query = <<< SQL
                UPDATE
                    profiles
                SET
                    gender = :gender
                WHERE
                    user_id = :user_id;
            SQL;
            $statement = $conn->prepare($query);
            $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $statement->bindParam("gender", $gender, PDO::PARAM_STR);
            $result = $statement->execute();

            if ($result) {
                header("Location: " . BASE_URL . "/pages/onboarding/distance_preference.php");
                exit();
            } else {
                echo "Error: " . $e->getMessage();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        header("Location: " . BASE_URL . "/pages/auth/login.php");
        exit();
    }
}

is_gender_set($conn, $user_id);*/

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Select Your Gender - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/buttons.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>


<body>

    <div class="container gender-container">
        <div class="left-panel">

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <h1 class="gender-h1">What’s your gender?</h1>
                <p class="gender-p">How do you roll?</p>
                <div class="gender-options">
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Female">
                        <span class="gender-span">Woman</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Male">
                        <span class="gender-span">Man</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Other">
                        <span class="gender-span">Other</span>
                    </label>
                </div>
                <div >
                    <button class="next-btn" type="submit">Next</button>
                </div>
            </form>
        </div>
        <div class="right-panel">
            
               <img src="<?php echo BASE_URL; ?>/public/images/gender/gender-reel-1.png" alt="1">
               <img src="<?php echo BASE_URL; ?>/public/images/gender/gender-reel-2.png" alt="">
              
            
        </div>
    </div>

</body>

</html>
