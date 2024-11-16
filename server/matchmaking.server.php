<?php

require '../config.php';
require '../utils/database.php';

$conn = initialize_database();
function findMatches($user_id, $conn)
{
    // Fetch the current user's profile details
    $query = <<< SQL
        SELECT 
            profiles.gender AS user_gender,
            profiles.preferred_age_min,
            profiles.preferred_age_max,
            profiles.date_of_birth,
            GROUP_CONCAT(user_preferences.preference_option_id) AS user_preferences
        FROM profiles
        LEFT JOIN user_preferences ON profiles.user_id = user_preferences.user_id
        WHERE profiles.user_id = $user_id
        GROUP BY profiles.user_id;
        SQL;

    $currentUser = mysqli_query($conn, $query)->fetch_assoc();

    if (!$currentUser) {
        return []; // User profile not found
    }

    $userGender = $currentUser['user_gender'];
    $preferredAgeMin = $currentUser['preferred_age_min'];
    $preferredAgeMax = $currentUser['preferred_age_max'];
    $userPreferences = explode(',', $currentUser['user_preferences']);

    // Calculate the age of the current user
    $currentDate = new DateTime();
    $birthDate = new DateTime($currentUser['date_of_birth']);
    $userAge = $currentDate->diff($birthDate)->y;

    // Find potential matches
    $query = "SELECT 
                p.user_id AS match_user_id,
                p.gender AS match_gender,
                p.date_of_birth,
                p.biography,
                p.location,
                GROUP_CONCAT(up.preference_option_id) AS match_preferences
              FROM profiles p
              LEFT JOIN user_preferences up ON p.user_id = up.user_id
              WHERE p.user_id != :user_id
                AND p.gender != :user_gender
                AND :user_age BETWEEN p.preferred_age_min AND p.preferred_age_max
                AND YEAR(CURDATE()) - YEAR(p.date_of_birth) BETWEEN :preferred_age_min AND :preferred_age_max
              GROUP BY p.user_id";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        'user_id' => $user_id,
        'user_gender' => $userGender,
        'user_age' => $userAge,
        'preferred_age_min' => $preferredAgeMin,
        'preferred_age_max' => $preferredAgeMax,
    ]);

    $potentialMatches = $stmt->fetchAll($conn::FETCH_ASSOC);

    // Filter matches based on preference overlap
    $matches = [];
    foreach ($potentialMatches as $match) {
        $matchPreferences = explode(',', $match['match_preferences']);
        $commonPreferences = array_intersect($userPreferences, $matchPreferences);

        if (count($commonPreferences) > 0) { // Require at least one common preference
            $matches[] = [
                'match_user_id' => $match['match_user_id'],
                'biography' => $match['biography'],
                'location' => $match['location'],
                'common_preferences' => $commonPreferences,
            ];
        }
    }

    return $matches;
}

$matches = findMatches(1, $conn);
print($matches);
