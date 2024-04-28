<?php
session_start();

// Include database connection
include "db_connection.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Function to validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to hash passwords
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fetch user information
$sql = "SELECT name, email, age, weight, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// User's current details
$name = $user_data["name"];
$email = $user_data["email"];
$age = $user_data["age"];
$weight = $user_data["weight"];
$profile_picture = $user_data["profile_picture"] ?? 'blank_profile_picture.jpg';

// Message variables
$update_email_msg = '';
$update_password_msg = '';
$update_profile_picture_msg = '';

// Update email logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_email"])) {
    $new_email = $_POST["new_email"];
    if (validate_email($new_email)) {
        // Update email in the database
        $sql_update = "UPDATE users SET email = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $new_email, $user_id);
        if ($stmt_update->execute()) {
            $update_email_msg = "Email updated successfully.";
            $email = $new_email; // Update current email
        } else {
            $update_email_msg = "Error updating email in the database.";
        }
    } else {
        $update_email_msg = "Invalid email format.";
    }
}

// Change password logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change_password"])) {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Fetch hashed password from the database
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $hashed_password = $user_data["password"];

    if (password_verify($current_password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            // Hash the new password and update it in the database
            $hashed_new_password = hash_password($new_password);
            $sql_update = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $hashed_new_password, $user_id);
            if ($stmt_update->execute()) {
                $update_password_msg = "Password changed successfully.";
            } else {
                $update_password_msg = "Error updating password in the database.";
            }
        } else {
            $update_password_msg = "New password and confirm password do not match.";
        }
    } else {
        $update_password_msg = "Current password is incorrect.";
    }
}

// Profile picture upload logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['profile_picture'])) {
    $target_dir = "profilepic/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $update_profile_picture_msg = "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["profile_picture"]["size"] > 500000) {
        $update_profile_picture_msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $update_profile_picture_msg = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update profile picture in the database
            $sql_update = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $target_file, $user_id);
            if ($stmt_update->execute()) {
                $update_profile_picture_msg = "Profile picture updated successfully.";
                $profile_picture = $target_file; // Update current profile picture
            } else {
                $update_profile_picture_msg = "Error updating profile picture in the database.";
            }
        } else {
            $update_profile_picture_msg = "Error uploading your profile picture.";
        }
    } else {
        $update_profile_picture_msg .= " Profile picture was not uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Profile</title>
</head>
<body>
<section class="hero-section">
    <nav class="navbar">
        <div class="data-container">
            <!-- Logo Section -->
            <a class="lg">FITNEPAL</a>
            
            <!-- Menu Section -->
            <div id="menu-time" class="menu-data animate__animated">
                <!-- Close Button for Mobile -->
                <a onclick="closebar()"><i id="close" class="size fa-solid fa-xmark"></i></a>
                
                <!-- Navigation Links -->
                <a href="profile.php">Profile</a>
                <a href="goal.php">Goal</a>
                <a href="diet.php">Diet</a>
                <a class ="log" href="logout.php">Logout</a>
            </div>
            
            <!-- Menu Bar for Mobile -->
            <a id="Menu-bar" onclick="menubar()"><i class="size-icon fa-solid fa-bars"></i></a>
        </div>
    </nav>

    <div class="container">
        <div class="profile-info">
            <!-- Display profile picture and handle file input -->
            <div class="profile-pic-wrapper">
                <img src="<?php echo $profile_picture; ?>" id="profile-picture-display" alt="Profile Picture" class="profile-picture">
                <form id="profile-picture-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <input type="file" id="profile_picture_input" name="profile_picture" accept="image/*" required>
                    <input type="submit" id="submit_button" value="Upload Profile Picture">
                </form>
            </div>

            <!-- Display upload message -->
            <p id="upload-msg"><?php echo $update_profile_picture_msg; ?></p>

            <hr>

            <!-- Display user information -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Name -->
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

                <!-- Email -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                <!-- Age -->
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
                
                <!-- Weight -->
                <label for="weight">Weight:</label>
                <input type="number" id="weight" step="0.01" value="<?php echo $weight; ?>" required>

            </form>

            <hr>

            <!-- Form to update email -->
            <h3>Update Email</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="new_email">New Email:</label>
                <input type="email" id="new_email" name="new_email" required>
                <input type="hidden" name="update_email" value="1">
                <button class="prof"  type="submit">Update Email</button>
            </form>
            <p><?php echo $update_email_msg; ?></p>

            <hr>

            <!-- Form to change password -->
            <h3>Change Password</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <input type="hidden" name="change_password" value="1">
                <button class="prof" type="submit">Change Password</button>
            </form>
            <p><?php echo $update_password_msg; ?></p>
        </div>
    </div>
</section>

<script>
function menubar() {
    var menuData = document.querySelector('.menu-data');
    var menuBar = document.getElementById('Menu-bar');

    if (menuData) {
        menuData.classList.remove('animate__fadeOut');
        menuData.style.zIndex = '1';
        menuData.classList.add('animate__fadeIn');
        menuBar.style.display = 'none';
    }
}

function closebar() {
    var menuData = document.queryactor('.menu-data');
    var menuBar = document.getElementById('Menu-bar');

    if (menuData) {
        menuData.classList.remove('animate__fadeIn');
        menuData.style.zIndex = '-10';
        menuData.classList.add('animate__fadeOut');
        menuBar.style.display = 'block';
    }
}

// Trigger file input when profile picture is clicked
document.addEventListener('DOMContentLoaded', function() {
    var profilePicture = document.getElementById('profile-picture-display');
    var profilePictureInput = document.getElementById('profile_picture_input');
    var submitButton = document.getElementById('submit_button');
    
    profilePicture.addEventListener('click', function() {
        profilePictureInput.click(); // Clicks the hidden file input
    });

    profilePictureInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            profilePicture.src = e.target.result;
        };
        
        if (file) {
            reader.readAsDataURL(file);
            submitButton.click();
        }
    });
});

// Clear success messages after a few seconds
document.addEventListener('DOMContentLoaded', function() {
    var uploadMsg = document.getElementById('upload-msg');
    var emailMsg = document.getElementById('email-msg');
    var passwordMsg = document.getElementById('password-msg');

    if (uploadMsg.innerHTML !== '') {
        setTimeout(function() {
            uploadMsg.innerHTML = '';
        }, 3000);
    }

    if (emailMsg.innerHTML !== '') {
        setTimeout(function() {
            emailMsg.innerHTML = '';
        }, 3000);
    }

    if (passwordMsg.innerHTML !== '') {
        setTimeout(function() {
            passwordMsg.innerHTML = '';
        }, 3000);
    }
});
</script>

</body>
</html>
