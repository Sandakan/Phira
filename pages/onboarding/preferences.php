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
$user_id = $_SESSION["user_id"]?? null; 
$error = '';
function is_preferences_set($conn, $user_id)
{
    $check_query = <<< SQL
    SELECT 
        COUNT(*) AS count 
    FROM 
        user_preferences 
    WHERE 
        user_id = $user_id AND
        preference_option_id IN (
            SELECT preference_option_id FROM preference_options WHERE preference_id = 6
        )
    SQL;
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);

    if ($check_row['count'] > 0) {
        header("Location: " . BASE_URL . "/pages/onboarding/show_off.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $communication = $_POST['communication'] ?? null;
    $loveLanguage = $_POST['love-language'] ?? null;
    $education = $_POST['education'] ?? null;
    $sleeping = $_POST['sleeping'] ?? null;

    // Check if all preferences are selected
    if ($communication && $loveLanguage && $education && $sleeping) {
        try {

            $conn->begin_transaction();

            // Insert preferences into user_preferences table
            $query = "INSERT INTO user_preferences (user_id, preference_option_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            // Bind and execute for each preference
            $stmt->bind_param("ii", $user_id, $preferenceOptionId);

            $preferenceOptionId = $communication;
            $stmt->execute();

            $preferenceOptionId = $loveLanguage;
            $stmt->execute();

            $preferenceOptionId = $education;
            $stmt->execute();

            $preferenceOptionId = $sleeping;
            $stmt->execute();

            $conn->commit();

            header("Location: " . BASE_URL . "/pages/onboarding/show_off.php");
            exit;
        } catch (Exception $e) {
            // Rollback transaction on error
            // TODO: Save preferences failed.
            $conn->rollback();
            $error = "Failed to save preferences. Please try again.";
        }
    } else {
        $error = "Please select all preferences.";
    }
}

is_preferences_set($conn,$user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Preferences - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="preferences-container">
    <!-- Left Section -->
    <div class="preferences-left-section">
        <h1 class="preferences-title">What makes you uniquely you?</h1>
        <p class="preferences-description">Be real. The right match will love the real you.</p>
        <span class="error-message"> <?php echo $error; ?> </span>
        <br>
        <button class="preferences-next-btn">Next</button>
        
    </div>

    <!-- Right Section -->
    <div class="preferences-right-section">
       
            <!-- Communication Style -->
            <div class="preferences-question">
                <p class="preferences-question-title">What's your communication style?</p>
                <div class="preferences-options">
                    <input type="radio" id="big-texter" name="communication" value="24"/>
                    <label for="big-texter">Big time texter</label>

                    <input type="radio" id="phone-caller" name="communication" value="25"/>
                    <label for="phone-caller">Phone caller</label>

                    <input type="radio" id="video-chatter" name="communication" value="26"/>
                    <label for="video-chatter">Video chatter</label>

                    <input type="radio" id="bad-texter" name="communication" value="27"/>
                    <label for="bad-texter">Bad texter</label>

                    <input type="radio" id="in-person" name="communication" value="28"/>
                    <label for="in-person">Better in person</label>
                </div>
            </div>

            <!-- Love Language -->
            <div class="preferences-question">
                <p class="preferences-question-title">How do you receive love?</p>
                <div class="preferences-options">
                    <input type="radio" id="gestures" name="love-language" value="29"/>
                    <label for="gestures">Thoughtful gestures</label>

                    <input type="radio" id="presents" name="love-language" value="30"/>
                    <label for="presents">Presents</label>

                    <input type="radio" id="touch" name="love-language" value="31"/>
                    <label for="touch">Touch</label>

                    <input type="radio" id="compliments" name="love-language" value="32"/>
                    <label for="compliments">Compliments</label>

                    <input type="radio" id="time" name="love-language" value="33"/>
                    <label for="time">Time together</label>
                </div>
            </div>

            <!-- Education Level -->
            <div class="preferences-question">
                <p class="preferences-question-title">What is your education level?</p>
                <div class="preferences-options">
                    <input type="radio" id="bachelor-degree" name="education" value="34"/>
                    <label for="bachelor-degree">Bachelor degree</label>

                    <input type="radio" id="a-levels" name="education" value="35"/>
                    <label for="a-levels">A/L</label>

                    <input type="radio" id="high-school" name="education" value="36"/>
                    <label for="high-school">High school</label>

                    <input type="radio" id="phd" name="education" value="37"/>
                    <label for="phd">PhD</label>

                    <input type="radio" id="graduate-program" name="education" value="38"/>
                    <label for="graduate-program">On a graduate programme</label>
                </div>
            </div>

            <!-- Sleeping Habits -->
            <div class="preferences-question">
                <p class="preferences-question-title">What's your sleeping habits?</p>
                <div class="preferences-options">
                    <input type="radio" id="early-bird" name="sleeping" value="39"/>
                    <label for="early-bird">Early bird</label>

                    <input type="radio" id="night-owl" name="sleeping" value="40"/>
                    <label for="night-owl">Night owl</label>

                    <input type="radio" id="unique" name="sleeping" value="41"/>
                    <label for="unique">It varies</label>
                </div>
            </div>
       
    </div>
</div>
</form>
</body>

</html>
