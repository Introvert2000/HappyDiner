<?php
session_start();
$username = $_SESSION['Name1'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$location = $_POST['location'];
$address = $_POST['address'];

// Connect to your database (replace with your own database details)
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "login";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a record with the same Name1 exists
$checkSql = "SELECT Name1 FROM reg WHERE Name1 = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $username);

if ($checkStmt->execute()) {
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        // Record exists, update it
        $updateSql = "UPDATE reg SET lat = ?, lon = ?, location = ?, address_line = ? WHERE Name1 = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ddsss", $latitude, $longitude, $location, $address, $username);

        if ($updateStmt->execute()) {
            echo "Data updated in the database successfully";
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    } else {
        // Record doesn't exist, insert it
        $insertSql = "INSERT INTO reg (lat, lon, location, address_line, Name1) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ddsss", $latitude, $longitude, $location, $address, $username);

        if ($insertStmt->execute()) {
            echo '<script>';
            echo 'alert("Data inserted into the database successfully");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
                    }
        else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: " . $checkSql . "<br>" . $conn->error;
}

// Close the connection at the end of the script
$conn->close();

?>