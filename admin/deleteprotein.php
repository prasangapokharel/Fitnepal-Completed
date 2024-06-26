<?php
include 'db_connection.php'; // Include PDO connection

// SQL to delete all entries
$sql = "DELETE FROM entries";

$stmt = $pdo->prepare($sql);
if ($stmt->execute()) {
    // Return success message
    http_response_code(200);
    echo json_encode(array("message" => "All entries deleted successfully."));
} else {
    // Return error message
    http_response_code(500);
    echo json_encode(array("error" => "Error deleting entries."));
}
?>
