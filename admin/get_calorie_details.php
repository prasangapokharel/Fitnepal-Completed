<?php
include 'db_connection.php';

try {
    $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

    if ($user_id <= 0) {
        throw new Exception("Invalid user ID.");
    }

    $sql = "SELECT `date`, `amount`, `calories`, `description` 
            FROM `calorie` 
            WHERE `user_id` = :user_id 
            ORDER BY `date` DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $calorie_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$calorie_details) {
        throw new Exception("No data found for user.");
    }

    $output = "<table>";
    $output .= "<tr><th>Date</th><th>Amount</th><th>Calories</th><th>Description</th></tr>";

    foreach ($calorie_details as $detail) {
        $output .= "<tr>";
        $output .= "<td>" . htmlspecialchars($detail['date']) . "</td>";
        $output .= "<td>" . htmlspecialchars($detail['amount']) . "</td>";
        $output .= "<td>" . htmlspecialchars($detail['calories']) . "</td>";
        $output .= "<td>" . htmlspecialchars($detail['description']) . "</td>";
        $output .= "</tr>";
    }

    $output .= "</table>";
    echo $output; // Return the table as a response

} catch (Exception $e) {
    // Return the error message as the response
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
