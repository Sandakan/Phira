<?php

if (!isset($_SESSION["profile_picture_url"])) die("Profile picture URL not set");
$profile_picture_url = BASE_URL . "/private/media/user_photos/" . $_SESSION["profile_picture_url"];
?>

<section class="match-found-alert" id="match-found-alert">
    <button class="close-btn" onclick="hideMatchFoundAlert()"><span
            class="material-symbols-rounded">close</span></button>

    <div class="profile-pictures-container">
        <img id="matched-user-profile-picture" src="<?php echo $BASE_URL; ?>/private/media/user_photos/3.jpg"
            alt="Match Img">
        <img id="user-profile-picture" src="<?php echo $profile_picture_url; ?>" alt="Match Img">
    </div>
    <h1>IT'S A MATCH</h1>
    <p>You have a match with <span id="matched-user-name">Nila</span>.</p>

    <div class="buttons-container">
        <button class="btn btn-primary" id="say-something-nice-btn">
            <span class="material-symbols-rounded">chat</span>
            Say something nice
        </button>
        <button class="btn btn-primary" id="find-more-matches-btn" onclick="reload()">
            <span class="material-symbols-rounded">explore</span>
            Find more matches
        </button>
    </div>
</section>
