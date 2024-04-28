<?php
session_start();

// Database connection
include 'db_connection.php';

// Retrieve user's profile data with ID 4
$user_id = 4; // Change to the desired user ID
$sql = "SELECT * FROM trainers WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Check if profile image exists
    $profile_image_filename = $row['profile_image'];
    $profile_image_path = "http://localhost/p/trainer/" . $profile_image_filename; // Adjust the path based on your directory structure
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #1F6FFF;
            }

            .container {
                max-width: 100%;
                height: 500px;
                padding: 20px;
                color: #1255c5;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-card {
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 80%;
                max-width: 600px;
            }

            .profile-image {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 20px;
                border: 4px solid #1F6FFF; /* Changed border color to match the original design */
            }

            .profile-info {
                margin-bottom: 20px;
            }

            .profile-info p {
                margin: 10px 0;
                font-size: 18px;
            }

            .profile-info p span {
                font-weight: bold;
                padding-right: 10px;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="profile-card">
            <img src="<?php echo $profile_image_path; ?>" alt="Profile Image" class="profile-image">
            <div class="profile-info">
                <p><span>First Name:</span> <?php echo $row['first_name']; ?></p>
                <p><span>Last Name:</span> <?php echo $row['last_name']; ?></p>
                <p><span>Country:</span> <?php echo $row['country']; ?></p>
                <p><span>Age:</span> <?php echo $row['age']; ?></p>
                <p><span>Training Certificate:</span> <a href="<?php echo $row['training_certificate']; ?>">View Certificate</a></p>
                <p><span>Bio:</span> <?php echo $row['bio']; ?></p>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    echo "No profile data found for user ID 4.";
}
?>
