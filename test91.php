<?php
// Start the session
session_start();

// Assume you've stored the JSON string in a session variable named 'cartItemsJSON'
if (isset($_SESSION['cartItems'])) {
    // Retrieve the JSON string from the session
    $cartItems = $_SESSION['cartItems'];

    // Parse the JSON string into a PHP array

    // View the contents of the PHP array (equivalent to a JavaScript object)
    print_r($cartItems);

    // You can access individual items within $cartItems, e.g., $cartItems['item_name']
} else {
    echo "Session variable 'cartItemsJSON' is not set.";
}


?>