<?php
$conn = mysqli_connect("localhost", "root", "", "login");

session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$restaurant_name = $_POST['restaurant_name'];
$owner_name=$_POST['owner_name'];
$owner_email=$_POST['owner_email'];
$address = $_POST['address'];

$_SESSION['restaurant1']=$restaurant_name;
// Insert data into the database
$sql = "INSERT INTO restaurant (restaurant_id, restaurant_name,city,owner_name,owner_email) VALUES (NULL,'$restaurant_name', '$address','$owner_name','$owner_email')";

if (mysqli_query($conn, $sql)) {
            header('location:dashboard_restaurant.php');
            $restaurantName=$row['restaurant_name'];
            $_SESSION['restaurant']=$restaurantName;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


?>
