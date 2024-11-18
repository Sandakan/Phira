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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/fonts.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/auth.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/matches.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body id="body" data-base-url="<?php echo BASE_URL; ?>" data-user-id="<?php echo $_SESSION["user_id"]; ?>">
    <?php include('../../components/sidebar.php') ?>

    <main id="main">
        <section class="matches hidden" id="matches">
            <div class="match">
                <div class="match-banner">
                    <img src="<?php echo BASE_URL; ?>/private/media/user_photos/3.jpg" alt="Temp Match">
                    <div class="match-banner-data">
                        <div class="primary-data">
                            <h1 class="match-name">Lisa</h1>
                            <h3 class="match-age">22</h3>
                        </div>
                        <div class="secondary-data">
                            <span class="match-location"><span class="material-symbols-rounded">distance</span></span>
                            <span class="match-distance">2.5 km away</span>
                        </div>
                    </div>
                </div>
                <div class="match-info">
                    <div class="other-photos">
                        <img class="photo" src="<?php echo BASE_URL; ?>/private/media/user_photos/1.jpg" alt="Temp Match">
                        <img class="photo" src="<?php echo BASE_URL; ?>/private/media/user_photos/2.jpg" alt="Temp Match">
                        <img class="photo" src="<?php echo BASE_URL; ?>/private/media/user_photos/1.jpg" alt="Temp Match">
                        <img class="photo" src="<?php echo BASE_URL; ?>/private/media/user_photos/2.jpg" alt="Temp Match">
                    </div>
                    <p class="match-bio">
                        Explorer at heart, always seeking the next adventure. Whether it's hiking up a mountain or diving into a new book, I'm all about the journey. Let's make some memories together!
                    </p>
                    <div class="match-preferences">
                        <div class="match-preference location-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">distance</span>
                            </span>
                            <span class="match-preference-text"><b>2.5 km</b> away</span>
                        </div>
                        <div class="match-preference partner-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">digital_wellbeing</span>
                            </span>
                            <span class="match-preference-text">Looking for a <b>long-time partner</b></span>
                        </div>
                        <div class="match-preference birthday-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">cake</span>
                            </span>
                            <span class="match-preference-text"><b>22</b> years old</span>
                        </div>
                        <div class="match-preference gender-preference">
                            <span class="match-preference-icon-container">
                                <span class="material-symbols-rounded">female</span>
                            </span>
                            <span class="match-preference-text"><b>Female</b></span>
                        </div>
                    </div>
                    <div class="match-actions-container">
                        <button class="btn btn-primary dislike-btn">
                            <span class="btn-icon material-symbols-rounded-filled">heart_broken</span> Dislike</button>
                        <button class="btn btn-primary like-btn"><span class="btn-icon material-symbols-rounded-filled">favorite</span> Like</button>
                    </div>
                </div>
            </div>
        </section>

        <?php include('../../components/no_location_permission_alert.php') ?>
        <?php include('../../components/loader.php') ?>
    </main>

    <script src="<?php echo BASE_URL; ?>/public/scripts/matches.js"></script>
</body>

</html>
