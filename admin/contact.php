<!-- contact.php -->
<?php
include 'db_connection.php';

// Query to fetch all contact messages
$query_contactus = "SELECT * FROM contactus ORDER BY id DESC"; 
$stmt_contactus = $pdo->prepare($query_contactus);
$stmt_contactus->execute();
$contact_messages = $stmt_contactus->fetchAll(PDO::FETCH_ASSOC);

include 'navbar.php'; // Include the navbar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Inter font -->
    <link rel="stylesheet" href="./cssadmin/contact.css"> <!-- Custom CSS -->

    <script>
 function markAsCompleted(messageId) {
    console.log(`Sending request to mark message ${messageId} as completed.`); // Log the request

    fetch(`mark_as_completed.php?id=${messageId}`, {
        method: 'GET', // Make a GET request with the message ID
    })
    .then(response => {
        if (response.ok) { // If the response is OK
            return response.json(); // Parse the JSON response
        } else {
            throw new Error("Failed to update status"); // Throw an error if not OK
        }
    })
    .then(data => {
        if (data.success) { // If success in the JSON response
            const statusElement = document.getElementById(`status-${messageId}`);
            statusElement.textContent = 'Completed'; // Change text to 'Completed'
            statusElement.style.color = 'green'; // Set text color to green

            // Hide the "Mark as Completed" button
            const buttonElement = document.getElementById(`button-${messageId}`);
            if (buttonElement) {
                buttonElement.style.display = 'none'; // Hide the button after marking as completed
            }
        } else {
            alert(data.message || "Error marking as completed"); // Alert with the error message
        }
    })
    .catch(error => { // Catch any errors
        console.error("Error:", error); // Log the error for debugging
        alert("An unexpected error occurred. Please try again."); // Alert the user about the error
    });
}

    </script>
</head>
<body>
    <div class="main-container"> <!-- Overall container -->
        <div class="container"> <!-- Flexbox layout -->
            <div class="content"> <!-- Content area -->
                <h1>Contact Us Management</h1>
                <table> <!-- Display contact messages in a table -->
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through contact messages and display them -->
                        <?php foreach ($contact_messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['id']); ?></td>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['subject'] ?? 'N/A'); ?></td> <!-- Subject might be optional -->
                                <td><?php echo htmlspecialchars($message['message']); ?></td>
                                <td id="status-<?php echo htmlspecialchars($message['id']); ?>">
                                    <?php
                                    if (isset($message['viewed']) && $message['viewed']) {
                                        echo '<span style="color: green;">Completed</span>'; // Green for 'Completed'
                                    } else {
                                        echo 'Pending'; // 'Pending' status
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!isset($message['viewed']) || !$message['viewed']): ?>
                                        <button
                                            class="action-button pending-button"
                                            id="button-<?php echo htmlspecialchars($message['id']); ?>"
                                            onclick="markAsCompleted(<?php echo htmlspecialchars($message['id']); ?>)"
                                        >
                                            Mark as Completed
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
