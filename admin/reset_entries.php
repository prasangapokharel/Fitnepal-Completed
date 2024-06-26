<?php
include 'db_connection.php'; // Include PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logic to reset entries and set them for deletion after 24 hours
    // You might choose to set a flag or delete directly
    // For simplicity, here is an example that deletes all entries older than 24 hours
    try {
        // Delete entries older than 24 hours
        $sql = "DELETE FROM entries WHERE meal_time < NOW() - INTERVAL 24 HOUR";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        echo "Reset successful. All entries older than 24 hours deleted.";
    } catch (Exception $e) {
        // Handle any exceptions or errors
        echo "Error resetting entries: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
