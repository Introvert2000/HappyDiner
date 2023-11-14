<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form has been submitted (e.g., from a payment page)
    if (isset($_POST['restaurantName'])) {
        // Store restaurant name in a session variable
        $_SESSION['restaurantName'] = $_POST['restaurantName'];
    }

    if (isset($_POST['totalAmount'])) {
        // Store total amount in a session variable
        $_SESSION['totalAmount'] = $_POST['totalAmount'];
    }

    if (isset($_POST['cartItems'])) {
        // Store cart items in a session variable
        $_SESSION['cartItems'] = json_decode($_POST['cartItems'], true);
    }

    // Redirect to success.php or any other page
    header('Location: payscript2.php');
    exit;
}
?>
