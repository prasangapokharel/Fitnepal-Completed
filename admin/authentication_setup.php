<?php
include 'navbar.php';

// Session and database connection
include 'session.php'; // Include session check
include 'db_connection.php'; // Include PDO connection
require '../vendor/autoload.php'; // Ensure Composer autoload works
use PragmaRX\Google2FA\Google2FA; // Google2FA library

$google2fa = new Google2FA();

$user_id = $_SESSION['user_id']; // Fetch the user ID from the session

// Check if the user has a Google Authenticator secret key
$sql = "SELECT google_auth_secret FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$google_auth_secret = $user_data['google_auth_secret'] ?? null; // Fetch secret key from database

if ($google_auth_secret === null) {
    // Generate a new secret key
    $google_auth_secret = $google2fa->generateSecretKey(); // Generate unique secret key
    $company_name = "Fitnepal"; // Company name for QR code
    $qr_code_url = $google2fa->getQRCodeUrl($company_name, "user_{$user_id}", $google_auth_secret); // Generate QR code URL

    // Save the secret key to the database
    $sql_update = "UPDATE users SET google_auth_secret = :google_auth_secret WHERE id = :user_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':google_auth_secret', $google_auth_secret, PDO::PARAM_STR);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if (!$stmt_update->execute()) {
        die("Error storing Google Authentication secret key.");
    }
} else {
    $company_name = "YourCompany"; // Reuse company name
    $qr_code_url = $google2fa->getQRCodeUrl($company_name, "user_{$user_id}", $google_auth_secret); // Generate QR code URL from the secret key
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Google Authentication Setup</title>
    <link rel="stylesheet" href="./cssadmin/authentication_setup.css"> <!-- External CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Secret key copied to clipboard!");
            }).catch(err => {
                alert("Failed to copy text: " + err);
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> <!-- QRCode library -->
</head>
<body>
    <div class="container">
        <h2>Google Authentication Setup</h2>
        <p>Scan the QR code with Google Authenticator, then enter the generated OTP below:</p>
        <?php if (isset($qr_code_url)): ?>
            <div id="qrcode"></div>
            <script type="text/javascript">
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: "<?php echo $qr_code_url; ?>",
                    width: 200,
                    height: 200,
                });
            </script>
            <p>Your secret key: <strong><?php echo htmlspecialchars($google_auth_secret); ?></strong>
            <button class="copy-button" onclick="copyToClipboard('<?php echo htmlspecialchars($google_auth_secret); ?>')">Copy</button></p> <!-- Display secret key with copy button -->
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="otp">One-Time Password (OTP):</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Verify OTP</button>
        </form>
        <?php
        // Handling OTP verification
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["otp"])) {
            $otp = $_POST["otp"];
            $isValid = $google2fa->verifyKey($google_auth_secret, $otp); // Verify OTP
            
            if ($isValid) {
                echo "<p>Google Authentication setup successfully!</p>"; // Success message
            } else {
                echo "<p>Invalid OTP. Please try again.</p>"; // Error message
            }
        }
        ?>
    </div>
</body>
</html>
