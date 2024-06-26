<?php
include 'session.php'; // Include session check
include 'db_connection.php'; // Include PDO connection
require '../vendor/autoload.php'; // Ensure this path is correct
use PragmaRX\Google2FA\Google2FA; // Google2FA library

$google2fa = new Google2FA();
$user_id = $_SESSION['user_id']; // Get user ID from the session
$google_auth_secret = ''; // Google Authenticator secret key
$otp_message = ''; // Message for OTP success or failure

// Fetch the user's Google Authenticator secret key
$sql = "SELECT google_auth_secret FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$google_auth_secret = $stmt->fetchColumn();

$message = ''; // Message for password change success or error

// If the form is submitted, check OTP and update the password
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $otp = $_POST["otp"]; // OTP entered by the user

    // Verify the OTP
    if ($google2fa->verifyKey($google_auth_secret, $otp)) {
        // Fetch the current hashed password from the database
        $sql = "SELECT password FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $hashed_password = $stmt->fetchColumn();

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            if ($new_password === $confirm_password) {
                // Hash the new password and update it in the database
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE users SET password = :password WHERE id = :user_id";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->bindParam(':password', $hashed_new_password, PDO::PARAM_STR);
                $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                if ($stmt_update->execute()) {
                    $message = "Password changed successfully.";
                } else {
                    $message = "Error changing password.";
                }
            } else {
                $message = "New password and confirm password do not match.";
            }
        } else {
            $message = "Current password is incorrect.";
        }
    } else {
        $otp_message = "Invalid OTP. Please try again.";
    }
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="./cssadmin/change_password.css"> <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- For eye icon -->
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Current Password -->
            <div class="input-group">
                <label for="current_password">Current Password:</label>
                <div class="password-wrapper">
                    <input type="password" id="current_password" name="current_password" required>
                    <i class="fa fa-eye toggle-password" aria-hidden="true" onclick="togglePassword('current_password')"></i> <!-- Eye icon -->
                </div>
            </div>

            <!-- New Password and Confirm Password -->
            <div class="input-group">
                <label for="new_password">New Password:</label>
                <div class="password-wrapper">
                    <input type="password" id="new_password" name="new_password" required>
                    <i class="fa fa-eye toggle-password" aria-hidden="true" onclick="togglePassword('new_password')"></i> <!-- Eye icon -->
                </div>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm New Password:</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <i class="fa fa-eye toggle-password" aria-hidden="true" onclick="togglePassword('confirm_password')"></i> <!-- Eye icon -->
                </div>
            </div>

            <!-- OTP Field -->
            <div class="input-group">
                <label for="otp">One-Time Password (OTP):</label>
                <input type="text" id="otp" name="otp" required>
            </div>

            <div class="submit-section">
                <button type="submit" class="change-password-button">Change Password</button>
            </div>
        </form>

        <p><?php echo $message; ?></p> <!-- Display success or error message -->
        <p><?php echo $otp_message; ?></p> <!-- Display OTP error message -->
    </div>

    <script>
    function togglePassword(inputId) {
        var input = document.getElementById(inputId);
        var type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
    }
    </script>
</body>
</html>
