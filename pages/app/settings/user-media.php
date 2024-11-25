<?php
require '../../../config.php';
require '../../../utils/database.php';
require '../../../utils/authenticate.php';

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
    <title>User Media - Phira</title>
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
                <span class="material-symbols-rounded">camera</span>
                <h1>User media</h1>
            </div>
            <div class="media">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>"
                    enctype="multipart/form-data">

                    <div class="media-card">
                        <label class="image-container">
                            <img src="" id="img-1" alt="">
                            <input type="file" name="photo-1" id="photo-1" onchange="updateImage('photo-1','img-1')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                        <label class="image-container">
                            <img src="" id="img-2" alt="">
                            <input type="file" name="photo-2" id="photo-2" onchange="updateImage('photo-2','img-2')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                        <label class="image-container">
                            <img src="" id="img-3" alt="">
                            <input type="file" name="photo-3" id="photo-3" onchange="updateImage('photo-3','img-3')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                        <label class="image-container">
                            <img src="" id="img-4" alt="">
                            <input type="file" name="photo-4" id="photo-4" onchange="updateImage('photo-4','img-4')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                        <label class="image-container">
                            <img src="" id="img-5" alt="">
                            <input type="file" name="photo-5" id="photo-5" onchange="updateImage('photo-5','img-5')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                        <label class="image-container">
                            <img src="" id="img-6" alt="">
                            <input type="file" name="photo-6" id="photo-6" onchange="updateImage('photo-6','img-6')">
                            <span class="add-icon material-symbols-rounded">add_circle</span>
                        </label>
                    </div>
                </form>
            </div>
            <button class="btn btn-primary">Save</button>
        </section>
    </main>

    <script src="<?php echo BASE_URL; ?>/public/scripts/updateInputImage.js"></script>
</body>

</html>
