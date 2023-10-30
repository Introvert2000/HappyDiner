<?php
include 'connect_rest.php';
session_start();
$restaurant = $_SESSION['restaurant1'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM `$restaurant` WHERE id = $id";

    if (mysqli_query($connection, $sql)) {
        header("Location: dashboard_restaurant.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($connection);
?>
