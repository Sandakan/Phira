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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chats - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/chats.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body id="body" class="" data-base-url="<?php echo BASE_URL; ?>" data-user-id="<?php echo $_SESSION["user_id"]; ?>">
    <?php include('../../components/sidebar.php') ?>
    <main>
        <?php include('../../components/chat_list.php') ?>
        <section id="chat-container">
            <div class="user-chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="">
                <div class="user-info-container">
                    <div class="user-info">
                        <h1>Anjalee Nethmi</h1>
                        <p>Online</p>
                    </div>
                    <span class="privacy-icon material-symbols-rounded">info</span>
                </div>
            </div>

            <div class="user-bio">
                <p>Wifey material 😙<br>
                    <br>
                    A lover of nature and cozy nights in. Always seeking the next adventure, whether it’s a hike
                    through
                    the mountains or a weekend getaway to an undiscovered café. Currently navigating life one cup of
                    coffee at a time.
                </p>
            </div>

            <div class="user-education">
                <span class="material-symbols-rounded">school</span>
                <p>Studying Psychology at ABC University</p>
            </div>
            <div class="user-tags">
                <div class="tag">
                    <p>#DogMom</p>
                </div>
                <div class="tag">
                    <p>#DogMom</p>
                </div>
            </div>
            <div class="user-actions-buttons">
                <button class="btn btn-primary" id="dislike-btn"><span
                        class="material-symbols-rounded">heart_broken</span>Dislike</button>
                <button class="btn btn-primary" id="block-report-btn"><span
                        class="material-symbols-rounded">block</span>Block &
                    Report</button>
            </div>
        </section>
    </main>

    <nav class="match-user-profile-container" id="match-user-profile-container">
        <div class="match-user-profile-picture">
            <img src="<?php echo BASE_URL; ?>/public/images/ProfilePic2.png" alt="">
        </div>

        <div class="match-info-container">
            <h1>Anjalee Nethmi ,22</h1>
            <div class="user-location">
                <span class="material-symbols-rounded">location_on</span>
                <p>3 kilometers away</p>
            </div>
        </div>

        <div class="user-bio">
            <p>Wifey material 😙<br>
                <br>
                A lover of nature and cozy nights in. Always seeking the next adventure, whether it’s a hike
                through
                the mountains or a weekend getaway to an undiscovered café. Currently navigating life one cup of
                coffee at a time.
            </p>
        </div>

        <div class="user-education">
            <span class="material-symbols-rounded">school</span>
            <p>Studying Psychology at ABC University</p>
        </div>
        <div class="user-tags">
            <div class="tag">
                <p>#DogMom</p>
            </div>
            <div class="tag">
                <p>#DogMom</p>
            </div>
        </div>
        <div class="user-actions-buttons">
            <button class="btn btn-primary" id="dislike-btn"><span
                    class="material-symbols-rounded">heart_broken</span>Dislike</button>
            <button class="btn btn-primary" id="block-report-btn"><span
                    class="material-symbols-rounded">block</span>Block &
                Report</button>
        </div>


        <div class="match-user-profile-container" id="match-user-profile-container">
            <div class="match-user-profile-picture">
                <img src="<?php echo BASE_URL; ?>/public/images/ProfilePic2.png" alt="">
            </div>

            <div class="match-info-container">
                <h1>Anjalee Nethmi ,22</h1>
                <div class="user-location">
                    <span class="material-symbols-rounded">location_on</span>
                    <p>3 kilometers away</p>
                </div>
            </div>

            <div class="user-bio">
                <p>Wifey material 😙<br>
                    <br>
                    A lover of nature and cozy nights in. Always seeking the next adventure, whether it’s a hike
                    through
                    the mountains or a weekend getaway to an undiscovered café. Currently navigating life one cup of
                    coffee at a time.
                </p>
            </div>

            <div class="user-education">
                <span class="material-symbols-rounded">school</span>
                <p>Studying Psychology at ABC University</p>
            </div>
            <div class="user-tags">
                <div class="tag">
                    <p>#DogMom</p>
                </div>
                <div class="tag">
                    <p>#DogMom</p>
                </div>
            </div>
            <div class="user-actions-buttons">
                <button class="btn btn-primary" id="dislike-btn"><span
                        class="material-symbols-rounded">heart_broken</span>Dislike</button>
                <button class="btn btn-primary" id="block-report-btn"><span
                        class="material-symbols-rounded">block</span>Block &
                    Report</button>
            </div>

        </div>



    </nav>


    <script src="<?php echo BASE_URL; ?>/public/scripts/chat.js"></script>

    <script>
    var modal = document.getElementById("match-user-profile-container");
    var user_profile = document.getElementById("info-icon");

    user_profile.onclick = function() {
        modal.style.display = "block";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    </script>

   
</body>

</html>
