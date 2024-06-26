<?php
// Start session
session_start();

// Include database connection
require 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>

<?php
    include 'header\header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calories Tracker</title>
    <link rel="stylesheet" href="./CSS/workout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <main>
        <form action="post.php" method="post">
            <input type="text" placeholder="Amount" name="amt" required>
            <input type="text" placeholder="Description" name="description" required>
            <input type="text" placeholder="Calories per serving" name="calories" required>
            <input type="date" name="date" id="datetime" value="<?php echo date('Y-m-d'); ?>" required>
            <input type="submit" value="+ Add">
            <small>
               
                Find items on <a href="http://www.calorieking.com/foods/" target="_blank">FitNepal</a> 
            </small>
        </form>
        
        <?php
        // Fetch and display data
        $q = "SELECT *, DATE_FORMAT(date,'%a, %M %D %Y') AS thedate FROM calorie ORDER BY date DESC";
        $result = $conn->query($q);

        if ($result) {
            echo "<article>";

            while ($row = $result->fetch_assoc()) {
                $thedate = $row['thedate'];
                $amount = $row['amount'];
                $calories = $row['calories'];
                $description = $row['description'];
                $item_amount = $amount * $calories;

                echo "<h2>$thedate</h2>"; // Display the formatted date
                echo "<table>";
                echo "<tr><th>Description</th><th class=\"tr\">Cal. per serving</th><th class=\"tr\">Total</th></tr>";
                echo "<tr><td>$amount x $description</td><td class=\"tr\">" . number_format($calories) . "</td><td class=\"tr\">" . number_format($item_amount) . "</td></tr>";
            }

            echo "</table>";
            echo "</article>";
        } else {
            echo "Error fetching data from database.";
        }
        ?>
    </main>
</body>

</html>
