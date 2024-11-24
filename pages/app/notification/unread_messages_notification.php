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
  <title>Notification</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/settings.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/notification.css">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
  <?php include('../../../components/sidebar.php') ?>
  <main>
    <?php include('../../../components/settings_navbar.php') ?>

    <section>

      <div class="notification-birthday">
        <div class="notification-birthday-h">
          <div class="notification-birthday-reel">
          <span class="material-symbols-rounded">
              forum
            </span>
          </div>
          <div class="notification-birthday-h3">
            <h2>Unread Messages </h2>
          </div>
        </div>
        <div class="notification-birthday-notice">
          <p class="notification-birthday-p1">Welcome back! While you were offline, someone reached out to connect with you. 💌 Your inbox is brimming with unread messages from matches who are eager to hear from you!</p>
          <p class="notification-birthday-p2">2 minutes ago</p>
        </div>
        <div class="notification-birthday-btn-2">
          <button class="btn btn-primary"><span class="material-symbols-rounded">
              forum
            </span> Back to Chats</button>
          
        </div>
      </div>

    </section>

  </main>
</body>

</html>