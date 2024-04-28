<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error message if user is not logged in
    echo json_encode(array("error" => "Unauthorized access"));
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Ensure the user ID is 5 digits
if (strlen($user_id) != 5 || !is_numeric($user_id)) {
    // If the user ID is not 5 digits or not numeric, terminate with an error
    echo json_encode(array("error" => "Invalid user ID"));
    exit();
}

// Get the data from the POST request
$mealName = $_POST['mealName'];
$proteinGrams = $_POST['proteinGrams'];
$mealTime = $_POST['mealTime'];

// Prepare and bind the SQL statement to insert data into entries table
$stmt = $conn->prepare("INSERT INTO entries (user_id, meal_name, protein_grams, meal_time) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isds", $user_id, $mealName, $proteinGrams, $mealTime);

// Execute the statement
if ($stmt->execute() === TRUE) {
    // Return success message
    echo json_encode(array("message" => "New record created successfully"));
} else {
    // Return error message
    echo json_encode(array("error" => "Error: " . $stmt->error));
}

// Close the connection
$stmt->close();
$conn->close();
?>
