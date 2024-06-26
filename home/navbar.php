<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitNepal - Navbar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #60A5FA, #1E3A8A);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar .nav-links a:hover {
            background-color: #1f6fff;
        }

        .hamburger-icon {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger-icon span {
            background-color: #fff;
            height: 3px;
            margin: 4px;
            width: 25px;
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .nav-links {
                flex-direction: column;
                gap: 10px;
                display: none;
                width: 100%;
                position: absolute;
                left: 0;
                top: 60px; /* Adjust this based on your header height */
                background-color: #378ce7;
                padding: 10px 0;
                border-radius: 0 0 8px 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .navbar .nav-links.active {
                display: flex;
            }

            .navbar .nav-links a {
                width: 100%;
                text-align: center;
            }

            .hamburger-icon {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <a href="http://localhost/fitnepal/home/index.php" class="logo">FitNepal</a>
        <div class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-links">
            <a href="http://localhost/fitnepal/home/bmi.php">BMI</a>
        </div>
    </header>

    <script>
        // Toggle nav links for mobile
        const navLinks = document.querySelector('.nav-links');
        const hamburgerIcon = document.querySelector('.hamburger-icon');

        hamburgerIcon.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>

</html>
