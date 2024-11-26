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


function is_distance_range_set($conn, $user_id)
{
    try {
        // Check if a record already exists for this user_id in the profiles table
        $check_query = <<<SQL
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

        // If a record exists, prevent further insertion
        if ($result && $data['count'] > 0) {
            header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $distance_range = $_POST["distance_range"];

    if (!empty($distance_range)) {
        // Update distance range in the profiles table
        try {
            // Check if a record already exists for this user_id in the profiles table
            $check_query = <<<SQL
                UPDATE
                    profiles
                SET
                    distance_range = :distance_range
                WHERE
                    user_id = :user_id;
            SQL;
            $statement = $conn->prepare($check_query);
            $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $statement->bindParam("distance_range", $distance_range, PDO::PARAM_INT);
            $result = $statement->execute();

            if ($result) {
                header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
                exit();
            } else {
                echo "Failed to update distance range.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $distance_error = "Distance preference cannot be empty.";
    }
}

is_distance_range_set($conn, $user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Distance - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <form method="POST" class="container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <!-- Left Panel -->
        <div class="left-panel">
            <div class="onboarding-progress-container">
                <span class="display-icon material-symbols-rounded">location_on</span>
                <div class="onboarding-progress-container-text">
                    <p>step 3/8</p>
                    <h2>Distance Range</h2>
                </div>
            </div>
            <div>
                <h1>Your distance preference?</h1>
                <p>How far is too far?</p>
                <button class="btn btn-primary">Next</button>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="distance-preference-right-section">
                <div class="circle-container">
                    <div class="outer-circle">
                        <div id="inner-circle"></div>
                    </div>
                </div>

                <div class=".range-container">
                    <div id="change-text">
                        <label for="distance-slider" class="slider-label">Distance Preference ?</label>
                        <span id="distance-value">50 KM</span>
                    </div>
                    <input type="range" id="distance-slider" min="10" max="100" value="50" name="distance_range"
                        step="1" oninput="updateCircleSize(this.value)" />
                </div>
            </div>
        </div>
    </form>

    <script>
    // Function to update the inner circle size dynamically
    function updateCircleSize(value) {
        const innerCircle = document.getElementById("inner-circle");
        const distanceValue = document.getElementById("distance-value");

        // Calculate the size as a percentage of the outer circle
        const maxSize = 200; // Outer circle's width and height
        const size = (parseInt(value) / 100) * maxSize; // Scale inner circle size

        innerCircle.style.width = `${size}px`;
        innerCircle.style.height = `${size}px`;

        // Update the displayed distance value
        distanceValue.textContent = `${value} KM`;
    }
</script>

</body>

</html>