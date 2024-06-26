<?php
include 'session.php'; // Include the session check

include 'db_connection.php';

// Handle form submission for user update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update the user in the database
    $query_update = "UPDATE users SET name = :name, email = :email WHERE user_id = :user_id";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->execute([
        ':name' => $name,
        ':email' => $email,
        ':user_id' => $user_id,
    ]);
}

// Query to fetch all users
$query_users = "SELECT user_id, name, email, registration_time FROM users ORDER BY user_id DESC";
$stmt_users = $pdo->prepare($query_users);
$stmt_users->execute();
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

function daysAgo($registration_time) {
    $current_time = time(); // Current timestamp
    $registration_timestamp = strtotime($registration_time); // Convert registration time to timestamp
    $days = ($current_time - $registration_timestamp) / (60 * 60 * 24); // Calculate days
    return round($days);
}


include 'navbar.php'; // Include the navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Inter font -->
    <link rel="stylesheet" href="./cssadmin/user.css"> <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Font Awesome -->


    <script>
        // Function to open the registration modal
        function openRegisterModal() {
            var modal = document.getElementById("userRegistrationModal");
            modal.style.display = "block"; // Show the modal
        }

        // Function to close the registration modal
        function closeRegisterModal() {
            var modal = document.getElementById("userRegistrationModal");
            modal.style.display = "none"; // Hide the modal
        }

        // Function to open the edit modal
        function openEditModal(userId, name, email) {
            var modal = document.getElementById("editModal");
            modal.style.display = "flex"; // Display the modal

            // Set the user ID and other details in the form
            document.getElementById("user_id").value = userId;
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
        }

        // Function to close the edit modal
        function closeEditModal() {
            var modal = document.getElementById("editModal");
            modal.style.display = "none"; // Hide the modal
        }

        // Close the modal when clicking outside the content
        window.onclick = function(event) {
            var modal = document.getElementById("userRegistrationModal");
            if (event.target === modal) {
                modal.style.display = "none"; // Hide the modal when clicked outside
            }

            modal = document.getElementById("editModal");
            if (event.target === modal) {
                modal.style.display = "none"; // Hide the modal when clicked outside
            }
        };
    </script>
</head>
<body>
    <div class="main-container">
        <div class="container"> <!-- Flexbox layout -->
            <div class="content">
                <h1>User Management</h1>
                <button class="usr" id="openRegisterModal" onclick="openRegisterModal()">Create User</button>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through users and display them -->
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo daysAgo($user['registration_time']) . ' days ago'; ?></td>
                                <td>
                                    <!-- Edit button triggers modal -->
                                    <button class="action-button edit-button" onclick="openEditModal(<?php echo $user['user_id']; ?>, '<?php echo htmlspecialchars($user['name']); ?>', '<?php echo htmlspecialchars($user['email']); ?>')">Edit</button>
                                    <a class="action-button delete-button" href="userdelete.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>">Delete</a> <!-- Link to userdelete.php -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Add the Export to CSV button with Excel icon -->
                <div class="export-button-container" style="text-align: right;">
                    <a href="export_users.php" class="csv">
                        <i class="fas fa-file-excel"></i> Export to CSV
                    </a>
                </div>
            </div>

            <!-- Modal for registering a new user -->
            <div id="userRegistrationModal" class="modal">
                <div class="modal-content">
                    <span class="close-button" onclick="closeRegisterModal()">&times;</span> <!-- Close button -->
                    <h2>Register a New User</h2>
                    <!-- Registration form -->
                    <form id="registrationForm" action="register.php" method="post">
                        <div class="input-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" required>
                        </div>
                        <div class="input-group">
                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" required>
                        </div>
                        <div class="input-group">
                            <label for="weight">Weight (kg):</label>
                            <input type="number" id="weight" name="weight" step="0.01" required>
                        </div>
                        <div class="input-group">
                            <label for="height">Height (cm):</label>
                            <input type="number" id="height" required>
                        </div>
                        <div class="input-group">
                            <label for="activity">Weekly Activity Level:</label>
                            <select id="activity" name="activity" required>
                                <option value="normal">Normal</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="highly active">Highly Active</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <button type="submit">Register</button>
                    </form>
                </div>
            </div>

            <!-- Modal for editing user details -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close-button" onclick="closeEditModal()">&times;</span> <!-- Close button -->
                    <h2>Edit User</h2>
                    <form action="user.php" method="post">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <div class="input-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <button type="submit">Update</button>
                        <button type="button" class="close-button" onclick="closeEditModal()">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
