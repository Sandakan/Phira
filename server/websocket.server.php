<?php

require_once '../vendor/autoload.php';
require_once '../config.php';
require_once '../utils/database.php';

require './chat.websocket.php';
require './notifications.websocket.php';

// use ChatWebSocketServer;
// use NotificationsWebSocketServer;

$conn = initialize_database();

$app = new Ratchet\App('localhost', 8080);
$app->route('/chats', new ChatWebSocketServer($conn), ['*']);
$app->route('/notifications', new NotificationsWebSocketServer($conn), ['*']);

$app->run();
