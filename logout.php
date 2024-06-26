<?php
session_start();

if (isset($_GET['logout'])) {
    // Establish a MySQLi connection
    $conn = mysqli_connect('localhost', 'root', '', 'fitness');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_id = $_SESSION['user_id'];
    
    // Update the user status
    $query = "UPDATE users SET status = 'inactive' WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    
    // Clean up and close the connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Destroy the session and redirect
    session_destroy();
    
    header("Location: login.php");
    exit;
}
?>
