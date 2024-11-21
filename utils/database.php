<?php
function initialize_database()
{
    try {
        // $conn = mysqli_connect(DATABASE_HOST_NAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
        $conn = new PDO('mysql:host=' . DATABASE_HOST_NAME . ';dbname=' . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die("Error: " . $e->getMessage());
    }
}
