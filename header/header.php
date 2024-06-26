<?php
require_once './db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the user is verified
$user_id = $_SESSION['user_id'];

$sql = "SELECT status FROM bankpayment WHERE user_id = '$user_id' AND status = 'verified'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$verified = ($result->num_rows > 0);

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Destroy the session
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitNepal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
   
    <style>
     
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #1E3A8A;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            text-decoration: none;
            font-size: 24px;
            color: #fff;
            font-weight: 700;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            cursor: pointer;
        }

        .menu-toggle span {
            width: 100%;
            height: 2px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #60A5FA;
        }

        .nav-links.active {
            display: flex;
            flex-direction: column;
            background-color: #1E3A8A;
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .nav-links.active a {
            color: #fff;
        }

        @media screen and (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                gap: 10px;
                width: 100%;
                position: absolute;
                top: 60px;
                left: 0;
                background-color: #1E3A8A;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .nav-links a {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <a href="dashboard.php" class="logo">FitNepal</a>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="nav-links">
            
            <?php if ($verified): ?>
                <a href="goal.php">Protein Tracker</a>
                <a href="workout.php">Calorie Tracker</a>
                <a href="nutrition.php">Nutrition</a>
            <?php endif; ?>
            
            <a href="diet.php">Diet</a>
            <a href="profile.php"><i class="bi bi-person-circle"></i></a>
            <a href="?logout=true"><i class="bi bi-box-arrow-right"></i></a>
        </nav>
    </header>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>

</html>
