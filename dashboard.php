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

// // Display the result
// echo "Recommended daily protein intake for $name (age $age, weight $weight kg, height $height cm): ";
// echo "$protein_intake grams per day.";

    // Calculate BMI
    if ($height > 0 && $weight > 0) {
        $height_in_meters = $height / 100; // Convert height from cm to meters
        $bmi = $weight / ($height_in_meters * $height_in_meters);
    } else {
        $bmi = "N/A";
    }
// Determine the BMI category
if ($bmi < 18.5) {
    $bmi_category = "underweight";
} elseif ($bmi >= 18.5 && $bmi <= 24.9) {
    $bmi_category = "normal";
} elseif ($bmi >= 25.0 && $bmi <= 29.9) {
    $bmi_category = "overweight";
} else {
    $bmi_category = "obese";
}

    // Calculate ideal weight range
    if ($bmi !== "N/A") {
        $min_ideal_weight = 18.5 * $height_in_meters * $height_in_meters;
        $max_ideal_weight = 24.9 * $height_in_meters * $height_in_meters;
        $ideal_weight_message = "Your ideal weight range is between " . round($min_ideal_weight, 2) . " kg and " . round($max_ideal_weight, 2) . " kg.";
    } else {
        $ideal_weight_message = "Ideal weight cannot be calculated without complete information.";
    }
} else {
    echo "User data not found.";
}


// Query to fetch the total sum of calories consumed by each user
$totalCaloriesQuery = "SELECT user_id, SUM(amount * calories) AS total_calories FROM calorie GROUP BY user_id";
$totalCaloriesResult = $conn->query($totalCaloriesQuery);

// Array to store total calories for each user
$totalCaloriesPerUser = array();

// Populate the array with total calories for each user
if ($totalCaloriesResult) {
    while ($row = $totalCaloriesResult->fetch_assoc()) {
        $totalCaloriesPerUser[$row['user_id']] = $row['total_calories'];
    }
} else {
    echo "Error fetching total calories per user: " . $conn->error;
}




// Get the current month and year
$currentMonth = date('n');
$currentYear = date('Y');

// Get the number of days in the current month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Get the first day of the month
$firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01"));

// Initialize the weeks array
$weeks = array();

// Initialize the day counter
$dayCount = 1;

// Loop through the weeks of the month
for ($i = 0; $i < 6; $i++) {
    // Initialize the week array
    $week = array();

    // Fill in the days of the week
    for ($j = 1; $j <= 7; $j++) {
        if (($i === 0 && $j < $firstDayOfMonth) || $dayCount > $daysInMonth) {
            // Add empty string for days before the first day of the month or after the last day of the month
            $week[] = '';
        } else {
            // Add the day number
            $week[] = $dayCount++;
        }
    }

    // Add the week to the weeks array
    $weeks[] = $week;
}

// Query to fetch total protein consumed by the user
$protein_query = "SELECT SUM(protein_grams) AS total_protein FROM entries WHERE user_id = ?";
$protein_stmt = $conn->prepare($protein_query);
$protein_stmt->bind_param("s", $user_id);
$protein_stmt->execute();
$protein_result = $protein_stmt->get_result();

if ($protein_result->num_rows > 0) {
    $protein_row = $protein_result->fetch_assoc();
    $total_protein = $protein_row['total_protein'];
} else {
    $total_protein = 0;
}

  
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #3e4684;
            color: #fff;
        }
 
.navbar {
    background-color: #3e4684; /* Accent color */;
    overflow: hidden;
    text-align: right;
    padding: 30px; /* Increased height */
}

.navbar a {
    display: inline-block;
    color: #fff;
    text-align: center;
    padding: 0px ;
    padding-left: 30px; /* Increased height */
    text-decoration: none;
    font-size: 25px;
    text-shadow: 0 0 3px #1F6FFF;

}

.navbar .logo {
    float: left;
    padding: 8px 0px;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    text-shadow: 0 0 10px #1F6FFF;
}

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color:#3e4684; /* Dark container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1); /* White shadow for futuristic effect */
        }
        .container h2 {
            color: #fff;
            margin-bottom: 10px;
        }

        .container p {
            margin-bottom: 10px;
        }

        .weekdays {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-around;
            background-color: #1F6FFF;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            overflow: hidden;
        }

        .weekdays li {
            text-align: center;
            padding: 10px 0;
            flex: 1;
        }

        .days {
            padding: 15px;
            list-style-type: none;
            margin: 20px 0 0 0;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .days li {
            text-align: center;
            padding: 20px 0;
            border-radius: 18px;
            background-color: #fff;
            border: 2px solid #1F6FFF;
            color: #1F6FFF;
            font-weight: bold;
        }

        .days li span.active {
            color: #1F6FFF;
        }

        .data {
            border: 2px;
            border-radius: 12px;
            background-color: #1F6FFF;
            margin: 30px 5px;
            margin-top: 100px;
        }

        span {
            font-size: 18px;
        }
        .underweight {
    color: blue; /* Color for underweight */
}

.normal {
    color: green; /* Color for normal weight */
}

.overweight {
    color: orange; /* Color for overweight */
}

.obese {
    color: red; /* Color for obesity */
}
.content{
    justify-content: center;
    margin-left: 100px;
    font-size: 23px;
}
.proteinGoalChart{
    height: 400px;
    width: 400px;
}
    /* Container to hold the cards with a gap, border, and margin */
    .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three columns of equal width */
            gap: 20px; /* Gap between the cards */
            margin: 20px; /* Margin around the entire container */
            padding: 20px; /* Padding within the container */
            border: 2px solid #ccc; /* Border for the container */
            border-radius: 10px; /* Rounded corners for the container */
            background-color: #f5f5f5; /* Light gray background */
        }

        /* Styling for individual card */
        .card {
            background-color: white; /* Background color for the card */
            border: 1px solid #ddd; /* Border for the card */
            border-radius: 10px; /* Rounded corners for the card */
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2); /* Box shadow for a subtle 3D effect */
            text-align: center; /* Center text within the card */
            padding: 10px; /* Padding within the card */
        }

        /* Styling for the image within the card */
        .card img {
            width: 100%; /* Make the image fill the width of the card */
            height: 150px; /* Fixed height for the image */
            object-fit: cover; /* Ensures the image doesn't overflow and fills the area with proper aspect ratio */
            border-radius: 10px; /* Rounded corners for the image */
        }

        /* Styling for the card content */
        .card h1 {
            font-size: 1.5em; /* Larger font size for the title */
            margin: 10px 0; /* Margin around the title */
        }

        .card .price {
            color: green; /* Color for the price text */
            font-size: 1.2em; /* Larger font size for the price */
        }

        .card button {
            border: none; /* No border on the button */
            padding: 10px; /* Padding within the button */
            background-color: #4CAF50; /* Green background for the button */
            color: white; /* White text on the button */
            text-align: center; /* Center the text */
            font-size: 1em; /* Font size for the button */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Change cursor to indicate it's clickable */
        }

        .card button:hover {
            background-color: #45a049; /* Darken button on hover */
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

<!-- <div class="container">
    <h2><?php echo $name; ?></h2>
    <p><strong>BMI:</strong> <?php echo $bmi; ?></p>
    <p><strong>Username</strong> <?php echo $user_id; ?></p>

            <?php foreach ($totalCaloriesPerUser as $userId => $totalCalories): ?>
                <p><strong>Total Calories: <?php echo $totalCalories; ?> calories</strong></p> 

            <?php endforeach; ?>
            <p><strong>Total Protein Consumed:</strong> <?php echo $total_protein; ?> grams</p>


    <p><?php echo $ideal_weight_message; ?></p>
</div> -->
<!-- <div class="data">
    <ul class="weekdays">
        <li>Mo</li>
        <li>Tu</li>
        <li>We</li>
        <li>Th</li>
        <li>Fr</li>
        <li>Sa</li>
        <li>Su</li>
    </ul>

    <ul class="days">
        <?php foreach ($weeks as $week): ?>
            <?php foreach ($week as $day): ?>
                <li><?php echo ($day != '') ? '<span>' . $day . '</span>' : ''; ?></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</div> -->
<div class="content">
<p><strong>BMI:</strong> <span class="<?php echo $bmi_category; ?>"><?php echo $bmi; ?></span></p>
<p>You are in the <span class="<?php echo $bmi_category; ?>"><?php echo ucfirst($bmi_category); ?></span> category.</p>

<p>Protein Goal :  <?php echo $protein_intake; ?></p>
</div>
<canvas id="proteinGoalChart" width="200" height="200"></canvas>


<div class="card-container">
    <div class="card">
        <img src="https://imgs.search.brave.com/hNtL4jv1vyrukPTBAEKduhp1PNnm40OhPV29C8QW4g8/rs:fit:500:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMuc3F1YXJlc3Bh/Y2UtY2RuLmNvbS9j/b250ZW50L3YxLzU5/NDQyZDZiMzZlNWQz/MzdiZTVkYTExYy8x/NjAyMjAwMjg4NTMw/LVRJSFdZRDhYMlg4/NFJMUDNURUlGL01h/a2VfYWhlYWRfZGlu/bmVyX2tpdC5qcGc" alt="Denim Jeans">
        <h1>Tailored Jeans</h1>
        <p class="price">$19.99</p>
        <p>Some text about the jeans..</p>
        <p><button>Add to Cart</button></p>
    </div>

    <div class="card">
        <img src="https://imgs.search.brave.com/83BL7L2f5NPpY935K8M0TyUCcV-hkl_MqK9fWW8yzAI/rs:fit:500:0:0/g:ce/aHR0cHM6Ly9hc3Nl/dHMuZXBpY3VyaW91/cy5jb20vcGhvdG9z/LzYzMGFhZWQxZWJi/MWM5YmZhMDRmYjgw/NC9tYXN0ZXIvd18x/NjAwLGNfbGltaXQv/TWV0aG9kb2xvZ3kr/c2hvb3QrMDEtMDct/MjAyMS02MSsxLmpw/Zw" alt="Denim Jeans">
        <h1>Classic Jeans</h1>
        <p class="price">$29.99</p>
        <p>Some more text about the jeans..</p>
        <p><button>Add to Cart</button></p>
    </div>

    <div class="card">
        <img src="https://imgs.search.brave.com/BwpI4LNI0XKSTYPLgtn4105smVQggdvk6ysAZv31VXo/rs:fit:500:0:0/g:ce/aHR0cHM6Ly9hc3Nl/dHMuZXBpY3VyaW91/cy5jb20vcGhvdG9z/LzU5OWM0ZDFmYzdi/MzhjN2MxNzU3ZTVm/MC9tYXN0ZXIvd18x/NjAwLGNfbGltaXQv/ZGlubmVybHkuanBn" alt="Denim Jeans">
        <h1>Trendy Jeans</h1>
        <p class="price">$39.99</p>
        <p>Even more text about the jeans..</p>
        <p><button>Add to Cart</button></p>
    </div>
</div>
<!-- hi i am prasanga -->
<script>
        // Data for the protein goal
        const proteinGoal = <?php echo $protein_intake;?>; // Set your total protein goal
        const currentProtein = 10; // Current protein intake
        const remainingProtein = proteinGoal - currentProtein;

        // Calculate the percentage completed
        const percentageCompleted = (currentProtein / proteinGoal) * 100;

        // Create a pie chart
        const ctx = document.getElementById('proteinGoalChart').getContext('2d');
        const proteinGoalChart = new Chart(ctx, {
            type: 'pie', // Pie chart type
            data: {
                labels: ['Completed', 'Remaining'], // Labels for the pie chart
                datasets: [{
                    data: [currentProtein, remainingProtein], // Data for the pie chart
                    backgroundColor: ['#4CAF50', '#FF5722'], // Colors for the segments
                    hoverBackgroundColor: ['#66BB6A', '#FF7043'] // Hover colors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // Position of the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw;
                                const total = context.chart._metasets[context.datasetIndex].total;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${label}: ${value} grams (${percentage}%)`;
                            },
                        },
                    },
                },
            },
        });
    </script>
</body>
</html>
