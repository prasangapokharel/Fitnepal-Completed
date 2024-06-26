<?php
include 'session.php'; // Include the session check

include 'db_connection.php'; // Ensure this file sets up $pdo properly

if (isset($_GET['id'])) {
    $message_id = (int)$_GET['id']; // Convert ID to integer

    $query = "UPDATE contactus SET viewed = 1 WHERE id = ?";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([$message_id])) {
        echo json_encode(['success' => true]); // Return success if update is successful
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']); // Return failure if not
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']); // Error response if ID is not set
}
?>
