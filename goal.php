<?php
include 'session.php'; // Include the session check
include 'db_connection.php';

// Fetch normal protein goal from users table
$user_id = $_SESSION['user_id'];
$sql = "SELECT normal_protein FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$normal_protein_goal = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $normal_protein_goal = $row['normal_protein'];
}

// Fetch all entries from entries table for the user
$sql = "SELECT meal_name, protein_grams, meal_time FROM entries WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$entries_result = $stmt->get_result();

$entries = array();
$total_protein = 0;
if ($entries_result->num_rows > 0) {
    while ($row = $entries_result->fetch_assoc()) {
        $entries[] = $row;
        $total_protein += $row['protein_grams'];
    }
}
?>

<?php
include 'header/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/goal.css">
</head>
<style>
    @keyframes firebox {
            0% {
                box-shadow: 0 0 10px rgba(255, 165, 0, 0.5), 0 0 20px rgba(255, 140, 0, 0.5), 0 0 30px rgba(255, 69, 0, 0.5), 0 0 40px rgba(255, 0, 0, 0.5);
            }
            50% {
                box-shadow: 0 0 20px rgba(255, 69, 0, 0.5), 0 0 30px rgba(255, 0, 0, 0.5), 0 0 40px rgba(255, 69, 0, 0.5), 0 0 50px rgba(255, 140, 0, 0.5);
            }
            100% {
                box-shadow: 0 0 10px rgba(255, 165, 0, 0.5), 0 0 20px rgba(255, 140, 0, 0.5), 0 0 30px rgba(255, 69, 0, 0.5), 0 0 40px rgba(255, 0, 0, 0.5);
            }
        }

        @keyframes popup {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 0;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .popup-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: popup 0.5s ease-out, firebox 1s infinite;
        }
</style>

<body>
    <div class="container" id="container">
        <!-- <h2>Protein Tracker</h2> -->
        <p class="dta">Today Protein consumed: <span id="totalProteinGrams"><?php echo $total_protein; ?>grams</span></p>

        <!-- Display normal protein goal -->
        <p class="pg">Normal Protein Goal: <span id="normalProteinGoal"><?php echo $normal_protein_goal; ?> grams</span></p>

        <form id="proteinForm">
            <label for="mealName">Meal Name:</label>
            <input type="text" id="mealName" name="mealName" onclick="populateFoodOptions(); fetchProteinGrams();" required>

            <label for="proteinGrams">Protein Grams:</label>
            <input type="text" id="proteinGrams" name="proteinGrams" required>

            <label for="mealTime">Meal Time:</label>
            <input type="time" id="mealTime" name="mealTime" required>

            <button type="button" onclick="addEntry()">Add Entry</button>
            <button type="button" onclick="saveToPDF()">Save to PDF</button>
        </form>

        <br>
        <hr style="border-color: #67C6E3;">

        <table>
            <thead>
                <tr>
                    <th>Meal Name</th>
                    <th>Protein Grams</th>
                    <th>Meal Time</th>
                </tr>
            </thead>
            <tbody id="trackerTableBody">
                <!-- PHP to add entries from database -->
                <?php foreach ($entries as $entry) : ?>
                    <tr>
                        <td><?php echo $entry['meal_name']; ?></td>
                        <td><?php echo $entry['protein_grams']; ?></td>
                        <td><?php echo $entry['meal_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <div class="popup-message" id="goalCompletedMessage">
        Congratulation! Your protein goal is completed.
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    <script>
    // Function to save the entry to the server
    function addEntry() {
        var mealName = document.getElementById('mealName').value;
        var proteinGrams = parseFloat(document.getElementById('proteinGrams').value);
        var mealTime = document.getElementById('mealTime').value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "save_entry.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.message) {
                    addEntryToTable(mealName, proteinGrams, mealTime);
                    updateTotalProtein();
                } else if (response.error) {
                    console.error("Error: " + response.error);
                }
            }
        };
        var params = "mealName=" + encodeURIComponent(mealName) +
            "&proteinGrams=" + encodeURIComponent(proteinGrams) +
            "&mealTime=" + encodeURIComponent(mealTime);
        xhr.send(params);
    }

    // Function to add a new entry to the tracker table
    function addEntryToTable(mealName, proteinGrams, mealTime) {
        var tableBody = document.getElementById('trackerTableBody');
        var newRow = tableBody.insertRow(tableBody.rows.length);

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        cell1.innerHTML = mealName;
        cell2.innerHTML = proteinGrams;
        cell3.innerHTML = mealTime;

        // Check if the goal is completed
        checkGoalCompleted();
    }

    // Function to update total protein grams from the server
    function updateTotalProtein() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_total_protein.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                totalProteinGrams = parseFloat(xhr.responseText) || 0;
                document.getElementById('totalProteinGrams').textContent = totalProteinGrams;
                checkGoalCompleted();
            }
        };
        xhr.send();
    }

    // Function to check if the protein goal is completed
    function checkGoalCompleted() {
        if (totalProteinGrams >= <?php echo $normal_protein_goal; ?>) {
            showGoalCompletedMessage();
        }
    }

    // Function to show the goal completed message
    function showGoalCompletedMessage() {
        var popup = document.getElementById("goalCompletedMessage");
        popup.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
        }, 4000); // 4 seconds
    }

    // Function to populate food options when meal name input field is clicked
    function populateFoodOptions() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var foodOptions = JSON.parse(xhr.responseText);
                var mealNameInput = document.getElementById('mealName');
                var datalist = document.getElementById('foodList');

                // Clear existing options
                datalist.innerHTML = '';

                for (var i = 0; i < foodOptions.length; i++) {
                    var option = document.createElement('option');
                    option.value = foodOptions[i].Food_name;
                    datalist.appendChild(option);
                }
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
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var foodData = JSON.parse(xhr.responseText);
                    var proteinGramsInput = document.getElementById('proteinGrams');
                    // Find the selected food item in the food data
                    var selectedFoodData = foodData.find(function (item) {
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

    document.getElementById('mealName').addEventListener('input', fetchProteinGrams);

    // Initialize datalist
    document.addEventListener('DOMContentLoaded', function() {
        var mealNameInput = document.getElementById('mealName');
        var datalist = document.createElement('datalist');
        datalist.id = 'foodList';
        mealNameInput.setAttribute('list', datalist.id);
        mealNameInput.parentNode.appendChild(datalist);
        populateFoodOptions();
    });

    // Ensure totalProteinGrams is defined and updated correctly
    var totalProteinGrams = parseFloat(document.getElementById('totalProteinGrams').textContent) || 0;
</script>

</body>
</html>