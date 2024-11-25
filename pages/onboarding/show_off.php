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
    foreach ($_FILES as $file) {
        // echo $file['name'];
        if (isset($file['name']) && !empty($file['name'])) {;
            $photos[] = $file;
        };
    }


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

    if (count($photos) < 3) {
        $image_error = "Please upload at least 3 photos";
        $is_error = true;
    }

    $conn->beginTransaction();

    if (!$is_error) {
        try {
            $profile_picture_name = null;
            // Insert into database
            $query = <<< SQL
            INSERT INTO
                photos (user_id, photo_url)
            VALUES (
                :user_id,
                :photo_url
            );
            SQL;
            $statement = $conn->prepare($query);

            foreach ($photos as $index => $photo) {
                if (isset($photo) && !empty($photo["tmp_name"])) {
                    $image_file = $photo["name"];
                    $image_ext = '.' . pathinfo($image_file, PATHINFO_EXTENSION);

                    $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
                    $statement->bindParam("photo_url", $image_file, PDO::PARAM_STR);
                    $result = $statement->execute();

                    $photo_id = intval($conn->lastInsertId());

                    $image_new_filename = $photo_id .  $image_ext;
                    $image_save_path = $image_target_dir . $image_new_filename;

                    $image = $image_new_filename;

                    $update_query = "UPDATE photos SET photo_url = :photo_url WHERE photo_id = :photo_id";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bindParam("photo_url", $image_new_filename, PDO::PARAM_STR);
                    $update_stmt->bindParam("photo_id", $photo_id, PDO::PARAM_INT);
                    $update_result = $update_stmt->execute();

                    if (!move_uploaded_file(
                        $photo['tmp_name'],
                        $image_save_path
                    )) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }
                }

                if ($index == 0) {
                    $profile_picture_name = $image_new_filename;
                }
            }

            if (isset($profile_picture_name)) {
                $_SESSION["profile_picture_url"] = $profile_picture_name;

                $query = "UPDATE users SET onboarding_completed_at = NOW() WHERE user_id = :user_id";
                $statement = $conn->prepare($query);
                $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
                $result = $statement->execute();

                $query = "UPDATE profiles SET profile_picture_url = :profile_picture_url WHERE user_id = :user_id";
                $statement = $conn->prepare($query);
                $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
                $statement->bindParam("profile_picture_url", $profile_picture_name, PDO::PARAM_STR);
                $result = $statement->execute();

                $conn->commit();
                echo 'Photos uploaded successfully.';
                $_SESSION["onboarding_completed"] = true;

                header("Location: " . BASE_URL . "/pages/app/matches.php");
            } else throw new Exception("No first image found.");

            exit();
        } catch (\Throwable $e) {
            $conn->rollback();
            $image_error = "An error occurred. Please try again." . $e->getMessage();
        }
    }
}

if (isset($_SESSION["onboarding_completed"]) && $_SESSION["onboarding_completed"]) {
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/onboarding.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <form class="container show-off-container" method="POST"
        action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" enctype="multipart/form-data">

        <div class="left-panel">
            <div class="input-container">
                <h1>Show off the latest <br>you!</h1>
                <p> Add your recent photos. Your first image will be your profile picture.</p>

                <span class="error-message"><?php echo $image_error; ?></span>

                <div class="register-form-actions-container">
                    <button class="btn btn-primary" type="submit">Next</button>
                </div>
            </div>

        </div>

        <div class="right-panel">

            <div class="input-group-container">
                <label class="image-container">
                    <input type="file" name="photo-1">
                    <!-- <img src="../../../public/images/ProfilePic.png" alt=""> -->
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
                <label class="image-container">
                    <input type="file" name="photo-2">
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
                <label class="image-container">
                    <input type="file" name="photo-3">
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
            </div>

            <div class="input-group-container">
                <label class="image-container">
                    <input type="file" name="photo-4">
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
                <label class="image-container">
                    <input type="file" name="photo-5">
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
                <label class="image-container">
                    <input type="file" name="photo-6">
                    <span class="add-icon material-symbols-rounded">add_circle</span>
                </label>
            </div>
        </div>
    </form>

</body>

</html>
