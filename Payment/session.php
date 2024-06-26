<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit;
}

// Optional: Check if the user has an "admin" role
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    // Redirect to a different page if the user is not an admin
    header("Location: ../dashboard.php"); // or wherever non-admins should go
    exit;
}

// If this point is reached, the user is authenticated and has the correct role
?>
