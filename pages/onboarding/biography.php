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
$biography = $_POST["biography"];
$biography = '';

function is_distance_range_set($conn,$user_id)
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


    if (!empty($biography)) {
        // Update biography in the profiles table
        $query = "UPDATE profiles SET biography = '$biography' WHERE user_id = '$user_id';";

        if (mysqli_query($conn, $query)) {
            header("Location: " . BASE_URL . "/pages/onboarding/relationship_type.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        $biography = "Biography cannot be empty.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biography - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container biography-model-container">
        <form class="biography-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="input-container">
                <label for="biography">About Me</label>
                <p>Share a little about yourself! 📝 Highlight your passions, interests, and what makes you unique. Let others get to know the real you—be creative, be genuine, be you!</p>

                <textarea name="biography" id="biography"></textarea>

            </div>

            <div class="biography-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>
</body>

</html>
