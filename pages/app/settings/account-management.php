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
    <title>Account Management - Phira</title>
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
                <span class="material-symbols-rounded">supervised_user_circle</span>
                <h1>Account Management</h1>
            </div>
            <div>
                <form action="">
                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">digital_wellbeing</span>
                                <h3>Relationship Type</h3>
                            </div>
                            <p>Customize what you're looking for—whether it’s a long-term relationship, short-term
                                connection, new friendships, or something else. Adjust your preferences anytime!</p>
                        </div>
                        <select class="type" style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                            <option>New Friends</option>
                            <option>Long Term Relationship</option>
                        </select>
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">6_ft_apart</span>
                                <h3>Distance Preference</h3>
                            </div>
                            <p>Set your match distance to find people nearby, up to a maximum of 100 km. Adjust it to
                                meet
                                people as close or as far as you like!</p>
                        </div>
                        <input type="text" class="type" name="distance" placeholder="Distance"
                            style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">heart_check</span>
                                <h3>Age Preference</h3>
                            </div>
                            <p>Set your preferred age range to find matches that suit you best. Customize the minimum
                                and maximum age to connect with people who fit your ideal match!</p>
                        </div>
                        <input type="text" class="type" name="age-preference" placeholder="Age Preference"
                            style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">transgender</span>
                                <h3>Preferred Gender</h3>
                            </div>
                            <p>Choose who you'd like to match with—select women, men, or others based on your
                                preference. Update your settings anytime!</p>
                        </div>
                        <select class="type" style="font-size: 20px; font-weight: 500; padding: 10px 15px;">
                            <option>Women</option>
                            <option>Men</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">emoji_language</span>
                                <h3>Lifestyle Preferences</h3>
                            </div>
                            <p>Personalize your lifestyle choices—share how often you drink, smoke, exercise, and the
                                pets you have. Let others know what fits your daily vibe!</p>

                        </div>
                        <button class="btn btn-primary ">change</button>
                    </div>

                    <div class="account-management-card">
                        <div class="sub-title">
                            <div class="sub-title-container">
                                <span class="privacy-icon material-symbols-rounded">heart_check</span>
                                <h3>Personal Insights</h3>
                            </div>
                            <p>Share more about yourself—whether it’s your communication style, love language,
                                education, or sleeping habits. Let your matches discover what makes you, you!</p>

                        </div>
                        <button class="btn btn-primary ">change</button>
                    </div>

                    <button class="btn btn-primary">Save</button>

                </form>
            </div>
        </section>
    </main>
</body>

</html>