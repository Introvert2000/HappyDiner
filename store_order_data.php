<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the order data from the POST request
    $restaurantName = $_POST['restaurantName'];
    $cartQuantity = $_POST['cartQuantity'];
    $totalAmount = $_POST['totalAmount'];

    // Store the order data in session variables
    $_SESSION['restaurantName'] = $restaurantName;
    $_SESSION['cartQuantity'] = $cartQuantity;
    $_SESSION['totalAmount'] = $totalAmount;
}
