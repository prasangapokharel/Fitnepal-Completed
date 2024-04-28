<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Logout logic
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Query to fetch user's height, weight, and age
$sql = "SELECT height, weight, age, name, LPAD(user_id, 5, '0') as user_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
    $height = $row["height"];
    $weight = $row["weight"];
    $age = $row["age"];
    $name = $row["name"];
    $user_id = $row["user_id"]; // Now using the corrected user_id field


    // // Define the baseline protein recommendation (0.8 grams per kilogram of body weight)
$protein_per_kg = 0.8;

// Calculate the recommended protein intake
$protein_intake = $weight * $protein_per_kg;
}

// Logout logic
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Tracker</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
     body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #3e4684; /* Accent color */
    color: #fff;
}

.navbar {
    background-color: #3e4684; /* Accent color */;
    text-align: right;
    padding: 0px;
}

.navbar a {
    display: inline-block;
    color: #fff;
    text-align: center;
    padding: 14px;
    padding-left: 50px;
    text-decoration: none;
    font-size: 19px;
    text-shadow: 0 0 3px #1F6FFF;
}

.navbar .logo {
    float: left;
    padding: 8px 0;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    text-shadow: 0 0 10px #1F6FFF;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #FFF;
    padding: 20px;
    color: #3e4684; /* Accent color */

    border-radius: 10px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
    color: #3e4684; /* Accent color */
}

input {
    width: calc(100% - 16px);
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #F0F6FC;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: transparent;
    color: #F0F6FC;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

input:focus {
    outline: none;
    border-color: #1F6FFF;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

button {
    background-color: #3e4684; /* Accent color */;
    color: #fff;
    padding: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

button:hover {
    background-color: #0D6BFF;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    border: 1px;
    border-radius: 2px;
    padding: 14px;
    text-align: left;
    background-color: #3e4684; /* Accent color */;
    color: #F0F6FC;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

th {
    background-color: #3e4684; /* Accent color */;
    color: #fff;
    box-shadow: none;
}


    </style>
</head>
<body>

<div class="navbar">
    <a href="#" class="logo">Fitness Tracker</a>
    <a href="profile.php">Profile</a>
    <a href="goal.php">Goals</a>
    <a href="diet.php">Diet</a>
    <a href="index.php">Workout</a>
    <a href="?logout=true">Logout</a>
</div>

<div class="container" id="container">
<p>Protein Goal :  <?php echo $protein_intake; ?></p>

    <h2 style="text-align: center;">Protein Tracker</h2>

    <form id="proteinForm">
        <label for="mealName">Meal Name:</label>
        <!-- Updated meal name input field -->
        <input type="text" id="mealName" name="mealName" onclick="populateFoodOptions(); fetchProteinGrams();" required>

        <label for="proteinGrams">Protein Grams:</label>
        <input type="text" id="proteinGrams" name="proteinGrams" required>

        <label for="mealTime">Meal Time:</label>
        <input type="time" id="mealTime" name="mealTime" required>

        <button type="button" onclick="addEntry()">Add Entry</button>
        <button type="button" onclick="saveToPDF()">Save to PDF</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Meal Name</th>
                <th>Protein Grams</th>
                <th>Meal Time</th>
            </tr>
        </thead>
        <tbody id="trackerTableBody">
            <!-- Entries will be added here -->
        </tbody>
    </table>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
<script>
// Function to populate food options when meal name input field is clicked
function populateFoodOptions() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var foodOptions = JSON.parse(xhr.responseText);
            var mealNameInput = document.getElementById('mealName');
            mealNameInput.setAttribute('list', 'foodList');
            var datalist = document.createElement('datalist');
            datalist.id = 'foodList';
            for (var i = 0; i < foodOptions.length; i++) {
                var option = document.createElement('option');
                option.value = foodOptions[i].Food_name;
                datalist.appendChild(option);
            }
            mealNameInput.parentNode.appendChild(datalist);
        }
    };
    xhr.open("GET", "food.php", true);
    xhr.send();
}
// Function to fetch protein grams when a food item is selected
function fetchProteinGrams() {
    var selectedFood = document.getElementById('mealName').value;
    if (selectedFood) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var foodData = JSON.parse(xhr.responseText);
                var proteinGramsInput = document.getElementById('proteinGrams');
                // Find the selected food item in the food data
                var selectedFoodData = foodData.find(function(item) {
                    return item.Food_name === selectedFood;
                });
                // Update the protein grams input field with the protein value of the selected food
                if (selectedFoodData) {
                    proteinGramsInput.value = selectedFoodData.Protein;
                } else {
                    // If the selected food is not found in the data, clear the input field
                    proteinGramsInput.value = '';
                }
            }
        };
        xhr.open("GET", "food.php", true);
        xhr.send();
    }
}




    var totalProteinGrams = 0;

    function addEntry() {
        var mealName = document.getElementById('mealName').value;
        var proteinGrams = parseFloat(document.getElementById('proteinGrams').value) || 0;
        var mealTime = document.getElementById('mealTime').value;

        if (mealName && mealTime) {
            var tableBody = document.getElementById('trackerTableBody');
            var newRow = tableBody.insertRow(tableBody.rows.length);

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);

            cell1.innerHTML = mealName;
            cell2.innerHTML = proteinGrams;
            cell3.innerHTML = mealTime;

            totalProteinGrams += proteinGrams;
            document.getElementById('totalProteinGrams').textContent = totalProteinGrams;

            document.getElementById('mealName').value = '';
            document.getElementById('proteinGrams').value = '';
            document.getElementById('mealTime').value = '';

            // Send the data to the server to save the entry
            saveEntryToServer(mealName, proteinGrams, mealTime);
        } else {
            alert('Please enter meal name and meal time.');
        }
    }

    function saveEntryToServer(mealName, proteinGrams, mealTime) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "save_entry.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response if needed
                console.log(xhr.responseText);
            }
        };
        var params = "mealName=" + encodeURIComponent(mealName) +
                     "&proteinGrams=" + proteinGrams +
                     "&mealTime=" + encodeURIComponent(mealTime);
        xhr.send(params);
    }

    function saveToPDF() {
        var element = document.querySelector('table');
        html2pdf().from(element).save('prasanga_pdf');
    }
</script>

</body>
</html>
