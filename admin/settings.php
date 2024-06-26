<?php
include 'session.php'; // Include the session check

include 'db_connection.php';

// Ensure the assets folder exists
$upload_dir = 'C:/xampp/htdocs/fitnepal/home/assets/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create the directory with appropriate permissions
}

$site_title = ''; // Initialize site title
$header_image = ''; // Initialize header image
$site_logo = ''; // Initialize site logo

// Retrieve site settings
$query = "SELECT * FROM sitesettings WHERE id = 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$site_settings = $stmt->fetch(PDO::FETCH_ASSOC);

if ($site_settings) {
    $site_title = $site_settings['site_title'];
    $header_image = $site_settings['header_image'];
    $site_logo = $site_settings['site_logo'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update site title
    $site_title = $_POST['site_title'];

    // Handle header image upload
    if (!empty($_FILES['header_image']['name'])) {
        $header_image_name = basename($_FILES['header_image']['name']); // Get the file name
        $header_image_path = $upload_dir . $header_image_name; // Full path

        if (move_uploaded_file($_FILES['header_image']['tmp_name'], $header_image_path)) {
            $header_image = $header_image_path; // Update the variable with the new path
        }
    }

    // Handle site logo upload
    if (!empty($_FILES['site_logo']['name'])) {
        $site_logo_name = basename($_FILES['site_logo']['name']); // Get the file name
        $site_logo_path = $upload_dir . $site_logo_name; // Full path

        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $site_logo_path)) {
            $site_logo = $site_logo_path; // Update the variable with the new path
        }
    }

    // Update database with new site settings
    $update_query = "UPDATE sitesettings SET site_title = ?, header_image = ?, site_logo = ? WHERE id = 1";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$site_title, $header_image, $site_logo]);

    // Redirect to avoid form resubmission
    header("Location: settings.php");
    exit;
}
?>

<?php include 'navbar.php'; // Include the navbar ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Settings</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"> <!-- Inter font -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./cssadmin/settings.css"> <!-- Custom CSS -->
</head>
<body>
    
        <form action="settings.php" method="post" enctype="multipart/form-data"> <!-- Ensure form is multi-part for file uploads -->
            <fieldset>

                <div class="form-group">
                    <label for="site_title">Site Title</label>
                    <input type="text" name="site_title" id="site_title" value="<?php echo htmlspecialchars($site_title); ?>" required>
                </div>

                <div class="form-group">
                    <label for="header_image">Header Image</label>
                    <input type="file" name="header_image" id="header_image"> <!-- File input for new image -->
                    <p>Current: <img src="<?php echo htmlspecialchars($header_image); ?>" alt="Header Image" width="50"></p> <!-- Show current image -->
                </div>

                <div class="form-group">
                    <label for="site_logo">Site Logo</label>
                    <input type="file" name="site_logo" id="site_logo"> <!-- File input for new logo -->
                    <p>Current: <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="Site Logo" width="50"></p> <!-- Show current logo -->
                </div>

                <button type="submit">Update Settings</button>
            </fieldset>
        </form>
</body>
</html>
