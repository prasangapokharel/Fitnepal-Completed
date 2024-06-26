<?php
// Include the database connection
include 'db_connection.php';

// Define the absolute path for the upload directory
$uploadDir = '../uploads/'; // Relative path from the script's location

// Ensure the uploads directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle deletion of a diet item
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Delete the diet item with the given ID
    $sql = "DELETE FROM diets WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $delete_message = "Diet item deleted successfully.";
    } else {
        $delete_message = "Error deleting diet item.";
    }
}

// Function to upload food images
function uploadImage($file, $uploadDir) {
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Generate a unique file name to avoid conflicts
    $filename = uniqid() . '-' . basename($file['name']); // Create a unique filename
    $targetFilePath = $uploadDir . $filename; // Full path for the uploaded file

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $targetFilePath; // Return the path on success
    }

    return false; // Return false if upload fails
}

// Handle form submission to add a new diet item
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $category = $_POST['category'];
    $food_name = $_POST['food_name'];
    $protein = $_POST['protein'];
    $calories = $_POST['calories'];
    $meal_type = $_POST['meal_type'];
    $description = $_POST['description'];

    // Upload the image and get the file path
    $food_image = uploadImage($_FILES['food_image'], $uploadDir);

    if ($food_image) {
        // Insert the data into the diets table with the correct image path
        $sql = "INSERT INTO diets (category, food_image, food_name, protein, calories, meal_type, description) 
                VALUES (:category, :food_image, :food_name, :protein, :calories, :meal_type, :description)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters with named placeholders
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':food_image', $food_image, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);
        $stmt->bindParam(':protein', $protein, PDO::PARAM_STR);
        $stmt->bindParam(':calories', $calories, PDO::PARAM_INT);
        $stmt->bindParam(':meal_type', $meal_type, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $message = "Diet item added successfully!";
        } else {
            $message = "Error adding diet item: " . $stmt->errorInfo()[2];
        }
    } else {
        $message = "Failed to upload image.";
    }
}

// Fetch all diets from the database
$sql = "SELECT * FROM diets";
$result = $pdo->query($sql); // Use PDO query
include 'navbar.php'; // Include the navbar

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Diet Panel</title>
    <link rel="stylesheet" href="./cssadmin/meal.css"> <!-- Custom CSS -->
</head>
<body>
    <div class="container">

        <?php if (isset($message)): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Form to add a new diet item -->
        <form method="post" enctype="multipart/form-data">
            <label for="category">Category:</label>
            <select name="category" required>
                <option value="weight-loss">Weight Loss</option>
                <option value="weight-gain">Weight Gain</option>
                <option value="keto">Keto</option>
            </select>

            <label for="food_name">Food Name:</label>
            <input type="text" name="food_name" required>

            <label for="protein">Protein (per 100g):</label>
            <input type="number" step="0.1" name="protein" required>

            <label for="calories">Calories:</label>
            <input type="number" name="calories" required>

            <label for="meal_type">Meal Type:</label>
            <select name="meal_type" required>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>

            <label for="description">Description:</label>
            <textarea name="description" rows="4"></textarea>

            <label for="food_image">Food Image:</label>
            <input type="file" name="food_image" accept="image/*" required>

            <button type="submit">Add Diet Item</button>
        </form>
        <?php if (isset($delete_message)): ?>
            <div class="alert"><?php echo htmlspecialchars($delete_message); ?></div>
        <?php endif; ?>

        <!-- Display existing diet information in a table -->
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Food Image</th>
                    <th>Food Name</th>
                    <th>Protein</th>
                    <th>Calories</th>
                    <th>Meal Type</th>
                    <th>Description</th>
                    <th>Action</th> <!-- New column for the delete button -->

                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo ucfirst($row['category']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['food_image']); ?>" alt="<?php echo htmlspecialchars($row['food_name']); ?>" width="50" height="50"></td>
                        <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                        <td><?php echo $row['protein']; ?> g</td>
                        <td><?php echo $row['calories']; ?></td>
                        <td><?php echo ucfirst($row['meal_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <!-- Form for deleting a diet item -->
                            <form class="dtb" method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button class="dt" type="submit">Delete</button> <!-- Delete button -->
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
