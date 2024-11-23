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
    <title>Chats - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/chats.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <?php include('../../components/sidebar.php') ?>
    <nav class="chats">
        <h1>Chats</h1>
        <div class="chats-container">

            <div class="search-bar">
                <span class="icons material-symbols-rounded">search</span>
                <p>search</p>
            </div>
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>

        </div>
    </nav>
</body>

</html>