<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the amount in the database based on the booking ID
$bookingId = $data['booking_id'];
$amount = $data['amount'];
$sql = "UPDATE reservations SET amount = ? WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $amount, $bookingId);

if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $stmt->error));
}

$conn->close();
?>
