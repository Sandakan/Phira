USE PhiraDB;
-- -------------- PREFERENCE DATA -----------------------------------------------
INSERT INTO preferences (preference_name)
VALUES ('Relationship Type'),
    ('Drink'),
    ('Smoke'),
    ('Exercise'),
    ('Pets'),
    ('Communication Style'),
    ('Expect Love Type'),
    ('Educational Level'),
    ('Sleeping Habits');
-- Insert options for Relationship Type
INSERT INTO preference_options (preference_id, option_text)
VALUES (1, 'Long-term Partner'),
    (1, 'Short-term Partner'),
    (1, 'New Friends'),
    (1, 'Still figuring it out');
-- Insert options for Drink
INSERT INTO preference_options (preference_id, option_text)
VALUES (2, 'Newly Teetotal'),
    (2, 'Not for me'),
    (2, 'On Special Occasions'),
    (2, 'At the weekends'),
    (2, 'Most nights');
-- Insert options for Smoke
INSERT INTO preference_options (preference_id, option_text)
VALUES (3, 'Newly Teetotal'),
    (3, 'Not for me'),
    (3, 'On Special Occasions'),
    (3, 'At the weekends'),
    (3, 'Most nights');
-- Insert options for Exercise
INSERT INTO preference_options (preference_id, option_text)
VALUES (4, 'Every day'),
    (4, 'Often'),
    (4, 'Sometimes'),
    (4, 'Never');
-- Insert options for Pets
INSERT INTO preference_options (preference_id, option_text)
VALUES (5, 'Dog'),
    (5, 'Cat'),
    (5, 'Fish'),
    (5, 'Bird'),
    (5, 'Amphibian');
-- Insert options for Communication Style
INSERT INTO preference_options (preference_id, option_text)
VALUES (6, 'Big time texter'),
    (6, 'Phone caller'),
    (6, 'Video chatter'),
    (6, 'Bad texter'),
    (6, 'Better in person');
-- Insert options for Expect Love Type
INSERT INTO preference_options (preference_id, option_text)
VALUES (7, 'Thoughtful gestures'),
    (7, 'Presents'),
    (7, 'Touch'),
    (7, 'Compliments'),
    (7, 'Time together');
-- Insert options for Educational Level
INSERT INTO preference_options (preference_id, option_text)
VALUES (8, 'Bachelor degree'),
    (8, 'At uni'),
    (8, 'High School'),
    (8, 'PhD'),
    (8, 'On a graduate programme');
-- Insert options for Sleeping Habits
INSERT INTO preference_options (preference_id, option_text)
VALUES (9, 'Early Bird'),
    (9, 'Night Owl'),
    (9, 'It varies');
-- ----------------------------------------------------------------------------
-- Insert sample data for a user
INSERT INTO users (email, password, first_name, last_name, role)
VALUES (
        'user1@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'John',
        'Doe',
        'USER'
    ),
    (
        'user2@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jane',
        'Smith',
        'USER'
    ),
    (
        'user3@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Emily',
        'Johnson',
        'USER'
    ),
    (
        'user4@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Michael',
        'Brown',
        'USER'
    ),
    (
        'user5@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sophia',
        'Jones',
        'USER'
    ),
    (
        'user6@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'James',
        'Garcia',
        'USER'
    ),
    (
        'user7@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Mia',
        'Martinez',
        'USER'
    ),
    (
        'user8@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ethan',
        'Davis',
        'USER'
    ),
    (
        'user9@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Olivia',
        'Lopez',
        'USER'
    ),
    (
        'user10@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Alexander',
        'Hernandez',
        'USER'
    ),
    (
        'user11@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Isabella',
        'Moore',
        'USER'
    ),
    (
        'user12@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Aiden',
        'Martin',
        'USER'
    ),
    (
        'user13@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ella',
        'Taylor',
        'USER'
    ),
    (
        'user14@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Lucas',
        'White',
        'USER'
    ),
    (
        'user15@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Charlotte',
        'Harris',
        'USER'
    ),
    (
        'user16@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Noah',
        'Clark',
        'USER'
    ),
    (
        'user17@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Grace',
        'Lewis',
        'USER'
    ),
    (
        'user18@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Liam',
        'Walker',
        'USER'
    ),
    (
        'user19@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Chloe',
        'Allen',
        'USER'
    ),
    (
        'user20@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Benjamin',
        'Young',
        'USER'
    ),
    (
        'user21@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Victoria',
        'King',
        'USER'
    ),
    (
        'user22@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Henry',
        'Scott',
        'USER'
    ),
    (
        'user23@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sophia',
        'Green',
        'USER'
    ),
    (
        'user24@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Daniel',
        'Adams',
        'USER'
    ),
    (
        'user25@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Emma',
        'Baker',
        'USER'
    ),
    (
        'user26@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Oliver',
        'Carter',
        'USER'
    ),
    (
        'user27@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Lily',
        'Nelson',
        'USER'
    ),
    (
        'user28@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'William',
        'Mitchell',
        'USER'
    ),
    (
        'user29@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Amelia',
        'Perez',
        'USER'
    ),
    (
        'user30@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Mason',
        'Roberts',
        'USER'
    ),
    (
        'user31@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Hannah',
        'Turner',
        'USER'
    ),
    (
        'user32@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jacob',
        'Phillips',
        'USER'
    ),
    (
        'user33@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ava',
        'Campbell',
        'USER'
    ),
    (
        'user34@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Elijah',
        'Parker',
        'USER'
    ),
    (
        'user35@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Zoe',
        'Evans',
        'USER'
    ),
    (
        'user36@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Matthew',
        'Edwards',
        'USER'
    ),
    (
        'user37@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Isla',
        'Collins',
        'USER'
    ),
    (
        'user38@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Eli',
        'Stewart',
        'USER'
    ),
    (
        'user39@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Scarlett',
        'Sanchez',
        'USER'
    ),
    (
        'user40@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Joshua',
        'Morris',
        'USER'
    ),
    (
        'user41@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Abigail',
        'Rogers',
        'USER'
    ),
    (
        'user42@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Caleb',
        'Reed',
        'USER'
    ),
    (
        'user43@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ella',
        'Cook',
        'USER'
    ),
    (
        'user44@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Logan',
        'Morgan',
        'USER'
    ),
    (
        'user45@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Lucy',
        'Bell',
        'USER'
    ),
    (
        'user46@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ryan',
        'Murphy',
        'USER'
    ),
    (
        'user47@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ruby',
        'Bailey',
        'USER'
    ),
    (
        'user48@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Andrew',
        'Rivera',
        'USER'
    ),
    (
        'user49@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Alice',
        'Cooper',
        'USER'
    ),
    (
        'user50@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Nathan',
        'Richardson',
        'USER'
    ),
    (
        'user51@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sophie',
        'Cox',
        'USER'
    ),
    (
        'user52@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Evan',
        'Howard',
        'USER'
    ),
    (
        'user53@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Grace',
        'Ward',
        'USER'
    ),
    (
        'user54@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jack',
        'Torres',
        'USER'
    ),
    (
        'user55@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Layla',
        'Peterson',
        'USER'
    ),
    (
        'user56@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Dylan',
        'Gray',
        'USER'
    ),
    (
        'user57@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Chloe',
        'Ramirez',
        'USER'
    ),
    (
        'user58@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Tyler',
        'James',
        'USER'
    ),
    (
        'user59@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Mia',
        'Watson',
        'USER'
    ),
    (
        'user60@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Brandon',
        'Brooks',
        'USER'
    );
INSERT INTO profiles (
        user_id,
        date_of_birth,
        gender,
        biography,
        location,
        profile_picture_url,
        distance_range,
        preferred_age_min,
        preferred_age_max
    )
VALUES (
        1,
        '1992-06-15',
        'Male',
        'Enjoys traveling and photography.',
        POINT(6.9271, 79.8607),
        'https://example.com/profile1.jpg',
        50,
        25,
        35
    ),
    (
        2,
        '1988-12-10',
        'Female',
        'Loves cooking and outdoor adventures.',
        POINT(6.9319, 79.8525),
        'https://example.com/profile2.jpg',
        40,
        28,
        40
    ),
    (
        3,
        '1995-04-22',
        'Male',
        'Passionate about music and art.',
        POINT(6.9164, 79.8656),
        'https://example.com/profile3.jpg',
        30,
        22,
        32
    ),
    (
        4,
        '1990-09-15',
        'Female',
        'Enjoys hiking and reading.',
        POINT(6.9278, 79.8629),
        'https://example.com/profile4.jpg',
        60,
        27,
        37
    ),
    (
        5,
        '1997-02-18',
        'Male',
        'A foodie who loves to explore new cuisines.',
        POINT(6.9323, 79.8574),
        'https://example.com/profile5.jpg',
        20,
        21,
        31
    ),
    (
        6,
        '1993-08-07',
        'Female',
        'Fitness enthusiast and traveler.',
        POINT(6.9224, 79.8663),
        'https://example.com/profile6.jpg',
        35,
        24,
        34
    ),
    (
        7,
        '1989-01-25',
        'Male',
        'Tech geek and gaming lover.',
        POINT(6.9284, 79.8591),
        'https://example.com/profile7.jpg',
        40,
        26,
        36
    ),
    (
        8,
        '1991-07-30',
        'Female',
        'Writer and coffee enthusiast.',
        POINT(6.9261, 79.8682),
        'https://example.com/profile8.jpg',
        50,
        27,
        37
    ),
    (
        9,
        '1996-03-12',
        'Male',
        'Adventurer with a love for the ocean.',
        POINT(6.9306, 79.8617),
        'https://example.com/profile9.jpg',
        25,
        23,
        33
    ),
    (
        10,
        '1994-11-19',
        'Female',
        'Cat lover and bookworm.',
        POINT(6.9245, 79.8644),
        'https://example.com/profile10.jpg',
        30,
        24,
        34
    ),
    (
        11,
        '1987-05-15',
        'Male',
        'Fitness coach and motivational speaker.',
        POINT(6.9294, 79.8556),
        'https://example.com/profile11.jpg',
        40,
        29,
        39
    ),
    (
        12,
        '1990-10-22',
        'Female',
        'Art lover and yoga enthusiast.',
        POINT(6.9237, 79.8671),
        'https://example.com/profile12.jpg',
        60,
        26,
        36
    ),
    (
        13,
        '1998-07-09',
        'Male',
        'Enjoys extreme sports and mountain biking.',
        POINT(6.9256, 79.8599),
        'https://example.com/profile13.jpg',
        35,
        20,
        30
    ),
    (
        14,
        '1992-02-17',
        'Female',
        'Tea connoisseur and traveler.',
        POINT(6.9282, 79.8637),
        'https://example.com/profile14.jpg',
        50,
        24,
        34
    ),
    (
        15,
        '1985-09-30',
        'Male',
        'History buff and museum explorer.',
        POINT(6.9332, 79.8568),
        'https://example.com/profile15.jpg',
        40,
        30,
        40
    ),
    (
        16,
        '1991-06-25',
        'Female',
        'Adventure seeker and photographer.',
        POINT(6.9215, 79.8650),
        'https://example.com/profile16.jpg',
        45,
        27,
        37
    ),
    (
        17,
        '1994-03-10',
        'Male',
        'Beach lover and scuba diver.',
        POINT(6.9299, 79.8603),
        'https://example.com/profile17.jpg',
        30,
        23,
        33
    ),
    (
        18,
        '1986-12-05',
        'Female',
        'Dog mom and nature lover.',
        POINT(6.9270, 79.8624),
        'https://example.com/profile18.jpg',
        55,
        28,
        38
    ),
    (
        19,
        '1993-08-15',
        'Male',
        'Car enthusiast and engineer.',
        POINT(6.9203, 79.8648),
        'https://example.com/profile19.jpg',
        40,
        25,
        35
    ),
    (
        20,
        '1988-11-01',
        'Female',
        'Pianist and language learner.',
        POINT(6.9335, 79.8587),
        'https://example.com/profile20.jpg',
        30,
        28,
        38
    ),
    (
        21,
        '1995-12-12',
        'Male',
        'Guitarist and songwriter.',
        POINT(6.9275, 79.8572),
        'https://example.com/profile21.jpg',
        35,
        22,
        32
    ),
    (
        22,
        '1989-09-09',
        'Female',
        'DIY enthusiast and blogger.',
        POINT(6.9298, 79.8625),
        'https://example.com/profile22.jpg',
        50,
        26,
        36
    ),
    (
        23,
        '1996-07-23',
        'Male',
        'Chef and restaurant owner.',
        POINT(6.9219, 79.8594),
        'https://example.com/profile23.jpg',
        25,
        23,
        33
    ),
    (
        24,
        '1992-04-08',
        'Female',
        'Digital nomad and podcaster.',
        POINT(6.9286, 79.8602),
        'https://example.com/profile24.jpg',
        45,
        27,
        37
    ),
    (
        25,
        '1998-10-15',
        'Male',
        'Martial artist and mentor.',
        POINT(6.9320, 79.8579),
        'https://example.com/profile25.jpg',
        40,
        20,
        30
    ),
    (
        26,
        '1985-01-05',
        'Female',
        'Gardener and eco-warrior.',
        POINT(6.9251, 79.8664),
        'https://example.com/profile26.jpg',
        60,
        30,
        40
    ),
    (
        27,
        '1993-06-30',
        'Male',
        'Hiker and wildlife photographer.',
        POINT(6.9216, 79.8630),
        'https://example.com/profile27.jpg',
        50,
        24,
        34
    ),
    (
        28,
        '1987-03-18',
        'Female',
        'Coffee shop owner and designer.',
        POINT(6.9269, 79.8612),
        'https://example.com/profile28.jpg',
        40,
        29,
        39
    ),
    (
        29,
        '1990-08-25',
        'Male',
        'Architect and urban planner.',
        POINT(6.9302, 79.8640),
        'https://example.com/profile29.jpg',
        35,
        26,
        36
    ),
    (
        30,
        '1999-01-20',
        'Female',
        'Freelance writer and yoga instructor.',
        POINT(6.9285, 79.8563),
        'https://example.com/profile30.jpg',
        30,
        21,
        31
    ),
    (
        31,
        '1992-05-19',
        'Female',
        'Nature lover and avid photographer.',
        POINT(6.5773, 79.9604),
        'https://example.com/profile31.jpg',
        50,
        25,
        35
    ),
    (
        32,
        '1988-11-15',
        'Male',
        'Passionate about adventure sports.',
        POINT(6.5759, 79.9580),
        'https://example.com/profile32.jpg',
        40,
        28,
        40
    ),
    (
        33,
        '1995-03-30',
        'Female',
        'Loves cooking and exploring cultures.',
        POINT(6.5801, 79.9562),
        'https://example.com/profile33.jpg',
        30,
        22,
        32
    ),
    (
        34,
        '1990-07-12',
        'Male',
        'Tech enthusiast and gaming lover.',
        POINT(6.5784, 79.9536),
        'https://example.com/profile34.jpg',
        60,
        27,
        37
    ),
    (
        35,
        '1997-10-05',
        'Female',
        'Explorer with a love for hiking.',
        POINT(6.5798, 79.9518),
        'https://example.com/profile35.jpg',
        20,
        21,
        31
    ),
    (
        36,
        '1993-04-25',
        'Male',
        'Coffee lover and bookworm.',
        POINT(6.5779, 79.9502),
        'https://example.com/profile36.jpg',
        35,
        24,
        34
    ),
    (
        37,
        '1989-09-10',
        'Female',
        'Animal rights advocate.',
        POINT(6.5804, 79.9593),
        'https://example.com/profile37.jpg',
        40,
        26,
        36
    ),
    (
        38,
        '1991-08-08',
        'Male',
        'Fitness coach and adventure seeker.',
        POINT(6.5767, 79.9576),
        'https://example.com/profile38.jpg',
        50,
        27,
        37
    ),
    (
        39,
        '1996-02-28',
        'Female',
        'Art enthusiast and painter.',
        POINT(6.5791, 79.9545),
        'https://example.com/profile39.jpg',
        25,
        23,
        33
    ),
    (
        40,
        '1994-12-19',
        'Male',
        'Cyclist and marathon runner.',
        POINT(6.5786, 79.9523),
        'https://example.com/profile40.jpg',
        30,
        24,
        34
    ),
    (
        41,
        '1987-06-01',
        'Female',
        'Singer and songwriter.',
        POINT(6.5760, 79.9569),
        'https://example.com/profile41.jpg',
        40,
        29,
        39
    ),
    (
        42,
        '1990-03-23',
        'Male',
        'Beach lover and scuba diver.',
        POINT(6.5807, 79.9530),
        'https://example.com/profile42.jpg',
        60,
        26,
        36
    ),
    (
        43,
        '1998-07-15',
        'Female',
        'Enjoys creative writing.',
        POINT(6.5783, 79.9582),
        'https://example.com/profile43.jpg',
        35,
        20,
        30
    ),
    (
        44,
        '1992-01-10',
        'Male',
        'Cycling enthusiast.',
        POINT(6.5795, 79.9505),
        'https://example.com/profile44.jpg',
        50,
        24,
        34
    ),
    (
        45,
        '1985-10-27',
        'Female',
        'Interior designer.',
        POINT(6.5769, 79.9601),
        'https://example.com/profile45.jpg',
        40,
        30,
        40
    ),
    (
        46,
        '1991-06-19',
        'Male',
        'Photographer.',
        POINT(6.5789, 79.9510),
        'https://example.com/profile46.jpg',
        45,
        27,
        37
    ),
    (
        47,
        '1994-03-05',
        'Female',
        'Food blogger and traveler.',
        POINT(6.5762, 79.9548),
        'https://example.com/profile47.jpg',
        30,
        23,
        33
    ),
    (
        48,
        '1986-11-12',
        'Male',
        'Engineer with a love for technology.',
        POINT(6.5774, 79.9559),
        'https://example.com/profile48.jpg',
        55,
        28,
        38
    ),
    (
        49,
        '1993-07-08',
        'Female',
        'Pet lover.',
        POINT(6.5799, 79.9572),
        'https://example.com/profile49.jpg',
        40,
        25,
        35
    ),
    (
        50,
        '1988-01-19',
        'Male',
        'Avid biker.',
        POINT(6.5766, 79.9508),
        'https://example.com/profile50.jpg',
        30,
        28,
        38
    ),
    (
        51,
        '1995-10-20',
        'Female',
        'DIY expert.',
        POINT(6.5782, 79.9538),
        'https://example.com/profile51.jpg',
        35,
        22,
        32
    ),
    (
        52,
        '1989-08-05',
        'Male',
        'Loves cricket and rugby.',
        POINT(6.5768, 79.9579),
        'https://example.com/profile52.jpg',
        50,
        26,
        36
    ),
    (
        53,
        '1996-09-15',
        'Female',
        'Yoga and wellness enthusiast.',
        POINT(6.5793, 79.9542),
        'https://example.com/profile53.jpg',
        25,
        23,
        33
    ),
    (
        54,
        '1992-04-25',
        'Male',
        'Film enthusiast and aspiring director.',
        POINT(6.5776, 79.9515),
        'https://example.com/profile54.jpg',
        45,
        27,
        37
    ),
    (
        55,
        '1998-12-08',
        'Female',
        'Dreams of traveling the world.',
        POINT(6.5806, 79.9600),
        'https://example.com/profile55.jpg',
        40,
        20,
        30
    ),
    (
        56,
        '1985-02-02',
        'Male',
        'Car mechanic.',
        POINT(6.5785, 79.9529),
        'https://example.com/profile56.jpg',
        60,
        30,
        40
    ),
    (
        57,
        '1993-06-18',
        'Female',
        'Sculptor and artist.',
        POINT(6.5765, 79.9595),
        'https://example.com/profile57.jpg',
        50,
        24,
        34
    ),
    (
        58,
        '1987-10-10',
        'Male',
        'DJ and music producer.',
        POINT(6.5797, 79.9586),
        'https://example.com/profile58.jpg',
        40,
        29,
        39
    ),
    (
        59,
        '1990-12-30',
        'Female',
        'Animal rescuer.',
        POINT(6.5802, 79.9503),
        'https://example.com/profile59.jpg',
        35,
        26,
        36
    ),
    (
        60,
        '1999-01-14',
        'Male',
        'Blogger.',
        POINT(6.5778, 79.9567),
        'https://example.com/profile60.jpg',
        30,
        21,
        31
    );
INSERT INTO user_preferences (user_id, preference_option_id)
VALUES (1, 1),
    (1, 4),
    (1, 7),
    (1, 10),
    (2, 2),
    (2, 3),
    (2, 5),
    (2, 8),
    (3, 1),
    (3, 6),
    (3, 4),
    (3, 9),
    (4, 2),
    (4, 3),
    (4, 6),
    (4, 7),
    (5, 1),
    (5, 4),
    (5, 5),
    (5, 10),
    (6, 2),
    (6, 7),
    (6, 6),
    (6, 9),
    (7, 3),
    (7, 4),
    (7, 5),
    (7, 10),
    (8, 1),
    (8, 6),
    (8, 7),
    (8, 9),
    (9, 2),
    (9, 3),
    (9, 5),
    (9, 10),
    (10, 1),
    (10, 4),
    (10, 6),
    (10, 8),
    (11, 2),
    (11, 3),
    (11, 7),
    (11, 9),
    (12, 1),
    (12, 6),
    (12, 5),
    (12, 8),
    (13, 2),
    (13, 4),
    (13, 6),
    (13, 10),
    (14, 3),
    (14, 7),
    (14, 5),
    (14, 8),
    (15, 1),
    (15, 4),
    (15, 7),
    (15, 9),
    (16, 2),
    (16, 5),
    (16, 6),
    (16, 8),
    (17, 1),
    (17, 4),
    (17, 3),
    (17, 9),
    (18, 2),
    (18, 6),
    (18, 7),
    (18, 10),
    (19, 1),
    (19, 3),
    (19, 5),
    (19, 10),
    (20, 2),
    (20, 6),
    (20, 7),
    (20, 8),
    (21, 1),
    (21, 5),
    (21, 4),
    (21, 8),
    (22, 2),
    (22, 3),
    (22, 7),
    (22, 10),
    (23, 1),
    (23, 4),
    (23, 6),
    (23, 9),
    (24, 2),
    (24, 5),
    (24, 6),
    (24, 10),
    (25, 1),
    (25, 3),
    (25, 4),
    (25, 8),
    (26, 2),
    (26, 7),
    (26, 6),
    (26, 9),
    (27, 1),
    (27, 3),
    (27, 5),
    (27, 8),
    (28, 2),
    (28, 4),
    (28, 7),
    (28, 9),
    (29, 1),
    (29, 6),
    (29, 5),
    (29, 8),
    (30, 2),
    (30, 4),
    (30, 7),
    (30, 9),
    (31, 1),
    (31, 4),
    (31, 7),
    (31, 10),
    (32, 2),
    (32, 3),
    (32, 5),
    (32, 8),
    (33, 1),
    (33, 6),
    (33, 4),
    (33, 9),
    (34, 2),
    (34, 3),
    (34, 6),
    (34, 7),
    (35, 1),
    (35, 4),
    (35, 5),
    (35, 10),
    (36, 2),
    (36, 7),
    (36, 6),
    (36, 9),
    (37, 3),
    (37, 4),
    (37, 5),
    (37, 10),
    (38, 1),
    (38, 6),
    (38, 7),
    (38, 9),
    (39, 2),
    (39, 3),
    (39, 5),
    (39, 10),
    (40, 1),
    (40, 4),
    (40, 6),
    (40, 8),
    (41, 2),
    (41, 3),
    (41, 7),
    (41, 9),
    (42, 1),
    (42, 6),
    (42, 5),
    (42, 8),
    (43, 2),
    (43, 4),
    (43, 6),
    (43, 10),
    (44, 3),
    (44, 7),
    (44, 5),
    (44, 8),
    (45, 1),
    (45, 4),
    (45, 7),
    (45, 9),
    (46, 2),
    (46, 5),
    (46, 6),
    (46, 8),
    (47, 1),
    (47, 4),
    (47, 3),
    (47, 9),
    (48, 2),
    (48, 6),
    (48, 7),
    (48, 10),
    (49, 1),
    (49, 3),
    (49, 5),
    (49, 10),
    (50, 2),
    (50, 6),
    (50, 7),
    (50, 8),
    (51, 1),
    (51, 5),
    (51, 4),
    (51, 8),
    (52, 2),
    (52, 3),
    (52, 7),
    (52, 10),
    (53, 1),
    (53, 4),
    (53, 6),
    (53, 9),
    (54, 2),
    (54, 5),
    (54, 6),
    (54, 10),
    (55, 1),
    (55, 3),
    (55, 4),
    (55, 8),
    (56, 2),
    (56, 7),
    (56, 6),
    (56, 9),
    (57, 1),
    (57, 3),
    (57, 5),
    (57, 8),
    (58, 2),
    (58, 4),
    (58, 7),
    (58, 9),
    (59, 1),
    (59, 6),
    (59, 5),
    (59, 8),
    (60, 2),
    (60, 4),
    (60, 7),
    (60, 9);
