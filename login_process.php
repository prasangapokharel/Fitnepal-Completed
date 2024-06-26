<?php
session_start(); // Start the session

// Include database connection
require_once 'db_connection.php';

// Get form data from POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user data based on the email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verify user existence and check password
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = sprintf("%05d", $user['id']); // Pad to 5 digits
        $_SESSION['user_name'] = $user['name'];

        // Detect the user role
        $is_admin = isset($user['role']) && strtolower($user['role']) === 'admin';

        // Record login history
        $user_id = $user['user_id'];
        $device = $_SERVER['HTTP_USER_AGENT']; // User's device information
        $ip_address = $_SERVER['REMOTE_ADDR']; // User's IP address

        $history_sql = "INSERT INTO history (user_id, device, ip_address) VALUES (?, ?, ?)";
        $history_stmt = $conn->prepare($history_sql);
        $history_stmt->bind_param("iss", $user_id, $device, $ip_address);
        $history_stmt->execute();
        $history_stmt->close();

        // Redirect based on user role
        if ($is_admin) {
            // Redirect to the admin dashboard if user is an admin
            header("Location: /fitnepal/admin/dashboard.php");
        } else {
            // Redirect to the regular user dashboard otherwise
            header("Location: dashboard.php");
        }
        exit; // Ensure the script stops after redirect
    } else {
        echo "Invalid password. Please try again."; // If password is incorrect
    }
} else {
    echo "User with this email does not exist."; // If user does not exist
}

// Close the database connections
$stmt->close();
$conn->close();
