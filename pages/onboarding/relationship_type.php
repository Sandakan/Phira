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
$relationship_type_error = '';

function is_relationship_type_set($conn, $user_id)
{
    $check_query = <<< SQL
    SELECT 
        COUNT(*) AS count 
    FROM 
        user_preferences 
    WHERE 
        user_id = :user_id AND
        preference_option_id IN (
            SELECT preference_option_id FROM preference_options WHERE preference_id = 1
        )
    SQL;
    $statement = $conn->prepare($check_query);
    $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
    $result = $statement->execute();
    $check_row = $statement->fetch();

    if ($result && $check_row['count'] > 0) {
        header("Location: " . BASE_URL . "/pages/onboarding/habits.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["relationship_type"])) {
        $relationship_type = $_POST["relationship_type"];

    if (!empty($relationship_type)) {
        // Update biography in the profiles table
        try {
            $query = <<< SQL
        INSERT INTO
            user_preferences (user_id ,preference_option_id)
        VALUES (:user_id, :relationship_type);
        SQL;

            $stmt = $conn->prepare($query);
            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam("relationship_type", $relationship_type, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                header("Location: " . BASE_URL . "/pages/onboarding/habits.php");
                exit();
            } else {
                echo "Failed to update relationship type.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $relationship_type_error = "Relationship type cannot be empty.";
    }
}
}

is_relationship_type_set($conn, $user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relationship type - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container register-model-container">
        <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="relationship-right-section">
                <div class="options">
                    <input type="radio" id="long_term" name="relationship_type" value="1" required>
                    <label for="long_term">Long-Term Partner</label><br>
                    <input type="radio" id="short_term" name="relationship_type" value="2" required>
                    <label for="short_term">Short-Term Partner</label><br>
                    <input type="radio" id="new_friends" name="relationship_type" value="3" required>
                    <label for="new_friends">New Friends</label><br>
                    <input type="radio" id="still_figuring" name="relationship_type" value="4" required>
                    <label for="still_figuring">Still figuring it out</label><br>
                </div>

            </div>

            <div class="relationship-left-section">
                <h1>What are you looking for?</h1>
                <p>What's your goal?</p>
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>
</body>

</html>