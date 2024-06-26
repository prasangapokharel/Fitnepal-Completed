<?php
include 'session.php';
include 'db_connection.php';
include 'navbar.php'; // Check if user is logged in

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
    <link rel="stylesheet" href="./cssadmin/admin_styles.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <h1>Payment History</h1>

        <!-- Search bar -->
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search username..">
        </div>

        <table id="paymentTable">
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
    </div>

    <!-- JavaScript for search functionality -->
    <script>
        function searchTable() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("paymentTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Index 0 for Username column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
