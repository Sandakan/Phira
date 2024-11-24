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
                    <button id="info-icon"><span class="privacy-icon material-symbols-rounded">info</span></button>
                </div>
            </div>
            <div class="messages-container">
                <div class="message-container receiver-message">
                    <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="">
                    <div class="message">
                        <p>Explorer at heart, always seeking the next adventure. Whether it's hiking up a mountain or
                            diving
                            into a new book, I'm all about the journey. Let's make some memories together!</p>
                    </div>
                </div>
                <div class="message-container sender-message">
                    <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="">
                    <div class="message">
                        <p>Explorer at heart, always seeking the next adventure. Whether it's hiking up a mountain or
                            diving
                            into a new book, I'm all about the journey. Let's make some memories together!</p>
                    </div>
                </div>
            </div>
            <div class="message-input-container">
                <textarea class="type-area" id="message-input" placeholder="Type a message..."></textarea>
                <button onclick="sendMessage()"><span class="privacy-icon material-symbols-rounded">send</span></button>
            </div>
        </section>
    </main>
    <nav class="match-user-profile-container" id="match-user-profile-container">
        <span class="close">&times;</span>
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
    <div id="block-panel">
        <div id="block-modal">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h1>Why Are You Block This User?</h1>
            </div>
            <form action="">
                <p>We take your safety seriously. Please choose a reason for blocking this user so we can review the
                    issue
                    and
                    keep our community a safe and respectful place for everyone. Your feedback helps us improve the
                    experience
                    for all users.</p>
                <div class="reason-container">
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="html">Harassment or Bullying</label><br>
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="css">Inappropriate Language or Behavior</label><br>
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="javascript">Fake Profile</label><br>
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="javascript">Spamming</label><br>
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="javascript">Offensive or Discriminatory Content</label><br>
                    <input type="radio" id="reson" name="reson" value="">
                    <label for="javascript">Other</label>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </div>


    <script src="<?php echo BASE_URL; ?>/public/scripts/chat.js"></script>
</body>

</html>