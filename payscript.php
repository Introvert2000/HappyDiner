<?php
session_start();

// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve customer information
$yourVariable = $_SESSION['Name1'];
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
$orderDate = date("Y-m-d"); // Current date
$orderTime = date("H:i:s"); // Current time

// Initialize total amount and cart items
$totalAmount = $_SESSION['totalAmount'];
$cartItems = $_SESSION['cartItems'];
// Other order information (you can modify as needed)
$status = "Pending";
$specialInstructions = "No special instructions"; // Modify as needed

if (isset($_SESSION['restaurantName'])) {
    $restaurantName = $_SESSION['restaurantName'];
}

// Insert order information into the "orders" table
$sql = "INSERT INTO orders (customer_username, customer_email, order_date, order_time, total_amount, status, special_instructions, restaurant_name)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ssssdsss", $username, $email, $orderDate, $orderTime, $totalAmount, $status, $specialInstructions, $restaurantName);
    if ($stmt->execute()) {
        $orderID = $stmt->insert_id; // Get the ID of the newly inserted order

        // Loop through the cart items and add them to the "order_items" table
        if (is_array($cartItems) && count($cartItems) > 0) {
            foreach ($cartItems as $cartItems) {
                $itemName = $cartItems['name'];
                $quantity = $cartItems['quantity']; // Added item quantity

                // Insert order item into the "order_items" table
                $sql = "INSERT INTO order_items (order_id, item_name, quantity)
                        VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("isd", $orderID, $itemName, $quantity);
                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                    }
                }

                // Calculate the total amount for this item
               
            }


            echo '<script>alert("Order placed successfully! Order ID: ' . $orderID . '");</script>';
            header('Location: order_details.php?orderID=' . $orderID);
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close the database connection
$conn->close();
?>
