<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
background-color: #3e4684;
            color: #333; /* Dark text */
        }

        .container {
            max-width: 400px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
            display: none;
        }

        fieldset.show {
            display: block;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrapper .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px; /* Smaller icon size */
            color: #888;
        }

        .input-wrapper .icon-left {
            left: 10px; /* Adjusted for consistent spacing */
        }

        .input-wrapper .icon-right {
            right: 10px;
            cursor: pointer;
        }

        input {
            width: 100%;
            padding: 12px 10px 12px 36px; /* Adjusted for icon spacing */
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
            color: #333;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        input:focus {
            outline: none;
            border-color: #1F6FFF;
            box-shadow: 0 0 8px rgba(31, 111, 255, 0.3);
        }

        input[type="submit"] {
            background-color: #3e4684;
            color: #fff;
            margin-top: 10px;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0D6BFF;
            box-shadow: 0 0 8px rgba(13, 107, 255, 0.3);
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

        h2 {
            text-align: center;
            color: #3e4684;
            font-size: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form id="signupForm" action="register.php" method="post">
            <fieldset id="firstPart" class="show">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <div class="input-wrapper">
                    <i class="fa fa-envelope icon icon-left" style="color: #3e4684"></i>
                    <input type="email" id="email" name="email" required>
                </div>

                <label for="password">Password:</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock icon icon-left" style="color: #3e4684"></i>
                    <input type="password" id="password" name="password" required>
                    <i class="fa fa-eye icon icon-right" onclick="togglePasswordVisibility()"></i>
                </div>

                <input type="button" value="Next" onclick="showSecondPart()">
            </fieldset>

            <fieldset id="secondPart">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>

                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" step="0.01" required>

                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" required>

                <label for="activity">Weekly Activity Level:</label>
                <select id="activity" name="activity" required>
                    <option value="normal">Normal</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="highly active">Highly Active</option>
                </select>
            </fieldset>

            <input type="submit" value="Register">
        </form>

        <p class="register-link">Already have an account? <a href="login.php">Login Now</a></p>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.querySelector(".input-wrapper .fa-eye");
            const isPasswordHidden = passwordField.type === "password";

            if (isPasswordHidden) {
                passwordField.type = "text";
                eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        function showSecondPart() {
            document.getElementById('firstPart').classList.remove('show');
            document.getElementById('secondPart').classList.add('show');
        }
    </script>
</body>
</html>
