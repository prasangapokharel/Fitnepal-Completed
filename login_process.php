<?php
session_start();

// Include database connection code
require_once 'db_connection.php';

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Retrieve user data from the database based on the provided email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and verify the password
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variable and redirect to dashboard
        // Ensure the user ID is stored as a 5-digit value
        $_SESSION['user_id'] = sprintf("%05d", $user['id']); // Pad to 5 digits
        header("Location: dashboard.php");
        exit;
    }
    
    
    
    else {
        // Password is incorrect
        echo "Invalid password. Please try again.";
    }
} else {
    // User does not exist
    echo "User with this email does not exist.";
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
