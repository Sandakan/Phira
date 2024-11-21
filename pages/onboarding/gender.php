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

function is_gender_set($conn, $user_id)
{

    // Check if gender record already exists for the logged-in user
    $check_query = "SELECT COUNT(*) AS count FROM profiles WHERE user_id = '$user_id' AND gender IS NOT NULL";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);

    // If gender is already set, redirect to the next page (or wherever needed)
    if ($check_row['count'] > 0) {
        header("Location: " . BASE_URL . "/pages/onboarding/distance_preference.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $gender = $_POST["gender"];

    if (!empty($user_id)) {

        if (empty($gender)) {
            $gender_error = "Gender can not be empty";
        }

        $query = "UPDATE  profiles SET gender = '$gender' WHERE user_id = $user_id ";

        if (mysqli_query($conn, $query)) {
            header("Location: " . BASE_URL . "/pages/onboarding/distance_preference.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        header("Location: " . BASE_URL . "/pages/auth/login.php");
        exit();
    }
}

is_gender_set($conn, $user_id);

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
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>


<body>

    <div class="container">
        <div class="left-panel">

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <h1>What’s your gender?</h1>
                <p>How do you roll?</p>
                <div class="gender-options">
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Female">
                        <span>Woman</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Male">
                        <span>Man</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Other">
                        <span>Other</span>
                    </label>
                </div>
                <button id="next-button" type="submit">Next</button>
            </form>
        </div>
        <div class="right-panel">
            <div class="photo-reel">
                <div class="profile-card">Tiana, 34</div>
                <div class="profile-card">Kathy, 22</div>
            </div>
        </div>
    </div>

</body>

</html>
