<?php

require_once '../vendor/autoload.php';
require_once '../config.php';
require_once '../utils/database.php';

require './chat.server.php';

use ChatWebSocketServer;

$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new ChatWebSocketServer, ['*']);
$app->run();
