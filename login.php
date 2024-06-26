<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./CSS/login.css">
</head>
<?php
include 'home/navbar.php';
?>
<body>

    <div class="container">
        <!-- Login form section -->
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <div class="input-wrapper">
                <i class="fa fa-envelope icon"></i>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-wrapper">
                <i class="fa fa-lock icon"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="see">
                    <i class="fa fa-eye icon-right" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <input class="log" type="submit" value="Login">
        </form>

        <div class="register-link">
            Don't have an account? <a href="registration.php">Register Now</a>
        </div>
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
    </script>
</body>

</html>
