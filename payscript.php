<?php
session_start();
// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$conn = new mysqli($servername, $username, $password, $dbname);
$yourVariable = ($_SESSION['Name1']);
$sql = "SELECT Username, email FROM reg WHERE Name1 = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind the parameter
    $stmt->bind_param("s", $yourVariable); // "s" represents a string, adjust as needed

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $username = $row['Username'];
            $email = $row['email'];
            // Process the results here
        }
    }
    
    // Close the prepared statement
    $stmt->close();
}
// Retrieve order details
; // Replace with actual customer email
$orderDate = date("Y-m-d"); // Current date
$orderTime = date("H:i:s"); // Current time
$totalAmount = $_SESSION['totalAmount']; // Get the total amount from the form

// Other order information (you can modify as needed)
$status = "Pending";
$specialInstructions = "No special instructions"; // Modify as needed
if(isset($_SESSION['restaurantName'])){
    $restaurantName = $_SESSION['restaurantName'];
    // Now, you have the $restaurantName available for use in payscript.php
}

// Create a connection to the database

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert order information into the "order" table
$sql = "INSERT INTO orders (customer_username, customer_email, order_date, order_time, total_amount, status, special_instructions, restaurant_name)
        VALUES ('$username', '$email', '$orderDate', '$orderTime', $totalAmount, '$status', '$specialInstructions', '$restaurantName')";

if ($conn->query($sql) === TRUE) {
    $orderID = $conn->insert_id; // Get the ID of the newly inserted order
    // Now, you have the order ID that you can use to associate order items

    // Loop through the cart items and add them to the "order_item" table
    $cartItems = $_SESSION['cartItems'];
    foreach ($cartItems as $cartItem) {
        $itemName = $cartItem['name'];
        $itemPrice = $cartItem['price'];

        // Insert order item into the "order_item" table
        $sql = "INSERT INTO order_items (order_id, item_name, item_price)
                VALUES ($orderID, '$itemName', $itemPrice)";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo '<script>alert("Order placed successfully! Order ID: ' . $orderID . '");</script>';
    header('Location: order_details.php?orderID=' . $orderID);

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>

