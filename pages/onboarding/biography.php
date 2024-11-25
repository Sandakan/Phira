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
$biography = '';

function is_biography_set($conn, $user_id)
{
    try {
        // Check if a record already exists for this user_id in the profiles table
        $check_query = <<< SQL
            SELECT
                COUNT(*) AS count
            FROM
                profiles
            WHERE
                user_id = :user_id AND biography IS NOT NULL;
        SQL;
        $statement = $conn->prepare($check_query);
        $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $result = $statement->execute();
        $data = $statement->fetch();

        // If a record exists, prevent further insertion
        if ($result && $data['count'] > 0) {
            header("Location: " . BASE_URL . "/pages/onboarding/relationship_type.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $biography = $_POST["biography"];


    if (!empty($biography)) {
        // Update biography in the profiles table
        try {
            $query = <<< SQL
        UPDATE
            profiles
        SET
            biography = :biography
        WHERE
            user_id = :user_id;
        SQL;

            $statement = $conn->prepare($query);
            $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $statement->bindParam("biography", $biography, PDO::PARAM_STR);
            $result = $statement->execute();

            if ($result) {
                header("Location: " . BASE_URL . "/pages/onboarding/relationship_type.php");
                exit();
            } else {
                echo "Failed to update biography.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $biography = "Biography cannot be empty.";
    }
}

is_biography_set($conn, $user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biography - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/biography.css"> -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">

    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <form class="container biography-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


        <div class="left-panel">
            <div class="onboarding-progress-container">
                <span class="display-icon material-symbols-rounded">person_book</span>
                <div class="onboarding-progress-container-text">
                    <p>step 4/8</p>
                    <h2>Bio</h2>
                </div>
            </div>
            <h1>About Me</h1>
            <p>Share a little about yourself! 📝 Highlight your passions, interests, and what makes you unique.
                Let
                others get to know the real you—be creative, be genuine, be you!</p>

            <div class="input-container">
                <textarea name="biography" id="biography" placeholder="Tell us about yourself..."></textarea>
            </div>


            <div class="biography-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </div>


        <div class="right-panel">
            <img src="<?php echo BASE_URL; ?>/public/images/biography/biography-reel-1.png" alt="1">
            <img src="<?php echo BASE_URL; ?>/public/images/biography/biography-reel-2.png" alt="1">
        </div>
    </form>
</body>

</html>
