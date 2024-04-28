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

// Database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve logged-in user's ID
    $user_id = $_SESSION['user_id'];

    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $country = $_POST["country"];
    $age = $_POST["age"];
    $training_time = $_POST["training_time"];
    $bio = $_POST["bio"];
    
    // Upload training certificate
    $target_dir = "C:/Xamppp/htdocs/p/trainer/"; // Update this path as needed
    $training_certificate = $target_dir . basename($_FILES["training_certificate"]["name"]);
    move_uploaded_file($_FILES["training_certificate"]["tmp_name"], $training_certificate);

    // Upload profile image
    $profile_image = $target_dir . basename($_FILES["profile_image"]["name"]);
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image);

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO trainers (user_id, first_name, last_name, country, age, training_time, training_certificate, bio, profile_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssissss", $user_id, $first_name, $last_name, $country, $age, $training_time, $training_certificate, $bio, $profile_image);
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->affected_rows > 0) {
        echo "Trainer application submitted successfully!";
    } else {
        echo "Error submitting trainer application: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            text-align: right;
            letter-spacing: 1px;
        }

        .navbar a {
            display: inline-block;
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
            float: left;
            padding: 14px 20px;
            font-size: 25px;
            text-decoration: none;
            color: #fff;
        }

        @media screen and (max-width: 600px) {
            .navbar a {
                display: block;
                text-align: left;
            }
        }

        .container {
            padding: 20px;
            color: #fff;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-control {
            border-color: #ccc;
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
    <h2>Trainer Application Form</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="form-group">
            <label for="training_time">Training Time:</label>
            <input type="text" class="form-control" id="training_time" name="training_time" required>
        </div>
        <!-- <div class="form-group">
            <label for="option_selected">Option Selected:</label>
            <select class="form-control" id="option_selected" name="option_selected" required>
                <option value="citizenship">Citizenship</option>
                <option value="passport">Passport</option>
                <option value="driving_license">Driving License</option>
            </select>
        </div> -->
        <div class="form-group">
            <label for="training_certificate">Training Certificate:</label>
            <input type="file" class="form-control-file" id="training_certificate" name="training_certificate" required>
        </div>
        <div class="form-group">
            <label for="bio">Bio (150 words):</label>
            <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="profile_image">Profile Image:</label>
            <input type="file" class="form-control-file" id="profile_image" name="profile_image" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>