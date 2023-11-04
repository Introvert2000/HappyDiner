<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "login");

session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$restaurant_name = $_POST['restaurant_name'];
$owner_name = $_POST['owner_name'];
$owner_email = $_POST['owner_email'];
$location = $_POST['location'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$_SESSION['restaurant1'] = $restaurant_name;

$_SESSION['restaurant_name'] = $restaurant_name;


// Insert data into the "restaurant" table
$sql = "INSERT INTO restaurant (restaurant_id, restaurant_name, city, owner_name, owner_email, latitude, longitude) VALUES (NULL, '$restaurant_name', '$location', '$owner_name', '$owner_email', '$latitude', '$longitude')";



$conn2 = mysqli_connect("localhost", "root", "", "restaurant");

if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create a table for the restaurant
$createTableSQL = "CREATE TABLE IF NOT EXISTS `$restaurant_name` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_item VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    image LONGBLOB NOT NULL
)";

if (mysqli_query($conn2, $createTableSQL) && mysqli_query($conn, $sql)) {
    echo "<script>alert('Table `restaurant` created successfully.');</script>";
    header('location:dashboard_restaurant.php');
    $restaurantName = $restaurant_name;
    $_SESSION['restaurant'] = $restaurantName;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
