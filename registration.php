<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/registration.css">
</head>
<?php
include 'home/navbar.php';
?>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form id="signupForm" action="register.php" method="post">
            <fieldset id="firstPart" class="show">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <div class="input-wrapper">
                    <i class="fa fa-envelope icon icon-left"></i>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <label for="password">Password:</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock icon icon-left"></i>
                    <input type="password" id="password" name="password" placeholder="Password" required>
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

                <input type="submit" value="Register">
            </fieldset>
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
