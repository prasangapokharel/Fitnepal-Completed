<?php
include 'db_connection.php';

// Count of active users
$query_active_users = "SELECT COUNT(*) as active_users FROM users WHERE status = 'active'";
$stmt_active_users = $pdo->prepare($query_active_users);
$stmt_active_users->execute();
$result_active_users = $stmt_active_users->fetch(PDO::FETCH_ASSOC);
$active_users = $result_active_users['active_users'] ?? 0;

// Count of inactive users
$query_inactive_users = "SELECT COUNT(*) as inactive_users FROM users WHERE status = 'inactive'";
$stmt_inactive_users = $pdo->prepare($query_inactive_users);
$stmt_inactive_users->execute();
$result_inactive_users = $stmt_inactive_users->fetch(PDO::FETCH_ASSOC);
$inactive_users = $result_inactive_users['inactive_users'] ?? 0;

echo json_encode([
    'active_users' => $active_users,
    'inactive_users' => $inactive_users,
]);
?>
