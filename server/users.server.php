<?php

require '../config.php';
require '../utils/database.php';

$conn = initialize_database();

header('Content-Type: application/json; charset=utf-8');

function getUserData($userId, PDO $conn)
{
    $sql = <<<SQL
        SELECT
            u.user_id,
            u.first_name,
            u.last_name,
            p.gender,
            p.date_of_birth,
            p.biography,
            pr.preference_name,
            po.option_text,
            p.profile_picture_url,
            GROUP_CONCAT(DISTINCT ph.photo_url ORDER BY ph.photo_id) AS all_photos 
        FROM
            users u
            INNER JOIN profiles p ON u.user_id = p.user_id
            LEFT JOIN user_preferences up ON p.user_id = up.user_id
            LEFT JOIN preference_options po ON up.preference_option_id = po.preference_option_id
            LEFT JOIN preferences pr ON po.preference_id = pr.preference_id 
            LEFT JOIN photos ph ON p.user_id = ph.user_id 
        WHERE
            p.user_id = :user_id
        GROUP BY
            p.user_id,
            pr.preference_name 
        ORDER BY
            p.user_id,
            pr.preference_name;
        SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $data = $statement->fetchAll();

    $row = $data[0];

    $birthDate = new DateTime($row['date_of_birth']);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;

    $userDetails = [
        'user_id' => $row['user_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'gender' => $row['gender'],
        'age' => $age,
        'biography' => $row['biography'],
        'profile_picture_url' => $row['profile_picture_url'] ?? null,
        'all_photos' => $row['all_photos'] ? explode(',', $row['all_photos']) : [],
        'preferences' => []
    ];

    foreach ($data as $row) {
        if (!empty($row['preference_name']) && !empty($row['option_text'])) {
            $userDetails['preferences'][] = [
                'preference_name' => $row['preference_name'],
                'option_text' => $row['option_text']
            ];
        }
    }

    return $userDetails;
}


// handle post requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET['reason'] == 'get_user_data' && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $response = array(
            "success" => true,
            "error" => null
        );

        try {
            $user_data = getUserData($user_id, $conn);

            $response["user"] = $user_data;

            echo json_encode($response);
        } catch (Exception $e) {
            $response["success"] = false;
            $response["error"] = $e->getMessage();
            echo json_encode($response);
        }
    } else echo json_encode(array("success" => false, "error" => "Invalid request"));
}
