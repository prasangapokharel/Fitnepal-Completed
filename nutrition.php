<?php
include 'session.php';

// Debugging: Check if session is set
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

// Debugging: Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the header
include 'header/header.php';

// Handle search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);
}

// Fetch nutrition data
$sql = "SELECT id, Food_name, Protein, Calories, Amount FROM np_nutrition";
if ($searchQuery) {
    $sql .= " WHERE Food_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
}
$result = $conn->query($sql);

// Debugging: Check SQL execution
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Information</title>
    <link rel="stylesheet" href="./CSS/nutrition.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1>Nutrition Information</h1>
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Search for food..." value="<?php echo $searchQuery; ?>">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Food Name</th>
                    <th>Protein (g)</th>
                    <th>Calories</th>
                    <th>Amount (g)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Food_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Protein']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Calories']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Amount']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
