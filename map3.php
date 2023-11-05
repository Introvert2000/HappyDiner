<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve latitude and longitude from the database
$query = "SELECT latitude, longitude FROM coordinates WHERE id=1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Assuming only one row is retrieved, you can loop through the results if needed
    $row = $result->fetch_assoc();
    $latitude = $row["latitude"];
    $longitude = $row["longitude"];

    // Step 3: Use the latitude and longitude values in your API request
    $api_key = "your_api_key";
    $url = "https://api.geoapify.com/v1/geocode/reverse?lat={$latitude}&lon={$longitude}&format=json&apiKey=6280fa3f1f5e4b7ca8931c01979b1e88";
    // $url = "https://api.example.com/endpoint?lat=$latitude&lon=$longitude&apikey=$api_key";

    // You can now make an API request using $url
    // You may use cURL or any other method to make the request
    // Example:
    $response = file_get_contents($url);

    // Handle the API response as needed
    echo $response;
} else {
    echo "No results found in the database.";
}

// Close the database connection
$conn->close();
?>
