<?php
include 'session.php';
include 'db_connection.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Function to update protein goals
function updateProteinGoals($conn, $user_id) {
    // Calculate the recommended protein intake
    $protein_per_kg = 0.8;

    $sql = "SELECT weight, normal_protein, muscle_protein FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $weight = $row["weight"];
        $normal_protein = $row["normal_protein"];
        $muscle_protein = $row["muscle_protein"];

        // Calculate the recommended protein intake
        $protein_intake = $weight * $protein_per_kg;
        $protein_intakemuscle = $weight * 2;

        // Update normal protein and muscle protein in the database if they differ from the calculated values
        if ($normal_protein != $protein_intake || $muscle_protein != $protein_intakemuscle) {
            $update_sql = "UPDATE users SET normal_protein = ?, muscle_protein = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("dds", $protein_intake, $protein_intakemuscle, $user_id);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                echo "Protein goals updated successfully.";
            } else {
                echo "Failed to update protein goals.";
            }
        }
    } else {
        echo "User not found.";
    }

    return [$protein_intake, $protein_intakemuscle];
}

// Call the function to update protein goals and get updated values
list($protein_intake, $protein_intakemuscle) = updateProteinGoals($conn, $user_id);

// Query to fetch user's height, weight, age, name, and muscle protein
$sql = "SELECT height, weight, age, name, LPAD(user_id, 5, '0') as user_id, muscle_protein, normal_protein FROM users WHERE id = ?";
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
    $user_id = $row["user_id"];
    $muscle_protein = $row["muscle_protein"];
    $normal_protein = $row["normal_protein"];

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
    $week = array();

    for ($j = 1; $j <= 7; $j++) {
        if (($i === 0 && $j < $firstDayOfMonth) || $dayCount > $daysInMonth) {
            $week[] = '';
        } else {
            $week[] = $dayCount++;
        }
    }

    $weeks[] = $week;
}

// Query to fetch total protein intake for the user
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

?>

<?php
include 'header/header.php';
?>

<?php
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <p><strong>BMI :</strong> <span class="<?php echo htmlspecialchars($bmi_category); ?>"><?php echo htmlspecialchars($bmi); ?></span></p>
            <p>You are in the <span class="<?php echo htmlspecialchars($bmi_category); ?>"><?php echo htmlspecialchars(ucfirst($bmi_category)); ?></span> category.</p>
            <p>Normal Protein Goal: <?php echo isset($protein_intake) ? htmlspecialchars($protein_intake) : "N/A"; ?> grams</p>
            <p>Muscle Protein Goal: <?php echo isset($protein_intakemuscle) ? htmlspecialchars($protein_intakemuscle) : "N/A"; ?> grams</p>
        </div>

        <div id="chart">
            <canvas id="proteinGoalChart"></canvas>
        </div>
    </div>

    <div class="part2">
        <button class="styled-button"><a href="goal.php">Start Tracking</a></button>
    </div>

    <div class="video">
        <h2>Video Demonstration</h2>
    </div>
    <div class="container2">
        <div class="card">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/9o0UPuDBM8M?si=EAOOICuhg_9SpJQ2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Full Body Workout for Men and Women</h3>
            <p>This is the first video card with embedded YouTube content.</p>
        </div>
        <div class="card">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/YnUmJkicK3c?si=TyRb76qcRCc7YiuQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Best Exercises To Reduce Belly Fat</h3>
            <p>This is the second video card with embedded YouTube content.</p>
        </div>
        <div class="card">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/-hSERcBUsGY?si=nPAJz2LDFO5xORhp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>HOW TO DO THE 16-8 INTERMITTENT FASTING DIET | Weight loss, blood sugar control</h3>
            <p>This is the third video card with embedded YouTube content.</p>
        </div>
    </div>
    
    <div class="upgrade-container">
        <h1>Upgrade to Premium</h1>
        <p>Experience premium features and unlock exclusive content.</p>
        <button class="upgrade-button" onclick="window.location.href='../Fitnepal/Payment/paynow.php'">Upgrade Now</button>
    </div>

    <script>
        // Debug: Output PHP variables to console
        console.log('Protein Intake:', <?php echo isset($protein_intake) ? htmlspecialchars($protein_intake) : 'null'; ?>);
        console.log('Total Protein:', <?php echo isset($total_protein) ? htmlspecialchars($total_protein) : 'null'; ?>);

        // Data for the protein goal
        const proteinGoal = <?php echo isset($protein_intake) ? htmlspecialchars($protein_intake) : '0'; ?>;
        const currentProtein = <?php echo isset($total_protein) ? htmlspecialchars($total_protein) : '0'; ?>;
        const remainingProtein = proteinGoal - currentProtein;

        if (proteinGoal > 0 && currentProtein >= 0) {
            // Chart.js pie chart configuration
            const ctx = document.getElementById('proteinGoalChart').getContext('2d');
            const proteinGoalChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [currentProtein, remainingProtein],
                        backgroundColor: ['white', '#60A5FA'],
                        hoverBackgroundColor: ['white', '#60A5FA']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' grams';
                                }
                            }
                        }
                    }
                }
            });

            // Check if current protein intake is greater than or equal to the normal protein goal
            if (currentProtein >= proteinGoal) {
                const ctx2 = document.createElement('canvas');
                ctx2.setAttribute('id', 'normalProteinGoalChart');
                document.getElementById('chart').appendChild(ctx2);

                const normalProteinGoalChart = new Chart(ctx2.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Normal Protein Goal Achieved', 'Remaining Protein'],
                        datasets: [{
                            data: [proteinGoal, 0],
                            backgroundColor: ['#2196f3', '#f44336'],
                            hoverBackgroundColor: ['#64b5f6', '#ef5350']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' grams';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } else {
            console.error('Invalid data for protein goals.');
        }
    </script>
</body>

</html>
