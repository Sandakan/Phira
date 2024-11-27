<img src="https://github.com/Sandakan/Phira/blob/master/public/images/logo.webp?raw=true" alt="Phira Logo" width="100">

# Phira Dating App

Phira is a modern dating application designed to facilitate meaningful connections between users. It features real-time
chat functionality, notifications, and customizable user preferences, creating an engaging and interactive experience.

## Features

- **User Registration and Authentication**: Secure login system with email verification.
- **Matching Algorithm**: Matches users based on their preferences and interactions.
- **Real-Time Chat**: Instant messaging using WebSockets.
- **Notifications System**: Notifications like new matches, messages, and updates using WebSockets.
- **User Profiles**:
  - Detailed profiles with photos, bio, and preferences.
  - Editable user information.
- **Activity Logs**: Users can view recent activities, including likes and interactions.

---

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Technologies Used](#technologies-used)
4. [Setup Instructions](#setup-instructions)
5. [Architecture Overview](#architecture-overview)
6. [License](#license)

---

## Requirements

To run the Phira Dating App, ensure the following requirements are met:

### 1. Software

- Operating System: Windows, Linux, or macOS
- WAMP Server: Version 3.3 or later (for Windows users)
- PHP: Version 8.3 or later
- MySQL: Version 8.3 or later

---

## Installation

1. Install WAMP Server (Windows Only)

   1. Download the [WAMP server](https://www.wampserver.com/en/).
   2. Install WAMP and ensure Apache and MySQL services are running.

2. Clone the repository to the `wamp64/www` directory:
   ```bash
   git clone https://github.com/Sandakan/Phira.git
   ```
3. Install dependencies for the web server and WebSocket server:
   ```bash
   composer install
   ```
4. Configure the environment variables in [config.php](config.php) file:

   ```php
   <?php
   define('BASE_URL', 'http://localhost:80/Phira'); // Base url of the application
   define('ROOT_DIR', dirname(__FILE__)); // Root directory of the application
   $BASE_URL = BASE_URL;

   // Database credentials
   define('DATABASE_HOST_NAME', 'localhost');
   define('DATABASE_USERNAME', 'root');
   define('DATABASE_PASSWORD', '');
   define('DATABASE_NAME', 'PhiraDB');

   // Mail credentials
   define('MAIL_HOST', '__YOUR_MAIL_HOST__'); // e.g., 'smtp.gmail.com'
   define('MAIL_PORT', 587);
   define('MAIL_USERNAME', '__YOUR_MAIL_USERNAME__'); // e.g., 'info@phira'
   define('MAIL_PASSWORD', '__YOUR_MAIL_PASSWORD__'); // e.g., 'password'
   define('MAIL_ENCRYPTION', 'tls');
   ```

5. Initialize the database by installing the provided SQL scripts.

   - Run the [database.sql](database.sql) file to create the database schema.
   - Run the [seeds.database.sql](seeds.database.sql) file to insert sample data into the database.
     - User seed password: `12345678`

6. Create the following folders in the Phira project root to save the private data.

   ```
   Phira
   |----- private
   |       |---- media
   |             |---- user_photos
   |             |---- chats
   ```

7. Start the WebSocket server by opening the [websocket.server.php](server/websocket.server.php) file in a new browser
   tab:

8. Navigate to the default WAMP server URL in your browser to access the Phira Dating App.
   ```
   http://localhost:80/Phira/index.php
   ```

---

## Technologies Used

- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL
- **Real-Time Communication**: WebSockets
- **Other Libraries**:
  - `React\EventLoop` for asynchronous operations.
  - `Ratchet` for WebSocket handling.

---

## Setup Instructions

### 1. WebSocket Server

- The WebSocket server powers real-time chat and notifications. Ensure it is running.

### 2. Notifications

- Notifications are implemented using WebSockets. Configure your server to support real-time updates.

---

## Architecture Overview

- **Frontend**: Handles user interaction and WebSocket connections.
- **Backend**: PHP for data handling and WebSocket server for real-time communication.
- **Database**: Relational structure with tables for users, chats, messages, and notifications.

---

## License

This project is licensed under the [MIT License](LICENSE).
