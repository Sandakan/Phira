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

    <script src="<?php echo BASE_URL; ?>/public/scripts/chat.js"></script>
</body>

</html>