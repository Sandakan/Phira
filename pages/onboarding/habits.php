<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));

$user_id = $_SESSION["user_id"];
$name = $_SESSION["first_name"];

if (isset($_SESSION["user_id"]) && isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}

function is_habits_set($conn, $user_id)
{
    try {
        $check_query = <<<SQL
        SELECT
            COUNT(*) AS count 
        FROM
            user_preferences 
        WHERE
            user_id = :user_id AND
            preference_option_id IN (
                SELECT
                    preference_option_id
                FROM
                    preference_options
                WHERE
                    (preference_id = 2 OR
                    preference_id = 3 OR
                    preference_id = 4 OR
                    preference_id = 5)
            )
        SQL;
        $statement = $conn->prepare($check_query);
        $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $result = $statement->execute();
        $check_row = $statement->fetch();

        if ($result && $check_row['count'] > 0) {
            header("Location: " . BASE_URL . "/pages/onboarding/preferences.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $preferences = array("drink", "smoke", "exercise", "pets");
    $errors = [];

    $conn->beginTransaction();
    try {
        // Insert into user_preferences
        $query = <<<SQL
            INSERT INTO
                user_preferences (user_id, preference_option_id)
            VALUES (:user_id, :preference_option_id);
        SQL;
        $stmt = $conn->prepare($query);

        foreach ($preferences as $preference) {
            if (isset($_POST[$preference])) {
                $preference_option_id = intval($_POST[$preference]);

                $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                $stmt->bindParam("preference_option_id", $preference_option_id, PDO::PARAM_INT);

                $result = $stmt->execute();

                if (!$result) {
                    $errors[] = "Failed to save preference for $preference.";
                }
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

is_habits_set($conn, $user_id);
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
    <form class="container habits-container" method="post"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Left Panel -->
        <div class="left-panel">

            <div class="onboarding-progress-container">
                <span class="display-icon material-symbols-rounded">nightlife</span>
                <div class="onboarding-progress-container-text">
                    <p>step 6/8</p>
                    <h2>Lifestyle</h2>
                </div>
            </div>
            <h2>Let’s dive into lifestyle choices, <?php echo $name; ?>.</h2>
            <p>Do their habits align with yours?</p>
            <button type="submit" class="next-btn btn-primary">Next</button>

        </div>

        <!-- Right Section -->
        <div class="habit-right-section">

            <div class="question">
                <p>How often do you drink?</p>
                <div class="habit-options">

                    <input type="radio" id="newly_teetotal" name="drink" value="5" required>
                    <Label for="newly_teetotal">Newly teetotal</Label>

                    <input type="radio" id="not_for_me" name="drink" value="6" required>
                    <Label for="not_for_me" class="danger">Not for me</Label>

                    <input type="radio" id="on_special_occasions" name="drink" value="7" required>
                    <Label for="on_special_occasions">On special occasions</Label>

                    <input type="radio" id="weekends" name="drink" value="8" required>
                    <Label for="weekends">At the weekends</Label>

                    <input type="radio" id="most_nights" name="drink" value="9" required>
                    <Label for="most_nights">Most nights</Label>

                </div>
            </div>

            <div class="question">
                <p>How often do you smoke?</p>
                <div class="habit-options">
                    <input type="radio" id="smoke_newly_teetotal" name="smoke" value="10" required>
                    <label for="smoke_newly_teetotal">Newly teetotal</label>

                    <input type="radio" id="smoke_not_for_me" name="smoke" value="11" required>
                    <label for="smoke_not_for_me" class="danger">Not for me</label>

                    <input type="radio" id="smoke_special_occasions" name="smoke" value="12" required>
                    <label for="smoke_special_occasions">On special occasions</label>

                    <input type="radio" id="smoke_weekends" name="smoke" value="13" required>
                    <label for="smoke_weekends">At the weekends</label>

                    <input type="radio" id="smoke_most_nights" name="smoke" value="14" required>
                    <label for="smoke_most_nights">Most nights</label>
                </div>
            </div>

            <div class="question">
                <p>Do you exercise?</p>
                <div class="habit-options">
                    <input type="radio" id="exercise_every_day" name="exercise" value="15">
                    <label for="exercise_every_day">Every day</label>

                    <input type="radio" id="exercise_often" name="exercise" value="16">
                    <label for="exercise_often" class="danger">Often</label>

                    <input type="radio" id="exercise_sometimes" name="exercise" value="17">
                    <label for="exercise_sometimes">Sometimes</label>

                    <input type="radio" id="exercise_never" name="exercise" value="18">
                    <label for="exercise_never">Never</label>
                </div>
            </div>

            <div class="question">
                <p>Do you have any pets?</p>
                <div class="habit-options">
                    <input type="radio" id="no" name="pets" value="45">
                    <label for="no">No</label>

                    <input type="radio" id="pet_dog" name="pets" value="19">
                    <label for="pet_dog">Dog</label>

                    <input type="radio" id="pet_cat" name="pets" value="20">
                    <label for="pet_cat" class="danger">Cat</label>

                    <input type="radio" id="pet_fish" name="pets" value="21">
                    <label for="pet_fish">Fish</label>

                    <input type="radio" id="pet_bird" name="pets" value="22">
                    <label for="pet_bird">Bird</label>

                    <input type="radio" id="pet_amphibian" name="pets" value="23">
                    <label for="pet_amphibian">Amphibian</label>
                </div>
            </div>

    </form>
</body>

</html>