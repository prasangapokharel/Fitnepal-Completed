<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Logout logic
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #1F6FFF;
}

.navbar {
    background-color: #1F6FFF;
    overflow: hidden;
    text-align: right; /* Align navbar items to the right */
    letter-spacing: 1px; /* Add letter spacing */
}

.navbar a {
    display: inline-block; /* Display navbar items inline */
    color: #fff;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
    font-size: 17px;
}

.navbar a:hover {
    background-color: #1255c5;
}

.navbar .logo {
    float: left; /* Float the logo to the left */
    padding: 14px 20px;
    font-size: 25px;
    text-decoration: none;
    color: #fff;
}

@media screen and (max-width: 600px) {
    .navbar a {
        display: block; /* Change navbar items to block for responsive design */
        text-align: left; /* Align navbar items to the left on smaller screens */
    }
}

.container {
    padding: 20px;
}

    </style>
</head>
<body>


<div class="navbar">
    <a href="dashboard" class="logo">Fitness Tracker</a>
    <a href="profile.php">Profile</a>
    <a href="goal.php">Goals</a>
    <a href="diet.php">Diet</a>
    <a href="workout.php">Workout</a>
    <a href="?logout=true">Logout</a> <!-- Added logout link -->
</div>


<div class="container">
   
</div>

</body>
</html>
