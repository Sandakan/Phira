<?php
require '../config.php';
require '../utils/database.php';
require '../utils/authenticate.php';

/*$conn = initialize_database();
session_start();*/

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
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/notification.css">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

  <main>
    <nav class="nav-bar">
      <div class="notification-birthday">
        <div class="notification-birthday-h">
          <div class="notification-birthday-reel">
            <span class="material-symbols-rounded">
              cake
            </span>
          </div>
          <div class="notification-birthday-h3">
            <h2>Birthday Notifications</h2>
          </div>

        </div>
        <div class="notification-birthday-notice">
          <p class="notification-birthday-p1">🎉 It’s Nilani’s birthday today! Celebrate the special day by sending your
            warm wishes. We’ve suggested a message to make it extra sweet—don’t miss this chance to make her smile!</p>
          <p class="notification-birthday-p2">3 hours ago</p>
        </div>
        <div class="notification-birthday-btn-2">
          <button class="btn btn-primary"><span class="material-symbols-rounded">
              forum
            </span> Another year, brighter you! 🌟</button>
          <button class="btn btn-primary"><span class="material-symbols-rounded">
              forum
            </span>It’s your day! 🎁🎈</button>
        </div>



      </div>

    </nav>

  </main>
</body>

</html>