<?php
// Include database connection
include 'db_connection.php';

// Start the session to handle feedback messages
session_start();

// Check for feedback messages from subcontact.php
$feedback_message = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : null;

// Clear feedback message after use
unset($_SESSION['feedback']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4"> <!-- Added margin-top -->
        <!-- Display feedback message if set -->
        <?php if ($feedback_message): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($feedback_message); ?>
            </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <h2>Contact Us</h2>
        <form action="subcontact.php" method="post">
            <div class="form-group">
                <label for="formName">Name</label>
                <input type="text" id="formName" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="formEmail">E-mail</label>
                <input type="email" id="formEmail" name="email" class="form-control" placeholder="E-mail" required>
            </div>
            <div class="form-group">
                <label for="formSubject">Subject</label>
                <input type="text" id="formSubject" name="subject" class="form-control" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <label for="formMessage">Message</label>
                <textarea id="formMessage" name="message" class="form-control" rows="5" placeholder="Your message" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
