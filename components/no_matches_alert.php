<section class="no-matches-alert hidden" id="no-matches-alert">
    <span class="material-symbols-rounded">brightness_alert</span>

    <h1>No More Matches Nearby!</h1>
    <p>You've run out of matches in your area. Do you want to expand your Distance Preference and discover more
        people?</p>

    <div class="buttons-container">
        <button class="btn btn-primary" id="reload-page-btn" onclick="reload()">Reload</button>
        <a href="<?php echo BASE_URL . '/pages/app/settings/account_management.php'; ?>" class="btn btn-primary"
            id="increase-distance-btn" onclick="">Increase Distance</a>
    </div>
</section>
