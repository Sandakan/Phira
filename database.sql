show databases;
create database phiraDB;
use phiraDB;

-- HAVE TO SEPERATE USERS TABLE INTO USERS AND USER_PROFILES
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
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
    user_id INT NOT NULL,
    date_of_birth DATE,
    gender VARCHAR(10),
    biography VARCHAR(500),
    location POINT, -- Stores longitude and latitude
    profile_picture_url VARCHAR(1000), -- URL for profile picture
    distance_range INT, -- Distance preference in km
    preferred_age_min INT , -- Minimum preferred age
    preferred_age_max INT , -- Maximum preferred age
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
    photo_url VARCHAR(1000) NOT NULL, -- Stores photo uploads in url
    caption TEXT, -- image caption
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE interactions (
    interaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,             -- The user who likes/rejects
    interacted_user_id INT NOT NULL,       -- The user being liked/rejected
    status ENUM('LIKED', 'REJECTED') NOT NULL,  -- Interaction status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (interacted_user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (user_id, interacted_user_id)  -- Ensures only one like/reject per pair
);

CREATE TABLE matches (
    match_id INT PRIMARY KEY AUTO_INCREMENT,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of the match
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,  
    FOREIGN KEY (user1_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (user1_id, user2_id)  -- Ensures each match is unique
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
    message TEXT,  -- message_text can not
    message_media_url VARCHAR(1000),
    -- if message type is text, message column saves as message. If message type is other than text message will be the caption
    message_type ENUM('TEXT','IMAGE','VIDEO') NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Time the message was sent
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    seen_at TIMESTAMP, -- RECEIVER SEEN TIME
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
    blocker_id INT NOT NULL, -- User who blocks
    blocked_id INT NOT NULL, -- User being blocked
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Time when the block was set
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


INSERT INTO preferences (preference_name) 
VALUES
    ('Relationship Type'),
    ('Drink'),
    ('Smoke'),
    ('Exercise'),
    ('Pets'),
    ('Communication Style'),
    ('Expect Love Type'),
    ('Educational Level'),
    ('Sleeping Habits');

-- Insert options for Relationship Type
INSERT INTO preference_options (preference_id, option_text) VALUES
(1, 'Long-term Partner'),
(1, 'Short-term Partner'),
(1, 'New Friends'),
(1, 'Still figuring it out');

-- Insert options for Drink
INSERT INTO preference_options (preference_id, option_text) VALUES
(2, 'Newly Teetotal'),
(2, 'Not for me'),
(2, 'On Special Occasions'),
(2, 'At the weekends'),
(2, 'Most nights');

-- Insert options for Smoke
INSERT INTO preference_options (preference_id, option_text) VALUES
(3, 'Newly Teetotal'),
(3, 'Not for me'),
(3, 'On Special Occasions'),
(3, 'At the weekends'),
(3, 'Most nights');

-- Insert options for Exercise
INSERT INTO preference_options (preference_id, option_text) VALUES
(4, 'Every day'),
(4, 'Often'),
(4, 'Sometimes'),
(4, 'Never');

-- Insert options for Pets
INSERT INTO preference_options (preference_id, option_text) VALUES
(5, 'Dog'),
(5, 'Cat'),
(5, 'Fish'),
(5, 'Bird'),
(5, 'Amphibian');

-- Insert options for Communication Style
INSERT INTO preference_options (preference_id, option_text) VALUES
(6, 'Big time texter'),
(6, 'Phone caller'),
(6, 'Video chatter'),
(6, 'Bad texter'),
(6, 'Better in person');


-- Insert options for Expect Love Type
INSERT INTO preference_options (preference_id, option_text) VALUES
(7, 'Thoughtful gestures'),
(7, 'Presents'),
(7, 'Touch'),
(7, 'Compliments'),
(7, 'Time together');

-- Insert options for Educational Level
INSERT INTO preference_options (preference_id, option_text) VALUES
(8, 'Bachelor degree'),
(8, 'At uni'),
(8, 'High School'),
(8, 'PhD'),
(8, 'On a graduate programme');

-- Insert options for Sleeping Habits
INSERT INTO preference_options (preference_id, option_text) VALUES
(9, 'Early Bird'),
(9, 'Night Owl'),
(9, 'It varies');


-- Insert sample data for a user
INSERT INTO users (
    email, password, first_name, last_name, verification_token, token_expiry, verified_at, onboarding_completed_at, role
) 
VALUES (
    'janedoe@gmail.com',                             
    '$10$56n.VAVFDN7H18u.j1u2aeNUpMdxG2BZWRAl4m1tx/lHsfocEfxPi', -- Hashed Password (e.g., "12345678")
    'Jane',                                           
    'Doe',
    'xyz123verificationtoken',                       
    DATE_ADD(NOW(), INTERVAL 1 DAY),                  -- Token expiry (1 day from now)
    NOW(),                                            -- Verified at (current timestamp)
    NULL,                                             -- Onboarding completed at (NULL if not completed yet)
    'USER'
);


-- Insert sample data for a user's profile
INSERT INTO profiles (
    user_id, date_of_birth, gender, biography, location, profile_picture_url, distance_range, preferred_age_min,
    preferred_age_max, created_at, updated_at, deleted_at, show_birthday, show_age
)
VALUES (
    1,                              -- Foreign key referencing user_id in the users table
    '1995-06-15',                   -- Date of birth
    'Female',                       -- Gender
    'Passionate about technology and exploring new places.', -- Biography
    ST_GeomFromText('POINT(34.052235 -118.243683)'), -- Location (latitude and longitude of Los Angeles, CA)
    NULL,                           -- URL for profile picture
    50,                             -- Distance preference (in km)
    25,                             -- Minimum preferred age
    35,                             -- Maximum preferred age
    NOW(),                          -- Created timestamp
    NOW(),                          -- Updated timestamp
    NULL,                           -- Deleted timestamp (NULL means not deleted)
    1,                              -- Show birthday (1 = true,0 = false)
    1                               -- Show age (1 = true,0 = false)
);


-- Insert sample data for a user preference
INSERT INTO user_preferences (user_id, preference_option_id)
VALUES (1, 1),
    (1, 5),
    (1, 10),
    (1, 15),
    (1, 19);

