<?php
require '../config.php';
require '../utils/database.php';

$conn = initialize_database();
function findMatches($user_id, $conn)
{
    // Fetch the current user's profile details
    $query = <<< SQL
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

    $user_gender = $currentUser['user_gender'];
    $user_latitude = $currentUser['user_latitude'];
    $user_longitude = $currentUser['user_longitude'];
    $distance_range = $currentUser['distance_range'];
    $userPreferences = explode(',', $currentUser['user_preferences']);

    // Find potential matches
    $query = <<< SQL
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
                    p.user_id != 1
                    AND p.gender != '$user_gender'
                    AND 29 BETWEEN p.preferred_age_min AND p.preferred_age_max
                    AND YEAR(CURDATE()) - YEAR(p.date_of_birth) BETWEEN 25 AND 35
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


    // Filter matches based on same preferences
    $matches = [];
    foreach ($potentialMatches as $match) {
        $matchPreferences = explode(',', $match['match_preferences']);
        $commonPreferences = array_intersect($userPreferences, $matchPreferences);

        if (count($commonPreferences) > 0) { // Require at least one common preference
            $matches[] = [
                'match_user_id' => $match['match_user_id'],
                'biography' => $match['biography'],
                'distance_km' => $match['distance_km'],
                'common_preferences' => $commonPreferences,
            ];
        }
    }

    return $matches;
}

function getMatchUserDetails($matches, $conn)
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
            p.user_id,
            p.gender,
            p.date_of_birth,
            p.biography,
            ST_X(p.location) AS latitude,
            ST_Y(p.location) AS longitude,
            GROUP_CONCAT(up.preference_option_id) AS preferences
        FROM profiles p
        LEFT JOIN user_preferences up ON p.user_id = up.user_id
        WHERE p.user_id IN ($placeholders)
        GROUP BY p.user_id;
    SQL;

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters dynamically
    $stmt->bind_param(str_repeat('i', count($matchUserIds)), ...$matchUserIds);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all user details
    $userDetails = [];
    while ($row = $result->fetch_assoc()) {
        $userDetails[] = [
            'user_id' => $row['user_id'],
            'gender' => $row['gender'],
            'date_of_birth' => $row['date_of_birth'],
            'biography' => $row['biography'],
            'location' => [
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude']
            ],
            'preferences' => explode(',', $row['preferences']),
        ];
    }

    return $userDetails;
}


// handle post requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET['reason'] == 'get_matches') {
        $user_id = $_GET['user_id'];

        $matches = findMatches(intval($user_id), $conn);
        $user_details = getMatchUserDetails($matches, $conn);
        echo json_encode($user_details);
    } else echo json_encode(array("error" => "Invalid request"));
}
