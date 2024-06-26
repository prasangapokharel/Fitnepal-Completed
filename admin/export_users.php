<?php
include 'db_connection.php'; // Include the database connection

// Set the header to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=users.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, ['User ID', 'Name', 'Email', 'Registered']);

// Fetch user data from the database
$sql = "SELECT user_id, name, email, registration_time FROM users ORDER BY user_id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Loop through user data and output to CSV
while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $user['user_id'],
        $user['name'],
        $user['email'],
        date('Y-m-d H:i:s', strtotime($user['registration_time']))
    ]);
}

fclose($output);
?>
