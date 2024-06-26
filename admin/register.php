<?php
include 'session.php'; // Include the session check

require_once 'db_connection.php'; // Ensure this includes the correct connection variable

// Retrieve form data
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);
$activity = $_POST['activity'];

// Check email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Generate a 5-digit user_id (example)
$user_id = mt_rand(10000, 99999);

// Prepare SQL statement to insert user data into the database
$sql = "INSERT INTO users (user_id, name, email, password, age, weight, height, activity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement using PDO
$stmt = $pdo->prepare($sql); // Use `$pdo` to prepare the statement

// Bind parameters with proper data types
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->bindParam(2, $name, PDO::PARAM_STR);
$stmt->bindParam(3, $email, PDO::PARAM_STR);
$stmt->bindParam(4, $hashedPassword, PDO::PARAM_STR);
$stmt->bindParam(5, $age, PDO::PARAM_INT);
$stmt->bindParam(6, $weight, PDO::PARAM_STR);
$stmt->bindParam(7, $height, PDO::PARAM_INT);
$stmt->bindParam(8, $activity, PDO::PARAM_STR);

try {
    // Execute the prepared statement
    $stmt->execute();
    
    // If successful, provide success message or redirect as needed
    echo "Registration successful!";
} catch (PDOException $e) {
    // Handle errors, output a user-friendly message
    echo "Error: " . $e->getMessage();
}

// Close the statement
$stmt->closeCursor();

// Close the database connection (optional, depends on application flow)
// $pdo = null;
?>
