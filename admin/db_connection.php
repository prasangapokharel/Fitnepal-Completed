<!-- db_connection.php -->
<?php
$host = 'localhost';
$dbname = 'fitness';
$user = 'root';
$password = ''; // Change as needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
