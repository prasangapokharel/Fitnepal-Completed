<?php
// Include database connection code
require_once 'db_connection.php';

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$activity = $_POST['activity'];

// Check email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='error-message'>Invalid email format. Please enter a valid email address.</div>";
    exit;
}

// Check password strength
if (!preg_match("/(?=.*\d)(?=.*[^\w\s]).{8,}/", $password)) {
    echo "<div class='error-message'>Password must be at least 8 characters long and contain at least one symbol.</div>";
    exit;
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Generate a 5-digit user_id (example)
$user_id = mt_rand(10000, 99999);

// Prepare SQL statement to insert user data into the database
$sql = "INSERT INTO users (user_id, name, email, password, age, weight, height, activity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssiiis", $user_id, $name, $email, $hashedPassword, $age, $weight, $height, $activity);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Registration successful, redirect to dashboard.php with user_id
    header("Location: dashboard.php?user_id=$user_id");
    exit();
} else {
    echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
