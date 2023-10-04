<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $sql = "SELECT * FROM restaurant WHERE restaurant_name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Name: " . $row['restaurant_name'] . "<br>";
        }
    } else {
        echo "No results found.";
    }
}

$conn->close();
?>
