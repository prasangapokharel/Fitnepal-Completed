<?php
require_once '../admin/db_connection.php';
include 'session.php';


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $accountNumber = $_POST['accountNumber'];
    $holderName = $_POST['holderName'];
    $branch = $_POST['branch'];
    $transactionHash = $_POST['transactionHash'];
    $transactionScreenshot = $_FILES['transactionScreenshot']['name']; // File name

    // Upload transaction screenshot
    $targetDir = "manualpay/";
    $targetFile = $targetDir . basename($transactionScreenshot); // File path
    move_uploaded_file($_FILES["transactionScreenshot"]["tmp_name"], $targetFile);

    // Insert data into bankpayment table
    $sql = "INSERT INTO bankpayment (username, user_id, account_number, branch, transaction_hash, holderName, image, status) 
            VALUES (:username, :user_id, :account_number, :branch, :transaction_hash, :holderName, :image, 'unverified')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $holderName, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':account_number', $accountNumber, PDO::PARAM_STR);
    $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);
    $stmt->bindParam(':transaction_hash', $transactionHash, PDO::PARAM_STR);
    $stmt->bindParam(':holderName', $holderName, PDO::PARAM_STR);
    $stmt->bindParam(':image', $targetFile, PDO::PARAM_STR);
    $stmt->execute();

    // Show thank you message and redirect to dashboard after 3 seconds
    echo "<script>
            alert('Thank you! Payment review takes 12 hours.');
            setTimeout(function() {
                window.location.href = 'http://localhost/fitnepal/dashboard.php';
            }, 3000);
          </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="./CSSpayment/details.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <!-- Fixed public account information section -->
        <div class="public-account">
            <h2>Company Public Account Information</h2>
            <div class="account-details">
                <p><strong>Account Name:</strong> Ashish Khadka</p>
                <p><strong>Account No:</strong> 8856798223</p>
                <p><strong>Branch:</strong> Itahari</p>
            </div>
        </div>

        <hr> <!-- Horizontal line to separate sections -->

        <!-- User input section -->
        <div class="user-input">
            <h3>Transaction Information</h3>
            <form method="post" enctype="multipart/form-data">
                <label for="holderName">Account Holder Name:</label>
                <input type="text" id="holderName" name="holderName" placeholder="Enter your name" required>

                <label for="accountNumber">Account Number:</label>
                <input type="text" id="accountNumber" name="accountNumber" placeholder="Your account number" required>

                <label for="branch">Branch:</label>
                <input type="text" id="branch" name="branch" placeholder="Enter your branch" required>

                <label for="transactionHash">Transaction Hash:</label>
                <input type="text" id="transactionHash" name="transactionHash" placeholder="Enter transaction hash" required>

                <label for="transactionScreenshot">Transaction Screenshot:</label>
                <input type="file" id="transactionScreenshot" name="transactionScreenshot" accept="image/*" required>

                <p><strong>Amount:</strong> 300 Rs</p> <!-- Fixed amount -->

                <button type="submit" class="purchase-button">Purchase</button>
            </form>
        </div>
    </div>
</body>
</html>
