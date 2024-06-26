<?php
include 'db_connection.php'; // Include PDO connection
include 'navbar.php'; // Include the navbar

// Query to fetch all protein-related data
$sql = "
    SELECT 
        users.name AS username,
        entries.meal_name,
        entries.protein_grams,
        entries.meal_time,
        entries.user_id,
        entries.id AS entry_id
    FROM 
        entries
    INNER JOIN 
        users 
    ON 
        entries.user_id = users.id
    ORDER BY 
        entries.meal_time DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Protein Table</title>
    <link rel="stylesheet" href="./cssadmin/proteingoal.css"> <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Icons -->
</head>
<body>
    <div class="container">
        <h2>Protein Data</h2>
        <button id="deleteAllButton" class="delete-button">Delete All Entries</button> <!-- Delete all button -->
        
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Meal Name</th>
                    <th>Protein Grams</th>
                    <th>Meal Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['username']); ?></td>
                        <td><?php echo htmlspecialchars($entry['meal_name']); ?></td>
                        <td><?php echo htmlspecialchars($entry['protein_grams']); ?></td>
                        <td><?php echo htmlspecialchars($entry['meal_time']); ?></td>
                        <td><button class="details-button" data-entry-id="<?php echo $entry['entry_id']; ?>">Details</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for details -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <div id="modal-data"></div> <!-- Placeholder for modal data -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for simplicity -->
    <script>
        $(document).ready(function() {
            // Close modal when clicking on the close button
            $("#closeModal").click(function() {
                $("#detailsModal").hide();
            });

            // Show details modal when clicking the button
            $(".details-button").click(function() {
                const entryId = $(this).data("entry-id");
                
                $.ajax({
                    url: 'get_entry_details.php', // PHP file to fetch entry details
                    type: 'GET',
                    data: { entry_id: entryId },
                    success: function(data) {
                        $("#modal-data").html(data); // Populate modal with entry details
                        $("#detailsModal").show(); // Show the modal
                    },
                    error: function() {
                        alert("Error fetching details. Please try again later.");
                    }
                });
            });

            // Delete all button click event
            $("#deleteAllButton").click(function() {
                if (confirm("Are you sure you want to delete all entries?")) {
                    $.ajax({
                        url: 'deleteprotein.php', // PHP file to delete all entries
                        type: 'POST',
                        success: function() {
                            alert("All entries deleted successfully.");
                            location.reload(); // Reload the page after deletion
                        },
                        error: function() {
                            alert("Error deleting entries. Please try again.");
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
