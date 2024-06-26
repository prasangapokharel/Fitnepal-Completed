<?php
// Include the database connection
include 'db_connection.php';
include 'session.php'; // Include the session check

// Ensure the connection variable is initialized
if (!$conn) {
    die("Failed to connect to the database.");
}

// Get the selected category from the query parameter
$category = isset($_GET['category']) ? $_GET['category'] : 'weight-loss'; // Default to 'weight-loss'

// Fetch all diets for the selected category
$sql = "SELECT * FROM diets WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$diets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Get all results as an associative array

// Separate the diets into meal types
$meal_types = [
    'breakfast' => [],
    'lunch' => [],
    'dinner' => [],
];

foreach ($diets as $diet) {
    $meal_types[$diet['meal_type']][] = $diet; // Add to the appropriate meal type array
}
?>
<?php
include 'header/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Diet Planner</title>
    <link rel="stylesheet" href="./CSS/diet.css">
</head>
<body>
    <div class="container">

        <!-- Dropdown to select a diet category -->
        <div class="category-select">
            <label for="category">Choose a Diet Category:</label>
            <select id="category" onchange="changeCategory(this.value)">
                <option value="weight-loss" <?php echo $category === 'weight-loss' ? 'selected' : ''; ?>>Weight Loss</option>
                <option value="weight-gain" <?php echo $category === 'weight-gain' ? 'selected' : ''; ?>>Weight Gain</option>
            </select>
        </div>

        <div class="meal-sections">
            <!-- Breakfast -->
            <div class="meal-column">
                <h2>Breakfast</h2>
                <?php foreach ($meal_types['breakfast'] as $diet): ?>
                    <div class="diet-card">
                        <img src="uploads/<?php echo htmlspecialchars($diet['food_image']); ?>" alt="<?php echo htmlspecialchars($diet['food_name']); ?>">
                        <h3><?php echo htmlspecialchars($diet['food_name']); ?></h3>
                        <p><strong>Protein:</strong> <?php echo $diet['protein']; ?>g/100g</p>
                        <p><strong>Calories:</strong> <?php echo $diet['calories']; ?></p>
                        <p><?php echo htmlspecialchars($diet['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Lunch -->
            <div class="meal-column">
                <h2>Lunch</h2>
                <?php foreach ($meal_types['lunch'] as $diet): ?>
                    <div class="diet-card">
                        <img src="uploads/<?php echo htmlspecialchars($diet['food_image']); ?>" alt="<?php echo htmlspecialchars($diet['food_name']); ?>">
                        <h3><?php echo htmlspecialchars($diet['food_name']); ?></h3>
                        <p><strong>Protein:</strong> <?php echo $diet['protein']; ?>g/100g</p>
                        <p><strong>Calories:</strong> <?php echo $diet['calories']; ?></p>
                        <p><?php echo htmlspecialchars($diet['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Dinner -->
            <div class="meal-column">
                <h2>Dinner</h2>
                <?php foreach ($meal_types['dinner'] as $diet): ?>
                    <div class="diet-card">
                        <img src="uploads/<?php echo htmlspecialchars($diet['food_image']); ?>" alt="<?php echo htmlspecialchars($diet['food_name']); ?>">
                        <h3><?php echo htmlspecialchars($diet['food_name']); ?></h3>
                        <p><strong>Protein:</strong> <?php echo $diet['protein']; ?>g/100g</p>
                        <p><strong>Calories:</strong> <?php echo $diet['calories']; ?></p>
                        <p><?php echo htmlspecialchars($diet['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function changeCategory(category) {
            window.location.href = "?category=" + category; // Reload the page with the selected category
        }
    </script>
</body>
</html>
