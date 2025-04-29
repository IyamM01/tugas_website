<?php
    require_once 'index.php'; // Include the main dashboard file
    require_once __DIR__ . '/../config/config.php';

    $query = "SELECT * FROM users";
    $stmt = $conn->query($query);

    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row['user_id'] . "<br>";
            echo "Name: " . $row['name'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "Error: Query failed.";
    }
?>