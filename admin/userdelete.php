<?php
require_once 'db_connection.php';

// Check if user_id is passed via GET or POST
if (isset($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id']; // Cast to integer to avoid SQL injection
    
    try {
        // Prepare SQL to delete user by ID
        $query_delete = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query_delete);
        $stmt->execute([':user_id' => $user_id]);
        
        // Check if a row was deleted
        if ($stmt->rowCount() > 0) {
            // Successful deletion, redirect to user.php
            header("Location: user.php?message=User%20deleted%20successfully");
            exit();
        } else {
            // User ID not found or other error
            echo "Error: Could not delete user. User may not exist.";
        }
    } catch (PDOException $e) {
        // Handle exception
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: No user ID provided.";
}

?>
