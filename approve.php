<?php
// Get the restaurant ID from the URL
$restaurant_id = $_GET['restaurant_id'];

// Update the restaurant status in the database to 'Approved'
$db = new mysqli("localhost", "root", "", "login");
$query = "UPDATE restaurant SET status = 'Approved' WHERE restaurant_id = $restaurant_id";
$db->query($query);
$db->close();

// Redirect back to the admin dashboard
header("Location: admin.php");
?>
