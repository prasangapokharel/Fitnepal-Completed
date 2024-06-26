<?php
include 'session.php';
include 'db_connection.php';
include 'navbar.php'; // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['username'])) {
        $action = $_POST['action'];
        $username = $_POST['username'];
        
        if ($action === 'verified') {
            // Update status to verified
            $sql = "UPDATE bankpayment SET status = 'verified' WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        } elseif ($action === 'unverified') {
            // Update status to unverified
            $sql = "UPDATE bankpayment SET status = 'unverified' WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}

// Retrieve payment data from the database
$sql = "SELECT * FROM bankpayment";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Payments</title>
    <link rel="stylesheet" href="./cssadmin/paymentview.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <h2>Admin View Payments</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Image</th>
                <th>Transaction Date</th>
                <th>Transaction Hash</th>
                <th>Account Number</th>
                <th>Branch</th>
                <th>Account Holder Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo $payment['username']; ?></td>
                    <td><img src="<?php echo $payment['image']; ?>" alt="Transaction Screenshot" style="width: 100px;"></td>
                    <td><?php echo $payment['transaction_date']; ?></td>
                    <td><?php echo $payment['transaction_hash']; ?></td>
                    <td><?php echo $payment['account_number']; ?></td>
                    <td><?php echo $payment['branch']; ?></td>
                    <td><?php echo $payment['holderName']; ?></td>
                    <td><?php echo $payment['status']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="username" value="<?php echo $payment['username']; ?>">
                            <button type="submit" name="action" value="verified">Verified</button>
                            <button type="submit" name="action" value="unverified">Unverified</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
