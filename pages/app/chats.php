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

<body id="body" class="" data-is-chat="true" data-base-url="<?php echo BASE_URL; ?>"
    data-user-id="<?php echo $_SESSION["user_id"]; ?>"
    data-user-profile-picture="<?php echo $_SESSION["profile_picture_url"]; ?>">
    <?php include('../../components/sidebar.php') ?>
    <main>
        <?php include('../../components/chat_list.php') ?>
        <section id="chat-container"></section>

        <aside class="match-user-profile-container hidden" id="match-user-profile-container"></aside>
    </main>

    <dialog id="block-panel">
        <div id="block-modal">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h1>Why Are You Block This User?</h1>
            </div>
            <form action="">
                <p>
                    We take your safety seriously. Please choose a reason for blocking this user so we can review the
                    issue and keep our community a safe and respectful place for everyone. Your feedback helps us
                    improve the experience for all users.
                </p>
                <div class="reason-container">
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="html">Harassment or Bullying</label><br>
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="css">Inappropriate Language or Behavior</label><br>
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="javascript">Fake Profile</label><br>
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="javascript">Spamming</label><br>
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="javascript">Offensive or Discriminatory Content</label><br>
                    <input type="radio" id="reason" name="reason" value="">
                    <label for="javascript">Other</label>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </dialog>
    <script src="<?php echo BASE_URL; ?>/public/scripts/chat.js" type="module"></script>
</body>

</html>
