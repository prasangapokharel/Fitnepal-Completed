<?php
// Include necessary files
include 'db_connection.php';
include 'navbar.php'; // Assuming you have a navbar included in your page

// Prepare the SQL query to get the calorie details
$sql = "SELECT calorie.user_id, calorie.date, calorie.amount, calorie.calories, calorie.description
        FROM calorie
        ORDER BY calorie.date DESC"; // Order by date for consistency

$stmt = $pdo->prepare($sql);
$stmt->execute(); // Execute the prepared statement
$calorie_entries = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calories Details</title>
    <link rel="stylesheet" href="./cssadmin/calories.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <h2>Calories Tracker</h2>

        <!-- Display the calorie details in a table -->
        <table>
            <tr>
                <th>User ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Calories</th>
                <th>Description</th>
            </tr>
            <?php foreach ($calorie_entries as $entry): ?> <!-- Loop through each calorie entry -->
                <tr>
                    <td><?php echo htmlspecialchars($entry['user_id']); ?></td> <!-- User ID -->
                    <td><?php echo htmlspecialchars($entry['date']); ?></td> <!-- Date -->
                    <td><?php echo htmlspecialchars($entry['amount']); ?></td> <!-- Amount -->
                    <td><?php echo htmlspecialchars($entry['calories']); ?></td> <!-- Calories -->
                    <td><?php echo htmlspecialchars($entry['description']); ?></td> <!-- Description -->
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</body>
</html>
