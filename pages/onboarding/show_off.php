<?php
require '../../config.php';
require '../../utils/authenticate.php';
require '../../utils/database.php';

$conn = initialize_database();
session_start();


authenticate(array("USER"));
$image_error = "";
$image_target_dir = "./../../private/media/user_photos/";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION["user_id"];

    $photos = array();

    $photos[] = $_FILES['photo-1'];
    $photos[] = $_FILES['photo-2'];
    $photos[] = $_FILES['photo-3'];

    $is_error = false;

    foreach ($photos as $photo) {
        if (isset($photo) && !empty($photo["tmp_name"])) {
            // check the image file mime type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($photo['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                ),
                true
            )) {
                $image_error = "Only JPG, PNG, WEBP and GIF files are allowed";
                $is_error = true;
                break;
            }
        }
    }

    $conn->begin_transaction();

    if (!$is_error) {
        try {
            // Insert into database
            foreach ($photos as $index => $photo) {
                if (isset($photo) && !empty($photo["tmp_name"])) {
                    $image_file = $photo["name"];
                    $image_ext = '.' . pathinfo($image_file, PATHINFO_EXTENSION);

                    $query = "INSERT INTO photos (user_id, photo_url) VALUES (?, ?)";
                    $conn->execute_query($query, [$user_id, ""]);
                    $photo_id = $conn->insert_id;

                    $image_new_filename = $photo_id .  $image_ext;
                    $image_save_path = $image_target_dir . $image_new_filename;

                    if (!move_uploaded_file(
                        $photo['tmp_name'],
                        $image_save_path
                    )) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }

                    $image = $image_new_filename;

                    $query = "UPDATE photos SET photo_url = ? WHERE photo_id = ?";
                    $conn->execute_query($query, [$image_new_filename, $photo_id]);
                    $photo_id = $conn->insert_id;
                }
            }

            $query = "UPDATE users SET onboarding_completed_at = NOW() WHERE user_id = ?";
            $conn->execute_query($query, [$user_id]);

            $conn->commit();
            echo 'Photos uploaded successfully.';
            $_SESSION["onboarding_completed"] = true;
        } catch (\Throwable $e) {
            $conn->rollback();
            $image_error = "An error occurred. Please try again." . $e->getMessage();
            throw $e;
        }
    }
}

if (isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/pages/app/matches.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gallery - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>

    <div class="model-container register-model-container">
        <form class="register-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" enctype="multipart/form-data">

            <div class="input-container">
                <label for="preference">Show off the latest you! </label>
                <p> Add your recent photos </p>

            </div>

            <div class="input-container">
                <input type="file" name="photo-1" id="#photo">
                <span class="error-message"><?php echo $image_error ?></span>
            </div>

            <div class="input-container">
                <input type="file" name="photo-2" id="#photo">
                <span class="error-message"><?php echo $image_error ?></span>
            </div>

            <div class="input-container">
                <input type="file" name="photo-3" id="#photo">
                <span class="error-message"><?php echo $image_error ?></span>
            </div>

            <div class="register-form-actions-container">
                <button class="btn-primary form-submit-btn" type="submit">Next</button>
            </div>
        </form>

    </div>
</body>

</html>
