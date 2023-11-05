<?php
// Database configuration
$host = 'localhost';
$dbname = 'data';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if lat and lon are set
    if (isset($_POST['lat']) && isset($_POST['lon'])) {
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

        // Insert the captured coordinates into the database
        $stmt = $conn->prepare("INSERT INTO coordinates (latitude, longitude) VALUES (:lat, :lon)");
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lon', $lon);
        $stmt->execute();

        echo "Coordinates saved successfully!";
    } else {
        echo "Latitude and Longitude not set.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
