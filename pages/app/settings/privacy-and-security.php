<?php
require '../../../config.php';
require '../../../utils/database.php';
require '../../../utils/authenticate.php';

$conn = initialize_database();
session_start();

// authenticate(array("USER"));
// if (!isset($_SESSION["onboarding_completed"])) {
//     header("Location: " . BASE_URL . "/login.php");
// }

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
            <div>
                <h2>Privacy Settings</h2>
                <p>Control what others see on your profile. 👀 Manage your last seen status, share your profile
                    selectively, and choose whether to show your age and birthday. Your privacy, your rules!</p>
            </div>
            <div>
                <span class="material-symbols-rounded">admin_panel_settings</span>
                <h3>Last seen visibility</h3>
                <p>When turned on, all your matches can see when you were last active. Turn it off to keep your activity
                    status private.</p>
                <select class="toggle">
                    <option>On</option>
                    <option>Off</option>
                </select>
            </div>

        </section>
    </main>
</body>

</html>