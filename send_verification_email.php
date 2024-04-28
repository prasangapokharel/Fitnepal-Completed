<?php
// Include the PHPMailer library for sending emails
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Connect to the database
// This code should establish a connection to your database

// Code to retrieve user's email from the database
// This should be done based on the user data submitted during registration

// Generate random verification code
$verificationCode = mt_rand(1000, 9999);

// Store the verification code in the database
// This should be done in your database insertion code

// Send verification email
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'localhost';
$mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false;
$mail->Port = 25;
$mail->setFrom('fitnepal@example.com', 'FitNepal');
$mail->addAddress($_POST['email'], $_POST['name']); // Change $_POST['email'] and $_POST['name'] with appropriate variables containing user's email and name
$mail->isHTML(true);
$mail->Subject = 'Email Verification';
$mail->Body = 'Your verification code is: ' . $verificationCode;
if ($mail->send()) {
    echo 'Verification email sent!';
} else {
    echo 'Error: Unable to send verification email.';
}

// Close database connection (if opened)

// Redirect the user to the verification page or display a success message
?>
