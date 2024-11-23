<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

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
    <title>Profile - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/settings.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <?php include('../../components/sidebar.php') ?>
    <main>
        <?php include('../../components/settings_navbar.php') ?>
        <section>
            <div class="title-container">
                <span class="material-symbols-rounded">account_circle</span>
                <h1>My Profile</h1>
            </div>
            <div class="profile-card">
                <img src="<?php echo BASE_URL; ?>/public/images/ProfilePic.png" alt="">
                <h2>Sandakan ,21</h2>
                <p>Hey there! 😊 I'm here to meet new people, share good vibes ✨, and see where things go. I love
                    exploring new places 🌍, trying different cuisines 🍣, and having meaningful conversations 🗣️.
                    Let's connect and make some great memories together! 💫</p>

                <button class="btn btn-primary">Edit Profile</button>
                <button class="btn btn-primary">Logout</button>
            </div>
        </section>
    </main>
</body>

</html>