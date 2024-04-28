<?php
// Include database connection
include "db_connection.php";

// Query to fetch food options and their associated protein grams from the database
$sql = "SELECT Food_name, Protein FROM np_nutrition";
$result = $conn->query($sql);

$foodData = array();

if ($result->num_rows > 0) {
    // Fetch and store food options and their associated protein grams in an array
    while ($row = $result->fetch_assoc()) {
        $foodData[] = array(
            'Food_name' => $row['Food_name'],
            'Protein' => $row['Protein']
        );
    }
}

// Return food options and their associated protein grams as JSON response
echo json_encode($foodData);
?>
