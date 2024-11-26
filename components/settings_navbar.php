<?php

// Function to check active page 
function isActiveLink($link_url)
{
    // Get the current page URL
    $current_url = $_SERVER['REQUEST_URI'];

    // Check if the link URL matches the current URL
    return strpos($current_url, $link_url) !== false ? 'active' : '';
}

?>

<nav class="settings-navbar">
    <h1 class="settings-navbar-title">Settings</h1>

    <div class="settings-cards">
        <div class="settings-card <?php echo isActiveLink('/pages/app/profile.php'); ?>">
            <a href="<?php echo BASE_URL; ?>/pages/app/profile.php" class="settings-btn">
                <h2><span class="material-symbols-rounded">account_circle</span> My Profile</h2>
                <p>Personalize your profile by updating your photo and bio. Make it reflect who you are and attract the
                    right connections!</p>
            </a>
        </div>

        <div class="settings-card <?php echo isActiveLink('/pages/app/settings/user-media.php'); ?>">
            <a href="<?php echo BASE_URL; ?>/pages/app/settings/user-media.php" class="settings-btn">
                <h2><span class="material-symbols-rounded">camera</span> User Media</h2>
                <p>Upload eye-catching photos to showcase on your profile's home page. Add a minimum of 3 and up to 6
                    images to attract more matches. Make your first impression count!</p>
            </a>
        </div>

        <div class="settings-card <?php echo isActiveLink('/pages/app/settings/privacy-and-security.php'); ?>">
            <a href="<?php echo BASE_URL; ?>/pages/app/settings/privacy-and-security.php" class="settings-btn">
                <h2><span class="material-symbols-rounded">admin_panel_settings</span> Privacy and Security</h2>
                <p>Control online status, last seen visibility, and profile sharing. Show or hide your age and birthday.
                    Keep your account safe by updating your email and password </p>
            </a>
        </div>

        <div class="settings-card <?php echo isActiveLink('/pages/app/settings/account_management.php'); ?>">
            <a href="<?php echo BASE_URL; ?>/pages/app/settings/account_management.php" class="settings-btn">
                <h2><span class="material-symbols-rounded">supervised_user_circle</span> Account Management</h2>
                <p>The account management section lets users specify what they are looking for, preferred distance,
                    gender, lifestyle, and provide a brief "About You" description, helping to personalize their
                    experience and matches.</p>
            </a>
        </div>
    </div>
</nav>
