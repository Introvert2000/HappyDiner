<!DOCTYPE html>
<html>
<head>
    <title>Image and Item Upload</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="image">Select Image:</label>
        <input type="file" name="image" required>
        <br>

        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <br>

        <label for="item_price">Item Price:</label>
        <input type="text" name="item_price" required>
        <br>

        <input type="submit" value="Upload">
    </form>
</body>
</html>
<?php
session_start();
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

// Check if a file has been uploaded
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Check if the file is an image
    $fileType = exif_imagetype($file['tmp_name']);
    if ($fileType === IMAGETYPE_JPEG || $fileType === IMAGETYPE_PNG) {
        // Move the uploaded file to a server directory
        $uploadDirectory = 'uploads/';
        $targetFile = $uploadDirectory . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Insert the image, item name, and item price into the database
            $filename = $file['name'];
            $filePath = $targetFile;
            $item_name = $_POST['item_name'];
            $item_price = $_POST['item_price'];

            $query = "INSERT INTO images (filepath, item_name, item_price) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sss", $filePath, $item_name, $item_price);

            if ($stmt->execute()) {
                // Image, item name, and item price uploaded and saved to the database
                echo "Image, item name, and item price uploaded and saved to the database.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Only JPEG and PNG images are allowed.";
    }
}
?>

