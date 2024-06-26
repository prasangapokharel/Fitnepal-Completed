<?php
include 'session.php'; // Include the session check

include 'db_connection.php';

// Query for login history data
$query_history = "SELECT user_id, login_time, device, ip_address FROM history ORDER BY login_time DESC";
$stmt = $pdo->prepare($query_history);
$stmt->execute();
$history_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'navbar.php'; // Include the navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login History</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Inter font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="./cssadmin/history.css"> <!-- Custom CSS for history page -->
</head>
<body>
    <div class="container">

        <!-- Table to display login history -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Login Time</th>
                    <th>Device</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through the history data and display it in table rows -->
                <?php foreach ($history_data as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($entry['login_time']); ?></td>
                        <td>
                            <i class="fas fa-laptop"></i> <!-- Device icon -->
                            <?php echo htmlspecialchars($entry['device']); ?> <!-- Device name -->
                        </td>
                        <td><?php echo htmlspecialchars($entry['ip_address']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> <!-- Feather icons -->
    <script>
        feather.replace(); // Initialize Feather icons
    </script>
</body>
</html>
