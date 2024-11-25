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
    $check_query = <<<SQL
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

        if (isset($_POST["relationship_type"])) {
            $relationship_type = $_POST["relationship_type"];

            if (!empty($relationship_type)) {
                try {
                    $query = <<<SQL
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/relationship.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <form class="container" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="left-panel">
        <div class="register-form-actions-container">
            <span class="display-icon material-symbols-rounded">partner_exchange</span>
            <div class="register-form-actions-container-text">
                <p>step 5/8</p>
                <h2>Relationship</h2>
            </div>
        </div>
            <h1>What are you looking for?</h1>
            <p>What's your goal?</p>
            <button class="btn-primary form-submit-btn" type="submit">Next</button>
        </div>
        <div class="right-panel">
            <div class="relationship-type-options">
                <label class="radio-option relationship-type-option">
                    <input type="radio" id="relationship_type" name="relationship_type" value="1" required>
                    Long-Term Partner
                </label>
                <label class="radio-option relationship-type-option">
                    <input type="radio" id="relationship_type" name="relationship_type" value="2" required>
                    Short-Term Partner
                </label>
                <label class="radio-option relationship-type-option">
                    <input type="radio" id="relationship_type" name="relationship_type" value="3" required>
                    New Friends
                </label>
                <label class="radio-option relationship-type-option">
                    <input type="radio" id="relationship_type" name="relationship_type" value="4" required>
                    Still figuring it out
                </label>
                <label class="radio-option relationship-type-option">
                    <input type="radio" id="relationship_type" name="relationship_type" value="4" required>
                    Just a Fling
                </label>
            </div>
        </div>
    </form>
</body>

</html>
