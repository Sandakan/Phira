<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));
if (!isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/login.php");
}

// Logout query
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {

    try {
        $stmt = $conn->prepare("INSERT INTO activities(user_id, activity_type,activity_timestamp) VALUES (:user_id,:activity_type ,:logout_time)");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':activity_type' => 'LOGOUT',
            ':logout_time' => date('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }

    // Clear the session and redirect
    session_unset();
    session_destroy();
    header("Location:". BASE_URL . "/pages/auth /login.php");
    exit();
}
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
                <a href="?logout=true" class="btn btn-primary" >Logout</a>
                
            </div>
        </section>
    </main>
</body>

</html>