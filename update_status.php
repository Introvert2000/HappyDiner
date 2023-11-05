<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Get data from the request (you can add more validation here)
$booking_id = $_POST['booking_id'];
$new_status = $_POST['new_status'];

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the status in the database
$sql = "UPDATE reservations SET status = '$new_status' WHERE booking_id = $booking_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
