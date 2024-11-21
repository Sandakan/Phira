<?php

if (!isset($_SESSION["profile_picture_url"])) die("Profile picture URL not set");
$profile_picture_url = BASE_URL . "/private/media/user_photos/" . $_SESSION["profile_picture_url"];
?>

<section class="match-found-alert hidden" id="match-found-alert">
    <span class="material-symbols-rounded" onclick="hideMatchFoundAlert()">join_inner</span>

    <h1>IT'S A MATCH</h1>
    <img id="matched-user-profile-picture" src="" alt="Match Img">
    <img id="user-profile-picture" src="<?php echo $profile_picture_url; ?>" alt="Match Img">
    <p>You have a match with <span id="matched-user-name">Nila</span>.</p>

    <div class="buttons-container">
        <button class="btn btn-primary" id="say-something-nice-btn">
            Say something nice
        </button>
        <button class="btn btn-primary" id="find-more-matches-btn" onclick="reload()">
            Find more matches
        </button>
    </div>
</section>