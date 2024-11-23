<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require '../vendor/autoload.php';
require '../config.php';
require '../utils/database.php';

class ChatServer implements MessageComponentInterface
{
    protected $clients;
    protected $userConnections = [];

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $params);

        if (!isset($params['user_id'])) {
            $conn->close();
            return;
        }

        $userId = (int)$params['user_id'];

        // Attach the connection and store by user ID
        $this->clients->attach($conn);
        $this->userConnections[$userId][] = $conn;

        echo "User $userId connected\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (!isset($data['chat_id'], $data['sender_id'], $data['receiver_id'], $data['content'])) {
            return;
        }

        $chatId = (int)$data['chat_id'];
        $senderId = (int)$data['sender_id'];
        $receiverId = (int)$data['receiver_id'];
        $content = $data['content'];

        // // Save the message to the database
        // global $db;
        // $stmt = $db->prepare("
        //     INSERT INTO messages (chat_id, sender_id, receiver_id, content)
        //     VALUES (:chat_id, :sender_id, :receiver_id, :content)
        // ");
        // $stmt->execute([
        //     'chat_id' => $chatId,
        //     'sender_id' => $senderId,
        //     'receiver_id' => $receiverId,
        //     'content' => $content,
        // ]);

        // Notify relevant users
        $this->notifyUsers($chatId, $senderId, $receiverId, $content);
    }

    public function notifyUsers($chatId, $senderId, $receiverId, $content)
    {
        $message = json_encode([
            'chat_id' => $chatId,
            'sender_id' => $senderId,
            'content' => $content,
        ]);

        // Notify sender and receiver if connected
        foreach ([$senderId, $receiverId] as $userId) {
            if (isset($this->userConnections[$userId])) {
                foreach ($this->userConnections[$userId] as $conn) {
                    $conn->send($message);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        // Remove the connection from userConnections
        foreach ($this->userConnections as $userId => $connections) {
            $this->userConnections[$userId] = array_filter($connections, function ($clientConn) use ($conn) {
                return $clientConn !== $conn;
            });

            if (empty($this->userConnections[$userId])) {
                unset($this->userConnections[$userId]);
            }
        }

        echo "Connection closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: " . $e->getMessage() . "\n";
        $conn->close();
    }
}

$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new ChatServer, ['*']);
$app->run();
