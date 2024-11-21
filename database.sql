show databases;
create database phiraDB;
use phiraDB;
-- HAVE TO SEPERATE USERS TABLE INTO USERS AND USER_PROFILES
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    -- Store hashed passwords
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    verification_token VARCHAR(255),
    token_expiry TIMESTAMP,
    verified_at TIMESTAMP,
    onboarding_completed_at TIMESTAMP,
    role ENUM('ADMIN', 'MODERATOR', 'USER') NOT NULL DEFAULT 'USER',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP
);
CREATE TABLE profiles (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT UNIQUE NULL,
    date_of_birth DATE,
    gender VARCHAR(10),
    biography VARCHAR(500),
    location POINT,
    -- Stores longitude and latitude
    profile_picture_url VARCHAR(1000),
    -- URL for profile picture
    distance_range INT,
    -- Distance preference in km
    preferred_age_min INT,
    -- Minimum preferred age
    preferred_age_max INT,
    -- Maximum preferred age
    show_birthday BOOLEAN DEFAULT TRUE,
    show_age BOOLEAN DEFAULT TRUE,
    last_seen BOOLEAN DEFAULT TRUE,
    share_profile BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    photo_url VARCHAR(1000) NOT NULL,
    -- Stores photo uploads in url
    caption TEXT,
    -- image caption
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE interactions (
    interaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    -- The user who likes/rejects
    interacted_user_id INT NOT NULL,
    -- The user being liked/rejected
    status ENUM('LIKED', 'REJECTED') NOT NULL,
    -- Interaction status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (interacted_user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (user_id, interacted_user_id) -- Ensures only one like/reject per pair
);
-- Abondoned table
CREATE TABLE matches (
    match_id INT PRIMARY KEY AUTO_INCREMENT,
    user1_id INT NOT NULL,
    -- the user who initiated the matching process
    user2_id INT NOT NULL,
    -- the user who was matched
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Timestamp of the match
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user1_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (user1_id, user2_id) -- Ensures each match is unique
);
CREATE TABLE chats (
    chat_id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (match_id) REFERENCES matches(match_id) ON DELETE CASCADE
);
-- message 
CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    chat_id INT NOT NULL,
    sender_id INT NOT NULL,
    message TEXT,
    -- message_text can not
    message_media_url VARCHAR(1000),
    -- if message type is text, message column saves as message. If message type is other than text message will be the caption
    message_type ENUM('TEXT', 'IMAGE', 'VIDEO') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Time the message was sent
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    seen_at TIMESTAMP,
    -- RECEIVER SEEN TIME
    deleted_at TIMESTAMP,
    FOREIGN KEY (chat_id) REFERENCES chats(chat_id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    notification_type ENUM('MATCH', 'MESSAGE', 'BIRTHDAY'),
    notification TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE activities (
    activity_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    activity_type ENUM('LOGIN', 'LOGOUT'),
    activity_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE blocked_users (
    block_id INT AUTO_INCREMENT PRIMARY KEY,
    blocker_id INT NOT NULL,
    -- User who blocks
    blocked_id INT NOT NULL,
    -- User being blocked
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Time when the block was set
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (blocker_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (blocked_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (blocker_id, blocked_id) -- Ensures a user can only block another user once
);
-- relationship_type and habbits
CREATE TABLE preferences (
    preference_id INT PRIMARY KEY AUTO_INCREMENT,
    preference_name VARCHAR(80) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP
);
CREATE TABLE preference_options (
    preference_option_id INT PRIMARY KEY AUTO_INCREMENT,
    preference_id INT NOT NULL,
    option_text VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (preference_id) REFERENCES preferences(preference_id) ON DELETE CASCADE
);
CREATE TABLE user_preferences (
    user_id INT NOT NULL,
    preference_option_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    PRIMARY KEY (user_id, preference_option_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (preference_option_id) REFERENCES preference_options(preference_option_id) ON DELETE CASCADE
);
