<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #3e4684; /* Accent color */
            color: #333; /* Dark text */
        }

        .container {
            max-width: 400px;
            margin: 90px auto;
            background-color: white; /* White container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Shadow for premium effect */
        }

        h2 {
            text-align: center;
            color: #3e4684; /* Accent color */
            font-size: 30px;
            margin-bottom: 30px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrapper .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 10px;
            color: #888;
            font-size: 14px; /* Smaller icon size */
        }

        input {
            width: 100%;
            padding: 12px 10px 12px 36px; /* Adjust padding for icons */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9; /* Light background for input fields */
            color: #333; /* Dark text */
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        input:focus {
            outline: none;
            border-color: #1F6FFF;
            box-shadow: 0 0 8px rgba(31, 111, 255, 0.3);
        }

        .log {
            background-color: #3e4684; 
            color: #fff; 
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .log:hover {
            background-color: #0D6BFF; /* Darker accent color on hover */
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #3e4684; 
        }

        .register-link a {
            color: #3e4684; 
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: auto;
            border: 3px;
            border-radius: 100%;
        }
   
        /* .background-video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the video covers the whole area */
        } */
    </style>
</head>
<body>

    <div class="container">
        <!-- Login form section -->
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <div class="input-wrapper">
                <i class="fa fa-envelope icon" style="color: #3e4684"></i>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-wrapper">
                <i class="fa fa-lock icon" style="color: #3e4684"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <input class="log" type="submit" value="Login">
        </form>

        <div class="register-link">
            Don't have an account? <a href="registration.php">Register Now</a>
        </div>
    </div>
</body>
</html>
