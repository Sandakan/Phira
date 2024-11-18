<?php
require '../config.php';
require '../utils/database.php';

$conn = initialize_database();
function findMatches($user_id,  $conn, $latitude = null, $longitude = null)
{
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
        WHERE P.user_id = $user_id
        GROUP BY P.user_id;
    SQL;

    $currentUser = mysqli_query($conn, $query)->fetch_assoc();

    if (!$currentUser) {
        return []; // User profile not found
    }

    // Use passed latitude and longitude, or fall back to database values
    $user_latitude = $latitude ?? $currentUser['user_latitude'];
    $user_longitude = $longitude ?? $currentUser['user_longitude'];
    $user_gender = $currentUser['user_gender'];
    $distance_range = $currentUser['distance_range'];
    $userPreferences = explode(',', $currentUser['user_preferences']);

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
                        COS(RADIANS($user_latitude)) * COS(RADIANS(ST_X(p.location))) *
                        COS(RADIANS(ST_Y(p.location)) - RADIANS($user_longitude)) +
                        SIN(RADIANS($user_latitude)) * SIN(RADIANS(ST_X(p.location)))
                    )
                ) AS distance_km,
                GROUP_CONCAT(up.preference_option_id) AS match_preferences
            FROM profiles p
            INNER JOIN user_preferences up ON p.user_id = up.user_id
            WHERE 
                p.user_id != $user_id
                AND p.gender != '$user_gender'
                AND YEAR(CURDATE()) - YEAR(p.date_of_birth) BETWEEN {$currentUser['preferred_age_min']} AND {$currentUser['preferred_age_max']}
                AND NOT EXISTS (
                    SELECT 1
                    FROM interactions i
                    WHERE i.user_id = $user_id AND i.interacted_user_id = p.user_id
                )
            GROUP BY p.user_id
        ) AS filtered_matches
        WHERE distance_km <= $distance_range;
    SQL;

    $potentialMatches = [];
    $result = mysqli_query($conn, $query);

    while ($row = $result->fetch_assoc()) {
        $potentialMatches[] = $row;
    }

    // Filter matches based on common preferences
    $matches = [];
    foreach ($potentialMatches as $match) {
        $matchPreferences = explode(',', $match['match_preferences']);
        $commonPreferences = array_intersect($userPreferences, $matchPreferences);

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
            ph.photo_url AS profile_picture,
            GROUP_CONCAT( photos.photo_url ) AS all_photos 
        FROM
            users u
            INNER JOIN profiles p ON u.user_id = p.user_id
            LEFT JOIN user_preferences up ON p.user_id = up.user_id
            LEFT JOIN preference_options po ON up.preference_option_id = po.preference_option_id
            LEFT JOIN preferences pr ON po.preference_id = pr.preference_id 
            LEFT JOIN photos ph ON p.user_id = ph.user_id 
            LEFT JOIN photos ON p.user_id = photos.user_id 
        WHERE
            p.user_id IN ($placeholders) 
        GROUP BY
            p.user_id,
            pr.preference_name 
        ORDER BY
            p.user_id,
            pr.preference_name;
        SQL;

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the latitude and longitude for distance calculation and user IDs dynamically
    $bindParams = array_merge([$latitude, $longitude, $latitude], $matchUserIds);
    $stmt->bind_param(str_repeat('d', 3) . str_repeat('i', count($matchUserIds)), ...$bindParams);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Process results
    $userDetails = [];
    while ($row = $result->fetch_assoc()) {
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
                'profile_picture_url' => $row['profile_picture'] ?? null,
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

function addMatchInteractionStatus($user_id, $interacted_user_id, $status, $conn)
{
    $sql = "INSERT INTO interactions (user_id, interacted_user_id, status) VALUES ($user_id, $interacted_user_id, '$status')";
    $result = mysqli_query($conn, $sql);

    return !$result;
}


// handle post requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET['reason'] == 'get_matches') {
        $user_id = $_GET['user_id'];
        $latitude = $_GET['latitude'];
        $longitude = $_GET['longitude'];

        $matches = findMatches($user_id, $conn, $latitude, $longitude);
        $user_details = getMatchUserDetails($matches, $latitude, $longitude, $conn);
        // echo json_encode($matches);
        echo json_encode($user_details);
    } else echo json_encode(array("error" => "Invalid request"));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['reason'] == 'add_match_interaction_status') {
        $user_id = $_POST['user_id'];
        $match_user_id = $_POST['match_user_id'];
        $status = $_POST['status'];

        echo json_encode(addMatchInteractionStatus(intval($user_id), intval($match_user_id), $status, $conn));
    } else echo json_encode(array("error" => "Invalid request"));
}
