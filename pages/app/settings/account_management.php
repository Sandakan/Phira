<?php
require '../../../config.php';
require '../../../utils/database.php';
require '../../../utils/authenticate.php';

$conn = initialize_database();
session_start();
$error_message = '';

// Authenticate the user and check onboarding status
authenticate(array("USER"));
if (!isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/login.php");
    exit();
}

// Fetch relationship type options
$relationship_types = [];
try {
    $stmt = $conn->prepare("SELECT preference_option_id, option_text FROM preference_options WHERE preference_id = 1");
    $stmt->execute();
    $relationship_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching relationship types: " . $e->getMessage());
}

// Fetch user preferences from profiles
$user_preferences = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            distance_range, 
            preferred_age_min, 
            preferred_age_max
        FROM profiles 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user_preferences = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching user preferences: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user_id = $_SESSION['user_id'];

        // Retrieve and validate form inputs
        $relationship_type = !empty($_POST['relationship_type']) ? $_POST['relationship_type'] : null;
        $distance_range = !empty($_POST['distance_range']) ? (int) $_POST['distance_range'] : null;
        $preferred_age_min = !empty($_POST['preferred_age_min']) ? (int) $_POST['preferred_age_min'] : null;
        $preferred_age_max = !empty($_POST['preferred_age_max']) ? (int) $_POST['preferred_age_max'] : null;
        $preferred_gender = !empty($_POST['gender']) ? (int) $_POST['gender'] : null;

        // Ensure the user has a user_preferences record
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user_preferences WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user_preferences_exists = $stmt->fetchColumn() > 0;

        if (!$user_preferences_exists) {
            throw new Exception("Preferences record not found. Please contact support.");
        }

        // Update relationship type in user_preferences
        try {
            $stmt = $conn->prepare("
                UPDATE user_preferences 
                SET preference_option_id = (
                    SELECT preference_option_id 
                    FROM preference_options 
                    WHERE preference_id = :preference_id AND option_text = :option_text
                )
                WHERE user_id = :user_id AND preference_option_id IN (
                    SELECT preference_option_id 
                    FROM preference_options 
                    WHERE preference_id = :preference_id
                )
            ");
        
            $stmt->bindParam(':preference_id', $preference_id, PDO::PARAM_INT);
            $stmt->bindParam(':option_text', $option_text, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating preference: " . $e->getMessage());
        }

        try {
            // Update user profile preferences
            if ($distance_range !== null || $preferred_age_min !== null || $preferred_age_max !== null) {
                $stmt = $conn->prepare("
                    UPDATE profiles 
                    SET 
                        distance_range = :distance_range,
                        preferred_age_min = :preferred_age_min,
                        preferred_age_max = :preferred_age_max
                    WHERE user_id = :user_id
                ");
                
                $stmt->bindParam(':distance_range', $distance_range, PDO::PARAM_INT);
                $stmt->bindParam(':preferred_age_min', $preferred_age_min, PDO::PARAM_INT);
                $stmt->bindParam(':preferred_age_max', $preferred_age_max, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            // Log the error and optionally display a user-friendly message
            error_log("Error updating user profile preferences: " . $e->getMessage());
            echo "An error occurred while updating your profile preferences. Please try again later.";
        }

        try {
            // Check if a record exists for the user's preferred gender
            $stmt = $conn->prepare("
                SELECT COUNT(*) 
                FROM user_preferences 
                WHERE user_id = :user_id AND preference_option_id IN (42, 43, 44)
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $recordExists = $stmt->fetchColumn();
        
            if ($recordExists > 0) {
                // Update the existing record
                $stmt = $conn->prepare("
                    UPDATE user_preferences 
                    SET preference_option_id = :preference_option_id, updated_at = CURRENT_TIMESTAMP 
                    WHERE user_id = :user_id AND preference_option_id IN (42, 43, 44)
                ");
            } else {
                // Insert a new record
                $stmt = $conn->prepare("
                    INSERT INTO user_preferences (user_id, preference_option_id, created_at, updated_at) 
                    VALUES (:user_id, :preference_option_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
                ");
            }
        
            // Bind parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':preference_option_id', $preferred_gender, PDO::PARAM_INT);
        
            // Execute query
            $stmt->execute();
        
            echo "Preferred gender has been successfully updated!";
        } catch (PDOException $e) {
            // Log the error and display a friendly message
            error_log("Error updating preferred gender: " . $e->getMessage());
            echo "An error occurred while updating your preferred gender. Please try again later.";
        }
        
        
        // Reload the page to reflect updates
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit();
    } catch (PDOException $e) {
        error_log("Error updating preferences: " . $e->getMessage());
        $error_message = "Failed to save your preferences. Please try again.";

    } 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/settings.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <?php include('../../../components/sidebar.php') ?>
    <main>
        <?php include('../../../components/settings_navbar.php') ?>
        <section>
            <div class="title-container">
                <span class="material-symbols-rounded">supervised_user_circle</span>
                <h1>Account Management</h1>
            </div>
            <div>
                <form action="" method="POST">
                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">digital_wellbeing</span>
                                <h3>Relationship Type</h3>
                            </div>
                            <p>Customize what you're looking for—whether it’s a long-term relationship, short-term
                                connection, new friendships, or something else. Adjust your preferences anytime!</p>
                        </div>
                        <select name="relationship_type" style="font-size: 20px; font-weight: 500; padding: 10px 15px;">

                            <option name="relationship_type" value="1">
                                Long-Term Partner
                            </option>
                            <option name="relationship_type" value="2">
                                Short-Term Partner
                            </option>
                            <option name="relationship_type" value="3">
                                New Friend
                            </option>
                            <option name="relationship_type" value="4">
                                Still Figuring It Out
                            </option>

                        </select>
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">6_ft_apart</span>
                                <h3>Distance Preference</h3>
                            </div>
                            <p>Set your match distance to find people nearby, up to a maximum of 100 km. Adjust it to
                                meet
                                people as close or as far as you like!</p>
                        </div>
                        <input type="number" name="distance_range" placeholder="Distance Range"
                            value="<?= htmlspecialchars($user_preferences['distance_range'] ?? '') ?>"
                            style="font-size: 20px; font-weight: 500; padding: 10px 15px;">

                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">heart_check</span>
                                <h3>Age Preference</h3>
                            </div>
                            <p>Set your preferred age range to find matches that suit you best. Customize the minimum
                                and maximum age to connect with people who fit your ideal match!</p>
                        </div>

                        <div>
                            <input type="number" id="preferred_age" name="preferred_age_min" placeholder="Minimum Age"
                                value="<?= htmlspecialchars($user_preferences['preferred_age_min'] ?? '') ?>"
                                style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                            <input type="number" id="preferred_age" name="preferred_age_max" placeholder="Maximum Age"
                                value="<?= htmlspecialchars($user_preferences['preferred_age_max'] ?? '') ?>"
                                style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                        </div>

                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">transgender</span>
                                <h3>Preferred Gender</h3>
                            </div>
                            <p>Choose who you'd like to match with—select women, men, or others based on your
                                preference. Update your settings anytime!</p>
                        </div>
                        <select name="gender" style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                            
                                <option name = "gender" value="42">Man</option>        
                                <option name = "gender" value="43">Woman</option>
                                <option name = "gender" value="44">Other</option>
                        </select>

                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">emoji_language</span>
                                <h3>Lifestyle Preferences</h3>
                            </div>
                            <p>Personalize your lifestyle choices—share how often you drink, smoke, exercise, and the
                                pets you have. Let others know what fits your daily vibe!</p>

                        </div>
                        <a href="#" class="btn btn-secondary ">Click to change</a>
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">heart_check</span>
                                <h3>Personal Insights</h3>
                            </div>
                            <p>Share more about yourself—whether it’s your communication style, love language,
                                education, or sleeping habits. Let your matches discover what makes you, you!</p>

                        </div>
                        <a href="#" class="btn btn-secondary ">Click to change</a>
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                    <span class="error-message"><?php echo $error_message ?></span>
                </form>
            </div>
        </section>
    </main>
</body>

</html>