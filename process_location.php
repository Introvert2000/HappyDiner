<?php
// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the location and coordinates from the form
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Connect to your database (replace with your own database details)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database (replace with your own table name and column names)
    $sql = "INSERT INTO coordinates (latitude, longitude,city) VALUES ('$latitude', '$longitude','$location')";

    if ($conn->query($sql) === true) {
        echo "Data stored in the database successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
