<?php
session_start();
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
$date = $_POST['date'];
$time = $_POST['time'];
$guests = $_POST['guests'];


$name2 = $_SESSION['Name1'];

$sql = "SELECT * FROM reg WHERE Name1 = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name2); // "s" indicates a string parameter
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mobile = $row["MobileNo"];
    }
}
// Prepare and execute the SQL query to insert data
$sql = "INSERT INTO reservations (restaurant_name, name, email, phone, booking_date, booking_time, num_of_guests) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $restaurantName, $name2, $email, $mobile, $date, $time, $guests);

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
