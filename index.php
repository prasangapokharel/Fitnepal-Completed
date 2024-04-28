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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>calories</title>
    <style type="text/css">
		
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1F6FFF;
            color: #fff;
        }
 
.navbar {
    background-color: #1F6FFF;
    overflow: hidden;
    text-align: right;
    padding: 30px; /* Increased height */
}

.navbar a {
    display: inline-block;
    color: #fff;
    text-align: center;
    padding: 14px ;
    padding-left: 50px; /* Increased height */
    text-decoration: none;
    font-size: 19px;
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


		main {
			margin: 2rem auto;
			width: 60%;
		}

		main article {
			padding: 0 0 1rem 0;
			margin: 0 0 3rem 0;
		}

		h2 {
			margin: 0 0 0.5rem 0;
			color: #fff;
		}

		table {
			width: 100%;
            color:  #fff;
		}

		td,
		th {
			vertical-align: top;
			border-bottom: 1px solid #eee;
			padding: 10px 3px;
            color: #fff;
		}

		tr th:first-of-type,
		tr td:first-of-type {
			padding-left: 0;
		}

		tr:hover td {
			background-color:#1F6FFF;;
			color: black;
		}

		td:last-of-type {
			padding-right: 0;
		}

		tr:last-of-type td {
			border: 0;
			border-top: 2px solid #aaa;
			font-weight: bold;
			color: #fff;
		}

		.tr {
			text-align: right;
			padding-right: 0;
		}

		th {
			font-size: large;
		}


		form {
			margin: 0 0 2rem 0;
			padding: 0 0 1rem 0;
			border-bottom: 2px solid #eee;
			text-align: center;
		}

		input[type=text],
		input[type=date] {
			padding: 5px 7px 4px 10px;
			border: 1px solid #ccc;
			border-radius: 3px 3px;
			height: 30px;
			width: 20%;

		}
        input::placeholder{
            color: #1F6FFF;
        }

		input[type=text]:focus,
		input[type=date]:focus {
			background-color: lightyellow;
			border: 1px solid #aaa;
		}

		input[type=submit] {
			height: 30px;
			padding: 5px 20px;
			border-radius: 3px 3px;
			cursor: pointer;
			color: #222;
		}

		input[type=submit]:hover {
			color: #fff;
			background-color: #333;
		}

		small,
		small * {
			font-size: x-small;
            color: #1F6FFF;
		}

		@media only screen and (max-width: 700px) {
			main {
				width: auto;
				margin: 1rem 10%;
			}
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
    <main>
        <form action="post.php" method="post">
            <input type="text" placeholder="#" style="width:9%" name="amt" />
            <input type="text" placeholder="Description" name="description" />
            <input type="text" placeholder="Calories per serving" name="calories" />
            <input type="date" name="date" id="datetime" value="<?php echo date('Y-m-d'); ?>" />
            <input type="submit" value="+ Add">
            <br />
            <small>Ex.: Entering <i>3</i>, <i>Beer</i>, and <i>400</i> will result in an entry of 3 beers &agrave; 400
                calories, and a calculated total of 1,200 calories for that entry.<br />
                Find items on <a href="http://www.calorieking.com/foods/" target="_blank">CalorieKing</a> if the
                calories aren&rsquo;t listed on the packaging.</small>
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