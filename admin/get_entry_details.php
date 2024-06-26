<?php
include 'db_connection.php'; // Include PDO connection

if (isset($_GET['entry_id'])) {
    $entry_id = $_GET['entry_id']; // Get the entry ID from the GET request

    // Fetch the entry details based on entry_id
    $sql = "
        SELECT 
            users.name AS username,
            entries.meal_name,
            entries.protein_grams,
            entries.meal_time
        FROM 
            entries
        INNER JOIN 
            users 
        ON 
            entries.user_id = users.id
        WHERE 
            entries.id = :entry_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':entry_id', $entry_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $entry = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the single result
        // Display the details
        echo "<h3>Entry Details</h3>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($entry['username']) . "</p>";
        echo "<p><strong>Meal Name:</strong> " . htmlspecialchars($entry['meal_name']) . "</p>";
        echo "<p><strong>Protein Grams:</strong> " . htmlspecialchars($entry['protein_grams']) . "</p>";
        echo "<p><strong>Meal Time:</strong> " . htmlspecialchars($entry['meal_time']) . "</p>";
    } else {
        echo "<p>No data found for this entry.</p>";
    }
} else {
    echo "<p>Entry ID not provided.</p>";
}
?>
