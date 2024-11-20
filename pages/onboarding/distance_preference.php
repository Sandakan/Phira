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
    $check_query = "SELECT COUNT(*) AS count FROM profiles WHERE user_id = '$user_id' AND distance_range IS NOT NULL";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);


    if ($check_row['count'] > 0) {
        header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $distance_range = $_POST["distance_range"];

    if (!empty($distance_range)) {
        // Update distance range in the profiles table
        $query = "UPDATE profiles SET distance_range = '$distance_range' WHERE user_id = '$user_id';";

        if (mysqli_query($conn, $query)) {
            header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
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

            <h2>Your distance preference?</h2>
            <p>How far is too far?</p>
            <button class="next-btn">Next</button>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="circle">
                <div class="inner-circle"></div>
            </div>
            <div class="range-container">
                <label for="distance-range">distance preference ?</label>
                <input type="range" name="distance_range" id="distance-range" min="0" max="100" value="50" step="1">
                <span class="range-value">50 KM</span>
            </div>

        </div>
    </form>

    <script>
        const range = document.getElementById("distance-range");
        const rangeValue = document.querySelector(".range-value");

        range.addEventListener("input", () => {
            rangeValue.textContent = `${range.value} KM`;
        });
    </script>
</body>

</html>
