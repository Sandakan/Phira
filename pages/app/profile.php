<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();

authenticate(array("USER"));

if (!isset($_SESSION["onboarding_completed"])) {
    header("Location: " . BASE_URL . "/login.php");
    exit();
}

$profile_picture_url = BASE_URL . '/private/media/user_photos/' . $_SESSION['profile_picture_url'];

// Logout query
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    try {
        $stmt = $conn->prepare("INSERT INTO activities(user_id, activity_type, activity_timestamp) VALUES (:user_id, :activity_type, :logout_time)");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':activity_type' => 'LOGOUT',
            ':logout_time' => date('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        error_log("Failed to log logout activity for user_id " . $_SESSION['user_id'] . ": " . $e->getMessage());
    }

    // Clear the session and redirect to login
    session_unset();
    session_destroy();
    header("Location:" . BASE_URL . "/pages/auth/login.php");
    exit();
}

$profile_data = [];
$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['biography'])) {
    // Handle form submission to update biography
    $biography = htmlspecialchars(trim($_POST['biography']));
    if (!empty($biography)) {
        $update_query = "UPDATE profiles SET biography = :biography WHERE user_id = :user_id";
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam("biography", $biography, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            $success_message = "Your biography has been updated.";
        } else {
            $error_message = "Failed to update biography. Please try again.";
        }
    } else {
        $error_message = "Biography cannot be empty.";
    }
}

// Fetch user profile data
$query = <<<SQL
SELECT 
    u.first_name,
    YEAR(CURRENT_DATE) - YEAR(p.date_of_birth) AS age,
    p.biography
FROM 
    profiles p
JOIN 
    users u ON p.user_id = u.user_id
WHERE 
    p.user_id = :user_id

SQL;

$stmt = $conn->prepare($query);
$stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$profile_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/settings.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <?php include('../../components/sidebar.php'); ?>
    <main>
        <?php include('../../components/settings_navbar.php'); ?>
        <section>
            <div class="title-container">
                <span class="material-symbols-rounded">account_circle</span>
                <h1>My Profile</h1>
            </div>

            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <div class="profile-card">
                <img src="<?php echo $profile_picture_url; ?>" alt="Profile Picture">
                <h2><?php echo htmlspecialchars($profile_data['first_name']); ?>,
                    <?php echo htmlspecialchars($profile_data['age']); ?></h2>

                <?php if (isset($_GET['edit']) && $_GET['edit'] == "true"): ?>
                    <!-- Edit Biography -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <textarea name="biography" rows="5"
                            required><?php echo htmlspecialchars($profile_data['biography']); ?></textarea>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                <?php else: ?>
                    <p><?php echo htmlspecialchars($profile_data['biography']); ?></p>
                    <a href="?edit=true" class="btn btn-primary">Edit Profile</a>
                <?php endif; ?>

                <a href="?logout=true" class="btn btn-primary">Logout</a>
            </div>
        </section>
    </main>
</body>

</html>
