<?php
require '../config.php';
require '../utils/database.php';

$conn = initialize_database();

header('Content-Type: application/json; charset=utf-8');

function getUserChatList($user_id, PDO $conn)
{
    $sql = <<< SQL
    SELECT
        C.chat_id,
        C.match_id,
        ( CASE WHEN MA.user1_id = :user_id THEN MA.user2_id ELSE MA.user1_id END ) AS interacted_user_id,
        U.first_name AS interacted_user_first_name,
        U.last_name AS interacted_user_last_name,
        P.profile_picture_url AS interacted_user_profile_picture,
        M.message AS last_message,
        M.updated_at AS last_message_time 
    FROM
        chats AS C
        INNER JOIN matches AS MA ON C.match_id = MA.match_id
        LEFT JOIN ( SELECT chat_id, message, updated_at FROM messages WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 1 ) AS M ON C.chat_id = M.chat_id
        INNER JOIN users AS U ON ( CASE WHEN MA.user1_id = :user_id THEN MA.user2_id ELSE MA.user1_id END ) = U.user_id
        LEFT JOIN PROFILES AS P ON U.user_id = P.user_id 
    WHERE
        ( MA.user1_id = :user_id OR MA.user2_id = :user_id ) 
        AND C.deleted_at IS NULL 
    ORDER BY
        M.updated_at DESC;
    SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    $chats = $statement->fetchAll();

    return $chats;
}

function getChatMessages($chat_id, PDO $conn)
{
    $sql = <<< SQL
    SELECT
        message_id,
        chat_id,
        sender_id,
        message,
        message_media_url,
        message_type,
        seen_at,
        updated_at
    FROM
        messages
    WHERE
        chat_id = :chat_id
        AND deleted_at IS NULL
    ORDER BY
        updated_at ASC;
    SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':chat_id', $chat_id, PDO::PARAM_INT);
    $statement->execute();

    $messages =  $statement->fetchAll();

    return $messages;
}

$response = array(
    "success" => true,
    "error" => null
);

try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if ($_GET["reason"] == "get_user_chat_list" && isset($_GET["user_id"])) {
            $user_id = $_GET["user_id"];

            $userChatList = getUserChatList($user_id, $conn);
            $response["userChatList"] = $userChatList;

            echo json_encode($response);
            flush();
            exit();
        }
        if ($_GET["reason"] == "get_chat_messages" && isset($_GET["chat_id"])) {
            $chat_id = $_GET["chat_id"];

            $chatMessages = getChatMessages($chat_id, $conn);
            $response["messages"] = $chatMessages;

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
