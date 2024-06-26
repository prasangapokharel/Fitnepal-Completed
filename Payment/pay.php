<?php
// Include necessary files
include '../admin/db_connection.php';

// Execute the SQL query
$sql = "SELECT 
            username,
            'Khalti' AS payment_type,
            transaction_date AS time,
            CASE 
                WHEN status = 'unverified' THEN 'Pending'
                ELSE 'Completed'
            END AS status,
            IF(status = 'verified', 10, NULL) AS amount
        FROM 
            bankpayment
        ORDER BY 
            transaction_date DESC";

$stmt = $pdo->query($sql);
$payment_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page - Payment History</title>
    <link rel="stylesheet" href="admin_styles.css"> <!-- External CSS -->
</head>
<body>
    <h1>Payment History</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Payment Type</th>
                <th>Time</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payment_history as $payment): ?>
                <tr>
                    <td><?php echo $payment['username']; ?></td>
                    <td><?php echo $payment['payment_type']; ?></td>
                    <td><?php echo $payment['time']; ?></td>
                    <td><?php echo $payment['status']; ?></td>
                    <td><?php echo $payment['amount'] !== null ? 'Rs. ' . $payment['amount'] : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
