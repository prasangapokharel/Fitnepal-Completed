<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Workout Videos</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
<style>
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
        padding: 30px;
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
        background-color: #1F6FFF;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
    }

    .workout-category {
        margin-bottom: 30px;
    }

    .workout-category h2 {
        border-bottom: 2px solid #fff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .workout-video {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .video-player {
        flex: 1;
    }

    .timer {
        font-size: 24px;
        font-weight: bold;
    }
</style>
</head>
<body>

<div class="navbar">
    <a href="dashboard.php" class="logo">Fitness Tracker</a>
    <a href="profile.php">Profile</a>
    <a href="goal.php">Goals</a>
    <a href="diet.php">Diet</a>
    <a href="index.php">Workout</a>
    <a href="video.php">Video</a>

    <a href="?logout=true">Logout</a> <!-- Added logout link -->
</div>


<div class="container">
    <div class="workout-category">
        <h2>Stretch & Strength</h2>
        <div class="workout-video">
            <div class="video-player">
                <iframe width="560" height="315" src="https://youtu.be/7h_Pn7NyJ0k" frameborder="5" allowfullscreen></iframe>
            </div>
            <div class="timer">00:00:00</div>
        </div>
    </div>

    <div class="workout-category">
        <h2>Bull Body Burn</h2>
        <div class="workout-video">
            <div class="video-player">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/video2" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="timer">00:00:00</div>
        </div>
    </div>

    <div class="workout-category">
        <h2>Dumbbell</h2>
        <div class="workout-video">
            <div class="video-player">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/video3" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="timer">00:00:00</div>
        </div>
    </div>
</div>

</body>
</html>
