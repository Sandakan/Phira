<?php
require '../config.php';
require '../utils/database.php';

$conn = initialize_database();

header('Content-Type: application/json; charset=utf-8');
function getUserNotifications($user_id, PDO $conn)
{
    // Fetch new notifications from the database
    $query = <<< SQL
            SELECT
                *
            FROM
                notifications
            WHERE
                user_id = :user_id AND
                is_read = 0 AND
                deleted_at IS NULL;
            SQL;
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $notifications = $stmt->fetchAll();

    return $notifications;
}


$response = array(
    "success" => true,
    "error" => null
);

try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if ($_GET["reason"] == "get_user_notifications" && isset($_GET["user_id"])) {
            $user_id = $_GET["user_id"];

            $userChatList = getUserNotifications($user_id, $conn);
            $response["userNotifications"] = $userChatList;

            echo json_encode($response);
            flush();
            exit();
        }
    }

    $response["success"] = false;
    $response["error"] = "Invalid request";

    echo json_encode($response);
} catch (Exception $e) {
    $response["success"] = false;
    $response["error"] = $e->getMessage();

    echo json_encode($response);
}
