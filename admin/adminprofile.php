<?php
include 'session.php';
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email, age, weight, profile_picture, status FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $user_data['name'] ?? 'Unknown';
$email = $user_data['email'] ?? 'Unknown';
$age = $user_data['age'] ?? 'Unknown';
$weight = $user_data['weight'] ?? 'Unknown';
$status = $user_data['status'] ?? 'inactive';
$profile_picture = $user_data['profile_picture'] ?? 'profilepic/blank_profile_picture.jpg';

$update_msg = ''; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];

    $sql_update = "UPDATE users SET name = :name, email = :email, age = :age, weight = :weight WHERE id = :user_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_update->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt_update->bindParam(':weight', $weight, PDO::PARAM_INT);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        $update_msg = "Profile updated successfully.";
    } else {
        $update_msg = "Error updating profile.";
    }
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="./cssadmin/adminprofile.css"> 
</head>
<body>

    <div class="container">
        <!-- Profile Picture and Status -->
        <div class="profile-section">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" class="profile-image" alt="Profile Picture">
            <div class="status-dot <?php echo $status === 'active' ? 'active' : 'inactive'; ?>"></div>

        </div>
        
        <div class="divider"></div> <!-- Divider between profile and form -->

        <!-- Profile Settings and Info -->
        <div class="info-section">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="input-group">
                    <label for="age">Age:</label>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>">
                </div>
                <div class="input-group">
                    <label for="weight">Weight:</label>
                    <input type="number" step="0.01" name="weight" value="<?php echo htmlspecialchars($weight); ?>">
                </div>
                <div class="mt-5 text-center">
                    <button class="submit-button" type="submit">Save Profile</button>
                </div>
            </form>
            <p><?php echo $update_msg; ?></p>
        </div>
    </div>
</body>
</html>
