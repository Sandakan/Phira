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

$user_id = $_SESSION["user_id"];
$base_picture_url = BASE_URL . '/private/media/user_photos/';

// Fetch the existing photos for the user
$query = <<<SQL
    SELECT photo_id, photo_url FROM photos WHERE user_id = :user_id;
SQL;
$statement = $conn->prepare($query);
$statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
$statement->execute();
$photos = $statement->fetchAll(PDO::FETCH_ASSOC);

// If the query returns results, map them accordingly
$photo_map = [];
foreach ($photos as $index => $photo) {
    $photo_map[$index] = $photo;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    for ($i = 0; $i < 6; $i++) {
        $input_name = "photo-$i";

        // Check if the file is uploaded
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]["error"] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES[$input_name]["tmp_name"];
            $file_name = basename($_FILES[$input_name]["name"]);
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            // Validate file type (e.g., allow only images)
            $allowed_types = ["jpg", "jpeg", "png", "gif", "webp"];
            if (!in_array(strtolower($file_ext), $allowed_types)) {
                echo "Invalid file type for $file_name.";
                continue;
            }

            // Generate a unique file name to avoid overwriting
            $new_file_name = uniqid("photo_", true) . "." . $file_ext;

            // Define the upload directory
            $upload_dir = "../../../private/media/user_photos/";
            $destination = $upload_dir . $new_file_name;

            // Move the file to the upload directory
            if (move_uploaded_file($tmp_name, $destination)) {
                // Check if this index already has a photo to update
                if (isset($photo_map[$i])) {
                    $existing_photo = $photo_map[$i];
                    $existing_photo_id = $existing_photo['photo_id'];

                    // Delete the old file
                    $old_file_path = $upload_dir . $existing_photo['photo_url'];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }

                    // Update the existing photo in the database
                    $update_query = <<<SQL
                        UPDATE photos
                        SET photo_url = :photo_url
                        WHERE photo_id = :id;
                    SQL;
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bindParam("photo_url", $new_file_name, PDO::PARAM_STR);
                    $update_stmt->bindParam("id", $existing_photo_id, PDO::PARAM_INT);
                    if ($update_stmt->execute()) {
                        echo "File $file_name updated successfully.";
                    } else {
                        echo "Failed to update file $file_name in the database.";
                    }
                } else {
                    // Insert the new photo if slots are available
                    if (count($photos) < 6) {
                        $insert_query = <<<SQL
                            INSERT INTO photos (user_id, photo_url)
                            VALUES (:user_id, :photo_url);
                        SQL;
                        $insert_stmt = $conn->prepare($insert_query);
                        $insert_stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                        $insert_stmt->bindParam("photo_url", $new_file_name, PDO::PARAM_STR);
                        if ($insert_stmt->execute()) {
                            echo "File $file_name uploaded successfully.";
                        } else {
                            echo "Failed to save file $file_name in the database.";
                        }
                    } else {
                        echo "Cannot upload more than 6 photos.";
                    }
                }
            } else {
                echo "Failed to upload file $file_name.";
            }
        }
    }

    // Redirect after processing
    if (!headers_sent()) {
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit();
    }
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
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" enctype="multipart/form-data">

                    <div class="media-card">

                       <!-- Gallery Images -->
                    <?php
                    foreach ($photos as $index => $photo) {
                        $picture_url = $base_picture_url . $photo['photo_url'];  // Access 'photo_url' correctly
                        echo <<<HTML
                            <label class="image-container">
                                <input type="file" name="photo-$index">
                                <img src="$picture_url" alt="Gallery Image">
                                <span class="add-icon material-symbols-rounded">add_circle</span>
                            </label>
                        HTML;
                    }

                    // Fill empty slots for photos (if there are fewer than 6)
                    for ($i = count($photos); $i < 6; $i++) {
                        echo <<<HTML
                            <label class="image-container">
                                <input type="file" name="photo-$i">
                                <span class="add-icon material-symbols-rounded">add_circle</span>
                            </label>
                        HTML;
                    }
                    ?>

                        <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

        </section>
    </main>
</body>

</html>
