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
        'janedoe@gmail.com',
        '$10$56n.VAVFDN7H18u.j1u2aeNUpMdxG2BZWRAl4m1tx/lHsfocEfxPi',
        'Jane',
        'Doe',
        'USER'
    ),
    (
        'sophie@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sophie',
        'Smith',
        'USER'
    ),
    (
        'emma@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Emma',
        'Johnson',
        'USER'
    ),
    (
        'olivia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Olivia',
        'Brown',
        'USER'
    ),
    (
        'ava@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ava',
        'Jones',
        'USER'
    ),
    (
        'mia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Mia',
        'Davis',
        'USER'
    ),
    (
        'amelia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Amelia',
        'Garcia',
        'USER'
    ),
    (
        'isabella@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Isabella',
        'Martinez',
        'USER'
    ),
    (
        'sophia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sophia',
        'Hernandez',
        'USER'
    ),
    (
        'charlotte@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Charlotte',
        'Lopez',
        'USER'
    ),
    (
        'harper@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Harper',
        'Gonzalez',
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
        preferred_age_max,
        show_birthday,
        show_age,
        last_seen,
        share_profile
    )
VALUES (
        1,
        '1995-06-15',
        'Female',
        'Love hiking and exploring new places.',
        POINT(40.7128, -74.0060),
        'https://example.com/photos/sophie.jpg',
        50,
        25,
        35,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        2,
        '1993-03-22',
        'Female',
        'A bookworm who loves cozy coffee shops.',
        POINT(34.0522, -118.2437),
        'https://example.com/photos/emma.jpg',
        30,
        28,
        40,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        3,
        '1997-11-10',
        'Female',
        'Passionate about cooking and food photography.',
        POINT(51.5074, -0.1278),
        'https://example.com/photos/olivia.jpg',
        20,
        23,
        30,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        4,
        '1990-01-05',
        'Female',
        'Fitness enthusiast who enjoys yoga and running.',
        POINT(48.8566, 2.3522),
        'https://example.com/photos/ava.jpg',
        40,
        26,
        36,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        5,
        '1998-08-12',
        'Female',
        'Music lover and amateur guitarist.',
        POINT(35.6895, 139.6917),
        'https://example.com/photos/mia.jpg',
        25,
        24,
        32,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        6,
        '1992-04-18',
        'Female',
        'Nature photographer and animal lover.',
        POINT(37.7749, -122.4194),
        'https://example.com/photos/amelia.jpg',
        60,
        30,
        45,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        7,
        '1999-02-25',
        'Female',
        'Movie buff and aspiring screenwriter.',
        POINT(55.7558, 37.6173),
        'https://example.com/photos/isabella.jpg',
        15,
        21,
        29,
        FALSE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        8,
        '1994-09-30',
        'Female',
        'Lover of all things vintage and retro.',
        POINT(-33.8688, 151.2093),
        'https://example.com/photos/sophia.jpg',
        70,
        28,
        40,
        TRUE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        9,
        '1991-12-19',
        'Female',
        'Tech geek who enjoys gaming and coding.',
        POINT(52.5200, 13.4050),
        'https://example.com/photos/charlotte.jpg',
        35,
        27,
        35,
        FALSE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        10,
        '1996-07-07',
        'Female',
        'Passionate traveler and blogger.',
        POINT(-34.6037, -58.3816),
        'https://example.com/photos/harper.jpg',
        45,
        25,
        37,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    );
INSERT INTO user_preferences (user_id, preference_option_id)
VALUES (2, 2),
    (2, 6),
    (2, 10),
    (3, 3),
    (3, 7),
    (3, 11),
    (4, 4),
    (4, 8),
    (4, 12),
    (5, 1),
    (5, 9),
    (5, 14),
    (6, 2),
    (6, 10),
    (6, 15),
    (7, 3),
    (7, 11),
    (7, 16),
    (8, 4),
    (8, 12),
    (8, 13),
    (9, 1),
    (9, 7),
    (9, 11),
    (10, 2),
    (10, 8),
    (10, 14);
INSERT INTO users (email, password, first_name, last_name, role)
VALUES (
        'amelie@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Amelie',
        'Taylor',
        'USER'
    ),
    (
        'scarlett@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Scarlett',
        'Anderson',
        'USER'
    ),
    (
        'bella@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Bella',
        'Thomas',
        'USER'
    ),
    (
        'layla@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Layla',
        'Lee',
        'USER'
    ),
    (
        'nora@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Nora',
        'White',
        'USER'
    ),
    (
        'hannah@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Hannah',
        'Harris',
        'USER'
    ),
    (
        'chloe@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Chloe',
        'Martin',
        'USER'
    ),
    (
        'ellie@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ellie',
        'Thompson',
        'USER'
    ),
    (
        'zoe@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Zoe',
        'Moore',
        'USER'
    ),
    (
        'aurora@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Aurora',
        'Young',
        'USER'
    ),
    (
        'lucy@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Lucy',
        'Allen',
        'USER'
    ),
    (
        'elena@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Elena',
        'Scott',
        'USER'
    ),
    (
        'ruby@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ruby',
        'Adams',
        'USER'
    ),
    (
        'ivy@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ivy',
        'Mitchell',
        'USER'
    ),
    (
        'violet@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Violet',
        'Parker',
        'USER'
    ),
    (
        'hazel@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Hazel',
        'Evans',
        'USER'
    ),
    (
        'paisley@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Paisley',
        'Walker',
        'USER'
    ),
    (
        'aria@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Aria',
        'Hall',
        'USER'
    ),
    (
        'madelyn@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Madelyn',
        'Turner',
        'USER'
    ),
    (
        'jade@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jade',
        'Carter',
        'USER'
    ),
    (
        'sienna@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sienna',
        'Phillips',
        'USER'
    ),
    (
        'mila@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Mila',
        'Campbell',
        'USER'
    ),
    (
        'penelope@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Penelope',
        'Bennett',
        'USER'
    ),
    (
        'nova@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Nova',
        'Perez',
        'USER'
    ),
    (
        'luna@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Luna',
        'Roberts',
        'USER'
    ),
    (
        'clara@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Clara',
        'Powell',
        'USER'
    ),
    (
        'stella@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Stella',
        'Long',
        'USER'
    ),
    (
        'adeline@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Adeline',
        'Patterson',
        'USER'
    ),
    (
        'lydia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Lydia',
        'Hughes',
        'USER'
    ),
    (
        'naomi@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Naomi',
        'Flores',
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
        preferred_age_max,
        show_birthday,
        show_age,
        last_seen,
        share_profile
    )
VALUES (
        11,
        '1993-02-20',
        'Female',
        'Nature lover and adventure seeker.',
        POINT(48.8566, 2.3522),
        'https://example.com/photos/amelie.jpg',
        40,
        27,
        37,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        12,
        '1994-05-12',
        'Female',
        'Love baking and exploring new cuisines.',
        POINT(40.7128, -74.0060),
        'https://example.com/photos/scarlett.jpg',
        50,
        26,
        35,
        TRUE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        13,
        '1995-11-04',
        'Female',
        'Avid reader and coffee enthusiast.',
        POINT(34.0522, -118.2437),
        'https://example.com/photos/bella.jpg',
        30,
        24,
        34,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        14,
        '1992-01-15',
        'Female',
        'Fan of art and live music.',
        POINT(51.5074, -0.1278),
        'https://example.com/photos/layla.jpg',
        60,
        28,
        38,
        FALSE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        15,
        '1991-09-23',
        'Female',
        'Animal lover and weekend hiker.',
        POINT(37.7749, -122.4194),
        'https://example.com/photos/nora.jpg',
        70,
        29,
        39,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        16,
        '1993-10-10',
        'Female',
        'Passionate about fitness and yoga.',
        POINT(39.9042, 116.4074),
        'https://example.com/photos/hannah.jpg',
        50,
        26,
        36,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        17,
        '1996-08-18',
        'Female',
        'Foodie and travel enthusiast.',
        POINT(41.9028, 12.4964),
        'https://example.com/photos/chloe.jpg',
        40,
        25,
        35,
        FALSE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        18,
        '1990-12-02',
        'Female',
        'Love movies and cozy nights.',
        POINT(55.7558, 37.6173),
        'https://example.com/photos/ellie.jpg',
        30,
        29,
        39,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        19,
        '1997-03-28',
        'Female',
        'Photography is my passion.',
        POINT(28.6139, 77.2090),
        'https://example.com/photos/zoe.jpg',
        25,
        24,
        34,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        20,
        '1992-07-21',
        'Female',
        'Tech geek and gamer.',
        POINT(35.6895, 139.6917),
        'https://example.com/photos/aurora.jpg',
        60,
        27,
        37,
        TRUE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        21,
        '1994-04-13',
        'Female',
        'Love books and calm beaches.',
        POINT(40.4168, -3.7038),
        'https://example.com/photos/lucy.jpg',
        50,
        26,
        36,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        22,
        '1991-06-06',
        'Female',
        'Passionate about art and museums.',
        POINT(-33.8688, 151.2093),
        'https://example.com/photos/elena.jpg',
        55,
        29,
        39,
        TRUE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        23,
        '1993-01-01',
        'Female',
        'Outdoor adventurer and cyclist.',
        POINT(48.1351, 11.5820),
        'https://example.com/photos/ruby.jpg',
        70,
        28,
        38,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        24,
        '1995-11-11',
        'Female',
        'Coffee and book lover.',
        POINT(52.5200, 13.4050),
        'https://example.com/photos/ivy.jpg',
        40,
        24,
        34,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        25,
        '1997-05-05',
        'Female',
        'Animal rights activist.',
        POINT(50.1109, 8.6821),
        'https://example.com/photos/violet.jpg',
        45,
        22,
        32,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        26,
        '1990-09-12',
        'Female',
        'Love gardening and nature.',
        POINT(43.6532, -79.3832),
        'https://example.com/photos/hazel.jpg',
        35,
        29,
        39,
        FALSE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        27,
        '1992-02-20',
        'Female',
        'Dreamer and creative artist.',
        POINT(31.2304, 121.4737),
        'https://example.com/photos/paisley.jpg',
        50,
        28,
        38,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        28,
        '1996-06-14',
        'Female',
        'Entrepreneur and life-long learner.',
        POINT(1.3521, 103.8198),
        'https://example.com/photos/aria.jpg',
        60,
        25,
        35,
        FALSE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        29,
        '1995-03-03',
        'Female',
        'Avid hiker and wildlife photographer.',
        POINT(37.5665, 126.9780),
        'https://example.com/photos/madelyn.jpg',
        40,
        26,
        36,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        30,
        '1993-08-24',
        'Female',
        'Cultural explorer and historian.',
        POINT(19.0760, 72.8777),
        'https://example.com/photos/jade.jpg',
        45,
        27,
        37,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        31,
        '1992-12-05',
        'Female',
        'Pet lover and outdoor enthusiast.',
        POINT(51.1657, 10.4515),
        'https://example.com/photos/sienna.jpg',
        50,
        28,
        38,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        32,
        '1994-04-30',
        'Female',
        'Volunteering is my passion.',
        POINT(35.6762, 139.6503),
        'https://example.com/photos/mila.jpg',
        40,
        26,
        36,
        TRUE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        33,
        '1997-01-17',
        'Female',
        'Creative spirit and artist.',
        POINT(45.5017, -73.5673),
        'https://example.com/photos/penelope.jpg',
        30,
        23,
        33,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        34,
        '1995-10-09',
        'Female',
        'Music producer and performer.',
        POINT(41.8781, -87.6298),
        'https://example.com/photos/nova.jpg',
        55,
        24,
        34,
        TRUE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        35,
        '1991-07-19',
        'Female',
        'Environmental activist.',
        POINT(-22.9068, -43.1729),
        'https://example.com/photos/luna.jpg',
        60,
        29,
        39,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        36,
        '1993-06-12',
        'Female',
        'Blogger and travel enthusiast.',
        POINT(34.0522, -118.2437),
        'https://example.com/photos/clara.jpg',
        70,
        28,
        38,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        37,
        '1996-11-30',
        'Female',
        'Love exploring new cultures.',
        POINT(40.7306, -73.9352),
        'https://example.com/photos/stella.jpg',
        45,
        25,
        35,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        38,
        '1994-09-18',
        'Female',
        'Adventure junkie.',
        POINT(34.6937, 135.5023),
        'https://example.com/photos/adeline.jpg',
        50,
        26,
        36,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        39,
        '1992-05-22',
        'Female',
        'Bookworm and fitness fan.',
        POINT(-37.8136, 144.9631),
        'https://example.com/photos/lydia.jpg',
        55,
        28,
        38,
        FALSE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        40,
        '1995-03-12',
        'Female',
        'Cooking and gardening enthusiast.',
        POINT(33.8688, 151.2093),
        'https://example.com/photos/naomi.jpg',
        50,
        27,
        37,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    );
INSERT INTO user_preferences (user_id, preference_option_id)
VALUES (11, 1),
    (11, 3),
    (12, 2),
    (12, 4),
    (13, 1),
    (13, 5),
    (14, 2),
    (14, 6),
    (15, 3),
    (15, 7),
    (16, 4),
    (16, 8),
    (17, 5),
    (17, 9),
    (18, 1),
    (18, 10),
    (19, 2),
    (19, 11),
    (20, 3),
    (20, 12),
    (21, 4),
    (22, 1),
    (23, 5),
    (24, 3),
    (25, 6),
    (26, 2),
    (27, 7),
    (28, 4),
    (29, 8),
    (30, 5),
    (31, 9),
    (32, 10),
    (33, 1),
    (34, 2),
    (35, 3),
    (36, 4),
    (37, 5),
    (38, 6),
    (39, 7),
    (40, 8);
INSERT INTO users (email, password, first_name, last_name, role)
VALUES (
        'michael.smith@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Michael',
        'Smith',
        'USER'
    ),
    (
        'james.johnson@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'James',
        'Johnson',
        'USER'
    ),
    (
        'robert.brown@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Robert',
        'Brown',
        'USER'
    ),
    (
        'john.jones@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'John',
        'Jones',
        'USER'
    ),
    (
        'david.garcia@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'David',
        'Garcia',
        'USER'
    ),
    (
        'daniel.martinez@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Daniel',
        'Martinez',
        'USER'
    ),
    (
        'jose.rodriguez@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jose',
        'Rodriguez',
        'USER'
    ),
    (
        'noah.harris@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Noah',
        'Harris',
        'USER'
    ),
    (
        'william.clark@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'William',
        'Clark',
        'USER'
    ),
    (
        'joshua.lewis@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Joshua',
        'Lewis',
        'USER'
    ),
    (
        'ethan.walker@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ethan',
        'Walker',
        'USER'
    ),
    (
        'matthew.hall@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Matthew',
        'Hall',
        'USER'
    ),
    (
        'andrew.king@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Andrew',
        'King',
        'USER'
    ),
    (
        'jacob.hernandez@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jacob',
        'Hernandez',
        'USER'
    ),
    (
        'christopher.lopez@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Christopher',
        'Lopez',
        'USER'
    ),
    (
        'anthony.scott@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Anthony',
        'Scott',
        'USER'
    ),
    (
        'sebastian.moore@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Sebastian',
        'Moore',
        'USER'
    ),
    (
        'logan.adams@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Logan',
        'Adams',
        'USER'
    ),
    (
        'oliver.green@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Oliver',
        'Green',
        'USER'
    ),
    (
        'alexander.rivera@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Alexander',
        'Rivera',
        'USER'
    ),
    (
        'henry.baker@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Henry',
        'Baker',
        'USER'
    ),
    (
        'ryan.carter@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Ryan',
        'Carter',
        'USER'
    ),
    (
        'nathan.phillips@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Nathan',
        'Phillips',
        'USER'
    ),
    (
        'isaac.mitchell@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Isaac',
        'Mitchell',
        'USER'
    ),
    (
        'christian.perez@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Christian',
        'Perez',
        'USER'
    ),
    (
        'elijah.roberts@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Elijah',
        'Roberts',
        'USER'
    ),
    (
        'luke.turner@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Luke',
        'Turner',
        'USER'
    ),
    (
        'gabriel.parker@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Gabriel',
        'Parker',
        'USER'
    ),
    (
        'dylan.evans@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Dylan',
        'Evans',
        'USER'
    ),
    (
        'jack.collins@example.com',
        '$2y$10$LIHE/pNDnKXmSMZgvzEOl.LsDd0CNaLe5vhCSXyKryOUu8RXnZ8au',
        'Jack',
        'Collins',
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
        preferred_age_max,
        show_birthday,
        show_age,
        last_seen,
        share_profile
    )
VALUES (
        41,
        '1992-01-15',
        'Male',
        'Fitness and adventure lover.',
        POINT(40.7128, -74.0060),
        'https://example.com/photos/michael.jpg',
        50,
        24,
        34,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        42,
        '1993-05-22',
        'Male',
        'Tech geek and car enthusiast.',
        POINT(34.0522, -118.2437),
        'https://example.com/photos/james.jpg',
        40,
        26,
        36,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        43,
        '1994-03-18',
        'Male',
        'Sports fan and gamer.',
        POINT(41.8781, -87.6298),
        'https://example.com/photos/robert.jpg',
        60,
        25,
        35,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        44,
        '1991-08-09',
        'Male',
        'Music lover and foodie.',
        POINT(29.7604, -95.3698),
        'https://example.com/photos/john.jpg',
        30,
        22,
        32,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        45,
        '1995-11-12',
        'Male',
        'Outdoor enthusiast and nature lover.',
        POINT(33.4484, -112.0740),
        'https://example.com/photos/david.jpg',
        50,
        24,
        34,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        46,
        '1993-02-06',
        'Male',
        'Movie buff and aspiring chef.',
        POINT(39.7392, -104.9903),
        'https://example.com/photos/daniel.jpg',
        70,
        23,
        33,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        47,
        '1990-12-25',
        'Male',
        'Fitness junkie and motivational speaker.',
        POINT(32.7767, -96.7970),
        'https://example.com/photos/jose.jpg',
        100,
        27,
        37,
        TRUE,
        FALSE,
        TRUE,
        FALSE
    ),
    (
        48,
        '1992-07-20',
        'Male',
        'Tech enthusiast and dog lover.',
        POINT(37.7749, -122.4194),
        'https://example.com/photos/noah.jpg',
        40,
        26,
        36,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        49,
        '1996-09-14',
        'Male',
        'Photographer and traveler.',
        POINT(47.6062, -122.3321),
        'https://example.com/photos/william.jpg',
        80,
        25,
        35,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        50,
        '1994-10-30',
        'Male',
        'Entrepreneur and bookworm.',
        POINT(39.7684, -86.1581),
        'https://example.com/photos/joshua.jpg',
        60,
        24,
        34,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        51,
        '1995-04-18',
        'Male',
        'Love cars and building things.',
        POINT(42.3601, -71.0589),
        'https://example.com/photos/ethan.jpg',
        50,
        22,
        32,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        52,
        '1997-01-03',
        'Male',
        'Love exploring new cuisines.',
        POINT(38.9072, -77.0369),
        'https://example.com/photos/matthew.jpg',
        40,
        23,
        33,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        53,
        '1992-11-23',
        'Male',
        'Passionate about writing and poetry.',
        POINT(35.2271, -80.8431),
        'https://example.com/photos/andrew.jpg',
        60,
        25,
        35,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        54,
        '1996-06-08',
        'Male',
        'Soccer enthusiast and coach.',
        POINT(36.1627, -86.7816),
        'https://example.com/photos/jacob.jpg',
        30,
        26,
        36,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        55,
        '1993-05-04',
        'Male',
        'Art and culture enthusiast.',
        POINT(39.1031, -84.5120),
        'https://example.com/photos/christopher.jpg',
        70,
        27,
        37,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        56,
        '1994-09-25',
        'Male',
        'Binge watcher and foodie.',
        POINT(32.7157, -117.1611),
        'https://example.com/photos/anthony.jpg',
        50,
        24,
        34,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        57,
        '1990-03-11',
        'Male',
        'Runner and marathon enthusiast.',
        POINT(30.2672, -97.7431),
        'https://example.com/photos/sebastian.jpg',
        90,
        22,
        32,
        TRUE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        58,
        '1997-02-28',
        'Male',
        'Tech startup founder.',
        POINT(29.9511, -90.0715),
        'https://example.com/photos/logan.jpg',
        40,
        26,
        36,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        59,
        '1995-10-19',
        'Male',
        'Love gaming and coding.',
        POINT(25.7617, -80.1918),
        'https://example.com/photos/oliver.jpg',
        70,
        23,
        33,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        60,
        '1993-12-16',
        'Male',
        'Adventurous traveler.',
        POINT(35.7796, -78.6382),
        'https://example.com/photos/alexander.jpg',
        30,
        22,
        32,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        61,
        '1996-08-24',
        'Male',
        'Fitness trainer.',
        POINT(32.7555, -97.3308),
        'https://example.com/photos/henry.jpg',
        80,
        24,
        34,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        62,
        '1997-01-29',
        'Male',
        'Passionate about teaching.',
        POINT(33.7490, -84.3880),
        'https://example.com/photos/ryan.jpg',
        100,
        25,
        35,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        63,
        '1994-04-07',
        'Male',
        'Love debating and problem-solving.',
        POINT(39.9612, -82.9988),
        'https://example.com/photos/nathan.jpg',
        60,
        26,
        36,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        64,
        '1995-11-15',
        'Male',
        'Baking and pastry enthusiast.',
        POINT(27.9942, -82.4463),
        'https://example.com/photos/isaac.jpg',
        50,
        22,
        32,
        TRUE,
        FALSE,
        TRUE,
        TRUE
    ),
    (
        65,
        '1991-07-11',
        'Male',
        'Graphic designer and artist.',
        POINT(28.5383, -81.3792),
        'https://example.com/photos/christian.jpg',
        70,
        27,
        37,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        66,
        '1992-09-23',
        'Male',
        'Chess player and strategy gamer.',
        POINT(34.7465, -92.2896),
        'https://example.com/photos/elijah.jpg',
        40,
        24,
        34,
        FALSE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        67,
        '1990-10-10',
        'Male',
        'Marine enthusiast.',
        POINT(36.8508, -76.2859),
        'https://example.com/photos/luke.jpg',
        60,
        22,
        32,
        TRUE,
        TRUE,
        TRUE,
        FALSE
    ),
    (
        68,
        '1997-03-01',
        'Male',
        'Dedicated family man.',
        POINT(40.4406, -79.9959),
        'https://example.com/photos/gabriel.jpg',
        50,
        23,
        33,
        TRUE,
        TRUE,
        FALSE,
        TRUE
    ),
    (
        69,
        '1996-02-17',
        'Male',
        'Passionate mountain climber.',
        POINT(35.0844, -106.6504),
        'https://example.com/photos/dylan.jpg',
        40,
        25,
        35,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        70,
        '1994-06-20',
        'Male',
        'Beach lover and swimmer.',
        POINT(37.3382, -121.8863),
        'https://example.com/photos/jack.jpg',
        60,
        24,
        34,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    ),
    (
        71,
        '1994-06-20',
        'Male',
        'Beach lover and swimmer.',
        POINT(37.3382, -121.8863),
        'https://example.com/photos/jack.jpg',
        60,
        24,
        34,
        TRUE,
        TRUE,
        TRUE,
        TRUE
    );
INSERT INTO user_preferences (user_id, preference_option_id)
VALUES (43, 1),
    (44, 2),
    (45, 4),
    (46, 5),
    (47, 6),
    (48, 7),
    (49, 1),
    (50, 3),
    (51, 4),
    (52, 5),
    (53, 6),
    (54, 2),
    (55, 1),
    (56, 7),
    (57, 3),
    (58, 4),
    (59, 5),
    (60, 6),
    (61, 7),
    (62, 2),
    (63, 3),
    (64, 4),
    (65, 5),
    (66, 1),
    (67, 6),
    (68, 7),
    (69, 3),
    (70, 4),
    (71, 4);
-- Drop the existing location column
ALTER TABLE profiles DROP COLUMN location;
-- Add the location column again
ALTER TABLE profiles
ADD location POINT;
UPDATE profiles
SET location = POINT(79.8612, 6.9271)
WHERE profile_id = 1;
-- Colombo
UPDATE profiles
SET location = POINT(80.6378, 7.2906)
WHERE profile_id = 2;
-- Kandy
UPDATE profiles
SET location = POINT(81.2530, 6.0535)
WHERE profile_id = 3;
-- Galle
UPDATE profiles
SET location = POINT(81.6841, 7.8731)
WHERE profile_id = 4;
-- Batticaloa
UPDATE profiles
SET location = POINT(80.5938, 9.6615)
WHERE profile_id = 5;
-- Jaffna
UPDATE profiles
SET location = POINT(80.4194, 8.3222)
WHERE profile_id = 6;
-- Anuradhapura
UPDATE profiles
SET location = POINT(80.4485, 6.9810)
WHERE profile_id = 7;
-- Nuwara Eliya
UPDATE profiles
SET location = POINT(80.2093, 6.0415)
WHERE profile_id = 8;
-- Matara
UPDATE profiles
SET location = POINT(80.5869, 6.6818)
WHERE profile_id = 9;
-- Ratnapura
UPDATE profiles
SET location = POINT(80.2464, 7.8731)
WHERE profile_id = 10;
-- Polonnaruwa
-- Profile ID 11 to 20
UPDATE profiles
SET location = POINT(80.4037, 7.9528)
WHERE profile_id = 11;
-- Kurunegala
UPDATE profiles
SET location = POINT(79.9808, 8.5847)
WHERE profile_id = 12;
-- Puttalam
UPDATE profiles
SET location = POINT(81.1250, 6.9928)
WHERE profile_id = 13;
-- Badulla
UPDATE profiles
SET location = POINT(80.4990, 6.9932)
WHERE profile_id = 14;
-- Bandarawela
UPDATE profiles
SET location = POINT(81.1310, 6.7160)
WHERE profile_id = 15;
-- Monaragala
UPDATE profiles
SET location = POINT(80.5898, 8.3658)
WHERE profile_id = 16;
-- Vavuniya
UPDATE profiles
SET location = POINT(81.8445, 8.5937)
WHERE profile_id = 17;
-- Trincomalee
UPDATE profiles
SET location = POINT(81.7002, 7.7022)
WHERE profile_id = 18;
-- Ampara
UPDATE profiles
SET location = POINT(79.8550, 6.9331)
WHERE profile_id = 19;
-- Negombo
UPDATE profiles
SET location = POINT(80.2000, 6.7167)
WHERE profile_id = 20;
-- Kalutara
-- Profile ID 21 to 30
UPDATE profiles
SET location = POINT(80.9918, 7.0864)
WHERE profile_id = 21;
-- Haputale
UPDATE profiles
SET location = POINT(80.7200, 6.4274)
WHERE profile_id = 22;
-- Gampola
UPDATE profiles
SET location = POINT(79.9742, 7.2000)
WHERE profile_id = 23;
-- Chilaw
UPDATE profiles
SET location = POINT(80.4037, 7.8500)
WHERE profile_id = 24;
-- Dambulla
UPDATE profiles
SET location = POINT(80.6151, 8.3515)
WHERE profile_id = 25;
-- Medawachchiya
UPDATE profiles
SET location = POINT(80.7031, 7.5800)
WHERE profile_id = 26;
-- Kekirawa
UPDATE profiles
SET location = POINT(79.8834, 6.9607)
WHERE profile_id = 27;
-- Wattala
UPDATE profiles
SET location = POINT(80.3664, 7.8353)
WHERE profile_id = 28;
-- Sigiriya
UPDATE profiles
SET location = POINT(80.2314, 6.7100)
WHERE profile_id = 29;
-- Panadura
UPDATE profiles
SET location = POINT(79.8474, 6.8500)
WHERE profile_id = 30;
-- Ja-Ela
-- Profile ID 31 to 40
UPDATE profiles
SET location = POINT(80.2181, 6.4201)
WHERE profile_id = 31;
-- Beruwala
UPDATE profiles
SET location = POINT(79.9958, 6.8545)
WHERE profile_id = 32;
-- Gampaha
UPDATE profiles
SET location = POINT(80.7000, 8.2087)
WHERE profile_id = 33;
-- Mihintale
UPDATE profiles
SET location = POINT(79.8496, 7.1828)
WHERE profile_id = 34;
-- Marawila
UPDATE profiles
SET location = POINT(80.3327, 7.9524)
WHERE profile_id = 35;
-- Galewela
UPDATE profiles
SET location = POINT(80.7995, 7.2977)
WHERE profile_id = 36;
-- Nawalapitiya
UPDATE profiles
SET location = POINT(81.1896, 6.1323)
WHERE profile_id = 37;
-- Hambantota
UPDATE profiles
SET location = POINT(81.3286, 7.1237)
WHERE profile_id = 38;
-- Uva Paranagama
UPDATE profiles
SET location = POINT(79.8708, 6.7995)
WHERE profile_id = 39;
-- Dehiwala
UPDATE profiles
SET location = POINT(80.3746, 6.6738)
WHERE profile_id = 40;
-- Balangoda
-- Profile ID 41 to 50
UPDATE profiles
SET location = POINT(80.6000, 8.5000)
WHERE profile_id = 41;
-- Mannar
UPDATE profiles
SET location = POINT(80.7128, 7.0990)
WHERE profile_id = 42;
-- Hatton
UPDATE profiles
SET location = POINT(79.8300, 7.7000)
WHERE profile_id = 43;
-- Chilaw
UPDATE profiles
SET location = POINT(80.7167, 6.9331)
WHERE profile_id = 44;
-- Bogawantalawa
UPDATE profiles
SET location = POINT(81.0667, 6.7500)
WHERE profile_id = 45;
-- Koslanda
UPDATE profiles
SET location = POINT(81.1667, 7.1667)
WHERE profile_id = 46;
-- Wellawaya
UPDATE profiles
SET location = POINT(80.9886, 8.2989)
WHERE profile_id = 47;
-- Medirigiriya
UPDATE profiles
SET location = POINT(81.2337, 7.4604)
WHERE profile_id = 48;
-- Akkaraipattu
UPDATE profiles
SET location = POINT(81.4506, 6.8337)
WHERE profile_id = 49;
-- Kumana
UPDATE profiles
SET location = POINT(80.6163, 6.8501)
WHERE profile_id = 50;
-- Pelmadulla
-- Profile ID 51 to 71
UPDATE profiles
SET location = POINT(79.9619, 6.0486)
WHERE profile_id = 51;
-- Kalpitiya
UPDATE profiles
SET location = POINT(79.8588, 6.8361)
WHERE profile_id = 52;
-- Kelaniya
UPDATE profiles
SET location = POINT(81.6888, 7.8577)
WHERE profile_id = 53;
-- Pothuvil
UPDATE profiles
SET location = POINT(80.5898, 8.7831)
WHERE profile_id = 54;
-- Vavuniya
UPDATE profiles
SET location = POINT(80.9933, 7.8567)
WHERE profile_id = 55;
-- Minneriya
UPDATE profiles
SET location = POINT(79.9000, 7.1667)
WHERE profile_id = 56;
-- Wennappuwa
UPDATE profiles
SET location = POINT(80.5833, 7.1000)
WHERE profile_id = 57;
-- Peradeniya
UPDATE profiles
SET location = POINT(80.4029, 6.5323)
WHERE profile_id = 58;
-- Aluthgama
UPDATE profiles
SET location = POINT(80.3664, 6.4177)
WHERE profile_id = 59;
-- Hikkaduwa
UPDATE profiles
SET location = POINT(80.8365, 7.3327)
WHERE profile_id = 60;
-- Kadugannawa
UPDATE profiles
SET location = POINT(81.8547, 7.2333)
WHERE profile_id = 61;
-- Batticaloa
UPDATE profiles
SET location = POINT(80.7095, 6.9697)
WHERE profile_id = 62;
-- Haputale
UPDATE profiles
SET location = POINT(80.7800, 8.3000)
WHERE profile_id = 63;
-- Kekirawa
UPDATE profiles
SET location = POINT(79.8728, 6.8764)
WHERE profile_id = 64;
-- Mount Lavinia
UPDATE profiles
SET location = POINT(80.7167, 7.0833)
WHERE profile_id = 65;
-- Nawalapitiya
UPDATE profiles
SET location = POINT(80.7039, 6.4278)
WHERE profile_id = 66;
-- Kotagala
UPDATE profiles
SET location = POINT(81.1275, 7.3558)
WHERE profile_id = 67;
-- Ampara
UPDATE profiles
SET location = POINT(80.9877, 8.0330)
WHERE profile_id = 68;
-- Polonnaruwa
UPDATE profiles
SET location = POINT(80.7465, 6.7208)
WHERE profile_id = 69;
-- Ella
UPDATE profiles
SET location = POINT(80.7137, 6.9377)
WHERE profile_id = 70;
-- Bandarawela
UPDATE profiles
SET location = POINT(80.4823, 7.2582)
WHERE profile_id = 71;
-- Pussellawa
