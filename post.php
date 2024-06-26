<?php
// Start session
session_start();

require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all required fields are filled
    if (empty($_POST['amt']) || empty($_POST['description']) || empty($_POST['calories']) || empty($_POST['date'])) {
        // Handle incomplete form submission
        echo "Please fill all the fields.";
        exit();
    }

    // Sanitize and validate user input
    $amt = htmlspecialchars($_POST['amt'], ENT_QUOTES);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
    $calories = htmlspecialchars($_POST['calories'], ENT_QUOTES);
    $date = htmlspecialchars($_POST['date'], ENT_QUOTES);

    // Validate numeric input
    if (!is_numeric($amt) || !is_numeric($calories)) {
        // Handle invalid input
        echo "Amount and Calories must be numeric values.";
        exit();
    }

    // Retrieve user_id from session
    if (!isset($_SESSION['user_id'])) {
        // Handle unauthorized access or session expiration
        echo "User not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Prepare and execute the SQL query to insert data into the calorie table
    $query = "INSERT INTO calorie (user_id, date, amount, calories, description) VALUES (?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);

    // Bind parameters
    $statement->bind_param("isiss", $user_id, $date, $amt, $calories, $description);

    // Execute query
    if ($statement->execute()) {
        // Redirect to workout.php after successful insertion
        header("Location: workout.php");
        exit();
    } else {
        // Error handling
        echo "Error: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
