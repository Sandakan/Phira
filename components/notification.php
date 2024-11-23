<?php
require '../config.php';
require '../utils/database.php';
require '../utils/authenticate.php';

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
  <title>Notification</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/notifications.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">

</head>

<body>
  <?php include('./sidebar.php') ?>
<main>
  <nav class="nav-bar">
    
    <div class="notification-panal">
    <h1>Notification</h1>
      <div class="notification-types">
        <div class="notification-icon">
          <span class="material-symbols-rounded">cake</span>
        </div>

        <div class="notification-details">
          <h2>Birthday Notification</h2>
          <p>🎉 It’s Nilani’s birthday today....</p>
        </div>
        <div class="notification-times">
          <p class="notification-time">12:00 PM</p>
          <p class="notification-number">+5</p>
        </div>
      </div>

      <div class="notification-types">
        <div class="notification-icon">
          <span class="material-symbols-rounded">partner_exchange</span>
        </div>

        <div class="notification-details">
          <h2>Match Notifications </h2>
          <p>Congratulations! 🎉 You’ve .......</p>
        </div>
        <div class="notification-times">
          <p class="notification-time">12:00 PM</p>
          <p class="notification-number">+1</p>
        </div>
      </div>

      <div class="notification-types">
        <div class="notification-icon">
        <span class="sidebar-nav-btn-icon material-symbols-rounded material-symbols-rounded-filled">favorite</span>
        </div>

        <div class="notification-details">
          <h2>Likes</h2>
          <p>Exciting news! Someone just......</p>
        </div>
        <div class="notification-times">
          <p class="notification-time">12:00 PM</p>
          <p class="notification-number">+2</p>
        </div>
      </div>

      <div class="notification-types">
        <div class="notification-icon">
        <span class="sidebar-nav-btn-icon material-symbols-rounded material-symbols-rounded-filled">forum</span>
        </div>

        <div class="notification-details">
          <h2>Unread Messages </h2>
          <p>Congratulations! 🎉 You’ve .......</p>
        </div>
        <div class="notification-times">
          <p class="notification-time">12:00 PM</p>
          <p class="notification-number">+8</p>
        </div>
      </div>
    </div>
  </nav>
  </main>
</body>
</html>