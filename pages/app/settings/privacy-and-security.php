<?php
require '../../../config.php';
require '../../../utils/database.php';
require '../../../utils/authenticate.php';

$conn = initialize_database(); // Ensure this returns a PDO instance
session_start();

authenticate(array("USER"));
if (!isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch current privacy settings from the database
$query = "SELECT show_age, show_birthday, last_seen, share_profile FROM profiles WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$current_settings = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve values from the POST request
        $show_age = isset($_POST["show_age"]) && $_POST["show_age"] == "1" ? 1 : 0;
        $show_birthday = isset($_POST["show_birthday"]) && $_POST["show_birthday"] == "1" ? 1 : 0;
        $last_seen = isset($_POST["last_seen_visibility"]) ? intval($_POST["last_seen_visibility"]) : 1;
        $share_profile = isset($_POST["share_profile"]) ? intval($_POST["share_profile"]) : 1;

        // Prepare and execute SQL query
        $query = "UPDATE profiles 
                  SET 
                      show_age = :show_age, 
                      show_birthday = :show_birthday, 
                      last_seen = :last_seen, 
                      share_profile = :share_profile, 
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE user_id = :user_id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':show_age', $show_age, PDO::PARAM_INT);
        $stmt->bindParam(':show_birthday', $show_birthday, PDO::PARAM_INT);
        $stmt->bindParam(':last_seen', $last_seen, PDO::PARAM_INT);
        $stmt->bindParam(':share_profile', $share_profile, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Privacy settings updated successfully.');
                    window.location.href = '" . BASE_URL . "/pages/app/settings/privacy-and-security.php';
                  </script>";
        } else {
            echo "<script>alert('Failed to update privacy settings. Please try again.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred: " . $e->getMessage() . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy and Security - Phira</title>
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
                <span class="material-symbols-rounded">admin_panel_settings</span>
                <h1>Privacy and Security</h1>
            </div>
            <div class="privacy-and-security">
                <h2>Privacy Settings</h2>
                <p>Control what others see on your profile. 👀 Manage your last seen status, share your profile
                    selectively, and choose whether to show your age and birthday. Your privacy, your rules!</p>
            </div>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
                <div class="privacy-settings">
                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">visibility_lock</span>
                                <h3>Last seen visibility</h3>
                            </div>
                            <p>When turned on, all your matches can see when you were last active. Turn it off to
                                keep
                                your
                                activity
                                status private.</p>
                        </div>
                        <select name="last_seen_visibility" class=""
                            style="font-size: 20px; font-weight: 500; padding: 10px 10px;">
                            <option value="1" <?php echo ($current_settings['last_seen'] == 1) ? 'selected' : ''; ?>>On
                            </option>
                            <option value="0" <?php echo ($current_settings['last_seen'] == 0) ? 'selected' : ''; ?>>Off
                            </option>
                        </select>
                    </div>
                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">search_off</span>
                                <h3>share Profile</h3>
                            </div>
                            <p>When enabled, others can view your profile if they have your link. Turn it off to
                                make
                                your profile visible only to those you’ve matched with.</p>
                        </div>
                        <select name="share_profile" class=""
                            style="font-size: 20px; font-weight: 500; padding: 10px 10px;">
                            <option value="1" <?php echo ($current_settings['share_profile'] == 1) ? 'selected' : ''; ?>>
                                On</option>
                            <option value="0" <?php echo ($current_settings['share_profile'] == 0) ? 'selected' : ''; ?>>
                                Off</option>
                        </select>
                    </div>
                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">edit_calendar</span>
                                <h3>Display Age</h3>
                            </div>
                            <p>When enabled, your age will be visible on your profile and match screen. Turn it off to
                                hide your age from everyone.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="show_age" value="1" id="showAgeSwitch" <?php echo ($current_settings['show_age'] == 1) ? 'checked' : ''; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">calendar_month</span>
                                <h3>Display Birthday</h3>
                            </div>
                            <p>When enabled, your birthday will be visible on your profile. Turn it off to keep your
                                birthday private from all users.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="show_birthday" value="1" id="showBirthdaySwitch" <?php echo ($current_settings['show_birthday'] == 1) ? 'checked' : ''; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>

            <!-- ----- security ----- -->

            <div class="security">
                <div class="privacy-and-security">
                    <h2>Security Settings</h2>
                    <p>Keep your account secure by updating your email and changing your password anytime. Ensure
                        your
                        details are always up to date for better account protection.</p>
                </div>
                <form action="">

                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">lock</span>
                                <h3>Change Password</h3>
                            </div>
                            <p>Update your password to keep your account secure. Choose a strong, unique password to
                                protect
                                your profile from unauthorized access.</p>
                        </div>
                        <a class="btn btn-secondary" href="<?php echo BASE_URL; ?>/pages/auth/reset_password.php">
                            Change password
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script>
        // Toggle functionality for the checkbox values
        const showAgeSwitch = document.getElementById('showAgeSwitch');
        const showBirthdaySwitch = document.getElementById('showBirthdaySwitch');
    </script>
</body>

</html>
