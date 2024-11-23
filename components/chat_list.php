<?php
// require_once ROOT_DIR . '/utils/is_active_page.php';

// $user_id = $_SESSION['user_id'];

// $sql = <<< SQL
// SELECT
// 	C.chat_id,
// 	C.match_id,
// 	( CASE WHEN MA.user1_id = :user_id THEN MA.user2_id ELSE MA.user1_id END ) AS interacted_user_id,
// 	U.first_name AS interacted_user_first_name,
// 	U.last_name AS interacted_user_last_name,
// 	P.profile_picture_url AS interacted_user_profile_picture,
// 	M.message AS last_message,
// 	M.updated_at AS last_message_time 
// FROM
// 	chats AS C
// 	INNER JOIN matches AS MA ON C.match_id = MA.match_id
// 	LEFT JOIN ( SELECT chat_id, message, updated_at FROM messages WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT :user_id ) AS M ON C.chat_id = M.chat_id
// 	INNER JOIN users AS U ON ( CASE WHEN MA.user1_id = :user_id THEN MA.user2_id ELSE MA.user1_id END ) = U.user_id
// 	LEFT JOIN PROFILES AS P ON U.user_id = P.user_id 
// WHERE
// 	( MA.user1_id = :user_id OR MA.user2_id = :user_id ) 
// 	AND C.deleted_at IS NULL 
// ORDER BY
// 	M.updated_at DESC;
// SQL;

// $statement = $conn->prepare($sql);
// $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
// $statement->execute();

// $chats = $statement->fetchAll();
?>
<nav class="chats">
    <div class="chats-container">
        <h1>Chats</h1>


        <lable class="search-bar">
            <span class="icons material-symbols-rounded">search</span>

            <input type="search" placeholder="search">
        </lable>
        <div class="chats-list">
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>

            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>
            <div class="chat-profile">
                <img src="<?php echo BASE_URL; ?>/public/images/feedbackUser.png" alt="" class="profile-img">
                <div class="chat-info-container">
                    <div class="profile-info">
                        <h2>Tiana</h2>
                        <p>😂😂😂</p>
                    </div>
                    <p>12:00</p>
                </div>
            </div>
        </div>
    </div>
</nav>