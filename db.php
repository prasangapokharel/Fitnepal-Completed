<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'fitness';

$dbh = new mysqli($hostname, $username, $password, $database);

if ($dbh->connect_error) {
    die("Connection failed: " . $dbh->connect_error);
}
?>
