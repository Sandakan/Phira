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

// function is_relationship_type_set($conn,$user_id)
// {
//     $check_query = "SELECT COUNT(*) AS count FROM user_preferences WHERE user_id = '$user_id' " ;
//     $check_result = mysqli_query($conn, $check_query);
//     $check_row = mysqli_fetch_assoc($check_result);

//     if ($check_row['count'] > 0) {
//         header("Location: " . BASE_URL . "/pages/onboarding/biography.php");
//         exit();
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $relationship_type = $_POST["relationship_type"];

    if (!empty($relationship_type)) {
        // Update biography in the profiles table
        $query = "INSERT INTO user_preferences  (user_id,preference_option_id) VALUES ($user_id, $relationship_type);";

        if (mysqli_query($conn, $query)) {
            header("Location: " . BASE_URL . "/pages/onboarding/habits.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        $relationship_type_error = "Relationship type cannot be empty.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relationship type - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container register-model-container">
        <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="input-container">
                <label for="gender">What are you looking for?</label>

                <input type="radio" id="relationship_type" name="relationship_type" value="1">
                <label for="html">Long Term Partner</label><br>
                <input type="radio" id="relationship_type" name="relationship_type" value="2">
                <label for="html">Short Term Partner</label><br>
                <input type="radio" id="relationship_type" name="relationship_type" value="3">
                <label for="html">New Friends</label><br>
                <input type="radio" id="relationship_type" name="relationship_type" value="4">
                <label for="html">Still figuring it out</label><br>

            </div>

            <div class="register-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>
</body>

</html>
