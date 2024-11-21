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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION["user_id"];
    $preferences = array("drink", "smoke", "exercise", "pets");
    $errors = [];

    $conn->begin_transaction();

    try {
        foreach ($preferences as $preference) {
            if (isset($_POST[$preference])) {
                $preference_option_id = intval($_POST[$preference]);

                // Insert into user_preferences
                $stmt = $conn->prepare("
                    INSERT INTO user_preferences (user_id, preference_option_id) 
                    VALUES (?, ?)
                    
                ");
                $stmt->bind_param("ii", $user_id, $preference_option_id);

                if (!$stmt->execute()) {
                    $errors[] = "Failed to save preference for $preference.";
                }

                $stmt->close();
            }
        }

        // If there are no errors, commit the transaction
        if (empty($errors)) {
            $conn->commit();
            header("Location: " . BASE_URL . "/pages/onboarding/preferences.php");
            exit();
        } else {
            // Rollback if errors occurred
            $conn->rollback();
            echo "Error saving preferences: " . implode(", ", $errors);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Habits - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <form class="container habits-container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  >
        <!-- Left Section -->
        <div class="left-section">
            <h2>Let’s dive into lifestyle choices, Vimukthi.</h2>
            <p>Do their habits align with yours?</p>
            <button type="submit" class="next-btn btn-primary">Next</button>
        </div>

        <!-- Right Section -->
        <div class="right-section">

            <div class="question">
                <p>How often do you drink?</p>
                <div class="options">
                    <label>
                        <input type="radio" name="drink" value="5">
                        <span>Newly teetotal</span>
                    </label>
                    <label>
                        <input type="radio" name="drink" value="6">
                        <span class="danger">Not for me</span>
                    </label>
                    <label>
                        <input type="radio" name="drink" value="7">
                        <span>On special occasions</span>
                    </label>
                    <label>
                        <input type="radio" name="drink" value="8">
                        <span>At the weekends</span>
                    </label>
                    <label>
                        <input type="radio" name="drink" value="9">
                        <span>Most nights</span>
                    </label>
                </div>
            </div>

            <div class="question">
                <p>How often do you smoke?</p>
                <div class="options">
                    <label>
                        <input type="radio" name="smoke" value="10">
                        <span>Newly teetotal</span>
                    </label>
                    <label>
                        <input type="radio" name="smoke" value="11">
                        <span class="danger">Not for me</span>
                    </label>
                    <label>
                        <input type="radio" name="smoke" value="12">
                        <span>On special occasions</span>
                    </label>
                    <label>
                        <input type="radio" name="smoke" value="13">
                        <span>At the weekends</span>
                    </label>
                    <label>
                        <input type="radio" name="smoke" value="14">
                        <span>Most nights</span>
                    </label>
                </div>
            </div>

            <div class="question">
                <p>Do you exercise?</p>
                <div class="options">
                    <label>
                        <input type="radio" name="exercise" value="15">
                        <span>Every day</span>
                    </label>
                    <label>
                        <input type="radio" name="exercise" value="16">
                        <span class="danger">Often</span>
                    </label>
                    <label>
                        <input type="radio" name="exercise" value="17">
                        <span>Sometimes</span>
                    </label>
                    <label>
                        <input type="radio" name="exercise" value="18">
                        <span>Never</span>
                    </label>
                </div>
            </div>

            <div class="question">
                <p>Do you have any pets?</p>
                <div class="options">
                    <label>
                        <input type="radio" name="pets" value="19">
                        <span>Dog</span>
                    </label>
                    <label>
                        <input type="radio" name="pets" value="20">
                        <span class="danger">Cat</span>
                    </label>
                    <label>
                        <input type="radio" name="pets" value="21">
                        <span>Fish</span>
                    </label>
                    <label>
                        <input type="radio" name="pets" value="22">
                        <span>Bird</span>
                    </label>
                    <label>
                        <input type="radio" name="pets" value="23">
                        <span>Amphibian</span>
                    </label>
                </div>
            </div>
    </form>
</body>

</html>