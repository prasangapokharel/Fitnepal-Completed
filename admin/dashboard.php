<?php
include 'session.php'; // Include the session check
include 'db_connection.php';

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'] ?? null;

// Default profile picture if none is set
$default_profile_picture = 'profilepic/49d8e82040dfc158d398c2dbefbf11a2.jpg'; // Use a default image if none is found

$profile_picture = $default_profile_picture; // Set default as fallback

if ($user_id) {
    // Fetch the user's profile picture from the database
    $sql = "SELECT profile_picture FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['profile_picture']) {
        $profile_picture = $user['profile_picture']; // Use the user's profile picture
    }
}

// Query for the total number of users
$query_total_users = "SELECT COUNT(*) AS total_users FROM users";
$stmt_total_users = $pdo->prepare($query_total_users);
$stmt_total_users->execute();
$result_total_users = $stmt_total_users->fetch(PDO::FETCH_ASSOC);
$total_users = $result_total_users['total_users'] ?? 0;

// Query for the number of users registered today
$query_users_today = "SELECT COUNT(*) AS users_today FROM users WHERE DATE(registration_time) = CURDATE()";
$stmt_users_today = $pdo->prepare($query_users_today);
$stmt_users_today->execute();
$result_users_today = $stmt_users_today->fetch(PDO::FETCH_ASSOC);
$users_today = $result_users_today['users_today'] ?? 0;

// Query for active and inactive users
$query_active_users = "SELECT COUNT(*) AS active_users FROM users WHERE status = 'active'";
$stmt_active_users = $pdo->prepare($query_active_users);
$stmt_active_users->execute();
$result_active_users = $stmt_active_users->fetch(PDO::FETCH_ASSOC);
$active_users = $result_active_users['active_users'] ?? 0;

$query_inactive_users = "SELECT COUNT(*) AS inactive_users FROM users WHERE status = 'inactive'";
$stmt_inactive_users = $pdo->prepare($query_inactive_users);
$stmt_inactive_users->execute();
$result_inactive_users = $stmt_inactive_users->fetch(PDO::FETCH_ASSOC);
$inactive_users = $result_inactive_users['inactive_users'] ?? 0;

// Query for weekly user registrations
$query_weekly_users = "
SELECT DATE(registration_time) AS registration_date, COUNT(*) AS user_count
FROM users
WHERE DATE(registration_time) >= CURDATE() - INTERVAL 6 DAY
GROUP BY registration_date
ORDER BY registration_date;
";
$stmt_weekly_users = $pdo->prepare($query_weekly_users);
$stmt_weekly_users->execute();
$weekly_users_data = $stmt_weekly_users->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for ApexCharts
$dates = array_map(function ($data) {
    return date('Y-m-d', strtotime($data['registration_date']));
}, $weekly_users_data);

$user_counts = array_map(function ($data) {
    return $data['user_count'];
}, $weekly_users_data);

include 'navbar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Inter font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css"> <!-- ApexCharts CSS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Include ApexCharts -->
    <link rel="stylesheet" href="./cssadmin/dashboard.css"> <!-- Custom CSS -->
</head>
<body>
<!-- Profile container with image and dropdown menu -->
<div class="profile-container">
<img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Image" class="profile-image"> <!-- Use dynamic image path -->
        <!-- Dropdown menu with options -->
        <div class="dropdown-menu">
            <a href="adminprofile.php">Change Profile</a>
            <a href="change_password.php">Change Password</a>
        </div>
    </div>
    <!-- Logout button -->
    <br><button class="logout-button" onclick="logout()">Logout</button>

    <div class="container"> <!-- Navbar and content container -->

        <!-- Content area -->
        <div class="content">
            <!-- Content row with user statistics -->
            <div class="content-row">
                <!-- Total users -->
                <div class="info-box">
                    <i data-feather="users" class="icon"></i> <!-- Icon before text -->
                    <h2>Total Users</h2>
                    <p><?php echo $total_users; ?></p>
                </div>

                <!-- Users registered today -->
                <div class="info-box">
                    <i data-feather="user-plus" class="icon"></i> <!-- Icon -->
                    <h2>Registered Today</h2>
                    <p><?php echo $users_today; ?></p>
                </div>

                <!-- Active users -->
                <div class="info-box">
                    <i data-feather="activity" class="icon"></i> <!-- Icon for active users -->
                    <h2>Active Users</h2>
                    <p><?php echo $active_users; ?></p>
                </div>

                <!-- Inactive users -->
                <div class="info-box">
                    <i data-feather="user-x" class="icon"></i> <!-- Icon for inactive users -->
                    <h2>Inactive Users</h2>
                    <p><?php echo $inactive_users; ?></p>
                </div>

                
            </div>
 <!-- Bar graph for weekly user registrations -->
 <div class="bar-graph">
     <div id="userRegistrationChart"></div>
 </div>
           
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <!-- Initialize Feather Icons -->
    <script>
        feather.replace(); // Initialize icons
    </script>

    <!-- Initialize the bar graph with ApexCharts -->
    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Users Registered',
                data: <?php echo json_encode($user_counts); ?>
            }],
            xaxis: {
                categories: <?php echo json_encode($dates); ?>
            },
            colors: ['#3b82f6', '#ef4444', '#f59e0b'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#2563eb', '#dc2626', '#d97706']
            },
            legend: {
                position: 'bottom'
            }
        };

        var chart = new ApexCharts(document.querySelector("#userRegistrationChart"), options);
        chart.render();

        function logout() {
            // Navigate to the logout script
            window.location.href = "logout.php"; // Adjust path as needed
        }
    </script>
</body>
</html>
