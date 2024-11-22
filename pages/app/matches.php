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
    <title>Spark some magic! - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/matches.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body id="body" class="" data-base-url="<?php echo BASE_URL; ?>"
    data-user-id="<?php echo $_SESSION["user_id"]; ?>">
    <?php include('../../components/sidebar.php') ?>

    <main id="main">
        <section class="matches hidden" id="matches"></section>

        <?php include('../../components/loader.php') ?>
        <?php include('../../components/no_location_permission_alert.php') ?>
        <?php include('../../components/no_matches_alert.php') ?> -->
        <?php include('../../components/match_found_alert.php') ?>
    </main>

    <script src="<?php echo BASE_URL; ?>/public/scripts/matches.js"></script>
</body>

</html>
