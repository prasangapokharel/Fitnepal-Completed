<?php
include 'db_connection.php'; // Include your database connection

// Start session for feedback
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert the contact message into the database
    $query = "INSERT INTO contactus (name, email, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $email, $message]);

    // Set feedback message for successful submission
    $_SESSION['feedback'] = "Thank you for contacting us. We will get back to you shortly.";

    // Redirect back to the contact page
    header("Location: contact.php");
    exit;
} else {
    // If the request is not POST, redirect to contact page
    header("Location: contact.php");
    exit;
}
