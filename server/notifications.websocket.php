<?php

require '../vendor/autoload.php';
require '../config.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\Loop;

class NotificationsWebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $userConnections;
    protected PDO $db;
    private DateTime $lastFetchTime;

    public function __construct($db)
    {
        $this->clients = new \SplObjectStorage;
        $this->userConnections = [];
        $this->db = $db;

        $this->pollDatabase();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParams);
        $userId = $queryParams['user_id'] ?? null;

        if (!$userId) {
            $conn->close(); // Reject connection if no user ID is provided
            return;
        }

        // Store connection for the user
        $this->clients->attach($conn);
        $this->userConnections[$userId][] = $conn;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Notifications are handled automatically; no incoming messages expected
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        // Remove connection from userConnections
        foreach ($this->userConnections as $userId => $connections) {
            if (($key = array_search($conn, $connections)) !== false) {
                unset($this->userConnections[$userId][$key]);
                if (empty($this->userConnections[$userId])) {
                    unset($this->userConnections[$userId]);
                }
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    private function pollDatabase()
    {
        // Use the static Loop API
        $loop = Loop::get();

        // Initialize last fetch time with the server start time
        $this->lastFetchTime = new DateTime('now', new DateTimeZone('UTC'));

        // Add periodic polling of the database
        $loop->addPeriodicTimer(5, function () {
            $this->checkForNotifications();
        });
    }

    private function checkForNotifications()
    {
        try {
            $currentFetchTime = new DateTime('now', new DateTimeZone('UTC'));
            $lastFetchTimeString = $this->lastFetchTime->format('Y-m-d H:i:s');

            // Fetch new notifications from the database
            $query = <<< SQL
            SELECT
                *
            FROM
                notifications
            WHERE
                created_at > :last_fetch_time AND
                is_read = 0
                AND deleted_at IS NULL;
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':last_fetch_time', $lastFetchTimeString, PDO::PARAM_STR);
            $stmt->execute();
            $notifications = $stmt->fetchAll();

            foreach ($notifications as $notification) {
                foreach ($notifications as $notification) {
                    $this->sendNotification($notification);
                }

                // Mark notification as read
                // $updateQuery = "UPDATE notifications SET is_read = TRUE WHERE notification_id = :notification_id";
                // $updateStmt = $this->db->prepare($updateQuery);
                // $updateStmt->execute([':notification_id' => $notification['notification_id']]);

                // Update the last fetch time
                $this->lastFetchTime = $currentFetchTime;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function sendNotification($notification)
    {
        $userId = $notification['user_id'];

        // Broadcast the notification only to the connected client for the user
        if (isset($this->clients[$userId])) {
            $this->clients[$userId]->send(json_encode($notification));
        }
    }
}
