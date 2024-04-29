<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico|Quicksand:400,600&display=swap">
    <!-- Inline Styles -->
    <style>
        body{
            background-color: #3e4684;

        }
        .container {
            background-color: #3e4684;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        svg {
            height: 23rem;
            margin-right: 4rem;
        }

        #envelope {
            animation: float 2s ease-in-out infinite;
        }

        #star1, #star2, #star3, #star4, #star5, #star6 {
            animation: blink 1s ease-in-out infinite;
        }
        
        #star2 { animation-delay: 100ms; }
        #star3 { animation-delay: 500ms; }
        #star4 { animation-delay: 700ms; }
        #star5 { animation-delay: 300ms; }
        #star6 { animation-delay: 200ms; }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @keyframes blink {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        form {
            min-width: 25rem;

            h1.title {
                font-family: 'Pacifico', cursive;
                color: #fff;
                font-size: 2.5rem;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .form-control {
                background-color: #f2f6f8;
                border-radius: 2rem;
                border: none;
                box-shadow: 0px 7px 5px rgba(0, 0, 0, 0.11);

                &.thick {
                    height: 3.3rem;
                    padding: 0.5rem 3.5rem;
                }

                &:focus {
                    background-color: #f2f6f8;
                    border: none;
                    box-shadow: 0px 7px 5px rgba(0, 0, 0, 0.11);
                }
            }

            .message {
                .form-control {
                    padding: 0.5rem 1.8rem;
                }
            }

            .icon {
                color: #3e4684;
                height: 1.3rem;
                position: absolute;
                left: 1.5rem;
                top: 1.1rem;
            }
        }

        .btn.btn-primary {
            font-family: 'Quicksand', sans-serif;
            font-weight: bold;
            height: 2.5rem;
            line-height: 2.5rem;
            padding: 0 3rem;
            border: 0;
            border-radius: 3rem;
            background-image: linear-gradient(131deg, #ffd340, #ff923c, #ff923c, #ff923c);
            background-size: 300% 100%;
            transition: all 0.3s ease-in-out;
        }

        .btn.btn-primary:hover:enabled {
            box-shadow: 0 0.5em 0.5em -0.4em #3e4684;
            
            background-size: 100% 100%;
            transform: translateY(-0.15em);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center">
    <!-- SVG Graphics -->
    <!-- (Your SVG content here; I've omitted it for brevity) -->

    <!-- Contact Form with POST action to a new PHP script -->
    <form action="subcontact.php" method="post">
        <h1 class="title">Talk to Us</h1>
        <div class="form-group position-relative">
            <label for="formName" class="d-block">
                <i class="icon" data-feather="user"></i>
            </label>
            <input type="text" id="formName" name="name" class="form-control form-control-lg thick" placeholder="Name" required>
        </div>
        <div class="form-group position-relative">
            <label for="formEmail" class="d-block">
                <i class="icon" data-feather="mail"></i>
            </label>
            <input type="email" id="formEmail" name="email" class="form-control form-control-lg thick" placeholder="E-mail" required>
        </div>
        <div class="form-group message">
            <textarea id="formMessage" name="message" class="form-control form-control-lg" rows="7" placeholder="Message" required></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</div>

<!-- Feather Icons Initialization -->
<script>
    feather.replace();
</script>

<!-- Bootstrap JS and Dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
