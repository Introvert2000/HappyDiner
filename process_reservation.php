<?php
// Establish a database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'login';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$restaurantName = $_POST['restaurantName'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$guests = $_POST['guests'];

// Prepare and execute the SQL query to insert data
$sql = "INSERT INTO reservations (restaurant_name, Name1, email, phone, booking_date, booking_time, num_of_guests) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $restaurantName, $name, $email, $phone, $date, $time, $guests);

if ($stmt->execute()) {
    echo "<script>alert('Reservation successfully saved in the database.')</script>";
    echo "<script>location.href='dashboard.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
