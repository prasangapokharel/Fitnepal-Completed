<?php
// Include your database connection
require_once 'db_connection.php';

// Hash the password
$password = 'R@man741';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare SQL to insert an admin user
$sql = "INSERT INTO users (user_id, name, email, password, age, weight, height, activity, profile_picture, status, registration_time, role)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Define variables for the values to bind
$user_id = 10002;
$name = 'Raman Singh';
$email = 'inc@gmail.com';
$age = 25;
$weight = 65;
$height = 175;
$activity = 'normal';
$profile_picture = NULL;
$status = 'active';
$role = 'admin';

// Bind the parameters
$stmt->bind_param(
    'isssiiissss', // Expected data types
    $user_id, // Variable for user_id
    $name, // Variable for name
    $email, // Variable for email
    $hashedPassword, // Hashed password
    $age, // Variable for age
    $weight, // Variable for weight
    $height, // Variable for height
    $activity, // Activity level
    $profile_picture, // Profile picture (null if empty)
    $status, // User status
    $role // User role
);

// Execute the statement and check for success
if ($stmt->execute()) {
    echo "Admin user added successfully."; // Success message
} else {
    echo "Error adding admin user: " . $stmt->error; // Error message
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
