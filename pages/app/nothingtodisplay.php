<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';
// require '../../server/matchmaking.server.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));
if (!isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/login.php");
}

// $matches = findMatches($_SESSION["user_id"], $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No More Matches Nearby!</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/matches.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>
<body>
<?php include('../../components/sidebar.php') ?>

<div class="no-matches-container">
<div class="alert-icon">
<span class="material-symbols-rounded">brightness_alert</span>
</div>

<div id="main-error">
    <p>No More Matches Nearby!</p>
</div>
<div id="sub-error">
    <p>You've run out of matches in your area. Do you want to expand your Distance Preference and discover more people?</p>
</div>
<div id="button-container">
    <button class="Refresh "><a href="">Refresh</button>
    <button class="btn-settings"><a href="distance_preference.php">Increase Distance</button>
</div>
</div>
</body>
</html>