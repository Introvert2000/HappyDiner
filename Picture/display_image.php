<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test';

// Create a connection to the MySQL database
$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the image data from the database
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT filename, filepath FROM images WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->bind_result($filename, $filePath);
        $stmt->fetch();
        
        if (file_exists($filePath)) {
            // Set the appropriate Content-Type header based on the file type
            $fileType = exif_imagetype($filePath);
            if ($fileType === IMAGETYPE_JPEG) {
                header('Content-Type: image/jpeg');
            } elseif ($fileType === IMAGETYPE_PNG) {
                header('Content-Type: image/png');
            }

            // Output the image data
            readfile($filePath);
        } else {
            echo "Image file not found.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Display</title>
</head>
<body>
    <h1>Display Image</h1>
    <?php
    // Replace '1' with the actual image ID you want to display
    $imageId = 1;
    echo "<img src='display_image.php?id=$imageId' alt='Image'>";
    ?>
</body>
</html>
