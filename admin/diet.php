<?php
include 'session.php'; // Include the session check

// Include your database connection script
require_once 'db_connection.php';

// Fetch data from the np_nutrition table
$query = "SELECT * FROM np_nutrition";
$stmt = $pdo->prepare($query);
$stmt->execute();
$nutrition_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'navbar.php'; // Include the navbar

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nutrition Data</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Google Inter Font -->
    <style>
        /* Futuristic styling for the page */
        body {
            background-color: #1e1e1e; /* Dark background */
            color: #f0f0f0; /* Light text */
            font-family: 'Inter', sans-serif; /* Use Inter font */
            padding: 20px; /* Add some padding */
        }

        /* Futuristic styling for the table */
        table {
            width: 80%; /* Full width */
            border-collapse: collapse; /* No space between cells */
            background-color: #2c2c2c; /* Dark background for the table */
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Hide overflow for rounded corners */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Add a shadow */
            margin-left: 10%;
        }

        th {
            background-color: #3e3e3e; /* Dark header background */
            color: #f0f0f0; /* Light text */
            padding: 15px; /* Padding */
            text-align: left; /* Left-align text */
            text-transform: uppercase; /* Uppercase text */
            border-bottom: 2px solid #4e4e4e; /* Border at the bottom */
        }

        td {
            padding: 15px; /* Padding */
            border-bottom: 1px solid #4e4e4e; /* Border at the bottom */
        }

        /* Hover effect for table rows */
        tr:hover {
            background-color: #4e4e4e; /* Change background on hover */
        }

        /* Button styling for additional effect */
        .btn {
            padding: 10px 20px; /* Padding */
            background-color: #3e3e3e; /* Dark background */
            color: #f0f0f0; /* Light text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s; /* Transition effect */
        }

        .btn:hover {
            background-color: #5e5e5e; /* Change background on hover */
        }
    </style>
</head>
<body>
    <h1>Nutrition Information</h1> <!-- Page title -->

    <!-- Display data in a table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Food Name</th>
                <th>Protein (g)</th>
                <th>Calories (kcal)</th>
                <th>Amount (g)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the nutrition data and display it -->
            <?php foreach ($nutrition_data as $data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['id']); ?></td> <!-- Data sanitization -->
                    <td><?php echo htmlspecialchars($data['Food_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['Protein']); ?></td>
                    <td><?php echo htmlspecialchars($data['Calories']); ?></td>
                    <td><?php echo htmlspecialchars($data['Amount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
