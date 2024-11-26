<?php
require '../config.php';
require '../utils/database.php';

$conn = initialize_database();
function findMatches($user_id, PDO $conn, $latitude = null, $longitude = null)
{
    // save current user's location
    $query = <<<SQL
        UPDATE profiles
        SET location = POINT(:longitude, :latitude)
        WHERE user_id = :user_id;
    SQL;

    $statement = $conn->prepare($query);
    $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
    $statement->bindParam("latitude", $latitude, PDO::PARAM_STR);
    $statement->bindParam("longitude", $longitude, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the current user's profile details
    $query = <<<SQL
        SELECT 
            P.gender AS user_gender,
            P.preferred_age_min,
            P.preferred_age_max,
            P.date_of_birth,
            P.distance_range,
            ST_X(P.location) AS user_latitude,
            ST_Y(P.location) AS user_longitude,
            GROUP_CONCAT(UP.preference_option_id) AS user_preferences
        FROM profiles AS P
        LEFT JOIN user_preferences AS UP ON P.user_id = UP.user_id
        WHERE P.user_id = :user_id
        GROUP BY 
            P.user_id, P.gender, P.preferred_age_min, P.preferred_age_max, 
            P.date_of_birth, P.distance_range, ST_X(P.location), ST_Y(P.location);
    SQL;

    $statement = $conn->prepare($query);
    $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
    $statement->execute();
    $currentUser = $statement->fetch();

    if (!$currentUser) {
        throw new Exception('User not found');
    }

    // Use passed latitude and longitude, or fall back to database values
    $user_latitude = $latitude ?? $currentUser['user_latitude'];
    $user_longitude = $longitude ?? $currentUser['user_longitude'];
    $user_gender = $currentUser['user_gender'];
    $distance_range = $currentUser['distance_range'];
    $user_preferences = explode(',', $currentUser['user_preferences']);
    $preferred_age_min = $currentUser['preferred_age_min'];
    $preferred_age_max = $currentUser['preferred_age_max'];

    // Find potential matches
    $query = <<<SQL
    SELECT 
        *  
    FROM (
        SELECT  
            p.user_id AS match_user_id,
            p.gender AS match_gender,
            p.date_of_birth,
            p.biography,
            ST_X(p.location) AS match_latitude,
            ST_Y(p.location) AS match_longitude,
            (
                6371 * ACOS(
                    COS(RADIANS(:user_latitude)) * COS(RADIANS(ST_X(p.location))) *
                    COS(RADIANS(ST_Y(p.location)) - RADIANS(:user_longitude)) +
                    SIN(RADIANS(:user_latitude)) * SIN(RADIANS(ST_X(p.location)))
                )
            ) AS distance_km,
            GROUP_CONCAT(up.preference_option_id) AS match_preferences
        FROM profiles p
        INNER JOIN user_preferences up ON p.user_id = up.user_id
        WHERE 
            p.user_id != :user_id
            AND p.gender != :user_gender
            AND YEAR(CURDATE()) - YEAR(p.date_of_birth) BETWEEN :preferred_age_min AND :preferred_age_max
            AND NOT EXISTS (
                SELECT 1
                FROM interactions i
                WHERE i.user_id = :user_id AND i.interacted_user_id = p.user_id
            )
        GROUP BY 
            p.user_id, 
            p.gender, 
            p.date_of_birth, 
            p.biography, 
            p.location
    ) AS filtered_matches
    WHERE distance_km <= :distance_range;
    SQL;

    $statement = $conn->prepare($query);
    $statement->bindParam("user_id", $user_id, PDO::PARAM_INT);
    $statement->bindParam("user_latitude", $user_latitude, PDO::PARAM_STR);
    $statement->bindParam("user_longitude", $user_longitude, PDO::PARAM_STR);
    $statement->bindParam("user_gender", $user_gender, PDO::PARAM_STR);
    $statement->bindParam("distance_range", $distance_range, PDO::PARAM_INT);
    $statement->bindParam("preferred_age_min", $preferred_age_min, PDO::PARAM_INT);
    $statement->bindParam("preferred_age_max", $preferred_age_max, PDO::PARAM_INT);
    $result = $statement->execute();
    $potentialMatches = $statement->fetchAll();

    $matches = [];

    // Filter matches based on common preferences
    foreach ($potentialMatches as $match) {
        $matchPreferences = explode(',', $match['match_preferences']);
        $commonPreferences = array_intersect($user_preferences, $matchPreferences);

        if (count($commonPreferences) > 0) { // Require at least one common preference
            $matches[] = [
                'match_user_id' => $match['match_user_id'],
                'match_gender' => $match['match_gender'],
                'biography' => $match['biography'],
                'distance_km' => $match['distance_km'],
                'common_preferences' => $commonPreferences,
            ];
        }
    }
    return $matches;
}

function getMatchUserDetails($matches, $latitude, $longitude, $conn,)
{
    if (empty($matches)) {
        return []; // No matches to fetch information for
    }

    // Extract the match_user_ids from the $matches array
    $matchUserIds = array_column($matches, 'match_user_id');
    $placeholders = implode(',', array_fill(0, count($matchUserIds), '?'));

    // Prepare the SQL query to fetch details
    $sql = <<<SQL
        SELECT
            u.user_id,
            u.first_name,
            u.last_name,
            p.gender,
            p.date_of_birth,
            p.biography,
            ST_X ( p.location ) AS latitude,
            ST_Y ( p.location ) AS longitude,
            (
                6371 * ACOS(
                    COS(
                        RADIANS(?)) * COS(
                        RADIANS(
                        ST_X ( p.location ))) * COS(
                        RADIANS(
                        ST_Y ( p.location )) - RADIANS(?)) + SIN(
                        RADIANS(?)) * SIN(
                        RADIANS(
                        ST_X ( p.location ))) 
                ) 
            ) AS distance_km,
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
            p.user_id IN ($placeholders) 
        GROUP BY
            p.user_id,
            pr.preference_name 
        ORDER BY
            p.user_id,
            pr.preference_name;
        SQL;

    $stmt = $conn->prepare($sql);
    $params = array_merge([$latitude, $longitude, $latitude], $matchUserIds);
    $stmt->execute($params);
    $data = $stmt->fetchAll();

    // Process results
    $userDetails = [];
    foreach ($data as $row) {
        $userId = $row['user_id'];

        if (!isset($userDetails[$userId])) {
            // Initialize the user details
            $birthDate = new DateTime($row['date_of_birth']);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDate)->y;

            $userDetails[$userId] = [
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'gender' => $row['gender'],
                'age' => $age,
                'distance_km' => round($row['distance_km'], 2),
                'biography' => $row['biography'],
                'location' => [
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude']
                ],
                'profile_picture_url' => $row['profile_picture_url'] ?? null,
                'all_photos' => $row['all_photos'] ? explode(',', $row['all_photos']) : [],
                'preferences' => []
            ];
        }

        // Add selected preference details
        if (!empty($row['preference_name']) && !empty($row['option_text'])) {
            $userDetails[$userId]['preferences'][] = [
                'preference_name' => $row['preference_name'],
                'option_text' => $row['option_text']
            ];
        }
    }

    return array_values($userDetails); // Reset array keys
}

function sendNotifications($notification_type, $notification, $user_ids, $conn)
{
    $notificationIds = array();

    $sql = <<< SQL
        INSERT INTO notifications (user_id, notification_type, notification)
        VALUES (:user_id, :notification_type, :notification);
        SQL;

    $statement = $conn->prepare($sql);
    foreach ($user_ids as $user_id) {
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':notification_type', $notification_type, PDO::PARAM_STR);
        $statement->bindParam(':notification', $notification, PDO::PARAM_STR);
        $statement->execute();

        $notificationIds[] = $conn->lastInsertId();
    }

    return $notificationIds;
}

function createMatchEntry($user1_id, $user2_id, PDO $conn)
{
    $sql = <<< SQL
    INSERT INTO 
        matches (user1_id, user2_id)
    VALUES (:user1_id, :user2_id);
    SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':user1_id', $user1_id, PDO::PARAM_INT);
    $statement->bindParam(':user2_id', $user2_id, PDO::PARAM_INT);
    $result = $statement->execute();

    return $conn->lastInsertId();
}

function createChat($match_id, PDO $conn)
{
    $sql = <<< SQL
    INSERT INTO
        chats (match_id)
    VALUES (:match_id);
    SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':match_id', $match_id, PDO::PARAM_INT);
    $result = $statement->execute();

    return $conn->lastInsertId();
}

function addMatchInteractionStatus($user_id, $interacted_user_id, $status, PDO $conn)
{
    $response = array(
        "is_a_match" => false,
        "match_user_data" => null,
        "match_id" => null,
        "chat_id" => null,
        "notification_ids" => array()
    );

    $sql = <<< SQL
    INSERT INTO
        interactions (user_id, interacted_user_id, status)
    VALUES (:user_id, :interacted_user_id, :status);
    SQL;

    $statement = $conn->prepare($sql);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':interacted_user_id', $interacted_user_id, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_STR);
    $result = $statement->execute();

    // Check if interaction from interacted user has already been saved with liked status
    if ($status == 'LIKED') {
        $sql = <<< SQL
            SELECT
                U.user_id,
                U.first_name,
                U.last_name,
                P.profile_picture_url,
                I.interaction_id
            FROM
                users AS U
            INNER JOIN interactions AS I ON U.user_id = I.user_id
            INNER JOIN profiles AS P ON P.user_id = U.user_id
            WHERE
                I.interacted_user_id = :user_id AND
                I.user_id = :interacted_user_id AND
                status = 'LIKED'
            LIMIT 1;
        SQL;

        $statement = $conn->prepare($sql);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':interacted_user_id', $interacted_user_id, PDO::PARAM_INT);
        $result = $statement->execute();
        $data = $statement->fetch();

        if ($result && $data) {
            // another liked interaction already exists from the interacted user.
            // That means both liked each other.
            $response["is_a_match"] = true;
            $response["match_user_data"] = $data;

            $conn->beginTransaction();

            try {
                // send a notification to both users
                $response["notification_ids"] = sendNotifications(
                    "MATCH",
                    "You have a new match!",
                    [$user_id, $interacted_user_id],
                    $conn
                );

                // add match entry
                $response["match_id"] = createMatchEntry($user_id, $interacted_user_id, $conn);

                // create a new chat
                $response["chat_id"] = createChat($response["match_id"], $conn);

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                throw $e;
            }
        }
    }
    return $response;
}

header('Content-Type: application/json; charset=utf-8');

// handle post requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET['reason'] == 'get_matches' && isset($_GET['user_id']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
        $user_id = $_GET['user_id'];
        $latitude = $_GET['latitude'];
        $longitude = $_GET['longitude'];

        $response = array(
            "success" => true,
            "matches" => array(),
            "error" => null
        );

        try {
            $matches = findMatches($user_id, $conn, $latitude, $longitude);
            $match_user_details = getMatchUserDetails($matches, $latitude, $longitude, $conn);

            $response["matches"] = $match_user_details;

            echo json_encode($response);
        } catch (Exception $e) {
            $response["success"] = false;
            $response["error"] = $e->getMessage();
            echo json_encode($response);
        }
    } else echo json_encode(array("success" => false, "error" => "Invalid request"));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['reason'] == 'add_match_interaction_status') {
        $user_id = $_POST['user_id'];
        $match_user_id = $_POST['match_user_id'];
        $status = $_POST['status'];

        $response = array(
            "success" => true,
            "error" => null
        );

        try {
            $output = addMatchInteractionStatus($user_id, $match_user_id, $status, $conn);

            echo json_encode(array_merge($output, $response));
        } catch (Exception $e) {
            $response["success"] = false;
            $response["error"] = $e->getMessage();
            echo json_encode($response);
        }
    } else echo json_encode(array("success" => false, "error" => "Invalid request"));
}
