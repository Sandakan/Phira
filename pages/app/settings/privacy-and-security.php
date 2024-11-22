<?php
require '../../../config.php';
require '../../../utils/database.php';
require '../../../utils/authenticate.php';

$conn = initialize_database();
session_start();

// authenticate(array("USER"));
// if (!isset($_SESSION["onboarding_completed"])) {
//     header("Location: " . BASE_URL . "/login.php");
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy and Security - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/settings.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <?php include('../../../components/sidebar.php') ?>
    <main>
        <?php include('../../../components/settings_navbar.php') ?>
        <section>
            <div class="title-container">
                <span class="material-symbols-rounded">admin_panel_settings</span>
                <h1>Privacy and Security</h1>
            </div>
            <div class="privacy-and-security">
                <h2>Privacy Settings</h2>
                <p>Control what others see on your profile. 👀 Manage your last seen status, share your profile
                    selectively, and choose whether to show your age and birthday. Your privacy, your rules!</p>
            </div>
            <form action="">
                <div class="privacy-settings">
                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">visibility_lock</span>
                                <h3>Last seen visibility</h3>
                            </div>
                            <p>When turned on, all your matches can see when you were last active. Turn it off to
                                keep
                                your
                                activity
                                status private.</p>
                        </div>
                        <select class="toggle" style="font-size: 20px; font-weight: 500; padding: 10px 10px;">
                            <option>On</option>
                            <option>Off</option>
                        </select>
                    </div>
                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">search_off</span>
                                <h3>share Profile</h3>
                            </div>
                            <p>When enabled, others can view your profile if they have your link. Turn it off to
                                make
                                your profile visible only to those you’ve matched with.</p>
                        </div>
                        <select class="toggle" style="font-size: 20px; font-weight: 500; padding: 10px 10px;">
                            <option>On</option>
                            <option>Off</option>
                        </select>
                    </div>
                    <div>
                        <div class="privacy-card">
                            <div class="sub-title">
                                <div class="sub-title-container">
                                    <span class="privacy-icon material-symbols-rounded">edit_calendar</span>
                                    <h3>Display Age</h3>
                                </div>
                                <p>When enabled, your age will be visible on your profile and match screen. Turn it
                                    off
                                    to hide your age from everyone.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <div class="privacy-card">
                            <div class="sub-title">
                                <div class="sub-title-container">
                                    <span class="privacy-icon material-symbols-rounded">calendar_month</span>
                                    <h3>Display Birthday</h3>
                                </div>
                                <p>When enabled, your birthday will be visible on your profile. Turn it off to keep
                                    your
                                    birthday private from all users.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>

            <!-- ----- security ----- -->

            <div class="security">
                <div class="privacy-and-security">
                    <h2>Security Settings</h2>
                    <p>Keep your account secure by updating your email and changing your password anytime. Ensure your
                        details are always up to date for better account protection.</p>
                </div>
                <form action="">

                    <div class="privacy-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">lock</span>
                                <h3>Change Password</h3>
                            </div>
                            <p>Update your password to keep your account secure. Choose a strong, unique password to
                                protect
                                your profile from unauthorized access.</p>
                        </div>
                        <button class="change-password">Change password</button>
                    </div>
            </div>
            </form>
        </section>
    </main>
</body>

</html>